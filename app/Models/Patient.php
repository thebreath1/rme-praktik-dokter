<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'nik',
        'full_name',
        'birth_date',
        'gender',
        'address',
        'phone',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Relasi ke kunjungan medis (urut dari yang terbaru)
     */
    public function visits()
    {
        return $this->hasMany(Visit::class)->orderBy('visit_date', 'desc')->orderBy('id', 'desc');
    }

    /**
     * Accessor untuk usia pasien dalam tahun
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->age : 0;
    }

    /**
     * Accessor label jenis kelamin
     */
    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
