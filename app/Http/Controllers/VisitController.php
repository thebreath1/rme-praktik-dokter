<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visit;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    /**
     * Formulir pencatatan kunjungan medis baru untuk pasien tertentu
     */
    public function create(Patient $patient)
    {
        $today = Carbon::today()->format('Y-m-d');
        return view('visits.create', compact('patient', 'today'));
    }

    /**
     * Simpan data kunjungan medis beserta resep obat secara transaksional
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date',
            'complaint' => 'required|string',
            'examination' => 'nullable|string',
            'diagnosis' => 'required|string|max:255',
            'action' => 'required|string',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.drug_name' => 'nullable|string|max:255',
            'prescriptions.*.dosage' => 'nullable|string|max:100',
            'prescriptions.*.instructions' => 'nullable|string|max:255',
            'prescriptions.*.quantity' => 'nullable|integer|min:1',
        ], [
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'complaint.required' => 'Keluhan utama pasien wajib diisi.',
            'diagnosis.required' => 'Diagnosis wajib diisi.',
            'action.required' => 'Tindakan medis wajib diisi (misal: pemberian obat, edukasi, atau rujuk).',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan Kunjungan Medis
            $visit = Visit::create([
                'patient_id' => $patient->id,
                'visit_date' => $validated['visit_date'],
                'complaint' => $validated['complaint'],
                'examination' => $validated['examination'] ?? null,
                'diagnosis' => $validated['diagnosis'],
                'action' => $validated['action'],
            ]);

            // 2. Simpan Resep Obat Dinamis (jika ada obat yang diisi)
            if (!empty($validated['prescriptions'])) {
                foreach ($validated['prescriptions'] as $item) {
                    $drugName = trim($item['drug_name'] ?? '');
                    if ($drugName !== '') {
                        Prescription::create([
                            'visit_id' => $visit->id,
                            'drug_name' => $drugName,
                            'dosage' => trim($item['dosage'] ?? '-') ?: '-',
                            'instructions' => trim($item['instructions'] ?? '-') ?: '-',
                            'quantity' => !empty($item['quantity']) ? (int) $item['quantity'] : null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('patients.show', $patient->id)
                ->with('success', "Kunjungan medis untuk pasien \"{$patient->full_name}\" berhasil disimpan ke rekam medis!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'general' => 'Terjadi kesalahan saat menyimpan rekam medis: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Halaman pratinjau dan cetak resep digital (Browser print & PDF format)
     */
    public function printPrescription(Visit $visit)
    {
        $visit->load(['patient', 'prescriptions']);

        // Data praktik dokter untuk kop/header
        $clinic = [
            'name' => 'PRAKTIK DOKTER UMUM MANDIRI',
            'doctor' => 'dr. Pratama Wijaya, Sp.KKLP',
            'sip' => 'SIP: 446/1024/SIP-DU/DINKES/2024',
            'address' => 'Jl. Kesehatan No. 108, Ciamis, Jawa Barat 46211',
            'phone' => 'Telp: (0265) 771234 | WhatsApp: 0812-3456-7890',
            'schedule' => 'Senin - Sabtu: 08.00 - 12.00 & 16.00 - 20.00 WIB',
        ];

        return view('visits.print-prescription', compact('visit', 'clinic'));
    }
}
