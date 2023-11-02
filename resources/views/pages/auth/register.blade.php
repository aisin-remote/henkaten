@extends('layouts.root.auth')

@section('main')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            <!-- Periksa jika ada pesan sukses -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Periksa jika ada pesan error/validasi -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2 class="mb-3 fs-7 fw-bolder mt-3">Digital Henkaten</h2>
            <p class="mb-9">Your Henkaten Dashboard</p>
            <form method="POST" action="{{ route('register.store') }}"> <!-- Tambahkan method POST dan action -->
                @csrf <!-- Tambahkan token CSRF untuk keamanan -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <!-- Tambahkan name="name" -->
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" required>
                    <!-- Tambahkan name="npk" -->
                </div>
                <div class="form-group mb-4">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Role</label>
                    <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="role">
                        <option selected>-- select --</option>
                        <option value="Operator">Operator</option>
                        <option value="JP">JP</option>
                        <option value="Leader">Leader</option>
                        <option value="SPV">SPV</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <!-- Tambahkan name="password" -->
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required> <!-- Tambahkan name="password_confirmation" -->
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 mb-4 rounded-2">Sign Up</button>
                <!-- Ganti button menjadi type="submit" -->
                <div class="d-flex align-items-center">
                    <p class="fs-4 mb-0 text-dark">Already have an Account?</p>
                    <a class="text-primary fw-medium ms-2" href="{{ route('login.index') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
@endsection
