<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard - CatetAja!</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "#f9f9f9", "on-surface": "#1a1c1c", "on-surface-variant": "#4c4546", "outline": "#7e7576",
                        "surface-container-low": "#f3f3f3", "surface-container": "#eeeeee", "surface-container-high": "#e8e8e8",
                        "ts-red": "#bc0007", "ts-red-bright": "#e2241d", "ts-orange": "#fd9923"
                    },
                    spacing: { "margin-mobile": "16px", "margin-desktop": "48px", "gutter": "24px" },
                    fontFamily: {
                        "headline-xl": ["Montserrat"], "headline-md": ["Montserrat"], "headline-lg": ["Montserrat"],
                        "body-md": ["Montserrat"], "label-md": ["Montserrat"]
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .hard-shadow { box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1); }
        .dark .hard-shadow { box-shadow: 4px 4px 0px 0px rgba(255, 255, 255, 0.1); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface dark:bg-slate-900 text-on-surface dark:text-white transition-colors duration-300 min-h-screen">
    
    <!-- TopNavBar -->
    <nav class="bg-surface dark:bg-slate-800 border-b border-outline dark:border-slate-700 fixed top-0 w-full z-50 h-16 flex justify-between items-center px-4 md:px-margin-desktop">
        <div class="flex items-center gap-4">
            <img alt="Telkomsel Logo" class="h-8 object-contain" src="{{ asset('images/telkomsel-logo.png') }}">
            <span class="text-xl font-black text-ts-red dark:text-ts-red-bright hidden md:block">CatetAja!</span>
        </div>
        <div class="flex items-center gap-6">
            <button class="p-2 hover:bg-surface-container-low dark:hover:bg-slate-700 rounded-full transition-colors flex items-center justify-center" onclick="toggleDarkMode()">
                <span class="material-symbols-outlined" id="dark-mode-icon">dark_mode</span>
            </button>

            <!-- WADAH DROPDOWN PROFIL & LOGOUT -->
            <div class="relative group">
                <button class="flex items-center gap-3 border-l border-outline/20 pl-6 dark:border-slate-700 focus:outline-none cursor-pointer py-1" id="profile-menu-btn">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-on-surface-variant dark:text-slate-400 uppercase tracking-widest">{{ Auth::user()->role->name ?? 'User' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full border-2 border-ts-red overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=bc0007&color=fff" alt="User Avatar">
                    </div>
                    <span class="material-symbols-outlined text-sm text-slate-400 group-hover:rotate-180 transition-transform duration-200">keyboard_arrow_down</span>
                </button>

                <!-- Dropdown Menu Logout -->
                <div class="absolute right-0 top-full pt-3 w-48 hidden group-hover:block z-50" id="dropdown-menu">
                    <div class="bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow py-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="w-full flex items-center gap-3 px-4 py-3 text-ts-red hover:bg-red-50 dark:hover:bg-red-900/20 transition-all text-sm font-bold text-left" type="submit">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 pt-20 bg-surface dark:bg-slate-800 border-r border-outline dark:border-slate-700 px-4">
        <div class="space-y-2 mt-4">
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform active:translate-x-1" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff', 'Manager']))
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Barang' : 'Inventaris Barang' }}</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('borrowings.index') }}">
                <span class="material-symbols-outlined">handshake</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Peminjaman' : 'Data Peminjaman' }}</span>
            </a>
            @endif
        </div>
        @if((Auth::user()->role->name ?? '') === 'Admin')
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low transition-all border border-transparent hover:border-black" href="{{ route('users.index') }}">
                <span class="material-symbols-outlined">shield_person</span> <span class="text-sm">Kelola Akun (Admin)</span>
            </a>
            @endif
    </aside>

    <main class="pt-24 pb-20 md:pb-12 px-4 md:px-margin-desktop md:ml-64">
        
        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">
                    Dashboard Statistik Inventaris
                </h1>
                <div class="h-2 w-32 bg-ts-orange mt-4"></div>
            </div>
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff', 'Manager']))
            <div class="flex gap-3 hide-on-print">
                <a href="{{ route('dashboard.excel') }}" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 border border-black hard-shadow transition-transform active:translate-x-1">
                    <span class="material-symbols-outlined text-sm">table_view</span>
                    Excel
                </a>
                <button onclick="exportToPDF()" class="flex items-center gap-2 bg-black hover:bg-slate-800 text-white font-bold py-2 px-4 border border-ts-red hard-shadow transition-transform active:translate-x-1">
                    <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                    PDF
                </button>
            </div>
            @endif
        </header>

        <div id="cetak-pdf" class="bg-surface dark:bg-slate-900">
            <h2 id="judul-pdf" class="text-2xl font-black text-center mb-6 hidden">Laporan Inventaris {{ $tahunIni }}</h2>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-on-surface-variant dark:text-slate-400 uppercase mb-1">Total Barang Fisik</p>
                            <h2 class="text-4xl font-black leading-none">{{ $totalBarang }}</h2>
                        </div>
                        <div class="p-3 bg-slate-100 dark:bg-slate-700 border border-black dark:border-slate-500">
                            <span class="material-symbols-outlined text-ts-red">inventory_2</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-on-surface-variant dark:text-slate-400 uppercase mb-1">Barang Dipinjam</p>
                            <h2 class="text-4xl font-black leading-none text-ts-orange">{{ $dipinjam }}</h2>
                        </div>
                        <div class="p-3 bg-slate-100 dark:bg-slate-700 border border-black dark:border-slate-500">
                            <span class="material-symbols-outlined text-ts-orange">outbox</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-on-surface-variant dark:text-slate-400 uppercase mb-1">Barang Tersedia</p>
                            <h2 class="text-4xl font-black leading-none text-ts-red">{{ $tersedia }}</h2>
                        </div>
                        <div class="p-3 bg-slate-100 dark:bg-slate-700 border border-black dark:border-slate-500">
                            <span class="material-symbols-outlined text-ts-red">inbox</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-12">
                <div class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <h3 class="text-xl font-black uppercase text-ts-red dark:text-white">
                            Grafik Peminjaman per Bulan
                        </h3>
                        <span class="bg-ts-red/10 text-ts-red px-4 py-1 text-sm font-bold border border-ts-red">{{ $tahunIni }}</span>
                    </div>
                    <div class="w-full relative h-[40vh]">
                        <canvas id="peminjamanChart"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Global Loading Overlay -->
    <div id="global-loader" class="fixed inset-0 z-[9999] bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm flex flex-col justify-center items-center hidden transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="relative flex flex-col items-center">
            <div class="absolute -inset-6 border-[6px] border-surface-container-low dark:border-slate-800 border-t-ts-red dark:border-t-ts-red-bright rounded-full animate-spin"></div>
            <div class="bg-white dark:bg-slate-800 p-3 rounded-full hard-shadow z-10 flex items-center justify-center">
                <img src="{{ asset('images/telkomsel-logo.png') }}" alt="Loading" class="h-10 w-10 object-contain animate-pulse">
            </div>
            <p class="mt-10 text-sm font-black text-ts-red dark:text-white uppercase tracking-widest animate-pulse">
                Loading...
            </p>
        </div>
    </div>

    <script>
        // --- 1. DARK MODE LOGIC ---
        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('dark-mode-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                icon.textContent = 'dark_mode';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                icon.textContent = 'light_mode';
                localStorage.setItem('theme', 'dark');
            }
            updateChart();
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
            document.getElementById('dark-mode-icon').textContent = 'light_mode';
        }

        // --- 2. DYNAMIC CHART.JS INTEGRATION ---
        let chartInstance;
        function initChart() {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#e2e8f0' : '#1a1c1c';
            const gridColor = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';
            
            const dataDariBackend = @json($chartData);

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Total Transaksi',
                        data: dataDariBackend,
                        backgroundColor: 'rgba(188, 0, 7, 0.8)',
                        borderColor: '#bc0007',
                        borderWidth: 2,
                        hoverBackgroundColor: '#fd9923'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor, borderDash: [5, 5] },
                            ticks: { stepSize: 1, color: textColor, font: { family: 'Montserrat', weight: 'bold' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: textColor, font: { family: 'Montserrat', weight: 'bold' } }
                        }
                    }
                }
            });
        }

        function updateChart() {
            if (chartInstance) chartInstance.destroy();
            initChart();
        }

        document.addEventListener('DOMContentLoaded', () => {
            initChart();
        });

        // --- 3. EXPORT TO PDF LOGIC ---
        function exportToPDF() {
            document.getElementById('judul-pdf').classList.remove('hidden');
            
            const element = document.getElementById('cetak-pdf');
            const opt = {
                margin:       [0.5, 0.5, 0.5, 0.5],
                filename:     'Laporan_Inventaris_CatetAja!.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                document.getElementById('judul-pdf').classList.add('hidden');
            });
        }

        // --- 4. DROPDOWN TOGGLE ---
        const profileBtn = document.getElementById('profile-menu-btn');
        const dropdownMenu = document.getElementById('dropdown-menu');
        
        if (profileBtn && dropdownMenu) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', () => {
                if (!dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }

        // --- 5. LOADING OVERLAY LOGIC ---
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('global-loader');
            const showLoader = () => {
                loader.classList.remove('hidden', 'pointer-events-none');
                requestAnimationFrame(() => {
                    loader.classList.remove('opacity-0');
                    loader.classList.add('opacity-100');
                });
            };
            const hideLoader = () => {
                loader.classList.remove('opacity-100');
                loader.classList.add('opacity-0');
                setTimeout(() => {
                    loader.classList.add('hidden', 'pointer-events-none');
                }, 300);
            };

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => { showLoader(); });
            });
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', (e) => {
                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');
                    if (href && href !== '#' && !href.startsWith('javascript') && target !== '_blank' && !href.includes('export')) {
                        showLoader();
                    }
                });
            });
            window.addEventListener('pageshow', (e) => { if (e.persisted) hideLoader(); });
        });
    </script>
</body>
</html>