<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Daftar Transaksi Aktif</h3>
                    <a href="{{ route('borrowings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Peminjaman Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Peminjam (Karyawan)</th>
                                <th class="px-6 py-3">Barang & Jumlah</th>
                                <th class="px-6 py-3">Tanggal Pinjam</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $key => $borrowing)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ $borrowings->firstItem() + $key }}</td>
                                    
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-900 dark:text-white block">{{ $borrowing->employee_name }}</span>
                                        <span class="text-xs text-gray-400 block">Operator: {{ $borrowing->user->name }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @foreach($borrowing->details as $detail)
                                            <span class="block">{{ $detail->product->name }} ({{ $detail->quantity }} unit)</span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                                    
                                    <td class="px-6 py-4">
                                        @if($borrowing->status === 'Dipinjam')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                                {{ $borrowing->status }}
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                {{ $borrowing->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($borrowing->status === 'Dipinjam')
                                            <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Konfirmasi: Apakah seluruh barang fisik ini sudah dikembalikan ke gudang dalam kondisi baik?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs transition duration-150">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic block">Kembali pada:</span>
                                            <span class="text-gray-500 text-xs font-medium block dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data transaksi peminjaman barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $borrowings->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>