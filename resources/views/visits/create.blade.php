@extends('layouts.app', ['title' => 'Catat Kunjungan - ' . $patient->full_name])

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="prescriptionManager()">

    <!-- BREADCRUMB -->
    <div>
        <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-2">
            <a href="{{ route('patients.index') }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors">Data Pasien</a>
            <span>/</span>
            <a href="{{ route('patients.show', $patient->id) }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors">{{ $patient->full_name }}</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-slate-200">Catat Kunjungan & Resep</span>
        </nav>
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pencatatan Kunjungan & Rekam Medis</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Input keluhan klinis, pemeriksaan fisik, diagnosis, tindakan, dan resep obat.</p>
    </div>

    <!-- PATIENT MINI BANNER -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-teal-200/80 dark:border-slate-700 bg-gradient-to-r from-teal-50/60 dark:from-teal-950/30 to-white dark:to-slate-800 p-4 sm:p-5 flex flex-wrap items-center justify-between gap-4 shadow-sm transition-colors duration-200">
        <div class="flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-xl {{ $patient->gender === 'L' ? 'bg-blue-600' : 'bg-pink-600' }} text-white flex items-center justify-center font-bold text-lg shadow-sm">
                {{ strtoupper(substr($patient->full_name, 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <span class="text-base font-extrabold text-slate-900 dark:text-white">{{ $patient->full_name }}</span>
                    <span class="px-2 py-0.5 rounded text-xs font-bold {{ $patient->gender === 'L' ? 'bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300' : 'bg-pink-100 dark:bg-pink-900/60 text-pink-800 dark:text-pink-300' }}">
                        {{ $patient->gender_label }}
                    </span>
                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-teal-100 dark:bg-teal-900/60 text-teal-800 dark:text-teal-300">
                        {{ $patient->age }} Thn
                    </span>
                </div>
                <div class="text-xs font-bold text-slate-700 dark:text-slate-300 mt-0.5 font-mono">
                    NIK: {{ $patient->nik ?? '—' }} • Telp: {{ $patient->phone }}
                </div>
            </div>
        </div>

        <a href="{{ route('patients.show', $patient->id) }}" 
           class="text-xs font-bold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200 bg-white dark:bg-slate-700 border border-teal-200 dark:border-slate-600 hover:bg-teal-50 dark:hover:bg-slate-600 px-3 py-1.5 rounded-lg transition-colors">
            Lihat Riwayat Sebelumnya
        </a>
    </div>

    <!-- ERROR SUMMARY ALERT -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm shadow-sm">
            <div class="flex items-center space-x-2 font-bold mb-1.5">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Validasi Formulir Kunjungan Gagal:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700 dark:text-rose-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN VISIT FORM -->
    <form action="{{ route('patients.visits.store', $patient->id) }}" method="POST" class="space-y-6">
        @csrf

        <!-- CARD 1: INFORMASI KLINIS -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5 transition-colors duration-200">
            <h3 class="text-sm font-bold text-teal-800 dark:text-teal-400 uppercase tracking-wider pb-2 border-b border-slate-100 dark:border-slate-700 flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                <span>Anamnesis & Pemeriksaan Dokter</span>
            </h3>

            <!-- Tanggal Kunjungan (Default: Hari Ini) -->
            <div class="max-w-xs">
                <label for="visit_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Tanggal Kunjungan <span class="text-rose-500">*</span>
                </label>
                <input type="date" 
                       name="visit_date" 
                       id="visit_date" 
                       value="{{ old('visit_date', $today) }}"
                       required
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('visit_date') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Otomatis terisi tanggal hari ini (dapat disesuaikan jika mencatat mundur).</p>
            </div>

            <!-- Keluhan Utama (Wajib Diisi - SOP Klinis) -->
            <div>
                <label for="complaint" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Keluhan Utama Pasien (Anamnesis) <span class="text-rose-500">* (Wajib Diisi)</span>
                </label>
                <textarea name="complaint" 
                          id="complaint" 
                          rows="3" 
                          required
                          placeholder="Jelaskan keluhan yang dirasakan pasien, durasi/onset, keparahan, serta gejala penyerta..."
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('complaint') border-rose-400 bg-rose-50/30 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('complaint') }}</textarea>
                @error('complaint')
                    <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">SOP: Sistem mewajibkan keluhan utama diisi untuk validitas rekam medis.</p>
            </div>

            <!-- Pemeriksaan Fisik (Opsional) -->
            <div>
                <label for="examination" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Pemeriksaan Fisik & Tanda Vital <span class="text-slate-400 dark:text-slate-500">(Opsional)</span>
                </label>
                <textarea name="examination" 
                          id="examination" 
                          rows="2" 
                          placeholder="Contoh: TD: 120/80 mmHg, Nadi: 80x/m, Suhu: 36.8 C, RR: 20x/m. Faring hiperemis (-)..."
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('examination') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('examination') }}</textarea>
            </div>

            <!-- Diagnosis & Tindakan (2 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <!-- Diagnosis (Wajib) -->
                <div>
                    <label for="diagnosis" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Diagnosis Klinis <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="diagnosis" 
                           id="diagnosis" 
                           value="{{ old('diagnosis') }}"
                           required
                           placeholder="Contoh: Faringitis Akut / Hipertensi / Gastritis" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('diagnosis') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('diagnosis')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tindakan / Penanganan (Wajib) -->
                <div>
                    <label for="action" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Tindakan / Penanganan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="action" 
                           id="action" 
                           value="{{ old('action') }}"
                           required
                           placeholder="Contoh: Pemberian obat rawat jalan & edukasi, atau Rujuk RS" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border @error('action') border-rose-400 @else border-slate-300 dark:border-slate-700 @enderror dark:text-white rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('action')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- CARD 2: DYNAMIC RESEP OBAT (PRESCRIPTIONS) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-5 transition-colors duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-100 dark:border-slate-700">
                <div>
                    <h3 class="text-sm font-bold text-teal-800 dark:text-teal-400 uppercase tracking-wider flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                        <span>Resep Obat Digital (Rx)</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Dapat menambahkan beberapa obat sekaligus secara dinamis.</p>
                </div>

                <!-- Tombol Tambah Baris Obat -->
                <button type="button" 
                        @click="addPrescription()"
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-teal-50 dark:bg-teal-900/40 hover:bg-teal-100 dark:hover:bg-teal-900/60 text-teal-700 dark:text-teal-300 font-bold text-xs border border-teal-200 dark:border-teal-700 transition-colors self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Baris Obat</span>
                </button>
            </div>

            <!-- Quick Preset Obat Populer -->
            <div>
                <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Pilih Cepat Obat Sering Digunakan:</p>
                <div class="flex flex-wrap gap-1.5">
                    <template x-for="preset in presets" :key="preset.name">
                        <button type="button" 
                                @click="addPreset(preset)"
                                class="px-2.5 py-1 rounded-lg bg-slate-50 dark:bg-slate-700/60 hover:bg-teal-50 dark:hover:bg-teal-900/40 border border-slate-200 dark:border-slate-600 hover:border-teal-300 dark:hover:border-teal-500 text-slate-700 dark:text-slate-200 hover:text-teal-800 dark:hover:text-teal-300 text-xs font-medium transition-colors">
                            + <span x-text="preset.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Dynamic Prescription Rows -->
            <div class="space-y-3 pt-2">
                <template x-for="(item, index) in prescriptions" :key="index">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 relative group transition-all hover:border-teal-400 dark:hover:border-teal-500">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-extrabold text-teal-700 dark:text-teal-300 flex items-center space-x-1">
                                <span class="font-serif italic text-base">R/</span>
                                <span x-text="'Obat #' + (index + 1)"></span>
                            </span>
                            <button type="button" 
                                    @click="removePrescription(index)"
                                    x-show="prescriptions.length > 1"
                                    class="text-xs font-semibold text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 hover:underline flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <!-- Nama Obat (Cols 4) -->
                            <div class="sm:col-span-4">
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">
                                    Nama Obat
                                </label>
                                <input type="text" 
                                       :name="'prescriptions[' + index + '][drug_name]'" 
                                       x-model="item.drug_name" 
                                       placeholder="Contoh: Paracetamol"
                                       class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <!-- Dosis (Cols 3) -->
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">
                                    Dosis / Bentuk
                                </label>
                                <input type="text" 
                                       :name="'prescriptions[' + index + '][dosage]'" 
                                       x-model="item.dosage" 
                                       placeholder="Contoh: 500 mg"
                                       class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <!-- Aturan Pakai (Cols 3) -->
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">
                                    Aturan Pakai (Signa)
                                </label>
                                <input type="text" 
                                       :name="'prescriptions[' + index + '][instructions]'" 
                                       x-model="item.instructions" 
                                       placeholder="Contoh: 3x1 sesudah makan"
                                       class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <!-- Jumlah (Cols 2) -->
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">
                                    Jumlah (Qty)
                                </label>
                                <input type="number" 
                                       :name="'prescriptions[' + index + '][quantity]'" 
                                       x-model="item.quantity" 
                                       min="1"
                                       placeholder="10"
                                       class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 dark:text-white rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- FORM ACTION BUTTONS -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('patients.show', $patient->id) }}" 
               class="px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 font-semibold text-sm transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-7 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm shadow-md shadow-teal-600/20 transition-all duration-150 transform active:scale-95 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Kunjungan & Resep</span>
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
function prescriptionManager() {
    return {
        prescriptions: [
            { drug_name: '', dosage: '', instructions: '', quantity: '' }
        ],
        presets: [
            { name: 'Paracetamol', dosage: '500 mg', instructions: '3x1 tablet sesudah makan', quantity: 10 },
            { name: 'Amoxicillin', dosage: '500 mg', instructions: '3x1 kaplet sesudah makan (dihabiskan)', quantity: 15 },
            { name: 'Antasida Doen', dosage: 'Tablet Kunyah', instructions: '3x1 dikunyah 1 jam sebelum makan', quantity: 10 },
            { name: 'Cetirizine', dosage: '10 mg', instructions: '1x1 tablet malam hari', quantity: 7 },
            { name: 'Ibuprofen', dosage: '400 mg', instructions: '3x1 tablet sesudah makan bila nyeri', quantity: 10 },
            { name: 'Omeprazole', dosage: '20 mg', instructions: '1x1 kapsul sebelum sarapan', quantity: 7 },
            { name: 'Vitamin C', dosage: '500 mg', instructions: '1x1 tablet sesudah makan', quantity: 10 }
        ],
        addPrescription() {
            this.prescriptions.push({ drug_name: '', dosage: '', instructions: '', quantity: '' });
        },
        removePrescription(index) {
            if (this.prescriptions.length > 1) {
                this.prescriptions.splice(index, 1);
            }
        },
        addPreset(preset) {
            if (this.prescriptions.length === 1 && this.prescriptions[0].drug_name === '') {
                this.prescriptions[0] = { ...preset };
            } else {
                this.prescriptions.push({ ...preset });
            }
        }
    }
}
</script>
@endpush
