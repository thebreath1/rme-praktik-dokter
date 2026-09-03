<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visit;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard rekam medis
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $totalPatients = Patient::count();
        $todayVisits = Visit::whereDate('visit_date', $today)->count();
        $monthVisits = Visit::whereMonth('visit_date', $thisMonth)
            ->whereYear('visit_date', $thisYear)
            ->count();
        $totalPrescriptions = Prescription::count();

        // Kunjungan terbaru
        $recentVisits = Visit::with(['patient', 'prescriptions'])
            ->latest('visit_date')
            ->latest('id')
            ->take(6)
            ->get();

        // Pasien yang baru didaftarkan
        $recentPatients = Patient::latest('created_at')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'todayVisits',
            'monthVisits',
            'totalPrescriptions',
            'recentVisits',
            'recentPatients'
        ));
    }
}
