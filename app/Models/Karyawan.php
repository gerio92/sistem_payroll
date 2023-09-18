<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{

    public $timestamps = false;
    protected $table = 'karyawan'; // Nama tabel dalam database

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'jabatan',
        'status',
        'gaji_pokok',
        'tunjangan',
        'masa_kerja',
    ];

    // Relasi dengan tabel Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // Relasi dengan tabel Payroll
    public function slipgaji()
    {
        return $this->hasMany(SlipGaji::class);
    }
}
