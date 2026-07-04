<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Statistik Inventaris') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('dashboard.excel') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm shadow">
                    Export Excel
                </a>
                <button onclick="exportToPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm shadow">
                    Export PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div id="cetak-pdf" class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                
                <h3 class="text-center font-bold text-2xl mb-6 text-gray-800 dark:text-gray-200 hide-on-web" style="display:none;">
                    Laporan Inventaris Tahun {{ $tahunIni }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-blue-500">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Barang (Fisik)</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalBarang }}</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-yellow-500">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang Dipinjam</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $dipinjam }}</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-green-500">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang Tersedia (Gudang)</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $tersedia }}</p>
                    </div>

                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Grafik Transaksi Peminjaman ({{ $tahunIni }})</h4>
                    <div style="position: relative; height:40vh; width:100%">
                        <canvas id="peminjamanChart"></canvas>
                    </div>
                </div>

            </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        // --- 1. RENDER GRAFIK CHART.JS ---
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            const dataDariBackend = @json($chartData);

            new Chart(ctx, {
                type: 'bar', // Bisa diganti 'line' jika ingin grafik garis
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: dataDariBackend,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 } // Angka bulat karena ini jumlah transaksi
                        }
                    }
                }
            });
        });

        // --- 2. RENDER EXPORT PDF ---
        function exportToPDF() {
            // Tampilkan judul laporan khusus untuk di PDF
            const judulPdf = document.querySelector('.hide-on-web');
            judulPdf.style.display = 'block';

            const element = document.getElementById('cetak-pdf');
            
            // Konfigurasi Kualitas PDF
            const opt = {
                margin:       [0.5, 0.5, 0.5, 0.5], // [Atas, Kanan, Bawah, Kiri]
                filename:     'Dashboard_Inventaris_Lengkap.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' } // Landscape agar grafik lebar
            };

            // Proses Generate
            html2pdf().set(opt).from(element).save().then(() => {
                // Sembunyikan kembali judul setelah selesai dicetak
                judulPdf.style.display = 'none';
            });
        }
    </script>
</x-app-layout>