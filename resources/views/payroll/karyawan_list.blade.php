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
    <h2 style="text-align: center">Hitung Gaji Karyawan</h2>

    <div class="input-group mb-3">
        <input type="text" id="search" class="form-control" placeholder="Cari nama karyawan.." onkeyup="searchKaryawan()">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">Cari</button>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach($karyawan as $k)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->jabatan }}</td>
                    <td>{{ $k->status }}</td>
                    <td>{{ $k->gaji_pokok }}</td>
                    <td>{{ $k->tunjangan }}</td>
                    <td>
                        <a href="{{ route('select_karyawan.show', ['id' => $k->id]) }}" class="btn btn-primary">Hitung Gaji</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchKaryawan() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('search');
        filter = input.value.toUpperCase();
        table = document.querySelector('.table');
        tr = table.getElementsByTagName('tr');

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName('td')[1];

            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
</script>
@endsection
