<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    protected $fillable = [
        'visit_id',
        'drug_name',
        'dosage',
        'instructions',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Relasi ke kunjungan
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }
}
