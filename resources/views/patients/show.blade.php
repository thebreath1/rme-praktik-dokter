@extends('layouts.app', ['title' => 'Rekam Medis - ' . $patient->full_name])

@section('content')
<div class="space-y-6">

    <!-- BREADCRUMB -->
    <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('patients.index') }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors">Data Pasien</a>
        <span>/</span>
        <span class="text-slate-800 dark:text-slate-200">Detail Rekam Medis</span>
        <span>/</span>
        <span class="text-teal-700 dark:text-teal-400 font-bold">#{{ $patient->id }}</span>
    </nav>

    <!-- PATIENT IDENTITY SUMMARY CARD -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 relative overflow-hidden transition-colors duration-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <!-- Left: Avatar & Info -->
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-tr {{ $patient->gender === 'L' ? 'from-blue-600 to-teal-500' : 'from-pink-500 to-rose-400' }} text-white flex items-center justify-center font-extrabold text-2xl sm:text-3xl shadow-lg shrink-0">
                    {{ strtoupper(substr($patient->full_name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                            {{ $patient->full_name }}
                        </h1>
                        @if($patient->gender === 'L')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300">Laki-laki</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-pink-100 dark:bg-pink-900/60 text-pink-800 dark:text-pink-300">Perempuan</span>
                        @endif
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-900/60 text-teal-800 dark:text-teal-300">
                            {{ $patient->age }} Tahun
                        </span>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-1.5 mt-3 text-xs text-slate-600 dark:text-slate-300">
                        <div>
                            <span class="font-bold text-slate-400 dark:text-slate-500 block uppercase tracking-wider text-[10px]">Nomor NIK</span>
                            <span class="font-mono font-semibold text-slate-800 dark:text-slate-200 text-sm">{{ $patient->nik ?? '— Tidak ada NIK —' }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 dark:text-slate-500 block uppercase tracking-wider text-[10px]">Tanggal Lahir</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 text-sm">{{ $patient->birth_date->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 dark:text-slate-500 block uppercase tracking-wider text-[10px]">Kontak WhatsApp/HP</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 text-sm">{{ $patient->phone }}</span>
                        </div>
                    </div>

                    <div class="mt-2 text-xs text-slate-500 dark:text-slate-400 flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $patient->address }}</span>
                    </div>
                </div>
            </div>

            <!-- Right: Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 self-start md:self-center shrink-0">
                <a href="{{ route('patients.edit', $patient->id) }}" 
                   class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors flex items-center space-x-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>Edit Profil</span>
                </a>
                <a href="{{ route('patients.visits.create', $patient->id) }}" 
                   class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all duration-150 transform active:scale-95 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Kunjungan</span>
                </a>
            </div>
        </div>

        <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-slate-50 dark:from-slate-800 to-transparent pointer-events-none"></div>
    </div>

    <!-- MEDICAL HISTORY (RIWAYAT REKAM MEDIS) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Riwayat Kunjungan & Catatan Medis</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Urutan kunjungan dari yang paling baru ke yang terlama.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-full border border-slate-200 dark:border-slate-700">
                Total: {{ $patient->visits->count() }} Kunjungan
            </span>
        </div>

        @if($patient->visits->count() > 0)
            <div class="space-y-5">
                @foreach($patient->visits as $index => $visit)
                    <div id="visit-{{ $visit->id }}" class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/90 dark:border-slate-700 shadow-sm overflow-hidden transition-all hover:border-teal-400 dark:hover:border-teal-500">
                        <!-- Visit Card Header -->
                        <div class="bg-slate-50/80 dark:bg-slate-900/50 px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center space-x-3">
                                <span class="w-8 h-8 rounded-xl bg-teal-600 text-white flex items-center justify-center text-xs font-extrabold shadow-sm">
                                    #{{ $patient->visits->count() - $index }}
                                </span>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-extrabold text-slate-900 dark:text-white">
                                            Kunjungan: {{ $visit->visit_date->translatedFormat('l, d F Y') }}
                                        </span>
                                        @if($index === 0)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 uppercase tracking-wide">
                                                Terbaru
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500">Dicatat pada: {{ $visit->created_at->format('H:i') }} WIB</span>
                                </div>
                            </div>

                            <!-- Tombol Cetak Resep & Hapus Kunjungan -->
                            <div class="flex items-center space-x-2 self-start sm:self-auto">
                                <a href="{{ route('visits.print', $visit->id) }}" 
                                   target="_blank"
                                   class="px-3.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold shadow-sm flex items-center space-x-1.5 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    <span>Cetak Resep</span>
                                </a>
                                <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kunjungan medis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3.5 py-1.5 rounded-xl bg-rose-600/90 hover:bg-rose-700 text-white text-xs font-bold shadow-sm flex items-center space-x-1.5 transition-colors"
                                            title="Hapus Kunjungan Ini">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Visit Card Body -->
                        <div class="p-6 space-y-5">
                            <!-- Clinical Notes (Keluhan, Pemeriksaan, Diagnosis, Tindakan) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Keluhan Utama (Wajib) -->
                                <div class="p-4 rounded-2xl bg-rose-50/50 dark:bg-rose-950/30 border border-rose-100 dark:border-rose-900/40">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-700 dark:text-rose-400 block mb-1">
                                        🚨 Keluhan Utama Pasien
                                    </span>
                                    <p class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 leading-relaxed font-medium whitespace-pre-line">
                                        {{ $visit->complaint }}
                                    </p>
                                </div>

                                <!-- Pemeriksaan Fisik (Opsional) -->
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-slate-200/60 dark:border-slate-700/60">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-1">
                                        🩺 Pemeriksaan Fisik / Tanda Vital
                                    </span>
                                    <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                                        {{ $visit->examination ?: '— Tidak ada catatan pemeriksaan khusus —' }}
                                    </p>
                                </div>

                                <!-- Diagnosis Klinis (Wajib) -->
                                <div class="p-4 rounded-2xl bg-amber-50/50 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-900/40">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 dark:text-amber-400 block mb-1">
                                        📋 Diagnosis
                                    </span>
                                    <p class="text-sm sm:text-base font-extrabold text-amber-950 dark:text-amber-200">
                                        {{ $visit->diagnosis }}
                                    </p>
                                </div>

                                <!-- Tindakan / Penanganan (Wajib) -->
                                <div class="p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-200/80 dark:border-emerald-900/40">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400 block mb-1">
                                        💉 Tindakan / Rencana Terapi
                                    </span>
                                    <p class="text-xs sm:text-sm font-semibold text-emerald-950 dark:text-emerald-200 leading-relaxed">
                                        {{ $visit->action }}
                                    </p>
                                </div>
                            </div>

                            <!-- RESEP OBAT SECTION -->
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-700/60">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center space-x-1.5">
                                        <span>💊 Resep Obat (Rx)</span>
                                    </h4>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500">{{ $visit->prescriptions->count() }} Obat Diberikan</span>
                                </div>

                                @if($visit->prescriptions->count() > 0)
                                    <div class="border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                                        <table class="w-full text-left text-xs border-collapse">
                                            <thead>
                                                <tr class="bg-slate-50 dark:bg-slate-900/70 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                                                    <th class="py-2.5 px-4 w-12 text-center">No</th>
                                                    <th class="py-2.5 px-4">Nama Obat</th>
                                                    <th class="py-2.5 px-4">Dosis</th>
                                                    <th class="py-2.5 px-4">Aturan Pakai (Signa)</th>
                                                    <th class="py-2.5 px-4 text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                                                @foreach($visit->prescriptions as $pIndex => $rx)
                                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-700/40">
                                                        <td class="py-2.5 px-4 text-center text-slate-400 dark:text-slate-500 font-mono">{{ $pIndex + 1 }}</td>
                                                        <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">
                                                            <span class="text-teal-600 dark:text-teal-400 font-serif italic mr-1">R/</span> {{ $rx->drug_name }}
                                                        </td>
                                                        <td class="py-2.5 px-4 text-slate-700 dark:text-slate-300">{{ $rx->dosage }}</td>
                                                        <td class="py-2.5 px-4 text-slate-700 dark:text-slate-300 font-medium">{{ $rx->instructions }}</td>
                                                        <td class="py-2.5 px-4 text-center">
                                                            <span class="px-2 py-0.5 rounded-full font-mono font-bold bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                                                                {{ $rx->quantity ?? '-' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-xs text-slate-400 dark:text-slate-500 italic py-2">Tidak ada resep obat tertulis pada kunjungan ini.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- EMPTY VISITS STATE -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-teal-50 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Riwayat Kunjungan</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                    Pasien ini baru didaftarkan dan belum memiliki catatan pemeriksaan medis di klinik.
                </p>
                <a href="{{ route('patients.visits.create', $patient->id) }}" 
                   class="inline-flex items-center space-x-2 mt-4 px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold shadow-md shadow-teal-600/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Mulai Catat Kunjungan Pertama</span>
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
