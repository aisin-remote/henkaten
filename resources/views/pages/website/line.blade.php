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
            // Add more modals here as needed
        ];
    @endphp

    {{-- modal --}}
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
                    <form class="mt-3">
                        <div class="modal-body">
                            <div class="statusRadio text-center">
                                <div class="btn-group" data-bs-toggle="buttons">
                                    <label class="btn btn-light-primary text-primary font-medium">
                                        <div class="form-check">
                                            <input type="radio" id="{{ $modal['modalId'] }}RunningRadio"
                                                class="running-radio form-check-input" name="{{ $modal['modalId'] }}Status"
                                                value="running" @if ($modal['status'] == 'NO HENKATEN') checked @endif>
                                            <label class="form-check-label" for="{{ $modal['modalId'] }}RunningRadio">
                                                <span class="d-none d-md-block">
                                                    RUNNING
                                                </span>
                                            </label>
                                        </div>
                                    </label>
                                    <label class="btn btn-light-primary text-primary font-medium">
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
                            </div>

                            <div class="form-group mt-3 pic-form" style="display: none;">
                                <label>PIC</label>
                                <select class="select2 form-control select2-hidden-accessible picSelect"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                    id="{{ $modal['modalId'] }}PicSelect" name="pic" required>
                                    <option value="0">-- Select PIC --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3 description" style="display: none;">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" placeholder="Description..." name="description"
                                    id="{{ $modal['modalId'] }}Description"></textarea>
                            </div>
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
            <img src="{{ asset('assets/images/mapping-per-line.png') }}" alt="" class="mw-100" usemap="#roomMap"
                width="980vh">

            <div style="position: absolute; top: 60vh; left: 28vh;">
                <img src="../../dist/images/profile/tri.png" alt="Employee 1" style="width: 80px; height: 80px;"
                    class="rounded-1" />
            </div>

            <div style="position: absolute; top: 71vh; left: 44vh;">
                <img src="../../dist/images/profile/syarief.png" alt="Employee 2" style="width: 80px; height: 80px;"
                    class="rounded-1" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row text-center">
                @foreach ($modals as $modal)
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-hover" data-bs-toggle="modal"
                            data-bs-target="#{{ $modal['modalId'] }}">
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
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="../../dist/images/profile/tri.png" class="rounded-1 img-fluid" width="100">
                            <div class="mt-n2">
                                <span class="badge bg-warning">OPERATOR</span>
                                <h3 class="card-title mt-3">Ahmad Tri</h3>
                                <h6 class="card-subtitle">003921</h6>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button class="btn btn-warning" style="width: 100% !important">POS 1</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="../../dist/images/profile/syarief.png" class="rounded-1 img-fluid" width="100">
                            <div class="mt-n2">
                                <span class="badge bg-danger">JP</span>
                                <h3 class="card-title mt-3">Syarief</h3>
                                <h6 class="card-subtitle">002899</h6>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button class="btn btn-danger" style="width: 100% !important">POS 2</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="../../dist/images/profile/saiful.png" class="rounded-1 img-fluid" width="100">
                            <div class="mt-n2">
                                <span class="badge bg-dark">LEADER</span>
                                <h3 class="card-title mt-3">Saiful</h3>
                                <h6 class="card-subtitle">002899</h6>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button class="btn btn-dark" style="width: 100% !important">PIC</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="product-list">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-9">
                        <form class="position-relative">
                            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                placeholder="Search Product">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                        <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Filter list"><i class="ti ti-filter"></i></a>
                    </div>
                    <div class="table-responsive border rounded">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </th>
                                    <th scope="col">Henkaten</th>
                                    <th scope="col">Problem</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Penanganan</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../../dist/images/products/s1.jpg" class="rounded-circle"
                                                alt="..." width="56" height="56">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0 fs-4">Machine</h6>
                                                <p class="mb-0">DCAA01</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Mesin bagian A problem</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-success p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Uncritical</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">Diganti</h6>
                                    </td>
                                    <td><a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit"><i
                                                class="ti ti-dots-vertical"></i></a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../../dist/images/products/s2.jpg" class="rounded-circle"
                                                alt="..." width="56" height="56">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0 fs-4">Machine</h6>
                                                <p class="mb-0">DCAA01</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Mesin bagian B problem</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-danger p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Critical</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">Beli baru</h6>
                                    </td>
                                    <td><a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit"><i
                                                class="ti ti-dots-vertical"></i></a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../../dist/images/products/s3.jpg" class="rounded-circle"
                                                alt="..." width="56" height="56">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0 fs-4">Machine</h6>
                                                <p class="mb-0">DCAA01</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Mesin bagian C problem</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-success p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Critical</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">Ganti</h6>
                                    </td>
                                    <td><a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit"><i
                                                class="ti ti-dots-vertical"></i></a></td>
                            </tbody>
                        </table>
                        <div class="d-flex align-items-center justify-content-end py-1">
                            <p class="mb-0 fs-2">Rows per page:</p>
                            <select class="form-select w-auto ms-0 ms-sm-2 me-8 me-sm-4 py-1 pe-7 ps-2 border-0"
                                aria-label="Default select example">
                                <option selected="">5</option>
                                <option value="1">10</option>
                                <option value="2">25</option>
                            </select>
                            <p class="mb-0 fs-2">1–5 of 12</p>
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center mb-0 ms-8 ms-sm-9">
                                    <li class="page-item p-1">
                                        <a class="page-link border-0 rounded-circle text-dark fs-6 round-32 d-flex align-items-center justify-content-center"
                                            href="#"><i class="ti ti-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item p-1">
                                        <a class="page-link border-0 rounded-circle text-dark fs-6 round-32 d-flex align-items-center justify-content-center"
                                            href="#"><i class="ti ti-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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

        // on submit
        $('#methodModalSubmit').on('click', function() {
            $.ajax({
                type: 'get',
                url: "{{ url('dashboard/storeHenkaten') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    table: 'method',
                    status: toLowerCase(labelText),
                    lineId: getLineId(),
                    pic: $('#methodModalPicSelect').val(),
                    description: $('#methodModalDescription').val(),
                },
                success: function(data) {
                    if (data.status == 'success') {

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
    });
</script>
