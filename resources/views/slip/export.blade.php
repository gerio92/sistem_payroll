@extends('dashboard.layouts.main')

@section('title', 'Daftar Slip Gaji')

@section('styles')
<style>
    /* Custom styles for the table */
    .table-container {
        margin-top: 20px;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .table-container th, .table-container td {
        padding: 15px;
        background-color: #f9f9f9;
        text-align: left;
    }

    .table-container th {
        background-color: #333;
        color: white;
    }

    .table-container tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
</style>
@endsection

@section('container')
<div class="container">
    <h2 class="mb-4" style="text-align: center">Daftar Cetak Gaji</h2>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    {{-- <form action="{{ route('slipgaji.destroyAll') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-md">Hapus Semua</button>
    </form>     --}}
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Bulan</th>
                    <th>Total Gaji</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slipGaji as $index => $slip)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $slip->karyawan->nama }}</td>
                    <td>{{ $slip->karyawan->jabatan }}</td>
                    <td>{{ $slip->karyawan->status }}</td>
                    <td>{{ $slip->bulan }}</td>
                    <td>Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}</td>
                    <td>{{ $slip->keterangan }}</td>
                    <td>
                        <form action="{{ route('slipgaji.acc', $slip->id) }}"class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Lihat Detail</button>
                        </form>
                    
                        <form action="{{ route('slipgaji.destroy', $slip->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
