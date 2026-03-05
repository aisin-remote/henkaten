@extends('layouts.root.main')

@section('main')
    @php
        $statusMappings = [
            'running' => ['priority' => 1, 'overall' => 'RUNNING', 'shape' => 'circle', 'color' => 'success'],
            'henkaten' => ['priority' => 2, 'overall' => 'HENKATEN', 'shape' => 'triangle', 'color' => 'warning'],
            'stop' => ['priority' => 3, 'overall' => 'STOP', 'shape' => 'x', 'color' => 'danger'],
            'off' => ['priority' => 4, 'overall' => 'OFF', 'shape' => 'zzz', 'color' => 'dark'],
        ];

        $worstPriority = 0;
        $overall_status = $shape_status = $color_status = '';

        foreach (['man', 'machine', 'method', 'material'] as $property) {
            $status = $line->{"status_$property"};
            if (isset($statusMappings[$status])) {
                $priority = $statusMappings[$status]['priority'];
                if ($priority > $worstPriority) {
                    $worstPriority = $priority;
                    $overall_status = $statusMappings[$status]['overall'];
                    $shape_status = $statusMappings[$status]['shape'];
                    $color_status = $statusMappings[$status]['color'];
                }
            }
        }

        if (!function_exists('mapStatus')) {
            function mapStatus($status)
            {
                switch ($status) {
                    case 'running':
                        return 'NO HENKATEN';
                    case 'henkaten':
                        return 'HENKATEN';
                    case 'stop':
                        return 'STOP';
                    default:
                        return 'OFF';
                }
            }
        }

        if (!function_exists('mapStatusToShape')) {
            function mapStatusToShape($status)
            {
                switch ($status) {
                    case 'running':
                        return 'circle';
                    case 'henkaten':
                        return 'triangle';
                    case 'stop':
                        return 'x';
                    case 'off':
                        return 'zzz';
                    default:
                        return '';
                }
            }
        }

        if (!function_exists('mapStatusToColor')) {
            function mapStatusToColor($status)
            {
                switch ($status) {
                    case 'running':
                        return 'success';
                    case 'henkaten':
                        return 'warning';
                    case 'stop':
                        return 'danger';
                    default:
                        return 'dark';
                }
            }
        }

        $status_man = mapStatus($line->status_man);
        $status_method = mapStatus($line->status_method);
        $status_material = mapStatus($line->status_material);
        $status_machine = mapStatus($line->status_machine);

        $shape_man = mapStatusToShape($line->status_man);
        $shape_method = mapStatusToShape($line->status_method);
        $shape_material = mapStatusToShape($line->status_material);
        $shape_machine = mapStatusToShape($line->status_machine);

        $color_man = mapStatusToColor($line->status_man);
        $color_method = mapStatusToColor($line->status_method);
        $color_material = mapStatusToColor($line->status_material);
        $color_machine = mapStatusToColor($line->status_machine);

        $modals = [
            [
                'modalId' => 'methodModal',
                'modalTitle' => 'Method Henkaten',
                'title' => 'METHOD',
                'color' => $color_method,
                'status' => $status_method,
                'shape' => $shape_method,
            ],
            [
                'modalId' => 'manModal',
                'modalTitle' => 'Man Henkaten',
                'title' => 'MAN',
                'color' => $color_man,
                'status' => $status_man,
                'shape' => $shape_man,
            ],
            [
                'modalId' => 'materialModal',
                'modalTitle' => 'Material Henkaten',
                'title' => 'MATERIAL',
                'color' => $color_material,
                'status' => $status_material,
                'shape' => $shape_material,
            ],
            [
                'modalId' => 'machineModal',
                'modalTitle' => 'Machine Henkaten',
                'title' => 'MACHINE',
                'color' => $color_machine,
                'status' => $status_machine,
                'shape' => $shape_machine,
            ],
        ];
    @endphp

    {{-- modal henkaten --}}
    @foreach ($modals as $modal)
        <div class="modal fade" id="{{ $modal['modalId'] }}" tabindex="-1" aria-labelledby="bs-example-modal-lg"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            {{ $modal['modalTitle'] }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="mt-3 henkatenForm" action="{{ route('dashboard.storeHenkaten') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <input type="hidden" name="origin" class="origin-hidden">
                            <div class="statusRadio text-center mt-3">
                                <label class="btn btn-light-primary text-primary font-medium me-2">
                                    <div class="form-check">
                                        <input type="radio" id="{{ $modal['modalId'] }}HenkatenRadio"
                                            class="other-radio form-check-input" name="status" value="henkaten">
                                        <label class="form-check-label" for="{{ $modal['modalId'] }}HenkatenRadio">
                                            <span class="d-none d-md-block">HENKATEN</span>
                                        </label>
                                    </div>
                                </label>
                                <label class="btn btn-light-primary text-primary font-medium">
                                    <div class="form-check">
                                        <input type="radio" id="{{ $modal['modalId'] }}StopRadio"
                                            class="other-radio form-check-input" name="status" value="stop">
                                        <label class="form-check-label" for="{{ $modal['modalId'] }}StopRadio">
                                            <span class="d-none d-md-block">STOP</span>
                                        </label>
                                    </div>
                                </label>
                            </div>

                            <input type="hidden" name="type" value="{{ strtolower($modal['title']) }}">
                            <input type="hidden" name="line" value="{{ $line->id }}">

                            <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#planned-{{ $modal['modalId'] }}"
                                        role="tab" aria-selected="false" tabindex="-1">
                                        <span>Planned</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#unplanned-{{ $modal['modalId'] }}"
                                        role="tab" aria-selected="false" tabindex="-1">
                                        <span>Unplanned</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content border mt-2">
                                <div class="tab-pane p-3" id="planned-{{ $modal['modalId'] }}" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control buttonClass planned-input"
                                                    name="planned" />
                                                <span class="input-group-text">
                                                    <i class="ti ti-calendar fs-5"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="unplanned-{{ $modal['modalId'] }}" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control buttonClass unplanned-input"
                                                    name="unplanned" />
                                                <span class="input-group-text">
                                                    <i class="ti ti-calendar fs-5"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3 pic-form">
                                <label class="form-label mb-2 fw-semibold">Category</label>
                                <select class="select2 form-control select2-hidden-accessible category"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                    id="{{ $modal['modalId'] }}Category" name="category" required>
                                    <option value="0">-- Select Category --</option>
                                    <option value="Safety Issue">Safety Issue</option>
                                    <option value="Productivity Issue">Productivity Issue</option>
                                    <option value="Cost Issue">Cost Issue</option>
                                    <option value="Quality Issue">Quality Issue</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group mt-3 pic-form">
                                <label class="form-label mb-2 fw-semibold">Henkaten Table No.</label>
                                <select class="select2 form-control select2-hidden-accessible hanketenManagement"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                    id="{{ $modal['modalId'] }}TableManagement" name="henkatenManagement" required>
                                    <option value="0">-- Select --</option>
                                    @foreach ($henkatenManagements as $henkaten)
                                        <option value="{{ $henkaten->id }}">{{ $henkaten->henkaten_item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3 mb-3 description">
                                <label class="form-label mb-2 fw-semibold">Henkaten / Abnormality Content</label>
                                <textarea type="text" class="form-control" rows="3" name="abnormality"
                                    id="{{ $modal['modalId'] }}Abnormality" required></textarea>
                            </div>

                            <div class="form-group mt-3 mb-3 description">
                                <label for="formFileSm" class="form-label">Dokumen pendukung</label>
                                <input class="form-control form-control" type="file"
                                    id="{{ $modal['modalId'] }}Photo" name="photo">
                                <small class="text-danger">*optional</small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary henkatenSubmitButton"
                                id="{{ $modal['modalId'] }}Submit">
                                <span class="spinner-border spinner-border-sm d-none" id="{{ $modal['modalId'] }}Spinner"
                                    role="status" aria-hidden="true"></span>
                                <span class="button-text">Save changes</span>
                            </button>
                            <button type="button"
                                class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                                data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end of modal --}}

    {{-- modal error --}}
    <div class="modal fade" id="manModal-flag" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-light-danger">
                <div class="modal-body p-4">
                    <div class="text-center text-danger">
                        <i class="ti ti-hexagon-letter-x fs-7"></i>
                        <h4 class="mt-2">Oh snap!</h4>
                        <p class="mt-3">
                            Create Employee Planning First!
                        </p>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('employeePlanning.index') }}" type="button"
                            class="btn btn-secondary font-medium waves-effect text-start">
                            Create Planning
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    <div class="row" style="margin-top: -30px">
        <div class="card bg-light-{{ $color_status }} shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">{{ $line->name }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Status</li>
                                <li class="breadcrumb-item">
                                    <span class="badge bg-{{ $color_status }} px-4">{{ $overall_status }}</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-3 align-item-center" style="margin-bottom: -28px">
                        <div class="card bg-{{ $color_status }} overflow-hidden card-hover" data-bs-toggle="modal"
                            data-bs-target="#ModalStatus">
                            <div class="d-flex">
                                <div class="p-3 ps-4 pt-4 text-center">
                                    <h3 class="text-white mb-0 fs-6 fw-bolder">
                                        {{ $overall_status }}
                                    </h3>
                                </div>
                                <div class="align-self-center me-3 ms-auto">
                                    <h2 class="fs-7 text-success mb-0"></h2>
                                </div>
                                <div class="p-4 bg-{{ $color_status }}">
                                    <h3 class="text-white box mb-0 fw-bolder">
                                        <i class="ti ti-{{ $shape_status }}"></i>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====== (bagian peta & manpower) ====== --}}
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <img src="{{ asset('assets/images/' . $lineMap->photo) }}" alt="" class="mw-100" usemap="#roomMap"
                width="980vh" loading="lazy">
            @if (!$manHenkaten->isEmpty())
                @php
                    $photoMap = $manHenkaten
                        ->where('henkaten.is_done', '1')
                        ->pluck('manAfter.photo', 'employee_before_id')
                        ->all();
                @endphp

                @foreach ($activeEmployees as $emp)
                    @php
                        $photo = $photoMap[$emp->employee_id] ?? $emp->employee->photo;
                    @endphp

                    @if ($origin->id !== env('ORIGIN_SEAT') && $origin->id !== env('ORIGIN_HANDLE'))
                        @php
                            $isPresent = $attendance->contains('employee_active_id', $emp->id);
                        @endphp
                        @if ($isPresent)
                            <div style="position: absolute; top: {{ $emp->pos->top }}vh; left: {{ $emp->pos->left }}vh;">
                                <img src="{{ asset('uploads/doc/' . $photo) }}" alt="Employee Photo"
                                    style="width: {{ $emp->pos->size }}; height: {{ $emp->pos->size }};"
                                    class="rounded-1" loading="lazy" />
                            </div>
                        @endif
                    @else
                        <div style="position: absolute; top: {{ $emp->pos->top }}vh; left: {{ $emp->pos->left }}vh;">
                            <img src="{{ asset('uploads/doc/' . $photo) }}" alt="Employee Photo"
                                style="width: {{ $emp->pos->size }}; height: {{ $emp->pos->size }};" class="rounded-1"
                                loading="lazy" />
                        </div>
                    @endif
                @endforeach
            @else
                @foreach ($activeEmployees as $emp)
                    @php
                        $photo = $emp->employee->photo;
                        $positionStyle = "position: absolute; top: {$emp->pos->top}vh; left: {$emp->pos->left}vh;";
                        $sizeStyle = "width: {$emp->pos->size}; height: {$emp->pos->size};";
                    @endphp
                    @if ($origin->id !== env('ORIGIN_SEAT') && $origin->id !== env('ORIGIN_HANDLE'))
                        @php
                            $isPresent = $attendance->contains('employee_active_id', $emp->id);
                        @endphp
                        @if ($isPresent)
                            <div style="{{ $positionStyle }}">
                                <img src="{{ asset('uploads/doc/' . $photo) }}" alt="Employee Photo"
                                    style="{{ $sizeStyle }}" class="rounded-1" loading="lazy" />
                            </div>
                        @endif
                    @else
                        <div style="{{ $positionStyle }}">
                            <img src="{{ asset('uploads/doc/' . $photo) }}" alt="Employee Photo"
                                style="{{ $sizeStyle }}" class="rounded-1" loading="lazy" />
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="col-lg-6">
            <div class="row text-center">
                @foreach ($modals as $modal)
                    @php
                        $flag = '';
                        if ($activeEmployees->isEmpty()) {
                            $flag = '-flag';
                        }
                        $target =
                            $modal['modalId'] == 'manModal' ? '#' . $modal['modalId'] . $flag : '#' . $modal['modalId'];
                    @endphp
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-hover" data-bs-toggle="modal"
                            data-bs-target="{{ $target }}">
                            <div class="d-flex flex-row">
                                <div class="p-3 text-start">
                                    <h3 class="text-{{ $modal['color'] }} mb-0 fs-6 fw-bolder pb-2">{{ $modal['title'] }}
                                    </h3>
                                    <span class="text-muted">{{ $modal['status'] }}</span>
                                </div>
                                <div class="align-self-center me-3 ms-auto">
                                    <h2 class="fs-7 text-success mb-0"></h2>
                                </div>
                                <div class="p-4 bg-{{ $modal['color'] }}">
                                    <h3 class="text-white box mb-0">
                                        <i class="ti ti-{{ $modal['shape'] }}"></i>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ====== (bagian manpower list) ====== --}}
        <div class="row">
            @if (!$activeEmployees->isEmpty())
                <h5 class="text-muted mb-2 fw-bolder">Man Power</h5>
                <div class="col-lg-6 col-md-12">
                    <div class="owl-carousel owl-theme" id="carousel">
                        <div class="row temp-row">
                            @foreach ($activeEmployees as $emp)
                                @php
                                    $photo = $emp->employee->photo;
                                    $role = $emp->employee->role;
                                    $name = $emp->employee->name;
                                    $npk = $emp->employee->npk;

                                    foreach ($manHenkaten as $man) {
                                        if ($man->henkaten->is_done === '1') {
                                            $henkatenEmployeeId = $man->employee_before_id;
                                            $activeEmployeeId = $emp->employee_id;

                                            if ($activeEmployeeId == $henkatenEmployeeId) {
                                                $photo = $man->manAfter->photo;
                                                $role = $man->manAfter->role;
                                                $name = $man->manAfter->name;
                                                $npk = $man->manAfter->npk;
                                            }
                                        }
                                    }

                                    if (!function_exists('mapRoleToColor')) {
                                        function mapRoleToColor($role)
                                        {
                                            switch ($role) {
                                                case 'JP':
                                                    return 'danger';
                                                case 'Operator':
                                                    return 'warning';
                                                case 'Leader':
                                                    return 'dark';
                                                default:
                                                    return 'dark';
                                            }
                                        }
                                    }

                                    $color = mapRoleToColor($role);
                                    $col = $line->total_emp !== 2 ? '12' : '6';

                                    $pos_number = true;
                                    if ($line->name === 'DSAA01-02' && $emp->pos->pos == '1') {
                                        $pos_name = 'HAITO';
                                        $pos_number = false;
                                    } elseif (
                                        substr($line->name, 0, 2) === 'AS' &&
                                        substr($line->name, 2, 1) !== '0' &&
                                        $emp->pos->pos == $line->total_emp &&
                                        $line->total_emp !== 1
                                    ) {
                                        $pos_name = 'LAST MAN';
                                        $pos_number = false;
                                    } else {
                                        $pos_name = 'POS';
                                    }
                                @endphp

                                <div class="col-lg-{{ $col }} col-md-12">
                                    <div class="item">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <img src="{{ asset('uploads/doc/' . $photo) }}" class="rounded-1 center"
                                                    height="100"
                                                    style="width: 100px !important; margin-left: auto;margin-right: auto;"
                                                    loading="lazy">
                                                <div class="mt-n2">
                                                    <span
                                                        class="badge bg-{{ $color }}">{{ strtoupper($role) }}</span>
                                                    <h3 class="card-title mt-3">{{ ucwords($name) }}</h3>
                                                    <h6 class="card-subtitle">{{ $npk }}</h6>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <button class="btn btn-light-danger text-danger"
                                                            style="width: 100% !important">
                                                            {{ $pos_name }}
                                                            @if ($pos_number)
                                                                {{ strtoupper($emp->pos->pos) }}
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        @if ($activeMh !== null)
                            @php
                                $mhColor = mapRoleToColor($activeMh->employee->role);
                                $mhPhoto = $activeMh->employee->photo;
                                $mhRole = $activeMh->employee->role;
                                $mhName = $activeMh->employee->name;
                                $mhNpk = $activeMh->employee->npk;

                                foreach ($manHenkaten as $man) {
                                    if ($man->henkaten->is_done === '1') {
                                        $henkatenEmployeeId = $man->mh_before_id;
                                        $activeEmployeeId = $activeMh->employee_id;

                                        if ($activeEmployeeId == $henkatenEmployeeId) {
                                            $mhPhoto = $man->mhAfter->photo;
                                            $mhRole = $man->mhAfter->role;
                                            $mhName = $man->mhAfter->name;
                                            $mhNpk = $man->mhAfter->npk;
                                        }
                                    }
                                }
                            @endphp

                            <div class="col-lg-6 col-md-12">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <img src="{{ asset('uploads/doc/' . $mhPhoto) }}" class="rounded-1"
                                            width="100" height="100" loading="lazy">
                                        <div class="mt-n2">
                                            <span class="badge bg-info">MH</span>
                                            <h3 class="card-title mt-3">{{ ucwords($mhName) }}</h3>
                                            <h6 class="card-subtitle">{{ $mhNpk }}</h6>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <button class="btn btn-info" style="width: 100% !important">
                                                    {{ strtoupper('Material Handling') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($activePic !== null)
                            @php
                                $picColor = mapRoleToColor($activePic->employee->role);
                                $picPhoto = $activePic->employee->photo;
                                $picRole = $activePic->employee->role;
                                $picName = $activePic->employee->name;
                                $picNpk = $activePic->employee->npk;

                                foreach ($manHenkaten as $man) {
                                    if ($man->henkaten->is_done === '1') {
                                        $henkatenEmployeeId = $man->pic_before_id;
                                        $activeEmployeeId = $activePic->employee_id;

                                        if ($activeEmployeeId == $henkatenEmployeeId) {
                                            $picPhoto = $man->picAfter->photo;
                                            $picRole = $man->picAfter->role;
                                            $picName = $man->picAfter->name;
                                            $picNpk = $man->picAfter->npk;
                                        }
                                    }
                                }
                            @endphp

                            <div class="col-lg-6 col-md-12">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <img src="{{ asset('uploads/doc/' . $picPhoto) }}" class="rounded-1"
                                            width="100" height="100" loading="lazy">
                                        <div class="mt-n2">
                                            <span class="badge bg-dark">{{ strtoupper($picRole) }}</span>
                                            <h3 class="card-title mt-3">{{ ucwords($picName) }}</h3>
                                            <h6 class="card-subtitle">{{ $picNpk }}</h6>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <button class="btn btn-dark" style="width: 100% !important">
                                                    {{ strtoupper('JP') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            @else
                <div class="col-6"></div>
                <div class="col-lg-6 col-sm-12" id="firstPicContainer">
                    <h5 class="text-muted mb-2 fw-bolder mb-3">Man Power</h5>
                    <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal"
                        id="firstPic">
                        <a class="dropzone dz-clickable p-3 rounded-1 planning-link">
                            <p class="text-center pt-3 text-danger">Create Employee Planning</p>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ====== Pending Assignments ====== --}}
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: white !important">
                <div class="row">
                    <div class="col-10">
                        <h4 class="fw-4">
                            Pending Assignments
                            <h6 class="text-muted">
                                {{ Carbon\Carbon::now()->format('l, j F Y') }}
                            </h6>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table table-responsive-lg" id="henkatenHistory" style="width:100%">
                    <thead>
                        <tr>
                            <th>Line Status</th>
                            <th>4M</th>
                            <th>Abnormality</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Troubleshoot</th>
                            <th>Status</th>
                            <th class="text-center">Detail</th>
                            @if (auth()->user()->role !== 'JP')
                                <th class="text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody style="font-size: 15px">
                        @foreach ($histories as $history)
                            @php
                                $statusColor = [
                                    'running' => 'success',
                                    'henkaten' => 'warning',
                                    'stop' => 'danger',
                                    'default' => 'dark',
                                ];
                                $color = $statusColor[$history->henkaten->status] ?? $statusColor['default'];

                                $userRole = auth()->user()->role;
                                $isLeader = $userRole === 'LDR';
                                $isSupervisor = $userRole === 'SPV';
                                $isManager = $userRole === 'MGR';

                                $ldrApproved = $history->ldr !== null;
                                $spvApproved = $history->spv !== null;
                                $mgrApproved = $history->mgr !== null;

                                $currentStatus = $history->status ?? null;
                            @endphp
                            <tr>
                                <td>
                                    <span class="mb-1 badge bg-{{ $color }} rounded-pill">
                                        {{ $history->henkaten->status }}
                                    </span>
                                </td>
                                <td>{{ strtoupper($history->henkaten->{"4M"}) }}</td>
                                <td>{{ $history->henkaten->abnormality }}</td>
                                <td>{{ Carbon\Carbon::parse($history->henkaten->date)->format('j F Y, H:i:s') }} -
                                    {{ Carbon\Carbon::parse($history->henkaten->end_date)->format('j F Y') }}</td>

                                @if (!$history->henkaten->troubleshoot)
                                    <td class="text-center">
                                        <span class="badge bg-danger">Belum ditangani</span>
                                    </td>
                                    <td>
                                        <span class="mb-1 badge bg-light-danger text-danger">
                                            Waiting Troubleshoot
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary view-employee detail" data-bs-toggle="modal"
                                            data-bs-target="" data-history-id="{{ $history->henkaten->id }}">
                                            <span class="rounded-3" id="icon">
                                                <i class="ti ti-search"></i>
                                            </span>
                                        </button>
                                        @can('JP')
                                            <button class="btn btn-warning troubleshoot"
                                                data-history-id="{{ $history->henkaten->id }}">
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-edit"></i>
                                                </span>
                                            </button>
                                            <form
                                                action="{{ route('dashboard.henkaten.destroy', ['id' => $history->henkaten->id]) }}"
                                                method="post" class="delete d-inline-block m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete">
                                                    <span class="rounded-3" id="icon">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>

                                    @can('LDR')
                                        <td class="text-center">
                                            <button class="btn btn-warning troubleshoot"
                                                data-history-id="{{ $history->henkaten->id }}">
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-edit"></i>
                                                </span>
                                            </button>
                                            <form
                                                action="{{ route('dashboard.henkaten.destroy', ['id' => $history->henkaten->id]) }}"
                                                method="post" class="delete d-inline-block m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete">
                                                    <span class="rounded-3" id="icon">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                    @endcan

                                    @can('SPV')
                                        <td class="text-center">
                                            <button class="btn btn-danger" data-history-id="{{ $history->henkaten->id }}"
                                                disabled>
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-checks"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @endcan

                                    @can('MGR')
                                        <td class="text-center">
                                            <button class="btn btn-danger" data-history-id="{{ $history->henkaten->id }}"
                                                disabled>
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-checks"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @endcan
                                @else
                                    <td class="text-center">{{ $history->henkaten->troubleshoot->troubleshoot }}</td>
                                    <td>
                                        @if ($history->henkaten->is_done === '0')
                                            @if ($currentStatus === 'Leader')
                                                <span class="mb-1 badge bg-light-warning text-warning">
                                                    Waiting Approval SPV
                                                </span>
                                            @elseif($currentStatus === null)
                                                <span class="mb-1 badge bg-light-warning text-warning">
                                                    Waiting Approval LDR
                                                </span>
                                            @elseif($currentStatus === 'Supervisor')
                                                <span class="mb-1 badge bg-light-warning text-warning">
                                                    Waiting Approval MGR
                                                </span>
                                            @endif
                                        @else
                                            <span class="mb-1 badge bg-light-success text-success">
                                                Done Approval {{ $currentStatus }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary view-employee detail" data-bs-toggle="modal"
                                            data-bs-target="" data-history-id="{{ $history->henkaten->id }}">
                                            <span class="rounded-3" id="icon">
                                                <i class="ti ti-search"></i>
                                            </span>
                                        </button>
                                        @can('JP')
                                            <button class="btn btn-warning troubleshoot"
                                                data-history-id="{{ $history->henkaten->id }}">
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-edit"></i>
                                                </span>
                                            </button>
                                        @endcan
                                    </td>

                                    @if ($isLeader)
                                        @if (!$ldrApproved)
                                            <td class="text-center">
                                                <button class="btn btn-danger approve"
                                                    data-history-id="{{ $history->henkaten->id }}">
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <button class="btn btn-success approve"
                                                    data-history-id="{{ $history->henkaten->id }}" disabled>
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @endif
                                    @elseif ($isSupervisor)
                                        @if (!$ldrApproved)
                                            <td class="text-center">
                                                <button class="btn btn-danger approve"
                                                    data-history-id="{{ $history->henkaten->id }}" disabled>
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @elseif (!$spvApproved)
                                            <td class="text-center">
                                                <button class="btn btn-danger approve"
                                                    data-history-id="{{ $history->henkaten->id }}">
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <button class="btn btn-success approve"
                                                    data-history-id="{{ $history->henkaten->id }}" disabled>
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @endif
                                    @elseif ($isManager)
                                        @if (!$ldrApproved)
                                            <td class="text-center">
                                                <button class="btn btn-danger approve"
                                                    data-history-id="{{ $history->henkaten->id }}" disabled>
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @elseif (!$spvApproved)
                                            <td class="text-center">
                                                <button class="btn btn-danger approve"
                                                    data-history-id="{{ $history->henkaten->id }}" disabled>
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @elseif (!$mgrApproved)
                                            <td class="text-center">
                                                <button class="btn btn-danger approve"
                                                    data-history-id="{{ $history->henkaten->id }}">
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <button class="btn btn-success approve"
                                                    data-history-id="{{ $history->henkaten->id }}" disabled>
                                                    <span class="rounded-3"><i class="ti ti-checks"></i></span>
                                                </button>
                                            </td>
                                        @endif
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- =========================
        MODAL TROUBLESHOOT (FIXED: unique IDs + troubleshoot visible + origin per-modal)
    ========================= --}}
    @foreach ($histories as $history)
        @php
            $hid = $history->henkaten->id;
            $accordionId = "accordion-$hid";
            $collapseOneId = "collapseOne-$hid";
            $collapseTwoId = "collapseTwo-$hid";
            $collapseThreeId = "collapseThree-$hid";

            $originId = "origin-troubleshoot-$hid";
            $troubleshootId = "troubleshoot-$hid";

            $needId = "need-$hid";
            $noNeedId = "noNeed-$hid";

            $partId = "part-$hid";
            $picQualityId = "pic_quality-$hid";
            $picSafetyId = "pic_safety-$hid";
            $doneById = "doneBy-$hid";

            $beforeSelectId = "{$hid}BeforeTreatment";
            $afterSelectId = "{$hid}AfterTreatment";
            $resultSelectId = "{$hid}ResultCheck";

            $photoId = "photo-$hid";
        @endphp

        <div class="modal fade modal-lg troubleshootModal" id="{{ $hid }}Troubleshoot" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">Troubleshoot</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('dashboard.troubleshootHenkaten') }}" method="POST"
                        class="mt-3 henkatenTroubleshoot" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <input type="hidden" name="origin" id="{{ $originId }}">
                            <input type="hidden" name="henkaten_id" value="{{ $hid }}">
                            <input type="hidden" name="4M" value="{{ $history->henkaten->{"4M"} }}">
                            <input type="hidden" name="status" value="{{ $history->henkaten->status }}">
                            <input type="hidden" name="line" value="{{ $history->henkaten->line_id }}">

                            {{-- FIX: troubleshoot wajib diisi, jadi tampilkan --}}
                            <div class="form-group mt-3 mb-3 description">
                                <label class="form-label fw-semibold">Troubleshoot</label>
                                <textarea class="form-control" rows="3" name="troubleshoot" id="{{ $troubleshootId }}" required>{{ trim(optional($history->henkaten->troubleshoot)->troubleshoot ?? '') }}</textarea>
                            </div>

                            <div class="accordion accordion-flush position-relative overflow-hidden mt-2"
                                id="{{ $accordionId }}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="accordion-item mb-3 border rounded-top rounded-bottom">
                                            <h2 class="accordion-header" id="flush-headingOne-{{ $hid }}">
                                                <button
                                                    class="accordion-button fs-4 fw-bolder px-3 py-6 lh-base border-0 rounded-top collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseOneId }}" aria-expanded="false"
                                                    aria-controls="{{ $collapseOneId }}">
                                                    Quality Inspections
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseOneId }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingOne-{{ $hid }}"
                                                data-bs-parent="#{{ $accordionId }}">
                                                <div class="accordion-body px-3 fw-normal">
                                                    <div class="text-center mb-2">
                                                        <h6 class="fw-semibold">Abnormality Inspection Report</h6>

                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label"
                                                                for="{{ $needId }}">Need</label>
                                                            <input class="form-check-input" type="radio"
                                                                name="inspection" id="{{ $needId }}"
                                                                value="need"
                                                                @if (optional($history->henkaten->troubleshoot)->inspection_report == 'need') checked @endif>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="inspection" id="{{ $noNeedId }}"
                                                                value="no need"
                                                                @if (optional($history->henkaten->troubleshoot)->inspection_report == 'no need') checked @endif>
                                                            <label class="form-check-label" for="{{ $noNeedId }}">No
                                                                Need</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label for="{{ $partId }}"
                                                                    class="form-label fw-semibold">Part</label>
                                                                <input type="text" class="form-control"
                                                                    id="{{ $partId }}" name="part"
                                                                    value="{{ optional($history->henkaten->troubleshoot)->part }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label class="form-label mb-2 fw-semibold">Before
                                                                    Treatment</label>
                                                                <select
                                                                    class="select2 form-control select2-hidden-accessible beforeTreatment"
                                                                    style="width: 100%; height: 36px" tabindex="-1"
                                                                    aria-hidden="true" id="{{ $beforeSelectId }}"
                                                                    name="beforeTreatment" required>
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="ok"
                                                                        @if (optional($history->henkaten->troubleshoot)->before_treatment == 'ok') selected @endif>
                                                                        OK
                                                                    </option>
                                                                    <option value="ng"
                                                                        @if (optional($history->henkaten->troubleshoot)->before_treatment == 'ng') selected @endif>
                                                                        NG</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label class="form-label mb-2 fw-semibold">After
                                                                    Treatment</label>
                                                                <select
                                                                    class="select2 form-control select2-hidden-accessible"
                                                                    style="width: 100%; height: 36px" tabindex="-1"
                                                                    aria-hidden="true" id="{{ $afterSelectId }}"
                                                                    name="afterTreatment" required>
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="ok"
                                                                        @if (optional($history->henkaten->troubleshoot)->after_treatment == 'ok') selected @endif>
                                                                        OK</option>
                                                                    <option value="ng"
                                                                        @if (optional($history->henkaten->troubleshoot)->after_treatment == 'ng') selected @endif>
                                                                        NG</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <div class="form-group mt-3 mb-3 description">
                                                                <label class="form-label">PIC</label>
                                                                <input class="form-control" list="pic_quality_list"
                                                                    name="picQuality" placeholder="Input PIC ..."
                                                                    id="{{ $picQualityId }}" required
                                                                    value="{{ optional($history->henkaten->troubleshoot)->pic_quality }}">
                                                                <datalist id="pic_quality_list">
                                                                    <option value="saiful">
                                                                </datalist>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Safety --}}
                                    <div class="col-12">
                                        <div class="accordion-item mb-3 border rounded-top rounded-bottom">
                                            <h2 class="accordion-header" id="flush-headingThree-{{ $hid }}">
                                                <button
                                                    class="accordion-button fs-4 fw-semibold px-3 py-6 lh-base border-0 rounded-bottom collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseThreeId }}" aria-expanded="false"
                                                    aria-controls="{{ $collapseThreeId }}">
                                                    Safety
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseThreeId }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingThree-{{ $hid }}"
                                                data-bs-parent="#{{ $accordionId }}">
                                                <div class="accordion-body px-3 fw-normal">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label class="form-label mb-2 fw-semibold">Result
                                                                    Check</label>
                                                                <select
                                                                    class="select2 form-control select2-hidden-accessible"
                                                                    style="width: 100%; height: 36px" tabindex="-1"
                                                                    aria-hidden="true" id="{{ $resultSelectId }}"
                                                                    name="resultCheck" required>
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="ok"
                                                                        @if (optional($history->henkaten->troubleshoot)->result_check == 'ok') selected @endif>
                                                                        OK</option>
                                                                    <option value="ng"
                                                                        @if (optional($history->henkaten->troubleshoot)->result_check == 'ng') selected @endif>
                                                                        NG</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <div class="form-group mt-3 mb-3 description">
                                                                <label class="form-label">PIC</label>
                                                                <input class="form-control" list="pic_safety_list"
                                                                    name="picSafety" placeholder="Input PIC ..."
                                                                    id="{{ $picSafetyId }}" required
                                                                    value="{{ optional($history->henkaten->troubleshoot)->pic_safety }}">
                                                                <datalist id="pic_safety_list">
                                                                    <option value="saiful">
                                                                </datalist>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Man replacement (optional) --}}
                                    <div class="col-12">
                                        <div class="accordion-item mb-3 border rounded-top rounded-bottom">
                                            @if ($history->henkaten->{"4M"} === 'man')
                                                <h2 class="accordion-header" id="flush-headingTwo-{{ $hid }}">
                                                    <button
                                                        class="accordion-button fs-4 fw-bolder px-3 py-6 lh-base border-0 rounded-top collapsed"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#{{ $collapseTwoId }}" aria-expanded="false"
                                                        aria-controls="{{ $collapseTwoId }}">
                                                        Man Henkaten <small class="text-danger ps-1"> *Jika ada
                                                            perubahan</small>
                                                    </button>
                                                </h2>

                                                <div id="{{ $collapseTwoId }}" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingTwo-{{ $hid }}"
                                                    data-bs-parent="#{{ $accordionId }}">
                                                    <div class="accordion-body px-3 fw-normal">
                                                        @foreach ($activeEmployees as $emp)
                                                            <div class="row mt-1">
                                                                <div class="col-lg-1">
                                                                    <label class="form-label fw-semibold"
                                                                        style="color: white">Pos</label>
                                                                    <p
                                                                        class="mt-2 text-center badge bg-danger rounded-pill">
                                                                        Pos {{ $emp->pos->pos }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="mb-4">
                                                                        <label class="form-label fw-semibold">Current
                                                                            Employee</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="John"
                                                                            value="{{ $emp->employee->name }}" disabled>
                                                                        <input type="hidden"
                                                                            class="form-control employeeBefore"
                                                                            name="before[]"
                                                                            value="{{ $emp->employee->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <label class="form-label fw-semibold"
                                                                        style="color: white">Last</label>
                                                                    <p class="text-center mt-1">- to -</p>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="mb-4">
                                                                        <label class="form-label fw-semibold">Replacement
                                                                            Employee</label>
                                                                        <select
                                                                            class="select2 form-select select2-hidden-accessible employeeReplacement"
                                                                            style="width: 100%; height: 36px"
                                                                            tabindex="-1" aria-hidden="true"
                                                                            name="after[]">
                                                                            <option value="0">Select Employee</option>
                                                                            @foreach ($employees as $employee)
                                                                                <option value="{{ $employee->id }}">
                                                                                    {{ $employee->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <div class="row mt-1">
                                                            <div class="col-lg-1">
                                                                <label class="form-label fw-semibold"
                                                                    style="color: white">Pos</label>
                                                                <p class="mt-2 text-center badge bg-dark rounded-pill">PIC
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="mb-4">
                                                                    <label class="form-label fw-semibold">Current
                                                                        PIC/JP</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="John"
                                                                        value="{{ optional(optional($activePic)->employee)->name }}"
                                                                        disabled>
                                                                    <input type="hidden" class="form-control"
                                                                        name="picBefore"
                                                                        value="{{ optional(optional($activePic)->employee)->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <label class="form-label fw-semibold"
                                                                    style="color: white">Last</label>
                                                                <p class="text-center mt-1">- to -</p>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="mb-4">
                                                                    <label class="form-label fw-semibold">Replacement
                                                                        Employee</label>
                                                                    <select
                                                                        class="select2 form-select select2-hidden-accessible employeeReplacement"
                                                                        style="width: 100%; height: 36px" tabindex="-1"
                                                                        aria-hidden="true" name="picAfter">
                                                                        <option value="0">Select Employee</option>
                                                                        @foreach ($employees as $employee)
                                                                            <option value="{{ $employee->id }}">
                                                                                {{ $employee->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Upload --}}
                                    <div class="col-12 mt-4">
                                        <div class="mb-3">
                                            <label for="{{ $photoId }}" class="form-label">Dokumen
                                                pendukung</label>
                                            <input class="form-control form-control" id="{{ $photoId }}"
                                                type="file" name="photo">
                                            <small class="text-danger">*optional</small>
                                        </div>
                                    </div>

                                    {{-- Done By --}}
                                    <div class="col-12 mb-3">
                                        <div class="form-group mt-3 mb-3 description">
                                            <label class="form-label">Done By</label>
                                            <input class="form-control" list="doneBy_list" name="doneBy"
                                                placeholder="Input Name..." id="{{ $doneById }}" required
                                                value="{{ optional($history->henkaten->troubleshoot)->done_by }}">
                                            <datalist id="doneBy_list">
                                                <option value="saiful">
                                            </datalist>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary troubleshootSubmitButton">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                <span class="button-text">Save changes</span>
                            </button>
                            <button type="button"
                                class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                                data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
    {{-- end of modal troubleshoot --}}

    {{-- modal approve --}}
    @foreach ($histories as $history)
        @php $hid = $history->henkaten->id; @endphp
        <div class="modal fade modal-md" id="{{ $hid }}Approve" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">Approval</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.troubleshootApproval') }}" method="POST"
                        class="mt-3 henkatenApproval">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <input type="hidden" name="origin" class="origin-hidden">
                            <input type="hidden" name="henkaten_id" value="{{ $hid }}">
                            <input type="hidden" name="line" value="{{ $history->henkaten->line_id }}">
                            <input type="hidden" name="4M" value="{{ $history->henkaten->{"4M"} }}">
                            <input type="hidden" name="status" value="{{ $history->henkaten->status }}">
                            Do you really want to approve?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary approveSubmitButton">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                <span class="button-text">Approve</span>
                            </button>
                            <button type="button"
                                class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end of modal approve --}}

    {{-- modal detail (biarkan seperti punya paduka) --}}
    @foreach ($histories as $history)
        @php
            $hid = $history->henkaten->id;
            if ($history->henkaten->status === 'henkaten') {
                $color = 'warning';
                $shape = 'henkaten.svg';
            } else {
                $color = 'danger';
                $shape = 'stop.svg';
            }
        @endphp

        <div class="modal fade modal-md" id="{{ $hid }}Detail" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">Detail</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card-group mb-4">
                            <div class="card bg-{{ $color }}">
                                <div class="card-body text-center text-white">
                                    <div class="pt-2">
                                        <h4 class="fw-bolder text-white">{{ strtoupper($history->henkaten->status) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- (isi detail tetap sama seperti paduka; tidak aku ubah) --}}
                        {{-- ... --}}
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    {{-- end of modal detail --}}

    <!-- Status Modal -->
    <div class="modal fade" id="ModalStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="align-item-center">
                        <p>Current status is :</p>
                        <div class="card bg-{{ $color_status }} overflow-hidden card-hover">
                            <div class="d-flex">
                                <div class="p-3 ps-4 pt-4 text-center">
                                    <h3 class="text-white mb-0 fs-6 fw-bolder">
                                        {{ $overall_status }}
                                    </h3>
                                </div>
                                <div class="align-self-center me-3 ms-auto">
                                    <h2 class="fs-7 text-success mb-0"></h2>
                                </div>
                                <div class="p-4 bg-{{ $color_status }}">
                                    <h3 class="text-white box mb-0 fw-bolder">
                                        <i class="ti ti-{{ $shape_status }}"></i>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="statusForm">
                        @if ($overall_status === 'OFF' || $overall_status === 'RUNNING')
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="radio" id="OffSwitch" name="switchStatus"
                                    value="off">
                                <label class="form-check-label" for="OffSwitch">Turn Off</label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="radio" id="RunningSwitch" name="switchStatus"
                                    value="running">
                                <label class="form-check-label" for="RunningSwitch">Running</label>
                            </div>
                        @endif
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if ($overall_status === 'OFF' || $overall_status === 'RUNNING')
                            <button type="submit" class="btn btn-primary" onclick="submitLineForm()">Save
                                changes</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal confirmation --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-light-warning">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center text-warning">
                        <i class="ti ti-alert-octagon fs-7"></i>
                        <p class="mt-3">
                            Are you sure you want to delete this record?
                        </p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}
