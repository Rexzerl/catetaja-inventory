<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Detail Barang - CatetAja!</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "#f9f9f9", "on-surface": "#1a1c1c", "on-surface-variant": "#4c4546", "outline": "#7e7576",
                        "surface-container-low": "#f3f3f3", "surface-container": "#eeeeee", "ts-red": "#bc0007", "ts-orange": "#fd9923"
                    },
                    spacing: { "margin-mobile": "16px", "margin-desktop": "48px" }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .hard-shadow { box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1); }
        .dark .hard-shadow { box-shadow: 4px 4px 0px 0px rgba(255, 255, 255, 0.1); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .telkomsel-gradient { background: linear-gradient(135deg, #bc0007 0%, #fd9923 100%); }
    </style>
</head>
<body class="bg-surface dark:bg-slate-900 text-on-surface dark:text-white transition-colors duration-300 min-h-screen">
    
    <nav class="bg-surface dark:bg-slate-800 border-b border-outline dark:border-slate-700 fixed top-0 w-full z-50 h-16 flex justify-between items-center px-4 md:px-margin-desktop">
        <div class="flex items-center gap-4">
            <img alt="Telkomsel Logo" class="h-8 object-contain" src="{{ asset('images/telkomsel-logo.png') }}">
            <span class="text-xl font-black text-ts-red dark:text-ts-red-bright hidden md:block">CatetAja!</span>
        </div>
        <div class="flex items-center gap-6">
            <button class="p-2 hover:bg-surface-container-low dark:hover:bg-slate-700 rounded-full transition-colors flex items-center justify-center" onclick="toggleDarkMode()">
                <span class="material-symbols-outlined" id="dark-mode-icon">dark_mode</span>
            </button>

            <div class="relative group">
                <button class="flex items-center gap-3 border-l border-outline/20 pl-6 dark:border-slate-700 focus:outline-none cursor-pointer py-1" id="profile-menu-btn">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-on-surface-variant dark:text-slate-400 uppercase tracking-widest">{{ Auth::user()->role->name ?? 'User' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full border-2 border-ts-red overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=bc0007&color=fff" alt="Avatar">
                    </div>
                    <span class="material-symbols-outlined text-sm text-slate-400 group-hover:rotate-180 transition-transform duration-200">keyboard_arrow_down</span>
                </button>

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
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Manager', 'Staff']))
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform" href="{{ route('products.index') }}">
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
        
        <div class="w-full max-w-4xl mx-auto">
            
            <header class="mb-8 flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="p-2 bg-slate-200 dark:bg-slate-700 border border-black hover:bg-slate-300 transition-colors flex items-center justify-center" title="Kembali">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">Detail Data Barang</h1>
                </div>
            </header>

            <section class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6 md:p-8 space-y-8">
                
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Foto Fisik Barang</label>
                    <div class="w-full h-64 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-500 flex flex-col items-center justify-center overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="absolute inset-0 w-full h-full object-contain bg-white dark:bg-slate-900" alt="{{ $product->name }}">
                        @else
                            <span class="material-symbols-outlined text-6xl text-slate-400 mb-2">image_not_supported</span>
                            <span class="font-bold text-sm text-slate-500">Tidak ada foto dokumentasi</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Kode Barang</label>
                        <div class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-mono font-bold dark:text-white">
                            {{ $product->product_code }}
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Nama Aset / Barang</label>
                        <div class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-bold dark:text-white">
                            {{ $product->name }}
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Kategori Barang</label>
                        <div class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-bold dark:text-white">
                            {{ $product->category->name ?? '-' }}
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Kondisi Barang</label>
                        <div class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-bold dark:text-white flex items-center">
                            @if(in_array($product->condition, ['Baik', 'Bagus']))
                                <span class="text-green-600 dark:text-green-400 uppercase tracking-wider">{{ $product->condition }}</span>
                            @elseif(in_array($product->condition, ['Rusak', 'Rusak Ringan']))
                                <span class="text-ts-red dark:text-red-400 uppercase tracking-wider">{{ $product->condition }}</span>
                            @else
                               <span class="text-ts-orange dark:text-yellow-400 uppercase tracking-wider">{{ $product->condition }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Lokasi Penempatan</label>
                        <div class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-bold dark:text-white">
                            {{ $product->location }}
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Stok Tersedia (Unit)</label>
                        <div class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-black text-ts-red dark:text-ts-red-bright text-lg">
                            {{ $product->stock }} UNIT
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-black dark:border-slate-600 flex flex-col md:flex-row gap-4">
                    <a href="{{ route('products.index') }}" class="w-full py-4 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-black dark:text-white font-bold uppercase border border-black dark:border-slate-500 hard-shadow hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span> Kembali Ke Daftar
                    </a>
                    
                    @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                    <a href="{{ route('products.edit', $product->id) }}" class="w-full py-4 bg-ts-orange hover:bg-orange-500 text-black font-bold uppercase border border-black hard-shadow hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-2">
                        Edit Data Barang <span class="material-symbols-outlined text-[20px]">edit</span>
                    </a>
                    @endif
                </div>

            </section>
        </div> 
    </main>

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
        // --- Tema Gelap / Terang ---
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
        }
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
            document.getElementById('dark-mode-icon').textContent = 'light_mode';
        }

        // --- TOGGLE DROPDOWN (Mobile & Aksesibilitas) ---
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

        // --- SCRIPT LOADING OVERLAY ---
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