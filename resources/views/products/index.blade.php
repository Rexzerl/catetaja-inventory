<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Inventaris Barang - Telkomsel Inventory</title>
    
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

    <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 pt-20 bg-surface dark:bg-slate-800 border-r border-outline dark:border-slate-700 px-4">
        <div class="space-y-2 mt-4">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Manager', 'Staff']))
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform active:translate-x-1" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Barang' : 'Inventaris Barang' }}</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('borrowings.index') }}">
                <span class="material-symbols-outlined">handshake</span>
                <span class="text-sm">{{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Peminjaman' : 'Data Peminjaman' }}</span>
            </a>
            @endif
        </div>
    </aside>

    <main class="pt-24 pb-20 md:pb-12 px-4 md:px-margin-desktop md:ml-64">
        
        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">
                    {{ (Auth::user()->role->name ?? '') === 'Manager' ? 'Laporan Inventaris Barang' : 'Data Inventaris Barang' }}
                </h1>
                <div class="h-2 w-32 bg-ts-orange mt-4"></div>
            </div>
            
            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
            <a href="{{ route('products.create') ?? '#' }}" class="flex items-center gap-2 bg-ts-red hover:bg-ts-red-bright text-white font-bold py-3 px-5 border border-black hard-shadow transition-transform active:translate-x-1">
                <span class="material-symbols-outlined text-sm">add</span>
                Tambah Barang Baru
            </a>
            @endif
        </header>

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
                            
                            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                            <th class="py-4 px-2 text-sm font-bold uppercase text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($products ?? [] as $product)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">

                        <!-- Menampilkan Gambar -->
                            <td class="py-4 px-2">
                                @if($product->image)
                                    <!-- Jika gambar ada, panggil dari folder storage -->
                                    <div class="w-14 h-14 border border-black hard-shadow overflow-hidden bg-white">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <!-- Placeholder jika barang tidak memiliki foto -->
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
                            
                            @if(in_array(Auth::user()->role->name ?? 'Admin', ['Admin', 'Staff']))
                            <td class="py-4 px-2 text-center flex justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-on-surface dark:text-white p-2 border border-transparent hover:border-black dark:hover:border-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                <form action="#" method="POST" onsubmit="return confirm('Hapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-ts-red hover:bg-ts-red-bright text-white p-2 border border-transparent hover:border-black transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-on-surface-variant dark:text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">inventory_2</span>
                                Belum ada data barang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

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