<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Models\Absensi; // Import model Absensi
use App\Models\SlipGaji; // Import model SlipGaji
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;

class SlipGajiController extends Controller
{
    public function index()
{
    // Ambil hanya data slip gaji dengan keterangan 'draft'
    $slipGaji = SlipGaji::where('keterangan', 'draft')->get();

    return view('slip.index', ['slipGaji' => $slipGaji]);
}
    public function export()
{
    // Ambil hanya data slip gaji dengan keterangan 'draft'
    $slipGaji = SlipGaji::where('keterangan', 'approve')->get();

    return view('slip.export', ['slipGaji' => $slipGaji]);
}

    public function show($id)
    {
        // Cari slip gaji berdasarkan ID
        $slipGaji = SlipGaji::findOrFail($id);

        // Ambil data karyawan terkait
        $karyawan = $slipGaji->karyawan;
        

        // Implementasikan logika untuk mengambil data terkait sesuai kebutuhan aplikasi
        // Misalnya:
        $periode_gaji = $slipGaji->periode_gaji;
        $insentif = $slipGaji->insentif;
        $upahLembur = $slipGaji->lembur;
         // Menghitung jumlah hari tidak masuk berdasarkan status absensi
        $startDate = Carbon::create(null, $periode_gaji, 1)->startOfMonth();
        $endDate = Carbon::create(null, $periode_gaji, 1)->endOfMonth();
        
        $jumlahHariTidakMasuk = Absensi::where('karyawan_id', $karyawan->id)
            ->where('status_absensi', '<>', 'Hadir')
            ->where(function ($query) use ($karyawan) {
        if ($karyawan->status == 'Tetap' && $karyawan->masa_kerja >= 1) {
            $query->where('status_absensi', '<>', 'Cuti');
        }
         })
            ->where('tanggal_absensi', '>=', $startDate)
            ->where('tanggal_absensi', '<=', $endDate)
            ->count();

        

        $potonganBPJS = $slipGaji->potongan_bpjs;
        // $potonganNWNP = $slipGaji -> potongan_nwnp * ($karyawan->gaji_pokok / 30);// Ganti dengan logika sesuai kebutuhan
        $potonganNWNP = $jumlahHariTidakMasuk * ($karyawan->gaji_pokok / 30);
        $totalGaji = $slipGaji->total_gaji;

        // Kirim data ke view slipgaji.show
        return view('slip.show', [
            'karyawan' => $karyawan,
            'periode_gaji' => $periode_gaji,
            'insentif' => $insentif,
            'upahLembur' => $upahLembur,
            'jumlahHariTidakMasuk' => $jumlahHariTidakMasuk,
            'potonganBPJS' => $potonganBPJS,
            'potonganNWNP' => $potonganNWNP,
            'totalGaji' => $totalGaji,
            'slipGaji' => $slipGaji,
        ]);
    }
    public function acc($id)
    {
        // Cari slip gaji berdasarkan ID
        $slipGaji = SlipGaji::findOrFail($id);

        // Ambil data karyawan terkait
        $karyawan = $slipGaji->karyawan;
        

        // Implementasikan logika untuk mengambil data terkait sesuai kebutuhan aplikasi
        // Misalnya:
        $periode_gaji = $slipGaji->periode_gaji;
        $insentif = $slipGaji->insentif;
        $upahLembur = $slipGaji->lembur;
         // Menghitung jumlah hari tidak masuk berdasarkan status absensi
        $startDate = Carbon::create(null, $periode_gaji, 1)->startOfMonth();
        $endDate = Carbon::create(null, $periode_gaji, 1)->endOfMonth();
        
        $jumlahHariTidakMasuk = Absensi::where('karyawan_id', $karyawan->id)
            ->where('status_absensi', '<>', 'Hadir')
            ->where(function ($query) use ($karyawan) {
        if ($karyawan->status == 'Tetap' && $karyawan->masa_kerja >= 1) {
            $query->where('status_absensi', '<>', 'Cuti');
        }
         })
            ->where('tanggal_absensi', '>=', $startDate)
            ->where('tanggal_absensi', '<=', $endDate)
            ->count();

        

        $potonganBPJS = $slipGaji->potongan_bpjs;
        // $potonganNWNP = $slipGaji -> potongan_nwnp * ($karyawan->gaji_pokok / 30);// Ganti dengan logika sesuai kebutuhan
        $potonganNWNP = $jumlahHariTidakMasuk * ($karyawan->gaji_pokok / 30);
        $totalGaji = $slipGaji->total_gaji;

        // Kirim data ke view slipgaji.show
        return view('slip.approve', [
            'karyawan' => $karyawan,
            'periode_gaji' => $periode_gaji,
            'insentif' => $insentif,
            'upahLembur' => $upahLembur,
            'jumlahHariTidakMasuk' => $jumlahHariTidakMasuk,
            'potonganBPJS' => $potonganBPJS,
            'potonganNWNP' => $potonganNWNP,
            'totalGaji' => $totalGaji,
            'slipGaji' => $slipGaji,
        ]);
    }
    public function approveSlip($id)
    {
        // Find the SlipGaji by ID and update the 'keterangan' field
        $slipGaji = SlipGaji::findOrFail($id);
        $slipGaji->keterangan = 'approve';
        $slipGaji->save();

        // Return a response indicating success
        // return Redirect::route('slipgaji.show')->with('success', 'Slip Gaji Berhasil Di Approve');
        return redirect()->route('slipgaji.index')->with('success', 'Slip Gaji Berhasil Di Approve.');
    }
    
    public function destroy($id) {
        {
            // Cari SlipGaji berdasarkan ID
            $slipGaji = SlipGaji::findOrFail($id);
    
            // Hapus data SlipGaji
            $slipGaji->delete();
    
            return redirect()->route('slipgaji.export')->with('success', 'Data berhasil dihapus.');
        } 
    }

    public function destroyAll()
    {
        // Hapus semua data SlipGaji
        SlipGaji::truncate();
    
        return redirect()->route('slipgaji.export')->with('success', 'Semua data berhasil dihapus.');
    }
    
    
}
