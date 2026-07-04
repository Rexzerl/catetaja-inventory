<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Peminjaman Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong>Gagal!</strong> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('borrowings.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama Karyawan Peminjam</label>
                        <input type="text" name="employee_name" value="{{ old('employee_name') }}" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" placeholder="Masukkan nama karyawan luar..." required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Tanggal Pinjam</label>
                        <input type="date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Pilih Barang</label>
                        <select name="product_id" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                            <option value="">-- Pilih Barang yang Tersedia --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->product_code }} - {{ $product->name }} (Sisa Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Jumlah Pinjam</label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('borrowings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Proses Peminjaman</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>