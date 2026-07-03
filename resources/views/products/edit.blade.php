<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kode Barang</label>
                        <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama Barang</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kategori</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Lokasi Penyimpanan</label>
                        <input type="text" name="location" value="{{ old('location', $product->location) }}" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kondisi Barang</label>
                        <select name="condition" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                            <option value="Baik" {{ old('condition', $product->condition) == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ old('condition', $product->condition) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="Perlu Perbaikan" {{ old('condition', $product->condition) == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                        </select>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>