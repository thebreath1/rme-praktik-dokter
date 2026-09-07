<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rekam Medis Elektronik Praktik Dokter Umum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Anti-FOUC Dark Mode initialization script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-100 via-teal-50 to-emerald-100 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 min-h-screen flex items-center justify-center p-4 font-sans antialiased text-slate-800 dark:text-slate-100 selection:bg-teal-500 selection:text-white transition-colors duration-200"
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
          },
          fillDemo(u, p) {
              document.getElementById('username').value = u;
              document.getElementById('password').value = p;
          }
      }">

    <!-- Dark Mode Toggle Button (Top-Right) -->
    <div class="fixed top-5 right-5 z-50">
        <button type="button" 
                @click="toggleTheme()" 
                class="p-2.5 rounded-2xl bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-md border border-slate-200/80 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-amber-300 transition-all duration-150"
                title="Beralih Tema Gelap / Terang">
            <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <svg x-show="!isDark" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>
    </div>

    <div class="max-w-md w-full">
        <!-- Header Card / Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-teal-600 to-emerald-500 text-white shadow-xl shadow-teal-600/30 mb-4 transform hover:scale-105 transition-transform duration-200">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Medika RME</h1>
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Sistem Rekam Medis Elektronik Praktik Dokter Umum</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl shadow-xl shadow-slate-200/60 dark:shadow-black/40 border border-slate-200/80 dark:border-slate-700 p-8 backdrop-blur-sm transition-colors duration-200">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Masuk ke Akun</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Silakan masukkan username dan password yang terdaftar.</p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm">
                    <div class="flex items-center space-x-2 font-semibold mb-1">
                        <svg class="w-4 h-4 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Gagal Masuk</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700 dark:text-rose-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}" 
                               required 
                               autofocus
                               placeholder="Contoh: admin"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-150">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required 
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-150">
                    </div>
                </div>

                <!-- Remember me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-teal-600 border-slate-300 dark:border-slate-600 dark:bg-slate-800 focus:ring-teal-500">
                        <span class="text-xs text-slate-600 dark:text-slate-400">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-600/25 transition-all duration-150 transform active:scale-[0.99] flex items-center justify-center space-x-2">
                    <span>Masuk ke Sistem</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Quick Demo Credentials Selector -->
            <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-700">
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 text-center mb-2.5">Klik untuk mengisi akun demo:</p>
                <div class="w-full">
                    <button type="button" 
                            @click="fillDemo('admin', 'admin123')"
                            class="w-full p-2.5 text-center rounded-xl bg-slate-50 dark:bg-slate-700/50 hover:bg-teal-50 dark:hover:bg-teal-900/40 border border-slate-200 dark:border-slate-600 hover:border-teal-300 dark:hover:border-teal-500 transition-colors duration-150 group">
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-teal-700 dark:group-hover:text-teal-300">Admin / Perawat</span>
                        <span class="block text-[10px] text-slate-500 dark:text-slate-400">Username: admin | Password: admin123</span>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500 dark:text-slate-400 mt-6">&copy; {{ date('Y') }} Rekam Medis Elektronik Praktik Dokter Umum</p>
    </div>

</body>
</html>
