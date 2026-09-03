@extends('layouts.app', ['title' => 'Dashboard Utama'])

@section('content')
<div class="space-y-6">

    <!-- WELCOME BANNER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-700 via-teal-600 to-emerald-600 dark:from-teal-800 dark:via-slate-800 dark:to-emerald-900 text-white shadow-xl shadow-teal-700/10 p-6 sm:p-8 transition-colors duration-200">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/15 dark:bg-white/10 backdrop-blur-md text-teal-100 text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>Praktik Dokter Umum Terpadu</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat Datang, {{ auth()->user()->username }}!
                </h1>
                <p class="text-teal-100 text-sm mt-1.5 max-w-2xl">
                    Sistem Rekam Medis Elektronik (RME) siap digunakan untuk registrasi pasien, pencatatan kunjungan, diagnosis klinis, dan cetak resep digital.
                </p>
            </div>

            <!-- Quick Action Buttons on Banner -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('patients.create') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-white text-teal-700 hover:bg-teal-50 font-bold text-sm shadow-md transition-all duration-150 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Pasien Baru</span>
                </a>
                <a href="{{ route('patients.index') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-teal-800/40 hover:bg-teal-800/60 text-white border border-white/20 font-semibold text-sm backdrop-blur-md transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Cari Pasien</span>
                </a>
            </div>
        </div>

        <!-- Decorative background circles -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-40 -top-20 w-48 h-48 bg-emerald-400/10 rounded-full blur-xl pointer-events-none"></div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Pasien -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Pasien Terdaftar</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ number_format($totalPatients) }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-1">
                    Database Rekam Medis
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <!-- Kunjungan Hari Ini -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kunjungan Hari Ini</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-teal-600 dark:text-teal-400 mt-1">{{ number_format($todayVisits) }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
        </div>

        <!-- Kunjungan Bulan Ini -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kunjungan Bulan Ini</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ number_format($monthVisits) }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">
                    Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <!-- Resep Obat Diberikan -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Resep Obat Tercatat</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ number_format($totalPrescriptions) }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-amber-600 dark:text-amber-400 mt-1">
                    Digital Prescription
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            </div>
        </div>
    </div>

    <!-- MAIN TWO COLUMN SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KUNJUNGAN TERBARU (Col 1 & 2) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-sm transition-colors duration-200">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Kunjungan Medis Terbaru</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Daftar pemeriksaan pasien terakhir yang masuk ke sistem.</p>
                </div>
                <a href="{{ route('patients.index') }}" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300 flex items-center space-x-1">
                    <span>Semua Pasien</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($recentVisits->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @foreach($recentVisits as $visit)
                        <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                            <div class="flex items-start space-x-3.5">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-900/40 border border-teal-100 dark:border-teal-800 flex items-center justify-center text-teal-700 dark:text-teal-300 font-bold shrink-0 mt-0.5">
                                    {{ $visit->patient->gender === 'L' ? '♂' : '♀' }}
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('patients.show', $visit->patient_id) }}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-teal-600 dark:hover:text-teal-400 text-sm">
                                            {{ $visit->patient->full_name }}
                                        </a>
                                        <span class="text-xs text-slate-400 font-mono">NIK: {{ $visit->patient->nik ?? '-' }}</span>
                                    </div>
                                    <div class="text-xs text-slate-600 dark:text-slate-300 mt-1 flex flex-wrap gap-x-2 gap-y-0.5">
                                        <span class="font-semibold text-slate-700 dark:text-slate-200">Diagnosis:</span>
                                        <span class="bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200/50 dark:border-amber-800/50 px-2 py-0.5 rounded font-medium">{{ $visit->diagnosis }}</span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-500 dark:text-slate-400 truncate max-w-xs" title="{{ $visit->complaint }}">{{ Str::limit($visit->complaint, 40) }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 flex items-center space-x-2">
                                        <span>📅 {{ $visit->visit_date->translatedFormat('d F Y') }}</span>
                                        <span>•</span>
                                        <span>💊 {{ $visit->prescriptions->count() }} Resep Obat</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 self-end sm:self-center shrink-0">
                                <a href="{{ route('visits.print', $visit->id) }}" 
                                   target="_blank"
                                   class="px-2.5 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-700/60 hover:bg-teal-50 dark:hover:bg-teal-900/40 border border-slate-200 dark:border-slate-600 hover:border-teal-300 text-slate-700 dark:text-slate-200 hover:text-teal-700 dark:hover:text-teal-300 text-xs font-semibold flex items-center space-x-1.5 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    <span>Cetak Resep</span>
                                </a>
                                <a href="{{ route('patients.show', $visit->patient_id) }}" 
                                   class="px-2.5 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold transition-colors">
                                    Rekam Medis
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada catatan kunjungan medis hari ini.</p>
                </div>
            @endif
        </div>

        <!-- PASIEN BARU TERDAFTAR (Col 3) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-sm flex flex-col transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Pasien Baru</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Terdaftar terakhir di klinik.</p>
                </div>
                <a href="{{ route('patients.create') }}" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:text-teal-700">
                    + Tambah
                </a>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-700/60 flex-1">
                @foreach($recentPatients as $patient)
                    <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between">
                        <div>
                            <a href="{{ route('patients.show', $patient->id) }}" class="text-sm font-bold text-slate-800 dark:text-slate-200 hover:text-teal-600 dark:hover:text-teal-400 block">
                                {{ $patient->full_name }}
                            </a>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}, {{ $patient->age }} thn
                            </p>
                        </div>
                        <a href="{{ route('patients.visits.create', $patient->id) }}" 
                           class="px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/40 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 text-xs font-semibold transition-colors"
                           title="Catat kunjungan baru">
                            + Kunjungan
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Klinik Info Card -->
            <div class="mt-6 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200/60 dark:border-slate-700/60 text-xs text-slate-600 dark:text-slate-400">
                <span class="font-bold text-slate-800 dark:text-slate-200 block mb-1">ℹ️ SOP Praktik Mandiri:</span>
                Setiap kunjungan medis wajib mencantumkan keluhan utama pasien sebelum diagnosis dan resep obat dapat diterbitkan.
            </div>
        </div>

    </div>

</div>
@endsection
