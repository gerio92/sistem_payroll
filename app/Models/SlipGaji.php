<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'slip_gaji';

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'gaji_pokok',
        'insentif',
        'lembur',
        'potongan_nwnp',
        'potongan_bpjs',
        'total_gaji',
        'keterangan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
