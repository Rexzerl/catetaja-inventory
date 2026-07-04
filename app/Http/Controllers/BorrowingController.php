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
            'borrow_date' => 'required|date',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi! Sisa stok {$product->name} saat ini hanya {$product->stock} unit.");
        }

        DB::beginTransaction();
        try {
                $borrowing = Borrowing::create([
                'user_id'       => Auth::id(), 
                'employee_name' => $request->employee_name, // <-- WAJIB ADA BARIS INI
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

            DB::commit();
            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data peminjaman.'.$e->getMessage());
        }
    }
    public function returnDevice(string $id)
    {
        $borrowing = Borrowing::with('details')->findOrFail($id);

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
        $tersedia = Product::sum('stock');
        $dipinjam = BorrowingDetail::whereHas('borrowing', function($query) {
            $query->where('status', 'Dipinjam');
        })->sum('quantity');
        $totalBarang = $tersedia + $dipinjam;

        $fileName = "Laporan_Inventaris_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        // Header Kolom di Excel
        $columns = ['Kategori Data', 'Jumlah Unit'];

        // Menulis data langsung ke output stream
        $callback = function() use($totalBarang, $dipinjam, $tersedia, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['Total Keseluruhan Barang', $totalBarang]);
            fputcsv($file, ['Barang Sedang Dipinjam', $dipinjam]);
            fputcsv($file, ['Barang Tersedia (Gudang)', $tersedia]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

