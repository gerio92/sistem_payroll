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
    <h2 style="text-align: center">Daftar User</h2>

    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach($users as $user)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->level }}</td>
                    <td>
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection



