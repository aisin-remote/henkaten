@extends('layouts.root.main')

@section('main')
    @php
        $modalTitle = $pivot && $pivot->theme ? 'Change Theme' : 'Add Theme';
    @endphp

    <!-- theme modal -->
    <div class="modal fade" id="modalTheme" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="themeModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->theme)
                            <div class="mb-3">
                                <label class="mb-2">Current Theme</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->theme->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New Theme</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            tabindex="-1" aria-hidden="true" id="themeSelect">
                            <option>Select</option>
                            @foreach ($themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>

                        <div class="position-relative text-center my-4">
                            <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                                or set with custom theme
                            </p>
                            <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div>

                        <div class="mt-3">
                            <label class="mb-2">Custom Theme</label>
                            <input type="text" class="form-control" placeholder="Custom Theme" name="custom_theme">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="themeForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    @php
        $modalTitle = $pivot && $pivot->firstPic ? 'Change PIC' : 'Add PIC';
    @endphp

    {{-- 1 PIC modal --}}
    <div class="modal fade" id="firstPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->firstPic)
                            <div class="mb-3">
                                <label class="mb-2">Current PIC</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->firstPic->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="firstPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="firstPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- end of modal --}}
    @php
        $modalTitle = $pivot && $pivot->secondPic ? 'Change PIC' : 'Add PIC';
    @endphp

    {{-- 2 PIC modal --}}
    <div class="modal fade" id="secondPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->secondPic)
                            <div class="mb-3">
                                <label class="mb-2">Current PIC</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->secondPic->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="secondPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="secondPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    <div class="row" style="margin-top: -30px">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card shadow-md card-hover">
                <div class="card-body p-3 d-flex align-items-center gap-3" id="themeContainer">
                    <div>
                        <h5 class="fw-semibold mb-0">Tema Safety</h5>
                        <span
                            class="fs-2 d-flex align-items-center py-1 d-inline">{{ Carbon\Carbon::now()->isoFormat('ll') }}
                            <span id="time" class="fs-2 px-2"></span></span>
                    </div>
                    @php
                        $theme = $pivot ? $pivot->theme : null;
                    @endphp

                    <button type="button" class="btn btn-{{ $theme ? 'secondary' : 'light' }} py-2 px-5 ms-auto"
                        data-bs-toggle="modal" data-bs-target="#modalTheme"
                        style="border: 3px {{ $theme ? 'none' : 'dotted' }} {{ $theme ? 'lightgrey' : '#686868' }}">
                        <h4 class="fw-bolder pt-1" style="color: {{ $theme ? 'white' : '#686868' }}">
                            {{ $theme ? $theme->name : 'Set Theme' }}
                        </h4>
                    </button>
                </div>
            </div>
        </div>

        @php
            $firstPic = $pivot ? $pivot->firstPic : null;

            if ($pivot && $firstPic) {
                if ($firstPic->role == 'JP') {
                    $color = 'warning';
                } else {
                    $color = 'danger';
                }
            }
        @endphp

        <div class="col-lg-3 col-sm-12" id="firstPicContainer">
            <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal"
                id="firstPic">
                @if ($firstPic)
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <img src="{{ $firstPic->photo ? asset('uploads/doc/' . $firstPic->photo) : asset('path_to_default_image') }}"
                            alt="" class="rounded-circle" width="60" height="60">
                        <div>
                            <h6 class="fw-semibold mb-0">{{ $firstPic->name }}</h6>
                            <span class="fs-2 d-flex align-items-center py-1"><i
                                    class="ti ti-map-pin text-dark fs-3 me-1"></i>{{ $firstPic->npk }}</span>
                        </div>
                        <button class="btn btn-{{ $color }} py-1 px-3 ms-auto">{{ $firstPic->role }}</button>
                    </div>
                @else
                    <form action="#" class="dropzone dz-clickable p-3 rounded-1">
                        <p class="text-center pt-3">Add First PIC</p>
                    </form>
                @endif
            </div>
        </div>

        @php
            $secondPic = $pivot ? $pivot->secondPic : null;

            if ($pivot && $secondPic) {
                if ($secondPic->role == 'JP') {
                    $color = 'warning';
                } else {
                    $color = 'danger';
                }
            }
        @endphp

        <div class="col-lg-3 col-sm-12" id="secondPicContainer">
            <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#secondPicModal"
                id="secondPic">
                @if ($secondPic)
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <img src="{{ $secondPic->photo ? asset('uploads/doc/' . $secondPic->photo) : asset('path_to_default_image') }}"
                            alt="" class="rounded-circle" width="60" height="60">
                        <div>
                            <h6 class="fw-semibold mb-0">{{ $secondPic->name }}</h6>
                            <span class="fs-2 d-flex align-items-center py-1"><i
                                    class="ti ti-map-pin text-dark fs-3 me-1"></i>{{ $secondPic->npk }}</span>
                        </div>
                        <button class="btn btn-{{ $color }} py-1 px-3 ms-auto">{{ $secondPic->role }}</button>
                    </div>
                @else
                    <form action="#" class="dropzone dz-clickable p-3 rounded-1">
                        <p class="text-center pt-3">Add Second PIC</p>
                    </form>
                @endif
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="text-white">
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-4 py-4">
                                    <div class="card-body p-3 d-flex align-items-center gap-3">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <h1 class="fw-bolder text-center pt-3"
                                                    style="font-size: 1em; display:block; font-weight:900 !important; font-size:80px !important">
                                                    ALL
                                                    LINE
                                                    <br> DIE
                                                    CASTING
                                                </h1>
                                            </div>
                                            <div class="col-lg-3 text-center">
                                                <img src="{{ asset('assets/images/running.svg') }}" class="dark-logo"
                                                    width="240" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    MAN
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    METHOD
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    MACHINE
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card overflow-hidden card-hover">
                                    <div class="card-body bg-white text-center text-muted p-10">
                                        <div class="p-30">
                                            <img src="{{ asset('assets/images/running-medium.svg') }}" class="dark-logo"
                                                width="180" alt="" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-white bg-success p-30">
                                        <div class=" no-block align-items-center">
                                            <div class="text-center">
                                                <h3 class="font-weight-medium text-white fs-6">
                                                    MATERIAL
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-4 py-4">
                                    <div class="card-body p-3 align-items-center text-center">
                                        <h1 class="fw-bolder"
                                            style="font-size: 5em; display:block; font-weight:900 !important">
                                            NO HENKATEN
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="row vertical-carousel">
                <div class="carousel-inner">
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc1">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA01</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc2">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA02</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc3">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA03</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc4">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA04</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc5">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA05</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc6">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA06</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc7">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA07</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 carousel-item" id="dc8">
                        <div class="card overflow-hidden shadow card-hover" style="width:100%">
                            <div class="card-body bg-info text-white text-center p-10">
                                <div class="d-inline-block">
                                    <h3 class="text-light fw-bolder">DCAA08</h3>
                                </div>
                            </div>
                            <div class="card-body bg-success text-white text-center p-1 pt-2">
                                <div class="d-inline-block">
                                    <h4 class="text-light fw-bold">RUNNING</h4>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <div class="col border-end">
                                                <div class="mb-2">MEN</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">MACHINE</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col border-end">
                                                <div class="mb-2">METHOD</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">MATERIAL</div>
                                                <i class="ti ti-circle fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- pic modal 1-->
    <div class="modal fade" id="firstPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add PIC</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="firstPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="firstPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    <!-- pic modal 2 -->
    <div class="modal fade" id="secondPicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add PIC</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true"
                            id="secondPicSelect">
                            <option data-select2-id="select2-data-3-t8ia">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="form2">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    // get theme
    let pivot = @json($pivot);
    let themeName;
    if (pivot !== null) {
        themeName = pivot.theme
        if (themeName !== null) {
            themeName = themeName.name;
        } else {
            themeName = '';
        }
    }

    function initApp() {
        if (!localStorage.getItem('firstPic')) {
            $('#firstPicContainer').html('');
            $('#firstPicContainer').html(`
                    <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal" id="firstPic">
                        <form action="#" class="dropzone dz-clickable p-3 rounded-1">
                            <p class="text-center pt-3">Add First PIC</p>
                        </form>
                    </div>
                `);
        }
    }

    // toast
    function notif(status, message) {
        if (status == 'success') {
            toastr.success(message, "Success!", {
                progressBar: true,
            });
        } else {
            toastr.error(message, "Error!", {
                progressBar: true,
            });
        }
    }

    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const formattedTime = `${hours}:${minutes}:${seconds}`;
        const timeElement = document.getElementById('time');
        timeElement.textContent = formattedTime;
    }

    $(document).ready(function() {
        initApp();

        // Update the time every second
        setInterval(updateTime, 1000);

        // Initial call to display the time immediately
        updateTime();

        $('#themeSelect').select2({
            dropdownParent: $('#modalTheme')
        });

        $('#firstPicSelect').select2({
            dropdownParent: $('#firstPicModal')
        });

        $('#secondPicSelect').select2({
            dropdownParent: $('#secondPicModal')
        });

        // submit form 1
        $('#firstPicForm').on('click', function() {
            let pic = $('#firstPicSelect').val();
            $.ajax({
                type: 'get',
                url: "{{ url('dashboard/selectFirstPic') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    pic: pic
                },
                success: function(data) {
                    if (data.status == 'success') {
                        // set local storage
                        localStorage.setItem('firstPic', 'set');

                        $('#firstPicModal').modal('hide');

                        setTimeout(() => {
                            notif('success', data.message);
                        }, 500);

                        let color = data.role == 'leader' ? 'danger' : 'warning';
                        let photo = data.photo;

                        $('#firstPicContainer').html('');
                        $('#firstPicContainer').html(`
                        <div class="card shadow-md card-hover">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('uploads/doc') }}"
                                    alt="" class="rounded-circle" width="60" height="60">
                                <div>
                                    <h6 class="fw-semibold mb-0">${data.name}</h6>
                                    <span class="fs-2 d-flex align-items-center py-1"><i
                                            class="ti ti-map-pin text-dark fs-3 me-1"></i>${data.npk}</span>
                                </div>
                                <button class="btn btn-${color} py-1 px-3 ms-auto">${data.role}</button>
                            </div>
                        </div>
                        `);
                    } else {
                        notif('error', data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        notif("error", 'Connection Error');
                        return;
                    }
                    notif("error", 'Internal Server Error');
                }
            });
        });

        // submit form 2
        $('#secondPicForm').on('click', function() {
            let pic = $('#secondPicSelect').val();
            $.ajax({
                type: 'get',
                url: "{{ url('dashboard/selectSecondPic') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    pic: pic
                },
                success: function(data) {
                    if (data.status == 'success') {
                        // set local storage
                        localStorage.setItem('secondPic', 'set');

                        $('#secondPicModal').modal('hide');

                        setTimeout(() => {
                            notif('success', data.message);
                        }, 500);

                        let color = data.role == 'leader' ? 'danger' : 'warning';
                        let photo = data.photo;

                        $('#secondPicContainer').html('');
                        $('#secondPicContainer').html(`
                        <div class="card shadow-md card-hover">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <img src="../../public/uploads/doc/ . ${photo}"
                                    alt="" class="rounded-circle" width="60" height="60">
                                <div>
                                    <h6 class="fw-semibold mb-0">${data.name}</h6>
                                    <span class="fs-2 d-flex align-items-center py-1"><i
                                            class="ti ti-map-pin text-dark fs-3 me-1"></i>${data.npk}</span>
                                </div>
                                <button class="btn btn-${color} py-1 px-3 ms-auto">${data.role}</button>
                            </div>
                        </div>
                        `);
                    } else {
                        notif('error', data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        notif("error", 'Connection Error');
                        return;
                    }
                    notif("error", 'Internal Server Error');
                }
            });
        });

        // submit theme form
        $('#themeForm').on('click', function() {
            let theme = $('#themeSelect').val();
            $.ajax({
                type: 'get',
                url: "{{ url('dashboard/selectTheme') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    theme: theme
                },
                success: function(data) {
                    if (data.status == 'success') {

                        $('#modalTheme').modal('hide');

                        setTimeout(() => {
                            notif('success', data.message);
                        }, 500);

                        $('#themeContainer').html('');
                        $('#themeContainer').html(`
                            <div>
                                <h5 class="fw-semibold mb-0">Tema Safety</h5>
                                <span
                                    class="fs-2 d-flex align-items-center py-1">{{ Carbon\Carbon::now()->isoFormat('lll') }}</span>
                            </div>
                            <button id="themeModal" type="button" class="btn btn-secondary py-2 px-5 ms-auto"
                                data-bs-toggle="modal" data-bs-target="#themeModal">
                                <h4 class=" fw-bolder text-light pt-1">
                                    ${data.theme_name}
                                </h4>
                            </button>
                        `);
                    } else {
                        notif('error', data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        notif("error", 'Connection Error');
                        return;
                    }
                    notif("error", 'Internal Server Error');
                }
            });
        });

        $('#secondPic').on('click', function() {
            if (!localStorage.getItem('firstPic')) {
                notif('error', 'Tambah PIC pertama dahulu!');
                return;
            }

            $('#secondPic').attr('data-bs-target', '#secondPicModal');
        });

        $('#dc6, #dc7, #dc8, #dc1, #dc2, #dc3, #dc4, #dc5').on('click', function() {
            window.location.replace("{{ url('/line') }}");
        });
    });
</script>
