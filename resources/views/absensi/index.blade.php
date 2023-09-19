@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <h2 style="text-align: center">Data Absensi Karyawan</h2>

        <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a>

        <form action="{{ route('absensi.index') }}" method="GET" class="filter-form">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                        <select class="form-select" id="karyawan_id" name="karyawan_id">
                            <option value="" selected>Semua Karyawan</option>
                            @foreach($karyawan as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tanggal_absensi" class="form-label">Pilih Tanggal Absensi</label>
                        <input type="date" class="form-control" id="tanggal_absensi" name="tanggal_absensi">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="periode_absensi" class="form-label">Pilih Periode Absensi</label>
                        <select class="form-select" id="periode_absensi" name="periode_absensi">
                            <option value="" selected>Semua Periode</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">
                            <a href="{{ route('absensi.index', ['sort' => 'karyawan.nama', 'order' => ($order == 'asc' && $sort == 'karyawan.nama') ? 'desc' : 'asc']) }}">Nama Karyawan</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('absensi.index', ['sort' => 'tanggal_absensi', 'order' => ($order == 'asc' && $sort == 'tanggal_absensi') ? 'desc' : 'asc']) }}">Tanggal Absensi</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('absensi.index', ['sort' => 'status_absensi', 'order' => ($order == 'asc' && $sort == 'status_absensi') ? 'desc' : 'asc']) }}">Status Absensi</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensi as $index => $data)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>
                                @if($data->karyawan)
                                    {{ $data->karyawan->nama }}
                                @else
                                    Karyawan Tidak Ditemukan
                                @endif
                            </td>
                            <td>{{ $data->tanggal_absensi }}</td>
                            <td>{{ $data->status_absensi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
