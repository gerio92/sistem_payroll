@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <h1>Edit Karyawan</h1>

    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $karyawan->nama }}">
        </div>
        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $karyawan->tempat_lahir }}">
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $karyawan->tanggal_lahir }}">
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $karyawan->jabatan }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="Tetap" {{ $karyawan->status == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ $karyawan->status == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                <option value="HL" {{ $karyawan->status == 'HL' ? 'selected' : '' }}>Harian Lepas</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" value="{{ $karyawan->gaji_pokok }}">
        </div>
        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan</label>
            <input type="text" class="form-control" id="tunjangan" name="tunjangan" value="{{ $karyawan->tunjangan }}">
        </div>

        <div class="mb-3">
            <label for="masa_kerja" class="form-label">Masa Kerja (Tahun)</label>
            <input type="number" class="form-control" id="masa_kerja" name="masa_kerja" value="{{ $karyawan->masa_kerja }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
