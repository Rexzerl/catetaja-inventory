<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 border-b pb-2">Informasi Barang</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                    <div>
                        <p class="mb-2"><strong>Kode Barang:</strong> {{ $product->product_code }}</p>
                        <p class="mb-2"><strong>Nama Barang:</strong> {{ $product->name }}</p>
                        <p class="mb-2"><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="mb-2"><strong>Stok Tersedia:</strong> <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $product->stock }} Unit</span></p>
                        <p class="mb-2"><strong>Lokasi:</strong> {{ $product->location }}</p>
                        <p class="mb-2"><strong>Kondisi:</strong> 
                            @if($product->condition == 'Baik')
                                <span class="text-green-600 font-bold">{{ $product->condition }}</span>
                            @elseif($product->condition == 'Rusak')
                                <span class="text-red-600 font-bold">{{ $product->condition }}</span>
                            @else
                                <span class="text-yellow-600 font-bold">{{ $product->condition }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>