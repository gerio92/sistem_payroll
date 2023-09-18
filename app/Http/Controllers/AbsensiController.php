<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;

class AbsensiController extends Controller
{
    // Metode untuk menampilkan data absensi dengan filter berdasarkan karyawan dan periode absensi
    public function index(Request $request)
{
   // Query semua karyawan
//    $karyawanQuery = Karyawan::query();
    
    $karyawan = Karyawan::all();
    $filterKaryawanId = $request->input('karyawan_id');
    $filterPeriodeAbsensi = $request->input('periode_absensi');
    $order = $request->input('order', 'asc');
    $sort = $request->input('sort', 'tanggal_absensi');

    $absensiQuery = Absensi::query();

    // Filter berdasarkan karyawan jika dipilih
    if ($filterKaryawanId) {
        $absensiQuery->where('karyawan_id', $filterKaryawanId);
    }

    // Filter berdasarkan periode absensi (bulan) jika dipilih
    if ($filterPeriodeAbsensi) {
        $absensiQuery->whereMonth('tanggal_absensi', $filterPeriodeAbsensi);
    }

    // Mengurutkan berdasarkan tanggal absensi
    $absensiQuery->orderBy('tanggal_absensi', $order);

    $absensi = $absensiQuery->get();

    return view('absensi.index', compact('absensi', 'karyawan', 'order', 'sort'));
}



    // Metode untuk menampilkan laporan absensi dengan jumlah ketidakhadiran
    public function report(Request $request)
{
    // Mengambil data absensi berdasarkan filter
    $filterKaryawanId = $request->input('karyawan_id');
    $filterPeriodeAbsensi = $request->input('periode_absensi');

    $absensiQuery = Absensi::query();
    if ($filterKaryawanId) {
        $absensiQuery->where('karyawan_id', $filterKaryawanId);
    }
    if ($filterPeriodeAbsensi) {
        $absensiQuery->whereMonth('tanggal_absensi', $filterPeriodeAbsensi);
    }
    $absensi = $absensiQuery->get();

    // Mengelompokkan data absensi berdasarkan karyawan
    $absensiGrouped = $absensi->groupBy('karyawan_id');

    // Mengambil data karyawan untuk dropdown filter
    $karyawan = Karyawan::all();

    return view('absensi.absensi_report', compact('absensiGrouped', 'karyawan'));
}




    // Metode untuk menampilkan form tambah absensi
    public function create()
    {
        $karyawan = Karyawan::all();
        return view('absensi.create', compact('karyawan'));
    }

    // Metode untuk menyimpan data absensi
    public function store(Request $request)
{
    $request->validate([
        'status_absensi' => 'required|array',
        'status_absensi.*' => 'in:Hadir,Izin,Sakit,Alpha,Cuti',
        'karyawan_ids' => 'required|array',
        'karyawan_ids.*' => 'exists:karyawan,id',
        'tanggal_absensi' => 'required|date',
    ]);

    $statusAbsensi = $request->input('status_absensi');
    $karyawanIds = $request->input('karyawan_ids');
    $tanggalAbsensi = $request->input('tanggal_absensi');

    // Cek apakah karyawan sudah absen pada tanggal ini
    $existingAbsensi = Absensi::whereIn('karyawan_id', $karyawanIds)
        ->where('tanggal_absensi', $tanggalAbsensi)
        ->exists();

    if ($existingAbsensi) {
        return redirect()->route('absensi.create')->with('error', 'Karyawan sudah terabsen pada tanggal tersebut.');
    }

    // Simpan data absensi
    foreach ($karyawanIds as $karyawanId) {
        foreach ($statusAbsensi as $status) {
            Absensi::create([
                'karyawan_id' => $karyawanId,
                'status_absensi' => $status,
                'tanggal_absensi' => $tanggalAbsensi,
            ]);
        }
    }

    return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil disimpan.');
}


}
