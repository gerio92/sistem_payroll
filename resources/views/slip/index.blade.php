@extends('dashboard.layouts.main')

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
        text-align: left;
    }

    .table-container th {
        background-color: #005A8D;
        color: white;
    }

    .table-container th,
    .table-container td a {
        color: #005A8D;
        text-decoration: none;
        font-weight: bold;
    }

    .table-container td a:hover {
        color: #0098DB;
    }

    .table-container tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
</style>
@endsection

@section('container')
<div class="container">
    <h2 style="text-align: center">Daftar Slip Gaji</h2>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

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
                        <a href="{{ route('slipgaji.show', $slip->id) }}">Lihat Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
