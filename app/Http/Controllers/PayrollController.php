<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\SlipGaji;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    private function getNamaBulan($angkaBulan)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $namaBulan[$angkaBulan];
    }

    public function showKaryawanList(Request $request)
    {
        $search = $request->query('search');
    
    // Jika terdapat pencarian, filter karyawan berdasarkan nama
    if ($search) {
        $karyawan = Karyawan::where('nama', 'like', '%' . $search . '%')->get();
    } else {
        $karyawan = Karyawan::all();
    }

    return view('payroll.karyawan_list', ['karyawan' => $karyawan]);
    }

    public function showSelectKaryawan($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('payroll.select_karyawan', ['karyawan' => $karyawan]);
    }

    public function calculatePayroll(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            // 'nwnp' => 'required|numeric',
            // 'potongan_bpjs' => 'nullable|numeric',
            'jam_lembur' => 'required|numeric',
            'cuti' => 'nullable|numeric',
            'periode_gaji' => 'required|numeric'
        ]);

        // Mendapatkan data karyawan berdasarkan ID
        $karyawan = Karyawan::findOrFail($id);

        // Mendapatkan periode gaji
        $periode_gaji = $request->input('periode_gaji');

        // Mendapatkan tanggal awal dan akhir berdasarkan periode
        $startDate = Carbon::create(null, $periode_gaji, 1)->startOfMonth();
        $endDate = Carbon::create(null, $periode_gaji, 1)->endOfMonth();

        // Menggunakan query untuk menghitung jumlah hari tidak masuk selain 'Hadir'
        $jumlahHariTidakMasuk = Absensi::where('karyawan_id', $id)
        ->where('status_absensi', '<>', 'Hadir')
        ->where(function ($query) use ($karyawan) {
            // Tambahkan pengecekan apakah karyawan memiliki status 'Tetap' dan masa kerja lebih dari satu tahun
            if ($karyawan->status == 'Tetap' && $karyawan->masa_kerja >= 1) {
                $query->where('status_absensi', '<>', 'Cuti'); // Hanya hitung cuti jika syarat terpenuhi
            }
        })
        ->where('tanggal_absensi', '>=', $startDate)
        ->where('tanggal_absensi', '<=', $endDate)
        ->count();
        // Perhitungan insentif berdasarkan status dan masa kerja
        $insentif = 0;
        if ($karyawan->status == 'Tetap') {
            $masaKerjaTahun = $karyawan->masa_kerja;
            if ($masaKerjaTahun < 1) {
                $insentif = 1000000;
            } else {
                $insentif = 1000000 + $masaKerjaTahun * 100000;
            }
        }

        // Perhitungan upah lembur per jam
        $upahLemburPerJam = 0;
        if ($karyawan->status == 'HL') {
            $upahLemburPerJam = $karyawan->gaji_pokok / 173;
        } else {
            $upahLemburPerJam = ($karyawan->gaji_pokok + $karyawan->tunjangan) / 173;
        }

        // Perhitungan upah lembur
        $jamLembur = $request->input('jam_lembur');
        $jamLemburPenjabaran = ($jamLembur > 4) ? ($jamLembur - 4) * 2 + 4 : $jamLembur;
        $upahLembur = $upahLemburPerJam * $jamLemburPenjabaran;

        // Perhitungan potongan NWNP
        $potonganNWNP = $jumlahHariTidakMasuk * ($karyawan->gaji_pokok / 30);

        // Perhitungan potongan BPJS
        $potonganBPJS = $request->has('potongan_bpjs') ? (($karyawan->gaji_pokok + $karyawan->tunjangan) * 0.03) : 0;

        // Perhitungan total gaji
        $totalGaji = $karyawan->gaji_pokok + $karyawan->tunjangan + $insentif + $upahLembur - $potonganNWNP - $potonganBPJS;

        // Mengirim data ke tampilan result
        return view('payroll.result', [
            'karyawan' => $karyawan,
            'insentif' => $insentif,
            'upahLembur' => $upahLembur,
            'jumlahHariTidakMasuk' => $jumlahHariTidakMasuk,
            'potonganNWNP' => $potonganNWNP,
            'potonganBPJS' => $potonganBPJS,
            'totalGaji' => $totalGaji,
            'periode_gaji' => $periode_gaji
        ]);
    }

    public function sahkanSlipGaji(Request $request)
    {
        // Mendapatkan data dari formulir
        $karyawanId = $request->input('karyawan_id');
        $bulanAngka = $request->input('periode_gaji');
        $gajiPokok = $request->input('gaji_pokok');
        $insentif = $request->input('insentif');
        $lembur = $request->input('upahLembur');
        $potonganNWNP = $request->input('jumlahHariTidakMasuk');
        $potonganBPJS = $request->input('potonganBPJS');
        $totalGaji = $request->input('totalGaji');

        if (!$karyawanId) {
            return redirect()->back()->with('error', 'Karyawan ID tidak valid.');
        }

        // Ubah angka bulan menjadi nama bulan
        $bulan = $this->getNamaBulan($bulanAngka);

        // Simpan data ke tabel gaji
        SlipGaji::create([
            'karyawan_id' => $karyawanId,
            'bulan' => $bulan,
            'gaji_pokok' => $gajiPokok,
            'insentif' => $insentif,
            'lembur' => $lembur,
            'potongan_nwnp' => $potonganNWNP,
            'potongan_bpjs' => $potonganBPJS,
            'total_gaji' => $totalGaji
        ]);

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('payroll.karyawan_list')->with('success', 'Slip Gaji berhasil disimpan!');
    }

    public function showResult($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('payroll.result', ['karyawan' => $karyawan]);
    }
}