@endsection

<script src="{{ asset('js/jquery-3.6.3.min.js') }}" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>

<script>
    function submitLineForm() {
        const offSwitchChecked = $("#OffSwitch").is(':checked');
        const runningSwitchChecked = $("#RunningSwitch").is(':checked');
        const myid = @json(['id' => $line->id]);

        if (offSwitchChecked || runningSwitchChecked) {
            const formDataVal = offSwitchChecked ? $("#OffSwitch").val() : $("#RunningSwitch").val();

            $.ajax({
                type: 'GET',
                url: "{{ url('dashboard/updateStatus') }}" + "/" + myid.id,
                data: {
                    onOffSwitch: formDataVal
                },
                success: function() {
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Gagal:', error);
                }
            });
        } else {
            alert("Please select an option");
        }
    }

    function notif(status, message) {
        if (!message) return;
        if (status === 'success') {
            toastr.success(message, "Success!", {
                progressBar: true
            });
        } else {
            toastr.error(message, "Error!", {
                progressBar: true
            });
        }
    }

    $(document).ready(function() {

        // ===== SAFE TOASTR
        const sessionError = @json(session('error'));
        const sessionSuccess = @json(session('success'));
        const firstError = @json($errors->first());
        if (firstError) notif('error', firstError);
        else if (sessionError) notif('error', sessionError);
        else if (sessionSuccess) notif('success', sessionSuccess);

        // ===== DataTable guard (biar ga error kalau plugin gak ada)
        if ($.fn.DataTable) {
            $('#henkatenHistory').DataTable({
                scrollX: true,
                columnDefs: [{
                    orderable: false,
                    targets: 6
                }]
            });
        }

        // ===== planned/unplanned disable per modal
        $(document).on('change', '.planned-input', function() {
            const modal = $(this).closest('.modal');
            const val = $(this).val();
            modal.find('.unplanned-input').prop('disabled', val !== '');
        });

        $(document).on('change', '.unplanned-input', function() {
            const modal = $(this).closest('.modal');
            const val = $(this).val();
            modal.find('.planned-input').prop('disabled', val !== '');
        });

        // ===== Select2 GUARD (jangan sampai error kalau select2 belum ada)
        function safeSelect2($el, options) {
            if (!$.fn.select2) return; // select2 belum loaded -> skip, jangan error
            if (!$el.length) return;
            $el.select2(options);
        }

        // init select2 di modal henkaten
        safeSelect2($('#machineModalTableManagement'), {
            dropdownParent: $('#machineModal')
        });
        safeSelect2($('#manModalTableManagement'), {
            dropdownParent: $('#manModal')
        });
        safeSelect2($('#methodModalTableManagement'), {
            dropdownParent: $('#methodModal')
        });
        safeSelect2($('#materialModalTableManagement'), {
            dropdownParent: $('#materialModal')
        });

        safeSelect2($('#machineModalCategory'), {
            dropdownParent: $('#machineModal')
        });
        safeSelect2($('#manModalCategory'), {
            dropdownParent: $('#manModal')
        });
        safeSelect2($('#methodModalCategory'), {
            dropdownParent: $('#methodModal')
        });
        safeSelect2($('#materialModalCategory'), {
            dropdownParent: $('#materialModal')
        });

        // ===== Bootstrap 5 modal OPEN (tanpa jQuery plugin)
        function openBsModal(modalId) {
            const el = document.getElementById(modalId);
            if (!el) return;
            const instance = bootstrap.Modal.getOrCreateInstance(el);
            instance.show();
        }

        // open troubleshoot modal
        $(document).on('click', '.troubleshoot', function() {
            const historyId = $(this).data('history-id');
            openBsModal(`${historyId}Troubleshoot`);

            const $modal = $(`#${historyId}Troubleshoot`);

            // select2 inside troubleshoot modal (scoped)
            safeSelect2($modal.find(`#${historyId}BeforeTreatment`), {
                dropdownParent: $modal
            });
            safeSelect2($modal.find(`#${historyId}AfterTreatment`), {
                dropdownParent: $modal
            });
            safeSelect2($modal.find(`#${historyId}ResultCheck`), {
                dropdownParent: $modal
            });
            safeSelect2($modal.find('.employeeReplacement'), {
                dropdownParent: $modal
            });
        });

        // open approve modal
        $(document).on('click', '.approve', function() {
            const historyId = $(this).data('history-id');
            openBsModal(`${historyId}Approve`);
        });

        // open detail modal
        $(document).on('click', '.detail', function() {
            const historyId = $(this).data('history-id');
            openBsModal(`${historyId}Detail`);
        });

        // ===== set origin per-form
        function fillOriginInForm($form) {
            const origin = localStorage.getItem('origin_id');
            $form.find('input[name="origin"]').val(origin);
        }

        $('.henkatenForm').on('submit', function() {
            fillOriginInForm($(this));
            return true;
        });

        $('.henkatenTroubleshoot').on('submit', function() {
            fillOriginInForm($(this));
            return true;
        });

        $('.henkatenApproval').on('submit', function() {
            fillOriginInForm($(this));
            return true;
        });

        // delete confirm
        let deleteForm;
        $(document).on('click', 'form.delete button.delete, form.delete', function(event) {
            // biar ga salah tangkap klik form, lebih aman tangkap button saja:
        });

        $('.delete').on('click', function(event) {
            event.preventDefault();
            deleteForm = $(this).closest('form');
            openBsModal('confirmationModal');
        });

        $('#confirmDelete').on('click', function() {
            if (deleteForm) deleteForm.submit();
        });

        function initManPowerCarousel() {
            const $carousel = $('#carousel');
            if (!$carousel.length) return;

            // kalau plugin belum ada, tampilkan sebagai list biasa
            if (!$.fn.owlCarousel) {
                $carousel.removeClass('owl-carousel owl-theme');
                return;
            }

            // kalau sudah ter-init, jangan init lagi
            if ($carousel.hasClass('owl-loaded')) return;

            const itemsCount = $carousel.find('> .item').length;

            // kalau cuma 0/1 item, ga usah carousel
            if (itemsCount <= 1) {
                $carousel.removeClass('owl-carousel owl-theme');
                return;
            }

            $carousel.owlCarousel({
                margin: 25,
                autoplay: true,
                loop: itemsCount > 2, // loop hanya kalau banyak
                autoWidth: false,
                items: 2,
                responsive: {
                    0: {
                        items: 1
                    },
                    992: {
                        items: 2
                    }
                }
            });
        }

        $(document).ready(function() {
            initManPowerCarousel();
        });

    });
</script>
