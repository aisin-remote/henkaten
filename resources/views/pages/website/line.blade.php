@extends('layouts.root.main')

@section('main')
    @php
        $statusMappings = [
            'running' => ['priority' => 1, 'overall' => 'RUNNING', 'shape' => 'circle', 'color' => 'success'],
            'henkaten' => ['priority' => 2, 'overall' => 'HENKATEN', 'shape' => 'triangle', 'color' => 'warning'],
            'stop' => ['priority' => 3, 'overall' => 'STOP', 'shape' => 'x', 'color' => 'danger'],
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
                'history' => $methodHistory,
            ],
            [
                'modalId' => 'manModal',
                'modalTitle' => 'Man Henkaten',
                'title' => 'MAN',
                'color' => $color_man,
                'status' => $status_man,
                'shape' => $shape_man,
                'history' => $manHistory,
            ],
            [
                'modalId' => 'materialModal',
                'modalTitle' => 'Material Henkaten',
                'title' => 'MATERIAL',
                'color' => $color_material,
                'status' => $status_material,
                'shape' => $shape_material,
                'history' => $materialHistory,
            ],
            [
                'modalId' => 'machineModal',
                'modalTitle' => 'Machine Henkaten',
                'title' => 'MACHINE',
                'color' => $color_machine,
                'status' => $status_machine,
                'shape' => $shape_machine,
                'history' => $machineHistory,
            ],
        ];
    @endphp

    {{-- modal (other tham man) --}}
    @foreach ($modals as $modal)
        <div class="modal fade" id="{{ $modal['modalId'] }}" tabindex="-1" aria-labelledby="bs-example-modal-lg"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            {{ $modal['modalTitle'] }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="mt-3">
                        <div class="modal-body">
                            @if (!$modal['history']->isEmpty())
                                <div class="accordion" id="accordionExample">
                                    @foreach ($modal['history'] as $history)
                                        @if ($history->troubleshoot == null)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#history-{{ $loop->index }}" aria-expanded="false"
                                                        aria-controls="collapseOne">
                                                        <span class="mb-1 badge bg-dark me-2">PIC :
                                                            {{ $history->pic }}</span>
                                                        @if ($history->troubleshoot == null)
                                                            <span class="mb-1 badge bg-danger">Open</span>
                                                        @else
                                                            <span class="mb-1 badge bg-success">Closed</span>
                                                        @endif
                                                        <span class="ps-3">
                                                            {{ $history->henkaten_problem }}
                                                        </span>
                                                    </button>
                                                </h2>
                                                <div id="history-{{ $loop->index }}" class="accordion-collapse collapse"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                    style="">
                                                    <div class="accordion-body">
                                                        <strong>{{ $history->henkaten_description }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            <div class="statusRadio text-center mt-3">
                                <label class="btn btn-light-primary text-primary font-medium me-2">
                                    <div class="form-check">
                                        <input type="radio" id="{{ $modal['modalId'] }}HenkatenRadio"
                                            class="other-radio form-check-input" name="{{ $modal['modalId'] }}Status"
                                            value="henkaten" @if ($modal['status'] == 'HENKATEN') checked @endif>
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
                                            class="other-radio form-check-input" name="{{ $modal['modalId'] }}Status"
                                            value="stop" @if ($modal['status'] == 'STOP') checked @endif>
                                        <label class="form-check-label" for="{{ $modal['modalId'] }}StopRadio">
                                            <span class="d-none d-md-block">
                                                STOP
                                            </span>
                                        </label>
                                    </div>
                                </label>
                            </div>
                            <div class="form-group mt-3 pic-form" style="display: none;">
                                <label>PIC</label>
                                <select class="select2 form-control select2-hidden-accessible picSelect"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                    id="{{ $modal['modalId'] }}PicSelect" name="pic" required>
                                    <option value="0">-- Select PIC --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->name }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3 mb-3 description" style="display: none;">
                                <label>Problem</label>
                                <input class="form-control" rows="3" placeholder="Problem..." name="problem"
                                    id="{{ $modal['modalId'] }}Problem" required>
                                </input>
                            </div>
                            <div class="form-group mt-3 mb-3 description" style="display: none;">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" placeholder="Description..." name="description"
                                    id="{{ $modal['modalId'] }}Description" required>
                                    </textarea>
                            </div>
                            {{-- @endif --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="{{ $modal['modalId'] }}Submit">Save
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

    {{-- modal man --}}
    <div class="modal fade" id="manOnlyModal" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Man Henkaten
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="mt-3">
                    <div class="modal-body">
                        @foreach ($activeEmployees as $emp)
                            <div class="row">
                                <div class="col-lg-1">
                                    <label for="exampleInputPassword1" class="form-label fw-semibold"
                                        style="color: white">Pos</label>
                                    <p class="mt-2 text-center badge bg-danger rounded-pill">Pos {{ $emp->pos }}</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label fw-semibold">Current
                                            Employee</label>
                                        <input type="text" class="form-control" id="exampleInputtext"
                                            placeholder="John" value="{{ $emp->employee->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <label for="exampleInputPassword1" class="form-label fw-semibold"
                                        style="color: white">Last</label>
                                    <p class="text-center mt-1">- to -</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label fw-semibold">Replacement
                                            Employee</label>
                                        <select class="select2 form-select select2-hidden-accessible employeeReplacement"
                                            style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                            name="employeeReplacement[]" required>
                                            <option>Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group mt-3 mb-3 description" style="display: none;">
                            <label>Problem</label>
                            <input class="form-control" rows="3" placeholder="Problem..." name="problem"
                                id="{{ $modal['modalId'] }}Problem" required>
                            </input>
                        </div>
                        <div class="form-group mt-3 mb-3 description" style="display: none;">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" placeholder="Description" name="description"
                                id="{{ $modal['modalId'] }}Description" required>
                                </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="submit">Save
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
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <img src="{{ asset('assets/images/mapping-per-line.png') }}" alt="" class="mw-100"
                usemap="#roomMap" width="980vh">
            @foreach ($activeEmployees as $emp)
                @php
                    if ($emp->pos == '1') {
                        $top = 60;
                        $left = 28;
                    } else {
                        $top = 71;
                        $left = 44;
                    }
                @endphp
                <div style="position: absolute; top: {{ $top }}vh; left: {{ $left }}vh;">
                    <img src="{{ asset('uploads/doc/' . $emp->employee->photo) }}" alt="Employee 1"
                        style="width: 80px; height: 80px;" class="rounded-1" />
                </div>
            @endforeach
        </div>
        <div class="col-lg-6">
            <div class="row text-center">
                @foreach ($modals as $modal)
                    @php
                        $flag = '';
                        if ($activeEmployees->isEmpty()) {
                            $flag = '-flag';
                        }

                        $target = $modal['modalId'] == 'manModal' ? '#manOnlyModal' . $flag : '#' . $modal['modalId'];

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
                    @foreach ($activeEmployees as $emp)
                        @php
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
                            $color = mapRoleToColor($emp->employee->role);
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="{{ asset('uploads/doc/' . $emp->employee->photo) }}" class="rounded-1"
                                        width="100" height="100">
                                    <div class="mt-n2">
                                        <span
                                            class="badge bg-{{ $color }}">{{ strtoupper($emp->employee->role) }}</span>
                                        <h3 class="card-title mt-3">{{ ucwords($emp->employee->name) }}</h3>
                                        <h6 class="card-subtitle">{{ $emp->employee->npk }}</h6>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button class="btn btn-light-danger text-danger"
                                                style="width: 100% !important">POS
                                                {{ strtoupper($emp->pos) }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                    <div class="col-2 text-end">
                        <button class="btn btn-primary px-4 py-2">
                            <span class="rounded-3 pe-2">
                                <i class="ti ti-file-export"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">Export</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table table-responsive-lg" id="henkatenHistory" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>4M</th>
                            <th>Status</th>
                            <th>Desc</th>
                            <th>Time</th>
                            <th>Troubleshoot</th>
                            @php
                                $hasTroubleshootTime = collect($histories)->contains(function ($history) {
                                    return $history['troubleshoot'] !== 'Belum ditangani';
                                });
                            @endphp

                            {{-- If 'Troubleshoot Time' is present, add the column --}}
                            @if ($hasTroubleshootTime)
                                <th>Troubleshoot Time</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
                            @php
                                switch ($history['status']) {
                                    case 'running':
                                        $color = 'success';
                                        break;
                                    case 'henkaten':
                                        $color = 'warning';
                                        break;
                                    case 'stop':
                                        $color = 'danger';
                                        break;
                                    default:
                                        $color = 'dark';
                                        break;
                                }
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $history['type'] }}</td>
                                <td>
                                    <span class="mb-1 badge bg-{{ $color }}">{{ $history['status'] }}</span>
                                </td>
                                <td>{{ $history['problem'] }}</td>
                                <td>{{ Carbon\Carbon::parse($history['date'])->format('j F Y, H:i:s') }}</td>
                                @if ($history['status'] == 'stop')
                                    @if ($history['troubleshoot'] == 'Belum ditangani')
                                        <td class="text-center">
                                            <span class="mb-1 badge bg-danger">{{ $history['troubleshoot'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" checked data-toggle="toggle" data-on="Open"
                                                data-off="Closed" data-onstyle="danger" data-offstyle="success"
                                                data-width="150" style="margin: 0 auto !important"
                                                id="statusCheckbox-{{ $loop->index }}"
                                                data-history-id="{{ $history['id'] }}">
                                        </td>
                                    @elseif($history['status_after'] == 'running')
                                        <td class="text-center">{{ $history['troubleshoot'] }}</td>
                                        <td class="text-center">
                                            {{ Carbon\Carbon::parse($history['troubleshootTime'])->format('j F Y, H:i:s') }}
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" checked data-toggle="toggle" data-on="Closed"
                                                data-off="Open" data-onstyle="success" data-offstyle="closed"
                                                data-width="150" style="margin: 0 auto !important"
                                                id="statusCheckbox-{{ $loop->index }}"
                                                data-history-id="{{ $history['id'] }}" disabled>
                                        </td>
                                    @endif
                                @else
                                    @if ($history['troubleshoot'] == 'Belum ditangani')
                                        <td>
                                            <span class="mb-1 badge bg-danger">{{ $history['troubleshoot'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning" data-history-id="{{ $history['id'] }}"
                                                id="edit">
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-pencil"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @else
                                        <td>{{ $history['troubleshoot'] }}
                                        </td>
                                        <td class="text-center">
                                            {{ Carbon\Carbon::parse($history['troubleshootTime'])->format('j F Y, H:i:s') }}
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning" data-history-id="{{ $history['id'] }}"
                                                id="edit" disabled>
                                                <span class="rounded-3" id="icon">
                                                    <i class="ti ti-pencil"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal --}}
    @foreach ($histories as $history)
        <div class="modal fade" id="statusModal-{{ $history['id'] }}" tabindex="-1"
            aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
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
                            <input class="form-control" rows="3" value="{{ $history['type'] }}" type="hidden"
                                name="type">
                            <input class="form-control" rows="3" value="{{ $history['id'] }}" type="hidden"
                                name="henkatenId">
                            <input class="form-control" rows="3" value="{{ $line->id }}" type="hidden"
                                name="lineId">
                            <div class="form-group mb-3 description text-center">
                                <h4>Problem</h4>
                                <input class="form-control" rows="3" value="{{ $history['problem'] }}" disabled>
                                </input>
                            </div>
                            <div class="form-group mt-3 mb-3 description" style="display: none;">
                                <label>Troubleshoot</label>
                                <input class="form-control" rows="3" placeholder="Troubleshoot..."
                                    name="troubleshoot" id="troubleshoot" required>
                                </input>
                            </div>
                            <label>Approved By</label>
                            <select class="form-control picSelect" style="width: 100%; height: 36px" tabindex="-1"
                                aria-hidden="true" id="approval" name="approvedBy" required>
                                <option value="0">-- Select --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->name }}">
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
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
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
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
        // set shift to local storage
        localStorage.setItem('shift', $('#shift').html());

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

        // method on submit
        $('#methodModalSubmit').on('click', function() {
            let table = 'method';
            let status = labelText;
            let lineId = getLineId();
            let pic = $('#methodModalPicSelect').val();
            let description = $('#methodModalDescription').val();
            let problem = $('#methodModalProblem').val();

            if (!status) {
                notif('error', 'Isi Status terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && pic == 0) {
                notif('error', 'Isi PIC terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && description == 0) {
                notif('error', 'Isi deskripsi terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && problem == 0) {
                notif('error', 'Isi problem terlebih dahulu!');
                return false;
            }

            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/storeHenkaten/${table}/${status.toLowerCase().trim()}/${lineId}/${pic}/${problem}/${description}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        window.location.reload();
                        setInterval(() => {
                            notif('success', data.message)
                        }, 5000);
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
        })

        // machine on submit
        $('#machineModalSubmit').on('click', function() {
            let table = 'machine';
            let status = labelText;
            let lineId = getLineId();
            let pic = $('#machineModalPicSelect').val();
            let description = $('#machineModalDescription').val();
            let problem = $('#machineModalProblem').val();

            if (!status) {
                notif('error', 'Isi Status terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && pic == 0) {
                notif('error', 'Isi PIC terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && description == 0) {
                notif('error', 'Isi deskripsi terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && problem == 0) {
                notif('error', 'Isi problem terlebih dahulu!');
            }

            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/storeHenkaten/${table}/${status.toLowerCase().trim()}/${lineId}/${pic}/${problem}/${description}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        window.location.reload();
                        setInterval(() => {
                            notif('success', data.message)
                        }, 5000);
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
        })

        // material on submit
        $('#materialModalSubmit').on('click', function() {
            let table = 'material';
            let status = labelText;
            let lineId = getLineId();
            let pic = $('#materialModalPicSelect').val();
            let description = $('#materialModalDescription').val();
            let problem = $('#materialModalProblem').val();

            if (!status) {
                notif('error', 'Isi Status terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && pic == 0) {
                notif('error', 'Isi PIC terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && description == 0) {
                notif('error', 'Isi deskripsi terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && problem == 0) {
                notif('error', 'Isi problem terlebih dahulu!');
            }

            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/storeHenkaten/${table}/${status.toLowerCase().trim()}/${lineId}/${pic}/${problem}/${description}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        window.location.reload();
                        setInterval(() => {
                            notif('success', data.message)
                        }, 5000);
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
        })

        // man on submit
        $('#manModalSubmit').on('click', function() {
            let table = 'man';
            let status = labelText;
            let lineId = getLineId();
            let pic = $('#manModalPicSelect').val();
            let description = $('#manModalDescription').val();
            let problem = $('#manModalProblem').val();

            if (!status) {
                notif('error', 'Isi Status terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && pic == 0) {
                notif('error', 'Isi PIC terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && description == 0) {
                notif('error', 'Isi deskripsi terlebih dahulu!');
                return false;
            }

            if (status !== 'running' && problem == 0) {
                notif('error', 'Isi problem terlebih dahulu!');
            }

            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/storeHenkaten/${table}/${status.toLowerCase().trim()}/${lineId}/${pic}/${problem}/${description}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        window.location.reload();
                        setInterval(() => {
                            notif('success', data.message)
                        }, 5000);
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
        })

        $('input[type="checkbox"]').each(function(index) {
            let checkbox = $(this);

            checkbox.on('change', function() {
                if (checkbox.prop('checked')) {
                    // Checkbox is checked (Open)
                    if (!confirm('Are you sure?')) {
                        checkbox.bootstrapToggle('off'); // Uncheck the checkbox if canceled
                    }
                } else {
                    // Checkbox is not checked (Closed)
                    const historyId = $(this).data('history-id');
                    $(`#statusModal-${historyId}`).modal('show');
                }
            });
        });

        $('#edit').on('click', function() {
            const historyId = $(this).data('history-id');
            $(`#statusModal-${historyId}`).modal('show');
        })

        var errorMessage = "{!! session('error') !!}";
        var successMessage = "{!! session('success') !!}";

        if (errorMessage) {
            notif('error', errorMessage);
        }

        if (successMessage) {
            notif('success', successMessage);
        }

        $('#machineModalPicSelect').select2({
            dropdownParent: $('#machineModal')
        });
        $('#manModalPicSelect').select2({
            dropdownParent: $('#manModal')
        });
        $('#methodModalPicSelect').select2({
            dropdownParent: $('#methodModal')
        });
        $('#materialModalPicSelect').select2({
            dropdownParent: $('#materialModal')
        });

        $('.employeeReplacement').select2({
            dropdownParent: $('#manOnlyModal')
        });
    });
</script>
