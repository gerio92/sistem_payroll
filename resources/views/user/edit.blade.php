@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <h2 style="text-align: center">Edit Data Admin</h2>

    <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="text" class="form-control" id="level" name="level" value="{{ $user->level }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
