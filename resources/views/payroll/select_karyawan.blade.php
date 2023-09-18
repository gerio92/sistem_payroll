@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <h1>Form Perhitungan Gaji</h1>

        @include('payroll.form_gaji', ['karyawan' => $karyawan])

    </div>
@endsection
