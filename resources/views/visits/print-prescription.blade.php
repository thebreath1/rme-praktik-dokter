<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Dokter - {{ $visit->patient->full_name }} ({{ $visit->visit_date->format('d/m/Y') }})</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@1,600;1,700&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Dark Mode script -->
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
                        serif: ['"Playfair Display"', 'serif'],
                        mono: ['"Courier Prime"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .prescription-sheet {
                border: 2px solid #000 !important;
                box-shadow: none !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 auto !important;
                padding: 24px !important;
                page-break-inside: avoid;
            }
            @page {
                size: A5 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 min-h-screen py-8 px-4 font-sans antialiased flex flex-col items-center justify-start transition-colors duration-200"
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

    <!-- ACTION CONTROLS (NO PRINT) -->
    <div class="no-print max-w-xl w-full mb-6 flex items-center justify-between bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 transition-colors duration-200">
        <a href="{{ route('patients.show', $visit->patient->id) }}" 
           class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 px-3.5 py-2 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Pasien</span>
        </a>

        <div class="flex items-center space-x-2">
            <!-- Dark Mode Toggle Button -->
            <button type="button" 
                    @click="toggleTheme()" 
                    class="p-2 rounded-xl text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-amber-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors"
                    title="Beralih Tema Gelap / Terang">
                <svg x-show="isDark" class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg x-show="!isDark" class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            <button type="button" 
                    onclick="window.print()" 
                    class="inline-flex items-center space-x-2 px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md shadow-teal-600/20 transition-all duration-150 transform active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Resep</span>
            </button>
        </div>
    </div>

    <!-- OFFICIAL PRESCRIPTION SHEET (A5 Clinical Prescription Format) -->
    <div class="prescription-sheet bg-white max-w-xl w-full rounded-3xl border-2 border-slate-300 shadow-xl p-8 text-slate-900 relative">

        <!-- KOP PRAKTIK DOKTER -->
        <div class="text-center pb-4 border-b-2 border-slate-900">
            <div class="flex items-center justify-center space-x-2 mb-1">
                <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-sm">
                    +
                </div>
                <h1 class="text-lg font-extrabold uppercase tracking-wide text-slate-900">
                    {{ $clinic['name'] }}
                </h1>
            </div>
            <h2 class="text-base font-bold text-slate-800">{{ $clinic['doctor'] }}</h2>
            <p class="text-xs font-mono font-medium text-slate-600">{{ $clinic['sip'] }}</p>
            <p class="text-[11px] text-slate-600 mt-1">{{ $clinic['address'] }}</p>
            <p class="text-[10px] text-slate-500">{{ $clinic['phone'] }} • {{ $clinic['schedule'] }}</p>
        </div>

        <!-- META DATA (TANGGAL & NOMOR RESEP) -->
        <div class="py-3 flex justify-between items-center text-xs border-b border-dashed border-slate-300 text-slate-700">
            <div>
                <span class="font-bold">No. Rekam Medis:</span> 
                <span class="font-mono font-semibold">RM-{{ str_pad($visit->patient->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div>
                <span class="font-bold">Tanggal:</span> 
                <span>{{ $visit->visit_date->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <!-- DAFTAR RESEP OBAT (RECIPE R/) -->
        <div class="py-6 space-y-5 min-h-[260px]">
            @forelse($visit->prescriptions as $index => $rx)
                <div class="relative pl-7 group">
                    <!-- R/ Classical Symbol -->
                    <span class="absolute left-0 top-0 text-xl font-serif italic font-bold text-slate-900 select-none">
                        R/
                    </span>

                    <!-- Drug Name, Dosage, Qty -->
                    <div class="flex items-baseline justify-between border-b border-dotted border-slate-300 pb-1">
                        <span class="font-bold text-sm text-slate-900">
                            {{ $rx->drug_name }} {{ $rx->dosage }}
                        </span>
                        <span class="font-mono text-xs font-bold text-slate-800">
                            No. {{ $rx->quantity ? $rx->quantity : '—' }}
                        </span>
                    </div>

                    <!-- Signa (Instructions) -->
                    <div class="text-xs text-slate-700 mt-1 pl-4 flex items-center space-x-1 font-medium">
                        <span class="italic font-serif font-bold text-slate-900">S.</span>
                        <span>{{ $rx->instructions }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-xs italic text-slate-400">
                    — Tidak ada resep obat yang direkam pada kunjungan ini —
                </div>
            @endforelse
        </div>

        <!-- CLOSING LINE (Pemisah Resep & Paraf) -->
        <div class="relative my-4">
            <div class="border-t-2 border-slate-900"></div>
            <!-- Closing flourish mark -->
            <div class="absolute right-8 -top-3 bg-white px-2 font-serif italic text-sm text-slate-900">
                §
            </div>
        </div>

        <!-- FOOTER: PRO PASIEN & PARAF DOKTER -->
        <div class="pt-2 flex flex-col sm:flex-row justify-between items-end gap-6 text-xs">
            <!-- Data Pasien (Pro:) -->
            <div class="w-full sm:w-2/3 bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-1">
                <div class="font-extrabold uppercase text-[10px] text-slate-500 tracking-wider">Pro (Untuk Pasien):</div>
                <div class="text-sm font-bold text-slate-900">{{ $visit->patient->full_name }}</div>
                <div class="text-slate-600 text-xs">
                    Usia: <span class="font-semibold text-slate-800">{{ $visit->patient->age }} Tahun</span> 
                    ({{ $visit->patient->birth_date->format('d/m/Y') }}) • {{ $visit->patient->gender_label }}
                </div>
                <div class="text-slate-600 text-xs truncate" title="{{ $visit->patient->address }}">
                    Alamat: {{ $visit->patient->address }}
                </div>
            </div>

            <!-- Kolom Tanda Tangan / Paraf Dokter -->
            <div class="text-center w-full sm:w-1/3 shrink-0 self-end">
                <p class="text-[11px] text-slate-500">Ciamis, {{ $visit->visit_date->format('d/m/Y') }}</p>
                <p class="text-[11px] font-bold text-slate-800 mt-0.5">Dokter Pemeriksa,</p>
                
                <!-- Signature line -->
                <div class="h-16 flex items-center justify-center">
                    <span class="text-slate-300 text-xs italic no-print">(Paraf / Cap Dokter)</span>
                </div>

                <div class="border-t border-slate-900 pt-1">
                    <span class="font-bold text-xs text-slate-900 block">{{ $clinic['doctor'] }}</span>
                    <span class="text-[9px] text-slate-500 block">{{ $clinic['sip'] }}</span>
                </div>
            </div>
        </div>

        <!-- Catatan kaki resep -->
        <div class="mt-6 pt-3 border-t border-slate-100 text-[9px] text-slate-400 text-center uppercase tracking-wider">
            Resep ini dikeluarkan resmi oleh {{ $clinic['name'] }} • Berlaku untuk pengambilan obat di apotek/farmasi
        </div>

    </div>

</body>
</html>
