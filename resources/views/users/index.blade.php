<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kelola Akun - CatetAja!</title>
    
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
                        "surface-container-low": "#f3f3f3", "surface-container": "#eeeeee", "ts-red": "#bc0007", "ts-red-bright": "#e2241d", "ts-orange": "#fd9923"
                    },
                    fontFamily: { "headline-xl": ["Montserrat"], "body-md": ["Montserrat"], "label-md": ["Montserrat"] }
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
    
    <nav class="bg-surface dark:bg-slate-800 border-b border-outline dark:border-slate-700 fixed top-0 w-full z-50 h-16 flex justify-between items-center px-4 md:px-12">
        <div class="flex items-center gap-4">
            <button id="tombol-menu" class="btn-hamburger">☰</button>
            <img alt="Telkomsel Logo" class="h-8 object-contain" src="{{ asset('images/telkomsel-logo.png') }}">
            <span class="text-xl font-black text-ts-red hidden md:block">CatetAja!</span>
        </div>
        <div class="flex items-center gap-6">
            <button class="p-2 hover:bg-surface-container-low dark:hover:bg-slate-700 rounded-full transition-colors flex items-center justify-center" onclick="toggleDarkMode()">
                <span class="material-symbols-outlined" id="dark-mode-icon">dark_mode</span>
            </button>
            <div class="relative group">
                <button class="flex items-center gap-3 border-l border-outline/20 pl-6 dark:border-slate-700 py-1" id="profile-menu-btn">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-on-surface-variant dark:text-slate-400 uppercase tracking-widest">{{ Auth::user()->role->name ?? 'User' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full border-2 border-ts-red overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=bc0007&color=fff" alt="Avatar">
                    </div>
                    <span class="material-symbols-outlined text-sm text-slate-400 group-hover:rotate-180 transition-transform">keyboard_arrow_down</span>
                </button>
                <div class="absolute right-0 top-full pt-3 w-48 hidden group-hover:block z-50" id="dropdown-menu">
                    <div class="bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow py-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="w-full flex items-center gap-3 px-4 py-3 text-ts-red hover:bg-red-50 dark:hover:bg-red-900/20 font-bold text-left" type="submit">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 pt-20 bg-surface dark:bg-slate-800 border-r border-outline dark:border-slate-700 px-4">
        <div class="space-y-2 mt-4">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low transition-all border border-transparent hover:border-black" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span> <span class="text-sm">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low transition-all border border-transparent hover:border-black" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span> <span class="text-sm">Inventaris Barang</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low transition-all border border-transparent hover:border-black" href="{{ route('borrowings.index') }}">
                <span class="material-symbols-outlined">handshake</span> <span class="text-sm">Data Peminjaman</span>
            </a>
            @if((Auth::user()->role->name ?? '') === 'Admin')
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform active:translate-x-1" href="{{ route('users.index') }}">
                <span class="material-symbols-outlined">shield_person</span> <span class="text-sm">Kelola Akun (Admin)</span>
            </a>
            @endif
        </div>
    </aside>

    <main class="pt-24 pb-20 md:pb-12 px-4 md:px-12 md:ml-64">
        <header class="mb-10">
            <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">Manajemen Akun Terdaftar</h1>
            <div class="h-2 w-32 bg-ts-orange mt-4"></div>
            <p class="text-sm text-slate-500 font-bold mt-2">Area Kredensial Khusus Admin</p>
        </header>

        @if (session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm mb-6 font-bold border border-green-200 hard-shadow"><strong>Berhasil!</strong> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 font-bold border border-red-200 hard-shadow"><strong>Perhatian!</strong> {{ session('error') }}</div>
        @endif

        <section class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-black dark:border-slate-500">
                            <th class="py-4 px-4 text-sm font-bold uppercase w-1/3">Nama Pengguna</th>
                            <th class="py-4 px-4 text-sm font-bold uppercase w-1/3">Alamat Email</th>
                            <th class="py-4 px-4 text-sm font-bold uppercase text-center">Hak Akses / Role</th>
                            <th class="py-4 px-4 text-sm font-bold uppercase text-center w-24">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                            <td class="py-4 px-4 font-bold">
                                <div class="flex items-center gap-3">
                                    <img class="w-8 h-8 rounded-full border border-black" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Avatar">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-sm font-mono text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                            <td class="py-4 px-4 text-center">
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="flex justify-center">
                                        @csrf @method('PUT')
                                        <select name="role_id" onchange="this.form.submit()" class="text-xs font-bold border border-black px-3 py-1.5 bg-white dark:bg-slate-700 cursor-pointer outline-none focus:border-ts-red focus:ring-1 focus:ring-ts-red w-36 text-center">
                                            <option value="" disabled {{ !$user->role_id ? 'selected' : '' }}>Pilih Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="bg-black text-white text-[11px] px-3 py-1.5 font-black uppercase inline-block">Administrator (Anda)</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="form-delete-{{ $user->id }}" class="flex justify-center">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="openConfirmModal('form-delete-{{ $user->id }}')" class="bg-ts-red hover:bg-red-800 text-white p-2 border border-transparent hover:border-black transition-colors flex items-center justify-center" title="Cabut Akses Akun">
                                        <span class="material-symbols-outlined text-sm">delete_forever</span>
                                    </button>
                                </form>
                                @else
                                <span class="text-xs font-bold text-slate-400 italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <div id="confirm-modal" class="fixed inset-0 z-[10000] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 border-2 border-black dark:border-slate-600 hard-shadow p-6 w-full max-w-sm">
            <h3 class="text-lg font-black text-ts-red mb-3 uppercase">Peringatan Keamanan</h3>
            <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6">Tindakan ini akan <b>mencabut akses</b> dan menghapus akun pengguna ini secara permanen dari database. Lanjutkan?</p>
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
            <p class="mt-10 text-sm font-black text-ts-red dark:text-white uppercase tracking-widest animate-pulse">Loading...</p>
        </div>
    </div>

    <script>
        // Modal Logic
        let targetFormId = null;
        function openConfirmModal(formId) { targetFormId = formId; document.getElementById('confirm-modal').classList.remove('hidden'); }
        function closeConfirmModal() { document.getElementById('confirm-modal').classList.add('hidden'); targetFormId = null; }
        document.getElementById('confirm-submit-btn').addEventListener('click', () => {
            if (targetFormId) { document.getElementById('confirm-modal').classList.add('hidden'); document.getElementById(targetFormId).submit(); }
        });

        // Theme Logic
        function toggleDarkMode() {
            const html = document.documentElement; const icon = document.getElementById('dark-mode-icon');
            if (html.classList.contains('dark')) { html.classList.remove('dark'); icon.textContent = 'dark_mode'; localStorage.setItem('theme', 'light'); } 
            else { html.classList.add('dark'); icon.textContent = 'light_mode'; localStorage.setItem('theme', 'dark'); }
        }
        if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); document.getElementById('dark-mode-icon').textContent = 'light_mode'; }

        // Dropdown Logic
        const profileBtn = document.getElementById('profile-menu-btn'); const dropdownMenu = document.getElementById('dropdown-menu');
        if (profileBtn && dropdownMenu) {
            profileBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownMenu.classList.toggle('hidden'); });
            document.addEventListener('click', () => { if (!dropdownMenu.classList.contains('hidden')) dropdownMenu.classList.add('hidden'); });
        }

        const tombolMenu = document.getElementById('tombol-menu');
        const sidebar = document.getElementById('sidebar-kiri');

        if (tombolMenu && sidebar) {
            tombolMenu.addEventListener('click', function() {
                sidebar.classList.toggle('muncul');
            });
        }

        // Loading Overlay Logic
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('global-loader');
            const showLoader = () => { loader.classList.remove('hidden', 'pointer-events-none'); requestAnimationFrame(() => { loader.classList.remove('opacity-0'); loader.classList.add('opacity-100'); }); };
            const hideLoader = () => { loader.classList.remove('opacity-100'); loader.classList.add('opacity-0'); setTimeout(() => { loader.classList.add('hidden', 'pointer-events-none'); }, 300); };
            document.querySelectorAll('form').forEach(form => { form.addEventListener('submit', () => { showLoader(); }); });
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', (e) => {
                    const href = link.getAttribute('href'); const target = link.getAttribute('target');
                    if (href && href !== '#' && !href.startsWith('javascript') && target !== '_blank' && !href.includes('export')) { showLoader(); }
                });
            });
            window.addEventListener('pageshow', (e) => { if (e.persisted) hideLoader(); });
        });
    </script>
</body>
</html>