@extends('layouts.root.auth')

@section('main')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            <h2 class="mb-3 fs-7 fw-bolder">Digital Henkaten</h2>
            <p class=" mb-9">Your Admin Dashboard</p>
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <a href="index.html" class="btn btn-primary w-100 py-8 mb-4 rounded-2 fw-medium">Sign In</a>
                <div class="d-flex align-items-center justify-content-center">
                    <small class="fs-4 mb-0 fw-medium">New to Henkaten?</small>
                    <a class="text-primary fw-medium ms-2" href="{{ route('register.index') }}">Create an account</a>
                </div>
            </form>
        </div>
    </div>
@endsection
