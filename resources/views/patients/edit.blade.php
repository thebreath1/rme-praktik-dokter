@extends('layouts.app', ['title' => 'Edit Data Pasien - ' . $patient->full_name])

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- BREADCRUMB & HEADER -->
    <div>
        <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-2">
            <a href="{{ route('patients.index') }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors">Data Pasien</a>
            <span>/</span>
            <a href="{{ route('patients.show', $patient->id) }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors">{{ $patient->full_name }}</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-slate-200">Edit Profil</span>
        </nav>
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Perbarui Data Pasien</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Perbarui informasi identitas kependudukan, kontak, atau alamat pasien.</p>
    </div>

    <!-- ERROR SUMMARY ALERT -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm shadow-sm">
            <div class="flex items-center space-x-2 font-bold mb-1.5">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Mohon Periksa Data Formulir</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700 dark:text-rose-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN FORM CARD -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 transition-colors duration-200">
        <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- SECTION: IDENTITAS UTAMA -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-teal-800 dark:text-teal-400 uppercase tracking-wider pb-2 border-b border-slate-100 dark:border-slate-700 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                    <span>Identitas Pasien</span>
                </h3>

                <!-- Nama Lengkap -->
                <div>
                    <label for="full_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Nama Lengkap Pasien <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="full_name" 
                           id="full_name" 
                           value="{{ old('full_name', $patient->full_name) }}"
                           required
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('full_name') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('full_name')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="nik" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            Nomor Induk Kependudukan (NIK)
                        </label>
                        <span class="text-[11px] text-slate-400 dark:text-slate-500">16 Digit</span>
                    </div>
                    <input type="text" 
                           name="nik" 
                           id="nik" 
                           maxlength="16"
                           value="{{ old('nik', $patient->nik) }}"
                           class="w-full px-4 py-2.5 font-mono bg-slate-50 dark:bg-slate-900 border @error('nik') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('nik')
                        <div class="mt-2 p-2.5 rounded-lg bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-xs text-rose-700 dark:text-rose-300 font-medium">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Tanggal Lahir & Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="birth_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Tanggal Lahir <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" 
                               name="birth_date" 
                               id="birth_date" 
                               value="{{ old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '') }}"
                               max="{{ date('Y-m-d') }}"
                               required
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('birth_date') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('birth_date')
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center space-x-4 pt-1">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" 
                                       name="gender" 
                                       value="L" 
                                       {{ old('gender', $patient->gender) === 'L' ? 'checked' : '' }} 
                                       required
                                       class="w-4 h-4 text-teal-600 border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Laki-laki (L)</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" 
                                       name="gender" 
                                       value="P" 
                                       {{ old('gender', $patient->gender) === 'P' ? 'checked' : '' }} 
                                       required
                                       class="w-4 h-4 text-teal-600 border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Perempuan (P)</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION: KONTAK & ALAMAT -->
            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                <h3 class="text-sm font-bold text-teal-800 dark:text-teal-400 uppercase tracking-wider pb-2 border-b border-slate-100 dark:border-slate-700 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                    <span>Kontak & Domisili</span>
                </h3>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone', $patient->phone) }}"
                           required
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('phone') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('phone')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Lengkap -->
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Alamat Lengkap Tempat Tinggal <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="address" 
                              id="address" 
                              rows="3" 
                              required
                              class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('address') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('address', $patient->address) }}</textarea>
                    @error('address')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- BUTTON ACTIONS -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('patients.show', $patient->id) }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 font-semibold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm shadow-md shadow-teal-600/20 transition-all duration-150 transform active:scale-95 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
