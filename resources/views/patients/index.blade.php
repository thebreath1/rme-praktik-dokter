@extends('layouts.app', ['title' => 'Daftar Pasien'])

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Daftar Pasien</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola data pasien terdaftar dan buka riwayat rekam medis.</p>
        </div>
        <div class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 font-semibold text-xs cursor-not-allowed select-none opacity-80 self-start sm:self-auto"
             title="Input Pasien Baru hanya dapat diakses melalui Dashboard Utama">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <span>Input Pasien (Akses via Dashboard)</span>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 border border-slate-200/80 dark:border-slate-700 shadow-sm transition-colors duration-200">
        <form action="{{ route('patients.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
            <!-- Search input -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan Nama Pasien, NIK, atau No. Telepon..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <!-- Gender filter -->
            <div class="w-full md:w-48 shrink-0">
                <select name="gender" 
                        class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">Semua Gender</option>
                    <option value="L" {{ $gender === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ $gender === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-center space-x-2 w-full md:w-auto">
                <button type="submit" 
                        class="px-4 py-2 bg-slate-800 dark:bg-teal-600 hover:bg-slate-900 dark:hover:bg-teal-700 text-white rounded-xl text-sm font-semibold transition-colors duration-150 flex-1 md:flex-none text-center">
                    Cari Pasien
                </button>
                @if($search || $gender)
                    <a href="{{ route('patients.index') }}" 
                       class="px-3 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-xl text-sm font-medium transition-colors duration-150"
                       title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- PATIENT DATA TABLE -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm overflow-hidden transition-colors duration-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700 bg-slate-50/75 dark:bg-slate-900/60 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4 sm:px-6">No / NIK</th>
                        <th class="py-3.5 px-4">Nama Pasien</th>
                        <th class="py-3.5 px-4">Usia & JK</th>
                        <th class="py-3.5 px-4">Kontak & Alamat</th>
                        <th class="py-3.5 px-4 text-center">Total Kunjungan</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 text-sm">
                    @forelse($patients as $index => $patient)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors duration-150">
                            <!-- NIK -->
                            <td class="py-4 px-4 sm:px-6">
                                <span class="font-mono text-xs font-semibold text-slate-700 dark:text-slate-200 block">
                                    {{ $patient->nik ?? '— Tidak ada NIK —' }}
                                </span>
                                <span class="text-[11px] text-slate-400 dark:text-slate-500">ID: #{{ $patient->id }}</span>
                            </td>

                            <!-- Nama Pasien -->
                            <td class="py-4 px-4">
                                <a href="{{ route('patients.show', $patient->id) }}" class="font-bold text-slate-900 dark:text-white hover:text-teal-600 dark:hover:text-teal-400">
                                    {{ $patient->full_name }}
                                </a>
                                <span class="block text-xs text-slate-400 dark:text-slate-500">Lahir: {{ $patient->birth_date->format('d/m/Y') }}</span>
                            </td>

                            <!-- Usia & JK -->
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $patient->age }} thn</span>
                                    @if($patient->gender === 'L')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-900/60 text-blue-700 dark:text-blue-300">L</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-pink-100 dark:bg-pink-900/60 text-pink-700 dark:text-pink-300">P</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kontak & Alamat -->
                            <td class="py-4 px-4">
                                <div class="text-xs text-slate-800 dark:text-slate-200 font-medium">{{ $patient->phone }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-xs" title="{{ $patient->address }}">{{ Str::limit($patient->address, 35) }}</div>
                            </td>

                            <!-- Total Kunjungan -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $patient->visits_count > 0 ? 'bg-teal-100 dark:bg-teal-900/60 text-teal-800 dark:text-teal-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400' }}">
                                    {{ $patient->visits_count }}x
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center space-x-1.5">
                                    <a href="{{ route('patients.show', $patient->id) }}" 
                                       class="px-2.5 py-1.5 rounded-lg bg-teal-50 dark:bg-teal-900/40 hover:bg-teal-100 dark:hover:bg-teal-900/60 text-teal-700 dark:text-teal-300 text-xs font-bold transition-colors"
                                       title="Buka Rekam Medis Pasien">
                                        Rekam Medis
                                    </a>
                                    <a href="{{ route('patients.visits.create', $patient->id) }}" 
                                       class="px-2 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors"
                                       title="Catat Kunjungan Baru">
                                        + Kunjungan
                                    </a>
                                    <!-- Action Dropdown (Icon 3 Titik) -->
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button type="button" 
                                                @click="open = !open" 
                                                @click.outside="open = false"
                                                class="p-1.5 rounded-lg text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors focus:outline-none"
                                                title="Opsi Pasien">
                                            <!-- Icon 3 Titik (Vertical) -->
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-1.5 w-40 rounded-xl bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 py-1.5 z-50 divide-y divide-slate-100 dark:divide-slate-700/60 text-left"
                                             x-cloak>
                                            <div class="py-0.5">
                                                <!-- Opsi 1: Edit Profil -->
                                                <a href="{{ route('patients.edit', $patient->id) }}" 
                                                   class="flex items-center space-x-2 px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/70 transition-colors">
                                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                    <span>Edit Profil</span>
                                                </a>
                                            </div>
                                            <div class="py-0.5">
                                                <!-- Opsi 2: Hapus Data -->
                                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien {{ $patient->full_name }}? Seluruh riwayat kunjungan dan resep pasien ini juga akan dihapus.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="w-full flex items-center space-x-2 px-3.5 py-2 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors text-left">
                                                        <svg class="w-4 h-4 text-rose-500 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        <span>Hapus Data</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-slate-800 dark:text-white">Pasien Tidak Ditemukan</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                                    Tidak ada pasien yang cocok dengan kata kunci "{{ $search }}". Silakan periksa kembali atau daftarkan sebagai pasien baru.
                                </p>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2 mt-4 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition-colors">
                                    <span>+ Input Pasien Baru via Dashboard</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($patients->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40">
                {{ $patients->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
