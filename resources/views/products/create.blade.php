<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Tambah Barang - CatetAja!</title>
    
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
            <span class="text-xl font-black text-ts-red dark:text-ts-red-bright hidden md:block">Telkomsel Inventory</span>
        </div>
        <div class="flex items-center gap-6">
            <button class="p-2 hover:bg-surface-container-low dark:hover:bg-slate-700 rounded-full transition-colors flex items-center justify-center" onclick="toggleDarkMode()">
                <span class="material-symbols-outlined" id="dark-mode-icon">dark_mode</span>
            </button>
            
            <div class="relative group">
                <button class="flex items-center gap-3 border-l border-outline/20 pl-6 dark:border-slate-700 focus:outline-none cursor-pointer py-1" id="profile-menu-btn">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-[10px] text-on-surface-variant dark:text-slate-400 uppercase tracking-widest">{{ Auth::user()->role->name ?? 'Role' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full border-2 border-ts-red overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=bc0007&color=fff" alt="Avatar">
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
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">Inventaris Barang</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('borrowings.index') }}">
                <span class="material-symbols-outlined">handshake</span>
                <span class="text-sm">Data Peminjaman</span>
            </a>
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
                <a href="{{ route('products.index') }}" class="p-2 bg-slate-200 dark:bg-slate-700 border border-black hover:bg-slate-300 transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                <h1 class="text-2xl md:text-3xl font-black uppercase tracking-tight text-ts-red dark:text-white leading-none">Tambah Barang Baru</h1>
            </header>

            <section class="bg-white dark:bg-slate-800 border border-black dark:border-slate-600 hard-shadow p-6 md:p-8">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 font-bold border border-red-200">
                        <ul>@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Foto Barang (Opsional)</label>
                        <div id="drop-area" class="relative w-full h-48 bg-surface-container-low dark:bg-slate-900 border-2 border-dashed border-black dark:border-slate-500 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors overflow-hidden group">
                            
                            <img id="image-preview" class="absolute inset-0 w-full h-full object-contain hidden bg-white dark:bg-slate-900 z-10" alt="Preview">
                            
                            <div id="upload-content" class="flex flex-col items-center text-on-surface-variant dark:text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-2">cloud_upload</span>
                                <span class="font-bold text-sm">Drag & Drop foto di sini</span>
                                <span class="text-xs mt-1">atau klik untuk memilih file (JPG, PNG)</span>
                            </div>
                            
                            <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        </div>
                        
                        <button type="button" id="remove-image-btn" class="hidden text-ts-red text-xs font-bold uppercase mt-2 hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">delete</span> Hapus Foto
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="product_code">Kode Barang</label>
                            <input class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-mono focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="product_code" name="product_code" value="{{ old('product_code') }}" placeholder="Contoh: ATK-001" required type="text">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="name">Nama Aset / Barang</label>
                            <input class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama barang" required type="text">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="category_id">Kategori Barang</label>
                            <select class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="category_id" name="category_id" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="condition">Kondisi Barang</label>
                            <select class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="condition" name="condition" required>
                                <option value="Bagus" {{ old('condition') === 'Bagus' ? 'selected' : '' }}>Bagus (Siap Pakai)</option>
                                <option value="Rusak Ringan" {{ old('condition') === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Perbaikan" {{ old('condition') === 'Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="location">Lokasi Penempatan</label>
                            <input class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Gudang Utama / Ruang IT" required type="text">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="stock">Stok Awal (Unit)</label>
                            <input class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="stock" name="stock" value="{{ old('stock', 1) }}" min="1" required type="number">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 telkomsel-gradient text-white font-bold uppercase border border-black hard-shadow hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-2 mt-4">
                        Simpan Data <span class="material-symbols-outlined text-[20px]">save</span>
                    </button>
                </form>
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

        // --- Logika Drag & Drop Gambar ---
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const uploadContent = document.getElementById('upload-content');
        const removeBtn = document.getElementById('remove-image-btn');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add('drag-active');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove('drag-active');
            }, false);
        });
        
        dropArea.addEventListener('drop', (e) => {
            let dt = e.dataTransfer;
            let files = dt.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFiles(files[0]);
            }
        });
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFiles(this.files[0]);
            }
        });
        
        function handleFiles(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadContent.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        removeBtn.addEventListener('click', () => {
            fileInput.value = ''; 
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadContent.classList.remove('hidden');
            removeBtn.classList.add('hidden');
        });

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
                form.addEventListener('submit', () => {
                    showLoader();
                });
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

            window.addEventListener('pageshow', (e) => {
                if (e.persisted) {
                    hideLoader();
                }
            });
        });
    </script>
</body>
</html>