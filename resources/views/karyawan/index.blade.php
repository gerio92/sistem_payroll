@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <h2 class="mb-4" style="text-align: center">Daftar Karyawan</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Masa Kerja</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->jabatan }}</td>
                    <td>{{ $k->status }}</td>
                    <td>
                        @php
                            $masaKerjaText = $k->masa_kerja == 0 ? 'Kurang dari satu tahun' : $k->masa_kerja . ' Tahun';
                        @endphp
                        {{ $masaKerjaText }}
                    </td>
                    <td>Rp {{ number_format($k->gaji_pokok, 2) }}</td>
                    <td>Rp {{ number_format($k->tunjangan, 2) }}</td>
                    <td>
                        <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
