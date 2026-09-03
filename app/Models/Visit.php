<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'visits';

    protected $fillable = [
        'patient_id',
        'visit_date',
        'complaint',
        'examination',
        'diagnosis',
        'action',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Relasi ke data pasien
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Relasi ke resep obat
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'visit_id');
    }
}
