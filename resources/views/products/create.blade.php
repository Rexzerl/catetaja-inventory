<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Tambah Barang - Telkomsel Inventory</title>
    
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
        
        /* Drag & Drop Styles */
        .drag-active {
            border-color: #bc0007 !important;
            background-color: rgba(188, 0, 7, 0.05) !important;
        }
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
        </div>
    </nav>

    <!-- SideNavBar -->
    <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 pt-20 bg-surface dark:bg-slate-800 border-r border-outline dark:border-slate-700 px-4">
        <div class="space-y-2 mt-4">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-ts-red text-white hard-shadow font-bold transition-transform" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm">Master & Laporan Barang</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-slate-700 transition-all border border-transparent hover:border-black dark:hover:border-white" href="{{ route('borrowings.index') }}">
                <span class="material-symbols-outlined">handshake</span>
                <span class="text-sm">Master & Laporan Peminjaman</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="pt-24 pb-20 md:pb-12 px-4 md:px-margin-desktop md:ml-64 max-w-4xl">
        
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

            <!-- Wajib tambahkan enctype="multipart/form-data" untuk upload file -->
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Area Foto Drag & Drop -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400">Foto Barang (Opsional)</label>
                    <div id="drop-area" class="relative w-full h-48 bg-surface-container-low dark:bg-slate-900 border-2 border-dashed border-black dark:border-slate-500 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors overflow-hidden group">
                        
                        <!-- Preview Gambar -->
                        <img id="image-preview" class="absolute inset-0 w-full h-full object-contain hidden bg-white dark:bg-slate-900 z-10" alt="Preview">
                        
                        <!-- Konten Default -->
                        <div id="upload-content" class="flex flex-col items-center text-on-surface-variant dark:text-slate-400">
                            <span class="material-symbols-outlined text-4xl mb-2">cloud_upload</span>
                            <span class="font-bold text-sm">Drag & Drop foto di sini</span>
                            <span class="text-xs mt-1">atau klik untuk memilih file (JPG, PNG)</span>
                        </div>
                        
                        <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                    </div>
                    
                    <!-- Tombol Hapus Gambar (muncul saat gambar dipilih) -->
                    <button type="button" id="remove-image-btn" class="hidden text-ts-red text-xs font-bold uppercase mt-2 hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">delete</span> Hapus Foto
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="product_code">Kode Barang</label>
                        <input class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 font-mono focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="product_code" name="product_code" value="{{ old('product_code') }}" placeholder="Contoh: TSL-MKB-001" required type="text">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-slate-400" for="name">Nama Aset / Barang</label>
                        <input class="w-full px-4 py-3 bg-surface-container-low dark:bg-slate-900 border-2 border-black dark:border-slate-600 focus:ring-0 focus:border-ts-red outline-none dark:text-white" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama barang" required type="text">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gunakan <select> untuk Kategori yang merelasikan tabel Category -->
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
                    Simpan Data Master <span class="material-symbols-outlined text-[20px]">save</span>
                </button>
            </form>
        </section>
    </main>

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

        // Mencegah perilaku default browser saat file ditarik
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Menambahkan efek visual saat file berada di atas area
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

        // Menangani file saat dijatuhkan (drop)
        dropArea.addEventListener('drop', (e) => {
            let dt = e.dataTransfer;
            let files = dt.files;
            
            // Masukkan file ke input element
            if (files.length > 0) {
                fileInput.files = files;
                handleFiles(files[0]);
            }
        });

        // Menangani file saat diklik manual
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFiles(this.files[0]);
            }
        });

        // Fungsi untuk membaca dan menampilkan gambar
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

        // Fungsi untuk menghapus gambar yang dipilih
        removeBtn.addEventListener('click', () => {
            fileInput.value = ''; // Reset input file
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadContent.classList.remove('hidden');
            removeBtn.classList.add('hidden');
        });
    </script>
</body>
</html>