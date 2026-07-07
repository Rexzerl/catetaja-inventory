<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Inventaris Barang - CatetAja!</title>
    
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
        .btn-hamburger {
            display: none;
            font-size: 24px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            color: inherit;
        }

        @media (max-width: 768px) {
            .btn-hamburger {
                display: inline-block;
            }
            
            #sidebar-kiri {
                display: flex !important; /* Menimpa class 'hidden' bawaan tailwind di mode HP */
                position: fixed;
                top: 0;
                left: -100%;
                height: 100vh;
                z-index: 9999;
                transition: left 0.3s ease-in-out;
            }

            #sidebar-kiri.muncul {
                left: 0;
            }
        }
    </style>
</head>
<body class="bg-surface dark:bg-slate-900 text-on-surface dark:text-white transition-colors duration-300 min-h-screen">
    
    <nav class="bg-surface dark:bg-slate-800 border-b border-outline dark:border-slate-700 fixed top-0 w-full z-50 h-16 flex justify-between items-center px-4 md:px-margin-desktop">
        <div class="flex items-center gap-4">
            <button id="tombol-menu" class="btn-hamburger">☰</button>
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
            
            @if(in_array(Auth::user()->role->name ?? '', ['Admin', 'Manager', 'Staff']))
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform active:translate-x-1" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Barang' : 'Inventaris Barang' }}</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('borrowings.index') }}">
                <span class="material-symbols-outlined">handshake</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Peminjaman' : 'Data Peminjaman' }}</span>
            </a>
            @endif

            @if((Auth::user()->role->name ?? '') === 'Admin')
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low transition-all border border-transparent hover:border-black" href="{{ route('users.index') }}">
                <span class="material-symbols-outlined">shield_person</span> <span class="text-sm">Kelola Akun (Admin)</span>
            </a>
            @endif
        </div>
    </aside>

    <main class="pt-24 pb-20 md:pb-12 px-4 md:px-margin-desktop md:ml-64">
        
        <header class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">
                    {{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Inventaris Barang' : 'Data Inventaris Barang' }}
                </h1>
                <div class="h-2 w-32 bg-ts-orange mt-4"></div>
            </div>
            
            @if(in_array(Auth::user()->role->name ?? '', ['Admin', 'Staff']))
            <a href="{{ route('products.create') ?? '#' }}" class="flex items-center gap-2 bg-ts-red hover:bg-ts-red-bright text-white font-bold py-3 px-5 border border-black hard-shadow transition-transform active:translate-x-1">
                <span class="material-symbols-outlined text-sm">add</span>
                Tambah Barang Baru
            </a>
            @endif
        </header>

        <div class="mb-6 flex justify-between items-center">
            <form action="{{ route('products.index') }}" method="GET" class="w-full md:w-1/2 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kode, atau kategori barang..." class="w-full pl-12 pr-4 py-3 bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow focus:ring-0 focus:border-ts-red outline-none dark:text-white transition-all text-sm font-semibold">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">search</span>
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-ts-red hover:bg-ts-red-bright text-white px-3 py-1 border border-black transition-colors text-xs font-bold uppercase">Cari</button>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm mb-6 font-bold border border-green-200 hard-shadow">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 font-bold border border-red-200 hard-shadow">
                <strong>Perhatian!</strong> {{ session('error') }}
            </div>
        @endif

        <section class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-black dark:border-slate-500 text-on-surface dark:text-white">
                            <th class="py-4 px-2 text-sm font-bold uppercase w-16">Foto</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Kode Barang</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Nama Barang</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Kategori</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Kondisi</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Lokasi</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Stok</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($products ?? [] as $product)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">

                            <td class="py-4 px-2">
                                @if($product->image)
                                    <div class="w-14 h-14 border border-black hard-shadow overflow-hidden bg-white">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-14 h-14 border border-black bg-surface-container-low dark:bg-slate-700 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-slate-400 text-xl">image_not_supported</span>
                                    </div>
                                @endif
                            </td>

                            <td class="py-4 px-2 font-bold font-mono text-sm">{{ $product->product_code }}</td>
                            <td class="py-4 px-2 text-sm font-semibold">{{ $product->name }}</td>
                            
                            <td class="py-4 px-2 text-sm text-slate-600 dark:text-slate-300 font-medium">
                                {{ $product->category?->name ?? 'Umum' }}
                            </td>

                            <td class="py-4 px-2 text-sm">
                                <span class="px-2.5 py-1 text-[11px] font-black uppercase border border-black dark:border-slate-500 {{ ($product->condition ?? 'Bagus') === 'Bagus' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $product->condition ?? 'Bagus' }}
                                </span>
                            </td>
                            <td class="py-4 px-2 text-sm text-on-surface-variant dark:text-slate-300 font-medium">
                                {{ $product->location ?? 'Gudang Utama' }}
                            </td>
                            <td class="py-4 px-2 text-center">
                                <span class="{{ $product->stock > 0 ? 'bg-green-600' : 'bg-ts-red' }} text-white text-[11px] px-3 py-1 font-black">
                                    {{ $product->stock }} UNIT
                                </span>
                            </td>
                            
                            <td class="py-4 px-2 text-center flex justify-center gap-2 items-center">
                                
                                <a href="{{ route('products.show', $product->id) }}" class="bg-blue-100 dark:bg-slate-700 hover:bg-blue-200 dark:hover:bg-slate-600 text-blue-700 dark:text-blue-400 p-2 border border-transparent hover:border-black dark:hover:border-white transition-colors" title="Detail Barang">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>

                                @if(in_array(Auth::user()->role->name ?? '', ['Admin', 'Staff']))
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-on-surface dark:text-white p-2 border border-transparent hover:border-black dark:hover:border-white transition-colors" title="Edit Barang">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                @endif

                                @if((Auth::user()->role->name ?? '') === 'Admin')
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" id="form-delete-{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openConfirmModal('form-delete-{{ $product->id }}')" class="bg-ts-red hover:bg-ts-red-bright text-white p-2 border border-transparent hover:border-black transition-colors" title="Hapus Barang">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                                @endif

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-on-surface-variant dark:text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">inventory_2</span>
                                Belum ada data barang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
                @if(method_exists($products, 'links'))
                    {{ $products->appends(request()->query())->links() }}
                @endif
            </div>

        </section>
    </main>

    <div id="confirm-modal" class="fixed inset-0 z-[10000] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow p-6 w-full max-w-sm">
            <h3 class="text-lg font-black text-ts-red mb-3 uppercase">Peringatan Penghapusan</h3>
            <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6">Apakah Anda yakin ingin menghapus barang beserta fotonya secara permanen? Tindakan ini <b>tidak dapat dibatalkan</b>.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeConfirmModal()" class="flex-1 py-2 border-2 border-black dark:border-slate-500 font-bold hover:bg-slate-100 dark:hover:bg-slate-700">Batal</button>
                <button type="button" id="confirm-submit-btn" class="flex-1 py-2 bg-ts-red text-white font-bold border border-black hover:bg-red-800">Ya, Hapus</button>
            </div>
        </div>
    </div>

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
        // --- Modal Konfirmasi Logic ---
        let targetFormId = null;
        function openConfirmModal(formId) { 
            targetFormId = formId; 
            document.getElementById('confirm-modal').classList.remove('hidden'); 
        }
        function closeConfirmModal() { 
            document.getElementById('confirm-modal').classList.add('hidden'); 
            targetFormId = null; 
        }
        document.getElementById('confirm-submit-btn').addEventListener('click', () => {
            if (targetFormId) {
                // Tutup modal
                document.getElementById('confirm-modal').classList.add('hidden');
                
                // Munculkan loader secara manual
                const loader = document.getElementById('global-loader');
                loader.classList.remove('hidden', 'pointer-events-none');
                requestAnimationFrame(() => { loader.classList.remove('opacity-0'); loader.classList.add('opacity-100'); });
                
                // Eksekusi hapus
                document.getElementById(targetFormId).submit();
            }
        });

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

        // --- Dropdown Toggle ---
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

        const tombolMenu = document.getElementById('tombol-menu');
        const sidebar = document.getElementById('sidebar-kiri');

        if (tombolMenu && sidebar) {
            tombolMenu.addEventListener('click', function() {
                sidebar.classList.toggle('muncul');
            });
        }

        // --- Loading Overlay ---
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