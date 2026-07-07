<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Riwayat Peminjaman -  CatetAja!</title>
    
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
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Manager', 'Staff']))
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Barang' : 'Inventaris Barang' }}</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform active:translate-x-1" href="{{ route('borrowings.index') }}">
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
                    {{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Riwayat Peminjaman' : 'Data Riwayat Peminjaman' }}
                </h1>
                <div class="h-2 w-32 bg-ts-red mt-4"></div>
            </div>
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
            <a href="{{ route('borrowings.create') ?? '#' }}" class="flex items-center gap-2 bg-ts-red hover:bg-ts-red-bright text-white font-bold py-3 px-5 border border-black hard-shadow transition-transform active:translate-x-1">
                <span class="material-symbols-outlined text-sm">assignment_add</span>
                Catat Peminjaman
            </a>
            @endif
        </header> 
        
        @if (session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm mb-6 font-bold border border-green-200 hard-shadow">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 font-bold border border-red-200 hard-shadow">
                <strong>Gagal Memproses!</strong> {{ session('error') }}
            </div>
        @endif

        <section class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-black dark:border-slate-500 text-on-surface dark:text-white">
                            <th class="py-4 px-2 text-sm font-bold uppercase">Nama Peminjam</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Nama Barang</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Kode Barang</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Tanggal Pinjam</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Tanggal Kembali</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Status</th>
                            
                            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($borrowings ?? [] as $borrowing)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="py-4 px-2 font-bold">{{ $borrowing->employee_name }}</td>
                            <td class="py-4 px-2 text-sm font-semibold">{{ $borrowing->details->first()->product->name ?? '-' }}</td>
                            <td class="py-4 px-2 text-sm font-mono">{{ $borrowing->details->first()->product->product_code ?? '-' }}</td>
                            <td class="py-4 px-2 text-sm">{{ $borrowing->borrow_date }}</td>
                            <td class="py-4 px-2 text-sm">
                                @if($borrowing->return_date)
                                    {{ $borrowing->return_date }}
                                @else
                                    <span class="text-slate-400 font-bold italic">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-2 text-center">
                                @if($borrowing->status === 'Dipinjam')
                                    <span class="bg-ts-red text-white text-[11px] px-3 py-1 font-black uppercase">Dipinjam</span>
                                @else
                                    <span class="bg-green-600 text-white text-[11px] px-3 py-1 font-black uppercase">Kembali</span>
                                @endif
                            </td>
                            
                            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                            <td class="py-4 px-2 text-center flex justify-center gap-2 items-center">
                                @if($borrowing->status === 'Dipinjam')
                                    @if(in_array(Auth::user()->role->name ?? '', ['Admin', 'Staff']))
                                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" id="form-return-{{ $borrowing->id }}">
                                        @csrf @method('PUT')
                                        <button type="button" onclick="openConfirmModal('form-return-{{ $borrowing->id }}')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                            Kembalikan
                                        </button>
                                    </form>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400 font-bold italic">Selesai</span>
                                @endif

                                @if((Auth::user()->role->name ?? '') === 'Admin' && $borrowing->status !== 'Dipinjam')
                               <form action="{{ route('borrowings.destroy', $borrowing->id) }}" method="POST" id="form-delete-{{ $borrowing->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="openDeleteModal('form-delete-{{ $borrowing->id }}')" class="bg-ts-red hover:bg-red-800 text-white p-1 rounded transition-colors" title="Hapus Riwayat">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-on-surface-variant dark:text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">history</span>
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <div id="confirm-modal" class="fixed inset-0 z-[10000] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow p-6 w-full max-w-sm">
            <h3 class="text-lg font-black text-ts-red mb-3 uppercase">Konfirmasi Pengembalian</h3>
            <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6">Apakah Anda yakin ingin mengembalikan barang ini? Stok akan otomatis diperbarui.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeConfirmModal()" class="flex-1 py-2 border-2 border-black dark:border-slate-500 font-bold hover:bg-slate-100 dark:hover:bg-slate-700">Batal</button>
                <button type="button" id="confirm-submit-btn" class="flex-1 py-2 bg-ts-red text-white font-bold border border-black hover:bg-red-800">Kembalikan</button>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-[10000] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow p-6 w-full max-w-sm">
        <h3 class="text-lg font-black text-ts-red mb-3 uppercase">Konfirmasi Hapus</h3>
        <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6">Apakah Anda yakin ingin menghapus permanen riwayat ini? Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2 border-2 border-black dark:border-slate-500 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Batal</button>
            <button type="button" id="delete-submit-btn" class="flex-1 py-2 bg-ts-red text-white font-bold border border-black hover:bg-red-800 transition-colors">Hapus</button>
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
        // Modal Konfirmasi Logic
        let targetFormId = null;
        function openConfirmModal(formId) {
            targetFormId = formId;
            document.getElementById('confirm-modal').classList.remove('hidden');
        }
        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
            targetFormId = null;
        }
                // Modal Konfirmasi Hapus Logic
        let targetDeleteFormId = null;

        function openDeleteModal(formId) {
            targetDeleteFormId = formId;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            targetDeleteFormId = null;
        }

        document.getElementById('delete-submit-btn').addEventListener('click', () => {
            if (targetDeleteFormId) {
                document.getElementById('delete-modal').classList.add('hidden');
                document.getElementById(targetDeleteFormId).submit();
            }
        });
        document.getElementById('confirm-submit-btn').addEventListener('click', () => {
            if (targetFormId) {
                document.getElementById('confirm-modal').classList.add('hidden');
                document.getElementById(targetFormId).submit();
            }
        });

        // Toggle Tema
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

        // Toggle Dropdown
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

        // Loading Overlay
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