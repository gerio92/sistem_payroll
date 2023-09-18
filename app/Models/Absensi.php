<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    public $timestamps = false;
    protected $table = 'absensi'; // Nama tabel dalam database

    protected $fillable = [
        'karyawan_id',
        'tanggal_absensi',
        'status_absensi',
    ];

    // Relasi dengan model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
