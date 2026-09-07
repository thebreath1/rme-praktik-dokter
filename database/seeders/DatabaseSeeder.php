<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\Prescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna (Admin / Perawat)
        User::create([
            'username' => 'admin',
            'password_hash' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Data Pasien Awal
        $patient1 = Patient::create([
            'nik' => '3201011205890001',
            'full_name' => 'Budi Santoso',
            'birth_date' => '1989-05-12',
            'gender' => 'L',
            'address' => 'Jl. Merdeka Barat No. 45, Ciamis',
            'phone' => '081234567890',
        ]);

        $patient2 = Patient::create([
            'nik' => '3201014508960002',
            'full_name' => 'Siti Rahmawati',
            'birth_date' => '1996-08-15',
            'gender' => 'P',
            'address' => 'Perum Griya Sejahtera Blok B-12, Ciamis',
            'phone' => '085712345678',
        ]);

        $patient3 = Patient::create([
            'nik' => '3201012301720003',
            'full_name' => 'Ahmad Hidayat',
            'birth_date' => '1972-01-23',
            'gender' => 'L',
            'address' => 'Dusun Sukamaju RT 03/RW 02, Ciamis',
            'phone' => '082198765432',
        ]);

        $patient4 = Patient::create([
            'nik' => '3201016209830004',
            'full_name' => 'Dewi Lestari',
            'birth_date' => '1983-09-22',
            'gender' => 'P',
            'address' => 'Jl. Tentara Pelajar No. 8, Ciamis',
            'phone' => '087812349988',
        ]);

        // 3. Kunjungan & Resep untuk Pasien 1 (Budi Santoso)
        $visit1 = Visit::create([
            'patient_id' => $patient1->id,
            'visit_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
            'complaint' => 'Demam sejak 2 hari yang lalu, disertai nyeri tenggorokan dan batuk kering.',
            'examination' => 'TD: 120/80 mmHg, Nadi: 84x/m, Suhu: 38.3 C, Faring hiperemis (+), Tonsil T1-T1 tenang.',
            'diagnosis' => 'Faringitis Akut (Akut Pharyngitis)',
            'action' => 'Pemberian obat simtomatik dan edukasi istirahat cukup serta banyak minum air hangat.',
        ]);

        Prescription::create([
            'visit_id' => $visit1->id,
            'drug_name' => 'Paracetamol',
            'dosage' => '500 mg',
            'instructions' => '3x1 tablet sesudah makan bila demam',
            'quantity' => 10,
        ]);

        Prescription::create([
            'visit_id' => $visit1->id,
            'drug_name' => 'Amoxicillin',
            'dosage' => '500 mg',
            'instructions' => '3x1 kaplet sesudah makan (dihabiskan)',
            'quantity' => 15,
        ]);

        Prescription::create([
            'visit_id' => $visit1->id,
            'drug_name' => 'Dextromethorphan HBr',
            'dosage' => '15 mg',
            'instructions' => '3x1 tablet sesudah makan',
            'quantity' => 10,
        ]);

        // 4. Kunjungan & Resep untuk Pasien 2 (Siti Rahmawati)
        $visit2 = Visit::create([
            'patient_id' => $patient2->id,
            'visit_date' => Carbon::now()->format('Y-m-d'),
            'complaint' => 'Nyeri ulu hati, mual terutama setelah makan terlambat, perut terasa kembung.',
            'examination' => 'TD: 110/70 mmHg, Suhu: 36.5 C, Nyeri tekan epigastrium (+), bising usus normal.',
            'diagnosis' => 'Dispepsia Sindrom (Gastritis Ringan)',
            'action' => 'Pemberian antasida dan prokinetik, anjuran pola makan teratur hindari pedas dan kopi.',
        ]);

        Prescription::create([
            'visit_id' => $visit2->id,
            'drug_name' => 'Antasida Doen',
            'dosage' => 'Kombinasi kunyah',
            'instructions' => '3x1 tablet dikunyah 1 jam sebelum makan',
            'quantity' => 12,
        ]);

        Prescription::create([
            'visit_id' => $visit2->id,
            'drug_name' => 'Omeprazole',
            'dosage' => '20 mg',
            'instructions' => '1x1 kapsul 30 menit sebelum sarapan',
            'quantity' => 7,
        ]);

        Prescription::create([
            'visit_id' => $visit2->id,
            'drug_name' => 'Domperidone',
            'dosage' => '10 mg',
            'instructions' => '3x1 tablet sebelum makan bila mual',
            'quantity' => 10,
        ]);

        // 5. Kunjungan untuk Pasien 3 (Ahmad Hidayat)
        $visit3 = Visit::create([
            'patient_id' => $patient3->id,
            'visit_date' => Carbon::now()->format('Y-m-d'),
            'complaint' => 'Pusing tengkuk tegang terasa berat sejak pagi, riwayat darah tinggi kontrol rutin.',
            'examination' => 'TD: 150/95 mmHg, Nadi: 80x/m, Suhu: 36.6 C, Cor/Pulmo dalam batas normal.',
            'diagnosis' => 'Hipertensi Grade 1',
            'action' => 'Pemberian antihipertensi, diet rendah garam, kontrol ulang 1 bulan ke depan.',
        ]);

        Prescription::create([
            'visit_id' => $visit3->id,
            'drug_name' => 'Amlodipine',
            'dosage' => '5 mg',
            'instructions' => '1x1 tablet malam hari sebelum tidur',
            'quantity' => 30,
        ]);
    }
}
