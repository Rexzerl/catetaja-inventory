<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Barang
                        </a>

                        <form action="{{ route('products.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari barang..." class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mr-2">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cari
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="border-b dark:border-gray-700 p-3">Kode</th>
                                    <th class="border-b dark:border-gray-700 p-3">Nama Barang</th>
                                    <th class="border-b dark:border-gray-700 p-3">Kategori</th>
                                    <th class="border-b dark:border-gray-700 p-3">Stok</th>
                                    <th class="border-b dark:border-gray-700 p-3">Lokasi</th>
                                    <th class="border-b dark:border-gray-700 p-3">Kondisi</th>
                                    <th class="border-b dark:border-gray-700 p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border-b dark:border-gray-700 p-3">{{ $product->product_code }}</td>
                                        <td class="border-b dark:border-gray-700 p-3">{{ $product->name }}</td>
                                        <td class="border-b dark:border-gray-700 p-3">{{ $product->category->name ?? '-' }}</td>
                                        <td class="border-b dark:border-gray-700 p-3">{{ $product->stock }}</td>
                                        <td class="border-b dark:border-gray-700 p-3">{{ $product->location }}</td>
                                        <td class="border-b dark:border-gray-700 p-3">{{ $product->condition }}</td>
                                        <td class="border-b dark:border-gray-700 p-3">
                                            <a href="{{ route('products.show', $product->id) }}" class="text-green-500 hover:underline mr-2">Detail</a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                            
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center border-b dark:border-gray-700 p-3">Belum ada data barang. Silakan tambah barang baru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->appends(['search' => $search])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>