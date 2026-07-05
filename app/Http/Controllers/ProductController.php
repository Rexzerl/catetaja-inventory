<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = \App\Models\Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

            return view('products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
    {
        // 1. Tambahkan validasi untuk image
        $request->validate([
            'product_code' => 'required|string|unique:products,product_code',
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'location'     => 'required|string|max:255',
            'condition'    => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ], [
            'product_code.unique' => 'Kode produk sudah terdaftar.',
            'image.image'         => 'File harus berupa gambar.',
            'image.max'           => 'Ukuran gambar maksimal 2MB.'
        ]);

        // 2. Ambil semua request kecuali image dan token CSRF
        $data = $request->except(['image', '_token']);

        // 3. Logika Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
            // Masukkan path gambar ke dalam array data untuk database
            $data['image'] = $imagePath;
        }

        // 4. Simpan ke database menggunakan array $data yang sudah rapi
        \App\Models\Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = \App\Models\Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, string $id)
    {
        // 1. Validasi
        $request->validate([
            'product_code' => 'required|string|unique:products,product_code,' . $id,
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'location'     => 'required|string|max:255',
            'condition'    => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = \App\Models\Product::findOrFail($id);

        // KUNCI 1: Buang 'image' dari request bawaan
        $data = $request->except(['image', '_token', '_method']);

        // Logika Gambar
        if ($request->hasFile('image')) {
            
            // Hapus gambar lama jika ada
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            
            // KUNCI 2: Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            
            // KUNCI 3: Tumpuk array $data dengan path gambar yang benar
            $data['image'] = $imagePath;
        }

        // KUNCI 4: Simpan ke database menggunakan variabel $data, BUKAN $request->all()
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   {
        // KUNCI KEAMANAN: Tolak jika bukan Admin
        if (\Illuminate\Support\Facades\Auth::user()->role->name !== 'Admin') {
            return redirect()->back()->with('error', 'Akses Ditolak! Hanya Admin yang berhak menghapus data master barang.');
        }

        $product = \App\Models\Product::findOrFail($id);
        
        // Hapus foto dari server jika barang memiliki foto
        if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data barang beserta fotonya berhasil dihapus permanen!');
    }
}