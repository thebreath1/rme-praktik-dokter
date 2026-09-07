<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Tampilkan daftar seluruh pasien dengan fitur pencarian Nama atau NIK
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $gender = $request->input('gender');

        $query = Patient::query()->withCount('visits');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($gender) && in_array($gender, ['L', 'P'])) {
            $query->where('gender', $gender);
        }

        $patients = $query->latest('id')->paginate(10)->withQueryString();

        return view('patients.index', compact('patients', 'search', 'gender'));
    }

    /**
     * Tampilkan form registrasi pasien baru (hanya dapat diakses melalui Dashboard)
     */
    public function create(Request $request)
    {
        $referer = $request->headers->get('referer');
        $isFromDashboard = $request->query('from') === 'dashboard' 
            || ($referer && str_contains($referer, route('dashboard')));

        if (!$isFromDashboard) {
            return redirect()->route('dashboard')
                ->with('error', 'Halaman Registrasi Pasien Baru tidak dapat diakses langsung. Silakan klik tombol "+ Pasien Baru" dari Dashboard Utama.');
        }

        return view('patients.create');
    }

    /**
     * Simpan data pasien baru ke database
     */
    public function store(Request $request)
    {
        // Pengecekan awal untuk NIK jika sudah ada di database (SOP: tolak simpan & beri peringatan)
        if ($request->filled('nik')) {
            $existing = Patient::where('nik', $request->nik)->first();
            if ($existing) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nik' => "Sistem menolak penyimpanan: NIK {$request->nik} sudah terdaftar dalam sistem atas nama pasien \"{$existing->full_name}\". Mohon periksa kembali.",
                    ]);
            }
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'nullable|string|digits:16|unique:patients,nik',
            'birth_date' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ], [
            'full_name.required' => 'Nama lengkap pasien wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem. Mohon gunakan NIK lain atau cari data pasien.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih (Laki-laki / Perempuan).',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'address.required' => 'Alamat tempat tinggal pasien wajib diisi.',
            'phone.required' => 'Nomor telepon / WhatsApp pasien wajib diisi.',
        ]);

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', "Pasien baru \"{$patient->full_name}\" berhasil didaftarkan ke sistem Rekam Medis!");
    }

    /**
     * Tampilkan detail rekam medis pasien beserta seluruh riwayat kunjungan & resep
     */
    public function show(Patient $patient)
    {
        // Eager load seluruh kunjungan (terurut dari yang terbaru) beserta resep obatnya
        $patient->load(['visits.prescriptions']);

        return view('patients.show', compact('patient'));
    }

    /**
     * Tampilkan formulir edit data pasien
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Perbarui data pasien di database
     */
    public function update(Request $request, Patient $patient)
    {
        // Cek duplikasi NIK selain pasien saat ini
        if ($request->filled('nik') && $request->nik !== $patient->nik) {
            $existing = Patient::where('nik', $request->nik)->where('id', '!=', $patient->id)->first();
            if ($existing) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nik' => "Sistem menolak penyimpanan: NIK {$request->nik} sudah terdaftar atas nama pasien \"{$existing->full_name}\".",
                    ]);
            }
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'nullable|string|digits:16|unique:patients,nik,' . $patient->id,
            'birth_date' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ], [
            'full_name.required' => 'Nama lengkap pasien wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem untuk pasien lain.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'address.required' => 'Alamat tempat tinggal pasien wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', "Data identitas pasien \"{$patient->full_name}\" berhasil diperbarui.");
    }

    /**
     * Hapus data pasien beserta seluruh riwayat kunjungan & resep obatnya
     */
    public function destroy(Patient $patient)
    {
        $name = $patient->full_name;

        \Illuminate\Support\Facades\DB::transaction(function () use ($patient) {
            foreach ($patient->visits as $visit) {
                $visit->prescriptions()->delete();
                $visit->delete();
            }
            $patient->delete();
        });

        return redirect()->route('patients.index')
            ->with('success', "Data pasien \"{$name}\" beserta riwayat rekam medisnya berhasil dihapus dari sistem.");
    }
}
