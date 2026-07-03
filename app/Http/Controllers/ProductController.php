<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


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
        $request->validate([
            'product_code' => 'required|string|unique:products,product_code',
            'name'         => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'location'     => 'required|string|max:255',
            'condition'    => 'required|string|max:255',
        ], ['product_code.unique' => 'Kode produk sudah terdaftar.']);

        \App\Models\Product::create($request->all());

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
        // Validasi input
        $request->validate([
            'product_code' => 'required|string|unique:products,product_code,' . $id, // Abaikan validasi unique untuk ID ini
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'location'     => 'required|string|max:255',
            'condition'    => 'required|string|max:255',
        ]);

        $product = \App\Models\Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data barang berhasil dihapus!');
    }
}