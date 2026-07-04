<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Riwayat Peminjaman - Telkomsel Inventory</title>
    
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
    </style>
</head>
<body class="bg-surface dark:bg-slate-900 text-on-surface dark:text-white transition-colors duration-300 min-h-screen">
    
    <!-- TopNavBar -->
    <nav class="bg-surface dark:bg-slate-800 border-b border-outline dark:border-slate-700 fixed top-0 w-full z-50 h-16 flex justify-between items-center px-4 md:px-margin-desktop">
        <div class="flex items-center gap-4">
            <img alt="Telkomsel Logo" class="h-8 object-contain" src="{{ asset('images/telkomsel-logo.png') }}">
            <span class="text-xl font-black text-ts-red dark:text-ts-red-bright hidden md:block">Telkomsel Inventory</span>
        </div>
        <div class="flex items-center gap-6">
            <button class="p-2 hover:bg-surface-container-low dark:hover:bg-slate-700 rounded-full transition-colors flex items-center justify-center" onclick="toggleDarkMode()">
                <span class="material-symbols-outlined" id="dark-mode-icon">dark_mode</span>
            </button>
            <div class="flex items-center gap-3 border-l border-outline/20 pl-6 dark:border-slate-700">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-on-surface-variant dark:text-slate-400 uppercase tracking-widest">{{ Auth::user()->role->name ?? 'User' }}</p>
                </div>
                <div class="w-10 h-10 rounded-full border-2 border-ts-red overflow-hidden">
                    <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=bc0007&color=fff" alt="Avatar">
                </div>
            </div>
        </div>
    </nav>

    <!-- SideNavBar -->
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
        
        <div class="mt-auto mb-8 space-y-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-3 text-ts-red hover:bg-red-50 dark:hover:bg-red-900/20 transition-all border border-transparent hover:border-ts-red" type="submit">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-bold">Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="pt-24 pb-20 md:pb-12 px-4 md:px-margin-desktop md:ml-64">
        
        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">
                    {{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Riwayat Peminjaman' : 'Data Riwayat Peminjaman' }}
                </h1>
                <div class="h-2 w-32 bg-ts-orange mt-4"></div>
            </div>
            
            <!-- Tombol Tambah HANYA muncul untuk Admin/Staff -->
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
            <a href="{{ route('borrowings.create') ?? '#' }}" class="flex items-center gap-2 bg-ts-orange hover:bg-orange-500 text-black font-bold py-3 px-5 border border-black hard-shadow transition-transform active:translate-x-1">
                <span class="material-symbols-outlined text-sm">assignment_add</span>
                Catat Peminjaman
            </a>
            @endif
        </header>

        <!-- Tabel Bento Grid -->
        <section class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-black dark:border-slate-500 text-on-surface dark:text-white">
                            <th class="py-4 px-2 text-sm font-bold uppercase">Nama Peminjam</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase">Tanggal Pinjam</th>
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Status</th>
                            
                            <!-- Header Aksi HANYA muncul untuk Admin/Staff -->
                            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($borrowings ?? [] as $borrowing)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="py-4 px-2 font-bold">{{ $borrowing->employee_name }}</td>
                            <td class="py-4 px-2 text-sm">{{ $borrowing->borrow_date }}</td>
                            <td class="py-4 px-2 text-center">
                                @if($borrowing->status === 'Dipinjam')
                                    <span class="bg-ts-red text-white text-[11px] px-3 py-1 font-black uppercase">Dipinjam</span>
                                @else
                                    <span class="bg-green-600 text-white text-[11px] px-3 py-1 font-black uppercase">Kembali</span>
                                @endif
                            </td>
                            
                            <!-- Kolom Aksi HANYA muncul untuk Admin/Staff -->
                            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                            <td class="py-4 px-2 text-center flex justify-center gap-2">
                                @if($borrowing->status === 'Dipinjam')
                                <form action="#" method="POST" onsubmit="return confirm('Proses pengembalian barang ini?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="flex items-center gap-1 bg-black text-white px-3 py-2 border border-transparent hover:border-ts-red transition-colors text-xs font-bold">
                                        <span class="material-symbols-outlined text-sm">keyboard_return</span>
                                        KEMBALIKAN
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-slate-400 font-bold italic">Selesai</span>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-on-surface-variant dark:text-slate-400">
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

    <!-- Mobile Navigation Bar -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-surface dark:bg-slate-800 border-t border-outline dark:border-slate-700 flex justify-around items-center py-3 z-50">
        <a class="flex flex-col items-center text-on-surface-variant dark:text-slate-400" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-[10px] font-bold uppercase mt-1">Dash</span>
        </a>
        @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Manager', 'Staff']))
        <a class="flex flex-col items-center text-on-surface-variant dark:text-slate-400" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="text-[10px] font-bold uppercase mt-1">Inv</span>
        </a>
        <a class="flex flex-col items-center text-ts-red" href="{{ route('borrowings.index') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">handshake</span>
            <span class="text-[10px] font-bold uppercase mt-1">Pinjam</span>
        </a>
        @endif
    </nav>

    <script>
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
    </script>
</body>
</html>