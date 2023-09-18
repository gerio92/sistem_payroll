@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <h1>Form Perhitungan Gaji</h1>

        <form action="{{ route('payroll.calculate', ['id' => $karyawan->id]) }}" method="POST">
            @csrf

            <!-- Bagian Data Karyawan -->

            <div class="mb-3">
                <label for="periode_gaji" class="form-label">Pilih Periode Gaji</label>
                <select class="form-select" id="periode_gaji" name="periode_gaji">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
           <!-- Bagian Checkbox Potongan BPJS -->
            <div class="mb-3">
                <label class="form-label">Potongan BPJS</label>
            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="potongan_bpjs" name="potongan_bpjs">
                <label class="form-check-label" for="potongan_bpjs">
                    Potongan BPJS (%)
                </label>
            </div>
            </div>
            <!-- Bagian Input Jam Lembur -->
            <div class="mb-3">
                <label for="jam_lembur" class="form-label">Jam Lembur</label>
                <input type="number" class="form-control" id="jam_lembur" name="jam_lembur" placeholder="Masukkan jam lembur" required>
            </div>

            <button type="submit" class="btn btn-primary">Hitung Gaji</button>
        </form>
    </div>
@endsection
