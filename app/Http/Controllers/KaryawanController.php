<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.index', ['karyawan' => $karyawan]);
    }

    // Menampilkan formulir tambah karyawan
    public function create()
    {
        return view('karyawan.tambah');
    }

    // Menyimpan karyawan baru ke database
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'jabatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'required|numeric',
            'masa_kerja' => 'required|integer',
        ]);

        Karyawan::create($validatedData);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }


    // Menampilkan formulir edit karyawan
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', ['karyawan' => $karyawan]);
    }

    // Mengupdate data karyawan ke dalam database
    public function update(Request $request, $id)
    {
        // Validasi data yang diinput
        $validatedData = $request->validate([   
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'required',
            'status' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'required|numeric',
            'masa_kerja' => 'required',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($validatedData);

        return redirect('/karyawan')->with('success', 'Karyawan berhasil diperbarui.');
    }

    // Menghapus karyawan dari database
    public function destroy($id)
{
    // Temukan karyawan berdasarkan ID
    $karyawan = Karyawan::findOrFail($id);

    // Hapus karyawan
    $karyawan->delete();

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
}

}
