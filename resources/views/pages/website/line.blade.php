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

        // Check if the function exists before declaring it
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

        // Assign status for each status property
        $status_man = mapStatus($line->status_man);
        $status_method = mapStatus($line->status_method);
        $status_material = mapStatus($line->status_material);
        $status_machine = mapStatus($line->status_machine);

        // Assign shapes for each status property
        $shape_man = mapStatusToShape($line->status_man);
        $shape_method = mapStatusToShape($line->status_method);
        $shape_material = mapStatusToShape($line->status_material);
        $shape_machine = mapStatusToShape($line->status_machine);

        // Assign color for each status property
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
                    <form class="mt-3" action="{{ route('dashboard.storeHenkaten') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="statusRadio text-center mt-3">
                                <label class="btn btn-light-primary text-primary font-medium me-2">
                                    <div class="form-check">
                                        <input type="radio" id="{{ $modal['modalId'] }}HenkatenRadio"
                                            class="other-radio form-check-input" name="status" value="henkaten">
                                        <label class="form-check-label" for="{{ $modal['modalId'] }}HenkatenRadio">
                                            <span class="d-none d-md-block">
                                                HENKATEN
                                            </span>
                                        </label>
                                    </div>
                                </label>
                                <label class="btn btn-light-primary text-primary font-medium">
                                    <div class="form-check">
                                        <input type="radio" id="{{ $modal['modalId'] }}StopRadio"
                                            class="other-radio form-check-input" name="status" value="stop">
                                        <label class="form-check-label" for="{{ $modal['modalId'] }}StopRadio">
                                            <span class="d-none d-md-block">
                                                STOP
                                            </span>
                                        </label>
                                    </div>
                                </label>
                            </div>
                            <input type="hidden" name="type" value="{{ strtolower($modal['title']) }}">
                            <input type="hidden" name="line" value="{{ $line->id }}">
                            <div class="form-group mt-3 pic-form">
                                <label class="form-label mb-2 fw-semibold">Category</label>
                                <select class="select2 form-control select2-hidden-accessible category"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                    id="{{ $modal['modalId'] }}Category" name="category" required>
                                    <option value="0">-- Select Category --</option>
                                    <option value="Safety Issue">Safety Issue</option>
                                    <option value="Productivity Issue">Productivity Issue</option>
                                    <option value="Cost Issue">Cost Issue</option>
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
                                <input class="form-control" rows="3" placeholder="Abnormality..." name="abnormality"
                                    id="{{ $modal['modalId'] }}Abnormality" required>
                                </input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" id="{{ $modal['modalId'] }}Submit">Save
                                changes</button>
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
    <div class="modal fade" id="manModal-flag" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;"
        aria-hidden="true">
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
                                <li class="breadcrumb-item" aria-current="page">
                                    Status
                                </li>
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
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <img src="{{ asset('assets/images/' . $lineMap->photo) }}" alt="" class="mw-100" usemap="#roomMap"
                width="980vh">
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

                    <div style="position: absolute; top: {{ $emp->pos->top }}vh; left: {{ $emp->pos->left }}vh;">
                        <img src="{{ asset('uploads/doc/' . $photo) }}" alt="Employee Photo"
                            style="width: {{ $emp->pos->size }}; height: {{ $emp->pos->size }};" class="rounded-1" />
                    </div>
                @endforeach
            @else
                @foreach ($activeEmployees as $emp)
                    @php
                        $photo = $emp->employee->photo;
                    @endphp
                    <!-- Displaying the employee photo with default position -->
                    <div style="position: absolute; top: {{ $emp->pos->top }}vh; left: {{ $emp->pos->left }}vh;">
                        <img src="{{ asset('uploads/doc/' . $photo) }}" alt="Employee Photo"
                            style="width: {{ $emp->pos->size }}; height: {{ $emp->pos->size }};" class="rounded-1" />
                    </div>
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

                        $target = $modal['modalId'] == 'manModal' ? '#' . $modal['modalId'] . $flag : '#' . $modal['modalId'];

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
            <h5 class="text-muted mb-2 fw-bolder">Man Power</h5>
            <div class="row">
                @if (!$activeEmployees->isEmpty())
                    <div class="col-lg-8 col-md-12">
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

                                        if ($line->name === 'ASAN01' || $line->name === 'ASAN02' || $line->name === 'ASIP01' || $line->name === 'ASMP01' || $line->name === 'ASVP01') {
                                            $col = '12';
                                        } else {
                                            $col = '6';
                                        }
                                    @endphp
                                    <div class="col-lg-{{ $col }} col-md-12">
                                        <div class="item">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <img src="{{ asset('uploads/doc/' . $photo) }}"
                                                        class="rounded-1 center" height="100"
                                                        style="width: 100px !important; margin-left: auto;
                                                    margin-right: auto;">
                                                    <div class="mt-n2">
                                                        <span
                                                            class="badge bg-{{ $color }}">{{ strtoupper($role) }}</span>
                                                        <h3 class="card-title mt-3">{{ ucwords($name) }}</h3>
                                                        <h6 class="card-subtitle">{{ $npk }}</h6>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-12">
                                                            <button class="btn btn-light-danger text-danger"
                                                                style="width: 100% !important">POS
                                                                {{ strtoupper($emp->pos->pos) }}</button>
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
                    @if ($activePic !== null)
                        @php
                            $picColor = mapRoleToColor($activePic->employee->role);

                        @endphp
                        <div class="col-lg-4 col-md-12">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="{{ asset('uploads/doc/' . $activePic->employee->photo) }}"
                                        class="rounded-1" width="100" height="100">
                                    <div class="mt-n2">
                                        <span
                                            class="badge bg-{{ $picColor }}">{{ strtoupper($activePic->employee->role) }}</span>
                                        <h3 class="card-title mt-3">{{ ucwords($activePic->employee->name) }}</h3>
                                        <h6 class="card-subtitle">{{ $activePic->employee->npk }}</h6>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button class="btn btn-dark" style="width: 100% !important">
                                                {{ strtoupper('pic') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="col-lg-12 col-sm-12 mt-3" id="firstPicContainer">
                        <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal"
                            id="firstPic">
                            <a href="{{ route('employeePlanning.index') }}" class="dropzone dz-clickable p-3 rounded-1">
                                <p class="text-center pt-3 text-danger">Create Employee Planning</p>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: white !important">
                <div class="row">
                    <div class="col-10">
                        <h4 class="fw-4">
                            Henkaten History Board
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
                            <th>Time</th>
                            <th class="text-center">Troubleshoot</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                            @if (auth()->user()->role !== 'JP')
                                <th class="text-center">Approval</th>
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
                                <td>{{ Carbon\Carbon::parse($history->henkaten->date)->format('j F Y, H:i:s') }}</td>
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
                                        @endcan
                                    </td>
                                    @can('LDR')
                                        <td class="text-center">
                                            <button class="btn btn-success" data-history-id="{{ $history->henkaten->id }}"
                                                disabled>
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-checks"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @endcan
                                    @can('SPV')
                                        <td class="text-center">
                                            <button class="btn btn-success" data-history-id="{{ $history->henkaten->id }}"
                                                disabled>
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-checks"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @endcan
                                    @can('MGR')
                                        <td class="text-center">
                                            <button class="btn btn-success" data-history-id="{{ $history->henkaten->id }}"
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
                                                Done Approval
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
                                                data-history-id="{{ $history->henkaten->id }}" disabled>
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

    {{-- modal troubleshoot --}}
    @foreach ($histories as $history)
        @php
            // Generate unique IDs based on $history->henkaten->id
            $accordionId = 'accordion-' . $history->henkaten->id;
            $collapseOneId = 'collapseOne-' . $history->henkaten->id;
            $collapseTwoId = 'collapseTwo-' . $history->henkaten->id;
            $collapseThreeId = 'collapseThree-' . $history->henkaten->id;
        @endphp
        <div class="modal fade modal-lg troubleshootModal" id="{{ $history->henkaten->id }}Troubleshoot" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Troubleshoot
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.troubleshootHenkaten') }}" method="POST" class="mt-3">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <input type="hidden" name="henkaten_id" value="{{ $history->henkaten->id }}">
                                    <input type="hidden" name="4M" value="{{ $history->henkaten->{"4M"} }}">
                                    <input type="hidden" name="status" value="{{ $history->henkaten->status }}">
                                    <input type="hidden" name="line" value="{{ $history->henkaten->line_id }}">
                                    <div class="form-group mt-3 mb-3 description" style="display: none;">
                                        <label class="form-label fw-semibold">Troubleshoot</label>
                                        <input class="form-control" rows="3" placeholder="Troubleshoot..."
                                            name="troubleshoot" id="troubleshoot" required>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion accordion-flush position-relative overflow-hidden mt-2"
                                id="{{ $accordionId }}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="accordion-item mb-3 border rounded-top rounded-bottom">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button
                                                    class="accordion-button fs-4 fw-bolder px-3 py-6 lh-base border-0 rounded-top collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseOneId }}" aria-expanded="false"
                                                    aria-controls="{{ $collapseOneId }}">
                                                    Quality Inspections
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseOneId }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingOne" data-bs-parent="#{{ $accordionId }}"
                                                style="">
                                                <div class="accordion-body px-3 fw-normal">
                                                    <div class="text-center mb-2">
                                                        <h6 class="fw-semibold">Abnormality Inspection Report</h6>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label" for="need">Need</label>
                                                            <input class="form-check-input" type="radio"
                                                                name="inspection" id="need" value="need">
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="inspection" id="noNeed" value="no need">
                                                            <label class="form-check-label" for="noNeed">No Need
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label for="part"
                                                                    class="form-label fw-semibold">Part</label>
                                                                <input type="text" class="form-control" id="part"
                                                                    name="part" placeholder="TCC d983">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label class="form-label mb-2 fw-semibold">Before
                                                                    Treatment</label>
                                                                <select
                                                                    class="select2 form-control select2-hidden-accessible beforeTreatment"
                                                                    style="width: 100%; height: 36px" tabindex="-1"
                                                                    aria-hidden="true"
                                                                    id="{{ $history->henkaten->id }}BeforeTreatment"
                                                                    name="beforeTreatment" required>
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="ok">OK</option>
                                                                    <option value="ng">NG</option>
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
                                                                    aria-hidden="true"
                                                                    id="{{ $history->henkaten->id }}AfterTreatment"
                                                                    name="afterTreatment" required>
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="ok">OK</option>
                                                                    <option value="ng">NG</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="accordion-item mb-3 border rounded-top rounded-bottom">
                                            <h2 class="accordion-header" id="flush-headingThree">
                                                <button
                                                    class="accordion-button fs-4 fw-semibold px-3 py-6 lh-base border-0 rounded-bottom collapsed"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseThreeId }}" aria-expanded="false"
                                                    aria-controls="{{ $collapseThreeId }}">
                                                    Safety
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseThreeId }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingThree"
                                                data-bs-parent="#{{ $accordionId }}" style="">
                                                <div class="accordion-body px-3 fw-normal">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <div class="form-group pic-form">
                                                                <label class="form-label mb-2 fw-semibold">Result
                                                                    Check</label>
                                                                <select
                                                                    class="select2 form-control select2-hidden-accessible"
                                                                    style="width: 100%; height: 36px" tabindex="-1"
                                                                    aria-hidden="true"
                                                                    id="{{ $history->henkaten->id }}ResultCheck"
                                                                    name="resultCheck" required>
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="ok">OK</option>
                                                                    <option value="ng">NG</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="accordion-item mb-3 border rounded-top rounded-bottom">
                                            @if ($history->henkaten->{"4M"} === 'man')
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button
                                                        class="accordion-button fs-4 fw-bolder px-3 py-6 lh-base border-0 rounded-top collapsed"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#{{ $collapseTwoId }}" aria-expanded="false"
                                                        aria-controls="{{ $collapseTwoId }}">
                                                        Man Henkaten <small class="text-danger ps-1"> *Jika
                                                            ada
                                                            perubahan</small>
                                                    </button>
                                                </h2>
                                                <div id="{{ $collapseTwoId }}" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#{{ $accordionId }}" style="">
                                                    <div class="accordion-body px-3 fw-normal">
                                                        @foreach ($activeEmployees as $emp)
                                                            <div class="row mt-1">
                                                                <div class="col-lg-1">
                                                                    <label for="exampleInputPassword1"
                                                                        class="form-label fw-semibold"
                                                                        style="color: white">Pos</label>
                                                                    <p
                                                                        class="mt-2 text-center badge bg-danger rounded-pill">
                                                                        Pos
                                                                        {{ $emp->pos->pos }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="mb-4">
                                                                        <label for="exampleInputPassword1"
                                                                            class="form-label fw-semibold">Current
                                                                            Employee</label>
                                                                        <input type="text" class="form-control"
                                                                            id="employeeBefore" placeholder="John"
                                                                            value="{{ $emp->employee->name }}" disabled>

                                                                        <input type="hidden"
                                                                            class="form-control employeeBefore"
                                                                            name="before[]" placeholder="John"
                                                                            value="{{ $emp->employee->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <label for="exampleInputPassword1"
                                                                        class="form-label fw-semibold"
                                                                        style="color: white">Last</label>
                                                                    <p class="text-center mt-1">- to -</p>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="mb-4">
                                                                        <label for="exampleInputPassword1"
                                                                            class="form-label fw-semibold">Replacement
                                                                            Employee</label>
                                                                        <select
                                                                            class="select2 form-select select2-hidden-accessible employeeReplacement"
                                                                            style="width: 100%; height: 36px"
                                                                            tabindex="-1" aria-hidden="true"
                                                                            name="after[]" required>
                                                                            <option value="0">Select
                                                                                Employee</option>
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
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <label class="form-label fw-semibold">Done By</label>
                                        <select class="select2 form-control" style="width: 100%; height: 36px"
                                            tabindex="-1" aria-hidden="true" id="{{ $history->henkaten->id }}DoneBy"
                                            name="doneBy" required>
                                            <option value="0">-- Select Employee--</option>
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
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary">Save
                                changes</button>
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

    {{-- modal approve --}}
    @foreach ($histories as $history)
        <div class="modal fade modal-md" id="{{ $history->henkaten->id }}Approve" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Approval
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.troubleshootApproval') }}" method="POST" class="mt-3">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <input type="hidden" name="henkaten_id" value="{{ $history->henkaten->id }}">
                            <input type="hidden" name="line" value="{{ $history->henkaten->line_id }}">
                            <input type="hidden" name="4M" value="{{ $history->henkaten->{"4M"} }}">
                            <input type="hidden" name="status" value="{{ $history->henkaten->status }}">
                            Do you really want to approve?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary">Approve</button>
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
    {{-- end of modal --}}

    {{-- modal detail --}}
    @foreach ($histories as $history)
        @php
            if ($history->henkaten->status === 'henkaten') {
                $color = 'warning';
                $shape = 'henkaten.svg';
            } else {
                $color = 'danger';
                $shape = 'stop.svg';
            }
        @endphp
        <div class="modal fade modal-md" id="{{ $history->henkaten->id }}Detail" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Detail
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group mb-4">
                            <!-- Column -->
                            <div class="card bg-{{ $color }}">
                                <div class="card-body text-center text-white">
                                    <div class="pt-2">
                                        <h4 class="fw-bolder text-white">{{ strtoupper($history->henkaten->status) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab"
                                        href="#{{ $history->henkaten->id }}Abnormal" role="tab"
                                        aria-selected="true">
                                        <span>Abnormality</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab"
                                        href="#{{ $history->henkaten->id }}Trouble" role="tab" aria-selected="true"
                                        tabindex="-1">
                                        <span>Troubleshoot</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content border mt-2">
                                <div class="tab-pane p-3 active" id="{{ $history->henkaten->id }}Abnormal"
                                    role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                    placeholder="Enter Name here"
                                                    value="{{ strtoupper($history->henkaten->{'4M'}) }}" disabled>
                                                <label for="tb-fname">4M</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                    placeholder="Enter Name here"
                                                    value="{{ strtoupper($history->henkaten->category) }}" disabled>
                                                <label for="tb-fname">Category</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                    placeholder="Enter Name here"
                                                    value="{{ $history->henkaten->henkatenManagement->henkaten_item }} [Table no: {{ $history->henkaten->henkatenManagement->table_no }}]"
                                                    disabled>
                                                <label for="tb-fname">Hankaten Table No.</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                    placeholder="Enter Name here"
                                                    value="{{ strtoupper($history->henkaten->abnormality) }}" disabled>
                                                <label for="tb-fname">Abnormality Content</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                    placeholder="Enter Name here"
                                                    value="{{ Carbon\Carbon::parse($history->henkaten->date)->format('j F Y,  H:i:s') }}"
                                                    disabled>
                                                <label for="tb-fname">Time</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="{{ $history->henkaten->id }}Trouble" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            @if ($history->henkaten->troubleshoot === null)
                                                <span class="badge bg-danger">
                                                    Belum dilakukan penanganan
                                                </span>
                                            @else
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                        placeholder="Enter Name here"
                                                        value="{{ strtoupper($history->henkaten->troubleshoot->troubleshoot) }}"
                                                        disabled>
                                                    <label for="tb-fname">Troubleshoot</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                        placeholder="Enter Name here"
                                                        value="{{ strtoupper($history->henkaten->troubleshoot->result_check) }}"
                                                        disabled>
                                                    <label for="tb-fname">Result Check</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                        placeholder="Enter Name here"
                                                        value="{{ strtoupper($history->henkaten->troubleshoot->inspection_report) }}"
                                                        disabled>
                                                    <label for="tb-fname">Inspection Report</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                        placeholder="Enter Name here"
                                                        value="{{ strtoupper($history->henkaten->troubleshoot->part) }}"
                                                        disabled>
                                                    <label for="tb-fname">Part</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control fw-bolder"
                                                                id="tb-fname" placeholder="Enter Name here"
                                                                value="{{ strtoupper($history->henkaten->troubleshoot->before_treatment) }}"
                                                                disabled>
                                                            <label for="tb-fname">Before Treatment</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control fw-bolder"
                                                                id="tb-fname" placeholder="Enter Name here"
                                                                value="{{ strtoupper($history->henkaten->troubleshoot->after_treatment) }}"
                                                                disabled>
                                                            <label for="tb-fname">After Treatment</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control fw-bolder" id="tb-fname"
                                                        placeholder="Enter Name here"
                                                        value="{{ strtoupper($history->henkaten->troubleshoot->employee->name) }}"
                                                        disabled>
                                                    <label for="tb-fname">Done By</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    {{-- end of modal --}}

    <!-- Status Modal -->
    <div class="modal fade" id="ModalStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
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
                        @if ($overall_status === 'off' || $overall_status === 'running')
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
                        @if ($overall_status === 'off' || $overall_status === 'running')
                            <button type="submit" class="btn btn-primary" onclick="submitLineForm()">Save
                                changes</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    function submitLineForm() {
        var offSwitchChecked = $("#OffSwitch").is(':checked');
        var runningSwitchChecked = $("#RunningSwitch").is(':checked');
        var offSwitch = $("#OffSwitch").is(':checked');
        var runningSwitch = $("#RunningSwitch").is(':checked');
        var myid = @json($line);

        if (offSwitchChecked || runningSwitchChecked) {
            var formDataVal = offSwitchChecked ? $("#OffSwitch").val() : $("#RunningSwitch").val();

            $.ajax({
                type: 'GET',
                url: 'updateStatus/' + myid.id,
                data: {
                    onOffSwitch: formDataVal
                },
                success: function(data) {
                    // Handle the response from the controller
                    location.reload();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        } else {
            alert("Please select an option");
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

    function getLineId() {
        let currentURL = window.location.href;

        // Split the URL by slashes and get the last part
        let parts = currentURL.split('/');
        let lineId = parts[parts.length - 1];

        return lineId;
    }

    $(document).ready(function() {
        var lineName = "{{ $line->name }}";

        if (lineName === 'ASAN01' || lineName === 'ASAN02') {
            $('.temp-row').children().unwrap();
            $('.owl-carousel').owlCarousel({
                margin: 25,
                autoplay: true,
                loop: true,
                autoWidth: false,
                items: 2
            })
        } else {
            $('#carousel').removeClass('owl-carousel')
            $('#carousel').removeClass('owl-theme')
        }
        // set shift to local storage
        localStorage.setItem('shift', $('#shift').html());

        var errorMessage = "{!! session('error') !!}";
        var successMessage = "{!! session('success') !!}";

        if (errorMessage) {
            notif('error', errorMessage);
        } else if (successMessage) {
            notif('success', successMessage);
        }

        // initialize datatable
        $('#henkatenHistory').DataTable({
            scrollX: true,
            columnDefs: [{
                orderable: false,
                targets: 6
            }],
        });

        let labelText;

        function toggleFormElements(modal) {
            const picForm = modal.find('.pic-form');
            const description = modal.find('.description');
            const selectedValue = modal.find('input[name$="Status"]:checked').val();

            if (selectedValue === 'running') {
                picForm.hide();
                description.hide();
            } else {
                picForm.show();
                description.show();
            }
        }

        $('.running-radio, .other-radio').change(function() {
            const modal = $(this).closest('.modal');

            // get label for radio button type
            labelText = modal.find('label[for="' + $(this).attr('id') + '"]').text();

            toggleFormElements(modal);
        });

        // Initialize form element visibility on page load
        $('.modal').each(function() {
            toggleFormElements($(this));
        });

        $('.troubleshoot').on('click', function() {
            const historyId = $(this).data('history-id');
            $(`#${historyId}Troubleshoot`).modal('show');

            $(`#${historyId}BeforeTreatment`).select2({
                dropdownParent: $(`#${historyId}Troubleshoot`)
            });

            $(`#${historyId}AfterTreatment`).select2({
                dropdownParent: $(`#${historyId}Troubleshoot`)
            });

            $(`#${historyId}ResultCheck`).select2({
                dropdownParent: $(`#${historyId}Troubleshoot`)
            });

            $(`.employeeReplacement`).select2({
                dropdownParent: $(`#${historyId}Troubleshoot`)
            });

            $(`#${historyId}DoneBy`).select2({
                dropdownParent: $(`#${historyId}Troubleshoot`)
            });
        })

        $('.approve').on('click', function() {
            const historyId = $(this).data('history-id');
            $(`#${historyId}Approve`).modal('show');
        })

        $('.detail').on('click', function() {
            const historyId = $(this).data('history-id');
            $(`#${historyId}Detail`).modal('show');
        })

        var errorMessage = "{!! session('error') !!}";
        var successMessage = "{!! session('success') !!}";

        if (errorMessage) {
            notif('error', errorMessage);
        }

        if (successMessage) {
            notif('success', successMessage);
        }

        $('#machineModalTableManagement').select2({
            dropdownParent: $('#machineModal')
        });
        $('#manModalTableManagement').select2({
            dropdownParent: $('#manModal')
        });
        $('#methodModalTableManagement').select2({
            dropdownParent: $('#methodModal')
        });

        $('#materialModalTableManagement').select2({
            dropdownParent: $('#materialModal')
        });

        $('#machineModalCategory').select2({
            dropdownParent: $('#machineModal')
        });
        $('#manModalCategory').select2({
            dropdownParent: $('#manModal')
        });
        $('#methodModalCategory').select2({
            dropdownParent: $('#methodModal')
        });
        $('#materialModalCategory').select2({
            dropdownParent: $('#materialModal')
        });

        $('.employeeReplacement').on('change', function() {
            // Recalculate the count of elements with value 0
            let countZero = $('.employeeReplacement').filter(function() {
                return $(this).val() === '0';
            }).length;

            // Check the count and disable or enable accordingly
            if (countZero === 2) {
                $('#manProblem').attr('disabled', 'disabled');
                $('#manDescription').attr('disabled', 'disabled');
            } else {
                $('#manProblem').removeAttr('disabled');
                $('#manDescription').removeAttr('disabled');
            }
        });

        // Push the initial values to the array
        $('.employeeReplacement').each(function() {
            let value = $(this).val();
            employeeReplacement.push(value);
        });
    });
</script>
