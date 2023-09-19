@extends('dashboard.layouts.main')

@section('styles')
<style>
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
    <h2 class="mb-4" style="text-align: center">Laporan Absensi Karyawan</h2>

    <form action="{{ route('absensi.report') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                <select class="form-select" id="karyawan_id" name="karyawan_id">
                    <option value="" selected>Semua Karyawan</option>
                    @foreach($karyawan as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="periode_absensi" class="form-label">Pilih Periode Absensi</label>
                <select class="form-select" id="periode_absensi" name="periode_absensi">
                    <option value="" selected>Semua Periode</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
            </div>
        </div>
    </form>

    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Masa Kerja (dalam tahun)</th>
                    <th scope="col">Periode Absensi</th>
                    <th scope="col">Jumlah Ketidakhadiran</th>
                    <th scope="col">Jumlah Cuti</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                    @foreach($absensiGrouped as $karyawanId => $grouped)
                    @php
                        $totalKetidakhadiran = $grouped->filter(function($item) {
                            return $item->status_absensi !== 'Hadir';
                        })->count();
                        
                        // Menghitung jumlah cuti
                        $jumlahCuti = $grouped->filter(function($item) {
                            return $item->status_absensi === 'Cuti';
                        })->count();
    
                        // Ambil jabatan dan status karyawan
                        $jabatan = $grouped->first()->karyawan->jabatan;
                        $status = $grouped->first()->karyawan->status;
                        $masa_kerja = $grouped->first()->karyawan->masa_kerja;
                    @endphp
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>
                            @if ($grouped->first()->karyawan) 
                                {{ $grouped->first()->karyawan->nama }}
                            @else
                                Nama tidak tersedia
                            @endif
                        </td>
                        <td>{{ $jabatan }}</td>
                        <td>{{ $status }}</td>
                        <td>
                            @php
                                // Mengambil masa kerja
                                $masaKerja = $grouped->first()->karyawan->masa_kerja;
                                
                                // Menampilkan "Kurang dari satu tahun" jika masa kerja kurang dari 1 tahun
                                echo $masaKerja == 0 ? 'Kurang dari satu tahun' : $masaKerja . ' tahun';
                            @endphp
                        </td>
                        <td>{{ date('F', strtotime($grouped->first()->tanggal_absensi)) }}</td>
                        <td>{{ $totalKetidakhadiran }}</td>
                        <td>
                            @if ($jumlahCuti > 0)
                                {{ $jumlahCuti }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
