<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Rekam Medis Elektronik' }} - Praktik Dokter Umum</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Dark Mode initialization script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS (CDN) with Dark Mode Support -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Inter"', 'sans-serif'],
                    },
                    colors: {
                        clinical: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 antialiased min-h-screen flex flex-col font-sans selection:bg-teal-500 selection:text-white transition-colors duration-200"
      x-data="{
          isDark: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.isDark = !this.isDark;
              if (this.isDark) {
                  document.documentElement.classList.add('dark');
                  localStorage.theme = 'dark';
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.theme = 'light';
              }
          }
      }">

    <!-- TOP NAVBAR -->
    <nav class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40 shadow-sm no-print transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-600 to-emerald-500 flex items-center justify-center text-white shadow-md shadow-teal-500/20 group-hover:scale-105 transition-transform duration-200">
                            <!-- Medical Cross SVG -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white block leading-tight">Medika RME</span>
                            <span class="text-xs font-medium text-teal-600 dark:text-teal-400 tracking-wide uppercase">Praktik Dokter Umum</span>
                        </div>
                    </a>

                    <!-- Nav Links -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-teal-50 dark:bg-teal-900/40 text-teal-700 dark:text-teal-300 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>

                        <a href="{{ route('patients.index') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('patients.*') && !request()->routeIs('patients.create') ? 'bg-teal-50 dark:bg-teal-900/40 text-teal-700 dark:text-teal-300 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Data Pasien</span>
                            </div>
                        </a>

                    </div>
                </div>

                <!-- Right Side: Dark Mode Toggle, User Info, & Logout -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- DARK MODE TOGGLE BUTTON -->
                    <button type="button" 
                            @click="toggleTheme()" 
                            class="p-2 rounded-xl text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-amber-300 hover:bg-slate-100 dark:hover:bg-slate-700/70 border border-slate-200 dark:border-slate-700 transition-all duration-150"
                            title="Beralih Tema Gelap / Terang">
                        <!-- Sun Icon (aktif saat dark mode) -->
                        <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <!-- Moon Icon (aktif saat light mode) -->
                        <svg x-show="!isDark" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    @auth
                        <div class="flex items-center space-x-3 pr-2 border-r border-slate-200 dark:border-slate-700">
                            <div class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-700 dark:text-slate-200 font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200 block leading-tight">{{ auth()->user()->username }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300">
                                    Admin / Perawat
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Logout Universal -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-transparent hover:border-rose-200 dark:hover:border-rose-800 transition-colors duration-150"
                                    title="Keluar dari sistem"
                                    onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full no-print">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 p-4 shadow-sm flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-emerald-900 dark:text-emerald-300">Berhasil!</h4>
                        <p class="text-sm text-emerald-700 dark:text-emerald-400 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300 text-sm font-bold">&times;</button>
            </div>
        @endif

        @if(session('error') || $errors->has('general'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 p-4 shadow-sm flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-rose-100 dark:bg-rose-900/60 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-rose-900 dark:text-rose-300">Peringatan / Kesalahan</h4>
                        <p class="text-sm text-rose-700 dark:text-rose-400 mt-0.5">{{ session('error') ?? $errors->first('general') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700 dark:hover:text-rose-300 text-sm font-bold">&times;</button>
            </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 py-4 no-print text-center text-xs text-slate-500 dark:text-slate-400 mt-auto transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <span>Sistem Informasi Rekam Medis Elektronik (RME) &copy; {{ date('Y') }} - Praktik Mandiri Dokter Umum</span>
            <span class="text-slate-400 dark:text-slate-500">Status Sistem: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">● Aktif (Terautentikasi)</span></span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
