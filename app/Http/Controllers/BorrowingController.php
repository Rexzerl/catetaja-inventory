<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $borrowings = Borrowing::with(['user', 'details.product'])->latest()->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('borrowings.create', compact('products'));
    }

public function store(Request $request)
{
    $request->validate([
        'employee_name' => 'required|string|max:255',
        'borrow_date'   => 'required|date',
        'product_id'    => 'required|exists:products,id',
        'quantity'      => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);

    // Cek stok awal
    if ($product->stock < $request->quantity) {
        return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi! Sisa stok {$product->name} saat ini hanya {$product->stock} unit.");
    }

    DB::beginTransaction();
    try {
        $borrowing = Borrowing::create([
            'user_id'       => Auth::id(), 
            'employee_name' => $request->employee_name,
            'borrow_date'   => $request->borrow_date,
            'status'        => 'Dipinjam',
        ]);

        BorrowingDetail::create([
            'borrowing_id' => $borrowing->id,
            'product_id'   => $product->id,
            'quantity'     => $request->quantity,
            'item_status'  => 'Baik',
        ]);

        // Update product stock
        $product->decrement('stock', $request->quantity);

        $product->refresh(); 
            
            // Ambil sisa stok yang benar-benar baru
            $sisaStok = $product->stock; 
            
            $message = 'Peminjaman berhasil ditambahkan.';

            // Jika sisa stok <= 3, tampilkan peringatan
            if ($sisaStok <= 3) {
                $message .= " Peringatan: Stok barang ini menipis, tersisa {$sisaStok} unit.";
            }

        DB::commit();
        return redirect()->route('borrowings.index')->with('success', $message);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data peminjaman. ' . $e->getMessage());
    }
}
    // Ganti nama dari returnDevice menjadi update, dan tambahkan parameter Request
    public function update(Request $request, string $id)
    {
        $borrowing = Borrowing::with('details')->findOrFail($id);

        // Sesuaikan teks dengan kondisi UI ('Kembali')
        if ($borrowing->status === 'Dikembalikan') {
            return redirect()->back()->with('error', 'Barang sudah dikembalikan.');
        }

        DB::beginTransaction();
        try {
            $borrowing->status = 'Dikembalikan'; 
            $borrowing->return_date = now()->toDateString();
            $borrowing->save();

            foreach ($borrowing->details as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $product->increment('stock', $detail->quantity);
            }

            DB::commit();
            return redirect()->route('borrowings.index')->with('success', 'Barang berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengembalikan barang.'.$e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        if (Auth::user()->role->name !== 'Admin') {
            return redirect()->back()->with('error', 'Akses Ditolak! Hanya Admin yang berhak menghapus riwayat peminjaman.');
        }

        $borrowing = Borrowing::findOrFail($id);

        // Validasi: Jangan izinkan hapus riwayat jika barang belum dikembalikan
        if ($borrowing->status === 'Dipinjam') {
            return redirect()->back()->with('error', 'Gagal! Barang masih berstatus "Dipinjam". Harap selesaikan pengembalian terlebih dahulu sebelum menghapus riwayat.');
        }

        // Hapus relasi detail peminjaman terlebih dahulu, lalu hapus riwayat utamanya
        $borrowing->details()->delete();
        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Riwayat peminjaman berhasil dibersihkan!');
    }
    

    public function dashboard()
    {
        $tersedia = Product::sum('stock');
        $dipinjam = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'Dipinjam');
        })->sum('quantity');

        $totalBarang = $tersedia + $dipinjam;

        $tahunIni = date('Y');
        $peminjamanPerBulan = Borrowing::select(
                DB::raw('MONTH(borrow_date) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('borrow_date', $tahunIni)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

            $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $peminjamanPerBulan[$i] ?? 0;
        }

        return view('dashboard', compact('totalBarang', 'dipinjam', 'tersedia', 'chartData', 'tahunIni'));
    }

    public function exportExcel()
    {
        // 1. Ambil Data
        $tersedia = Product::sum('stock');
        $dipinjam = BorrowingDetail::whereHas('borrowing', function($query) {
            $query->where('status', 'Dipinjam');
        })->sum('quantity');
        $totalBarang = $tersedia + $dipinjam;

        // 2. Siapkan Nama File (Ubah ekstensi menjadi .xls)
        $fileName = "Laporan_Ringkasan_Inventaris_" . date('Y-m-d') . ".xls";

        // 3. Susun Tabel HTML dengan sedikit styling CSS
        $html = '
        <html>
        <head>
            <style>
                table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
                th { background-color: #bc0007; color: #ffffff; font-weight: bold; border: 1px solid #000000; padding: 10px; text-align: left; }
                td { border: 1px solid #000000; padding: 10px; }
                h2 { font-family: Arial, sans-serif; color: #bc0007; }
                p { font-family: Arial, sans-serif; font-size: 12px; }
            </style>
        </head>
        <body>
            <h2>Laporan Ringkasan Inventaris </h2>
            <p><strong>Tanggal Cetak:</strong> ' . date('d-m-Y H:i:s') . ' WIB</p>
            
            <table>
                <thead>
                    <tr>
                        <th width="300">Kategori Data</th>
                        <th width="150">Jumlah Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Keseluruhan Barang (Sistem)</td>
                        <td align="center"><strong>' . $totalBarang . '</strong></td>
                    </tr>
                    <tr>
                        <td>Barang Sedang Dipinjam</td>
                        <td align="center"><strong>' . $dipinjam . '</strong></td>
                    </tr>
                    <tr>
                        <td>Barang Tersedia (Di Gudang)</td>
                        <td align="center"><strong>' . $tersedia . '</strong></td>
                    </tr>
                </tbody>
            </table>
        </body>
        </html>
        ';

        // 4. Return response dengan header khusus Excel
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}

