@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <h1 class="mb-4">Absensi Karyawan</h1>

    <form action="{{ route('absensi.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="tanggal_absensi" class="form-label">Tanggal Absensi</label>
            <input type="date" class="form-control" id="tanggal_absensi" name="tanggal_absensi" required>
        </div>

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Status Absensi</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="hadir" name="status_absensi[]" value="Hadir" onclick="uncheckOthers('hadir')">
                <label class="form-check-label" for="hadir">Hadir</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="izin" name="status_absensi[]" value="Izin" onclick="uncheckOthers('izin')">
                <label class="form-check-label" for="izin">Izin</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="sakit" name="status_absensi[]" value="Sakit" onclick="uncheckOthers('sakit')">
                <label class="form-check-label" for="sakit">Sakit</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="alpha" name="status_absensi[]" value="Alpha" onclick="uncheckOthers('alpha')">
                <label class="form-check-label" for="alpha">Alpha</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="cuti" name="status_absensi[]" value="Cuti" onclick="uncheckOthers('cuti')">
                <label class="form-check-label" for="cuti">Cuti</label>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- Tambahkan opsi status absensi lainnya sesuai kebutuhan -->
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Karyawan</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="select_all" onclick="selectAll()">
                <label class="form-check-label" for="select_all">Pilih Semua</label>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($karyawan as $k)
                    <div class="col">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h5 class="card-title">{{ $k->nama }}</h5>
                                <p class="card-text">{{ $k->jabatan }}</p>
                                <input class="form-check-input" type="checkbox" id="karyawan_{{ $k->id }}" name="karyawan_ids[]" value="{{ $k->id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- {{ $karyawan->links() }} --}}
        </div>
    </form>
</div>

<style>
    .form-label {
        font-size: 1rem;
        font-weight: bold;
    }

    .form-check-input {
        margin-right: 0.5rem;
    }

    .btn-primary {
        font-size: 1rem;
    }

    .btn-primary:hover {
        background-color: #005A8D;
    }

    .alert-danger {
        background-color: #FF4136;
        color: white;
    }

    .card {
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding: 10px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .card-text {
        font-size: 0.9rem;
        margin-bottom: 5px;
    }
</style>

<script>
    function uncheckOthers(clickedId) {
        const checkboxes = ['hadir', 'izin', 'sakit']; // Nama-nama checkbox
        checkboxes.forEach((checkboxId) => {
            if (checkboxId !== clickedId) {
                document.getElementById(checkboxId).checked = false;
            }
        });
    }

    function selectAll() {
        const checkboxes = document.querySelectorAll('input[name="karyawan_ids[]"]');
        const selectAllCheckbox = document.getElementById('select_all');

        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>

@endsection
