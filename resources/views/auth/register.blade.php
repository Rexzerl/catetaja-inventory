<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Daftar - Telkomsel Inventory Management</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <script id="tailwind-config">
    try {
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#e2241d", "on-primary-container": "#fffbff", "error": "#ba1a1a", "on-secondary-fixed": "#2d1600",
                        "on-primary-fixed-variant": "#930004", "surface-tint": "#c00007", "tertiary-fixed-dim": "#bec6e0", "tertiary-container": "#6c748b",
                        "outline": "#926f6a", "background": "#f8f9ff", "on-primary": "#ffffff", "surface-bright": "#f8f9ff", "on-secondary": "#ffffff",
                        "surface-container-low": "#eff4ff", "on-secondary-fixed-variant": "#6b3b00", "on-tertiary-fixed-variant": "#3f465c",
                        "on-error-container": "#93000a", "surface-dim": "#cbdbf5", "surface-container-highest": "#d3e4fe", "secondary-fixed": "#ffdcbf",
                        "on-primary-fixed": "#410001", "on-secondary-container": "#663800", "on-tertiary-container": "#fefcff", "secondary": "#8c4f00",
                        "on-surface": "#0b1c30", "surface-container-high": "#dce9ff", "surface-container": "#e5eeff", "surface-variant": "#d3e4fe",
                        "primary": "#bc0007", "on-surface-variant": "#5d3f3b", "error-container": "#ffdad6", "inverse-on-surface": "#eaf1ff",
                        "tertiary-fixed": "#dae2fd", "outline-variant": "#e7bdb7", "primary-fixed-dim": "#ffb4a9", "on-background": "#0b1c30",
                        "secondary-container": "#fd9923", "on-tertiary": "#ffffff", "tertiary": "#545c72", "on-error": "#ffffff",
                        "secondary-fixed-dim": "#ffb874", "inverse-primary": "#ffb4a9", "inverse-surface": "#213145", "surface": "#f8f9ff",
                        "primary-fixed": "#ffdad5", "surface-container-lowest": "#ffffff", "on-tertiary-fixed": "#131b2e"
                    },
                    "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                    "spacing": { "stack-sm": "0.5rem", "stack-md": "1rem", "margin-desktop": "2.5rem", "gutter": "1.5rem", "margin-mobile": "1rem", "stack-lg": "2rem", "container-max": "1280px" },
                    "fontFamily": {
                        "headline-lg-mobile": ["Montserrat"], "body-md": ["Montserrat"], "headline-lg": ["Montserrat"], "headline-xl": ["Montserrat"],
                        "body-lg": ["Montserrat"], "code": ["Montserrat"], "headline-md": ["Montserrat"], "label-md": ["Montserrat"]
                    },
                    "fontSize": {
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "700"}], "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}], "headline-xl": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "800"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}], "code": ["14px", {"lineHeight": "20px", "fontWeight": "500"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "700"}], "label-md": ["14px", {"lineHeight": "20px", "fontWeight": "600"}]
                    }
                }
            }
        }
    } catch(_e) {}
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .gradient-brand { background: linear-gradient(135deg, #bc0007 0%, #fd9923 100%); }
        .split-curve { border-bottom-right-radius: 32px; }
        @media (min-width: 768px) { .split-curve { border-bottom-right-radius: 64px; } }
    </style>
</head>
<body class="bg-background dark:bg-on-background min-h-screen transition-colors duration-300">
    
    <button class="fixed top-6 left-6 z-[100] p-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-white/20 transition-all active:scale-95 flex items-center justify-center shadow-lg" id="theme-toggle">
        <span class="material-symbols-outlined" data-icon="dark_mode" id="theme-icon">dark_mode</span>
    </button>
    
    <main class="min-h-screen flex flex-col md:grid md:grid-cols-2">
        
        <section class="relative h-64 md:h-screen w-full overflow-hidden flex items-end md:items-center px-margin-mobile md:px-margin-desktop split-curve md:rounded-none">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/70 to-secondary-container/80 z-10"></div>
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/login-banner.jpg') }}');"></div>
            </div>
            
            <div class="relative z-20 w-full mb-10 md:mb-0 max-w-xl">
                <h1 class="font-headline-xl text-headline-lg-mobile md:text-headline-xl text-white mb-4 tracking-tight">
                    Atur Pengelolaan Inventarismu dengan Telkomsel Inventory!
                </h1>
                <p class="text-white/90 text-body-lg font-body-lg max-w-md hidden md:block">
                    Solusi terpercaya untuk manajemen aset dan stok barang dengan kecepatan serta akurasi standar industri.
                </p>
            </div>
        </section>

        <section class="flex flex-col items-center justify-center bg-background dark:bg-on-background px-margin-mobile md:px-margin-desktop py-12">
            <div class="w-full max-w-md space-y-8">
                
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 mb-6 flex items-center justify-center">
                        <img alt="Telkomsel Logo" class="w-full h-full object-contain drop-shadow-xl" src="{{ asset('images/telkomsel-logo.png') }}">
                    </div>
                    <h2 class="font-headline-md text-headline-md text-on-surface dark:text-inverse-on-surface">Daftar Akun Baru</h2>
                    <p class="text-on-surface-variant dark:text-outline-variant mt-2 font-body-md">Lengkapi data di bawah ini untuk membuat akun</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/50 text-red-600 dark:text-red-400 p-4 rounded-xl text-sm">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" class="space-y-6" method="POST">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant dark:text-outline-variant px-1" for="name">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-outline dark:text-outline-variant">
                                <span class="material-symbols-outlined" data-icon="person">person</span>
                            </span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low dark:bg-surface-dim/10 border-2 border-transparent focus:border-primary dark:focus:border-secondary-container rounded-xl text-on-surface dark:text-on-primary-container placeholder:text-outline/50 transition-all outline-none" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required type="text">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant dark:text-outline-variant px-1" for="email">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-outline dark:text-outline-variant">
                                <span class="material-symbols-outlined" data-icon="mail">mail</span>
                            </span>
                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low dark:bg-surface-dim/10 border-2 border-transparent focus:border-primary dark:focus:border-secondary-container rounded-xl text-on-surface dark:text-on-primary-container placeholder:text-outline/50 transition-all outline-none" id="email" name="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com" required type="email">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant dark:text-outline-variant px-1" for="password">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-outline dark:text-outline-variant">
                                <span class="material-symbols-outlined" data-icon="lock">lock</span>
                            </span>
                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-low dark:bg-surface-dim/10 border-2 border-transparent focus:border-primary dark:focus:border-secondary-container rounded-xl text-on-surface dark:text-on-primary-container placeholder:text-outline/50 transition-all outline-none" id="password" name="password" placeholder="Min. 8 Karakter" required type="password">
                            <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-primary transition-colors" onclick="toggleVisibility('password', 'password-icon')" type="button">
                                <span class="material-symbols-outlined" id="password-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant dark:text-outline-variant px-1" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-outline dark:text-outline-variant">
                                <span class="material-symbols-outlined" data-icon="lock_reset">lock_reset</span>
                            </span>
                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-low dark:bg-surface-dim/10 border-2 border-transparent focus:border-primary dark:focus:border-secondary-container rounded-xl text-on-surface dark:text-on-primary-container placeholder:text-outline/50 transition-all outline-none" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required type="password">
                            <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-primary transition-colors" onclick="toggleVisibility('password_confirmation', 'confirm-icon')" type="button">
                                <span class="material-symbols-outlined" id="confirm-icon">visibility</span>
                            </button>
                        </div>
                    </div>
                    
                    <button class="w-full py-4 gradient-brand text-white font-bold text-body-lg rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:scale-[1.02] active:scale-95 transition-all duration-200 flex items-center justify-center gap-2 mt-4" type="submit">
                        Daftar Akun Baru
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                    </button>
                </form>
                
                <div class="text-center pt-4">
                    <p class="text-body-md text-on-surface-variant dark:text-outline-variant">
                        Sudah memiliki akun? 
                        <a class="font-bold text-primary dark:text-secondary-container hover:underline decoration-2 underline-offset-4 ml-1" href="{{ route('login') }}">Masuk</a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                themeIcon.textContent = 'dark_mode';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                themeIcon.textContent = 'light_mode';
                localStorage.setItem('theme', 'dark');
            }
        });

        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeIcon.textContent = 'light_mode';
        } else {
            html.classList.remove('dark');
            themeIcon.textContent = 'dark_mode';
        }

        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => button.style.opacity = '0.8');
            button.addEventListener('mouseup', () => button.style.opacity = '1');
            button.addEventListener('mouseleave', () => button.style.opacity = '1');
        });
    </script>
</body>
</html>