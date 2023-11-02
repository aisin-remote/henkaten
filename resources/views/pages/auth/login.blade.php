@extends('layouts.root.auth')

@section('main')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <h2 class="mb-3 fs-7 fw-bolder mt-3">Digital Henkaten</h2>
            <p class="mb-9">Your Henkaten Dashboard</p>
            <form method="POST" action="{{ route('login.authenticate') }}">
                @csrf
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2 fw-medium">Sign In</button>
                <div class="d-flex align-items-center justify-content-center">
                    <small class="fs-4 mb-0 fw-medium">New to Henkaten?</small>
                    <a class="text-primary fw-medium ms-2" href="{{ route('register.index') }}">Create an account</a>
                </div>
            </form>
        </div>
    </div>
@endsection
