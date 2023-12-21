@extends('layouts.root.blank')

@section('main')
    <div class="row">
        <div class="col-12">
            <a href="#" class="text-nowrap nav-link text-center mb-5">
                <img src="{{ asset('assets/images/henkaten-logo.svg') }}" class="dark-logo" width="300" alt="" />
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-6 d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card text-bg-light text-dark w-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mt-3">
                        <h1 class="text-dark">DIE CASTING</h1>
                        <div class="ms-auto">
                            <i class="ti ti-arrow-right fs-8"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card text-bg-light text-dark w-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mt-3">
                        <h1 class="text-dark">MACHINING</h1>
                        <div class="ms-auto">
                            <i class="ti ti-arrow-right fs-8"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card text-bg-light text-dark w-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mt-3">
                        <h1 class="text-dark">ASSEMBLING</h1>
                        <div class="ms-auto">
                            <i class="ti ti-arrow-right fs-8"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card text-bg-light text-dark w-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center mt-3">
                        <h1 class="text-dark">ELECTRIC</h1>
                        <div class="ms-auto">
                            <i class="ti ti-arrow-right fs-8"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
