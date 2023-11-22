@extends('layouts.root.main')

@section('main')
<div class="col-12 col-lg-12">
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Success - </strong> {{ session('success') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Error - </strong> {{ session('error') }}
    </div>
    @endif
    <div class="card shadow" id="addPlanningCard" style="display: none">
        <div class="border-bottom title-part-padding">
            <h3 class="card-title mb-0">Weekly Employees Planning</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('employeePlanning.store') }}" method="POST" class="mt-4">
                @csrf
                @method('POST')
                <div class="">
                    <div class="col-12 mb-3">
                        <select class="select2 form-select select2-hidden-accessible shift" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" id="shift" name="shift" required>
                            <option>Select Shift</option>
                            @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <select class="select2 form-select select2-hidden-accessible" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" id="line" name="line" required>
                            <option>Select Line</option>
                            @foreach ($lines as $line)
                            <option value="{{ $line->id }}">{{ $line->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="repeater-pic-container">
                        <div class="row mb-3">
                            <div class="col-lg-12 col-sm-12">
                                <select class="select2 form-select select2-hidden-accessible pic" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" id="pic_name" name="pic_name[]" required>
                                    <option value="0">Select PIC</option>
                                    @foreach ($pics as $pic)
                                    <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="repeater-mp-container">
                        <div class="row mb-3">
                            <div class="col-lg-9 col-sm-12">
                                <select class="select2 form-select select2-hidden-accessible employee_name" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="employee_name[]" required>
                                    <option>Select Employee</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <select class="form-select mr-sm-2 pos" id="inlineFormCustomSelect" name="pos[]">
                                    <option value="default">-- select pos --</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-sm-12">
                                <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light remove-mp-row" type="button">
                                    <i class="ti ti-circle-x fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3" id="addMp">
                        <div class="d-flex align-items-center">
                            Add MP
                            <i class="ti ti-circle-plus ms-1 fs-5"></i>
                        </div>
                    </button>
                    <div class="mt-3 mb-3">
                        <label for="" class="pb-1 text-muted">Active from</label>
                        <input type="date" class="form-control" placeholder="Designation" name="active_from" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <button class="btn rounded-pill px-4 btn-success text-light font-weight-medium waves-effect waves-light submit-planning" type="submit">
                            <i class="ti ti-send fs-5"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="card shadow p-3">
        <div class="card-header" style="background-color: white;">
            <div class="row">
                <div class="col-10">
                    <h4 class="fw-4">
                        Employee Planning List
                        <h6 class="text-muted">
                            {{ Carbon\Carbon::now()->format('l, j F Y') }}
                        </h6>
                    </h4>
                </div>
                <div class="col-2 text-end">
                    <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3" id="addPlanning">
                        <div class="d-flex align-items-center">
                            <span class="rounded-3 pe-2" id="icon">
                                <i class="ti ti-plus"></i>
                            </span>
                            Create Planning
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <table class="table text-nowrap align-middle mb-0" id="henkatenHistory" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Line</th>
                        <th>Shift</th>
                        <th>Pos</th>
                        <th>role</th>
                        <th>Planning Date</th>
                        {{-- <th>Henkaten History</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activeEmployees as $emp)
                    @php
                    if ($emp->employee->role == 'JP') {
                    $color = 'danger';
                    } else {
                    $color = 'warning';
                    }
                    @endphp
                    <tr>
                        <td class="ps-0 text-truncate ps-3">
                            <img src="{{ asset('uploads/doc/' . $emp->employee->photo) }}" class="rounded img-fluid me-2" width="40" alt="{{ $emp->employee->name }}">
                            <span class="ps-2 fw-semibold">{{ $emp->employee->name }}</span>
                        </td>
                        <td>{{ $emp->line->name }}</td>
                        <td>{{ $emp->shift->name }}</td>
                        <td>POS {{ $emp->pos }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $color }} p-2 px-3">
                                {{ $emp->employee->role }}
                            </span>
                        </td>
                        <td>{{ Carbon\Carbon::parse($emp->active_from)->format('j F Y') }} -
                            {{ Carbon\Carbon::parse($emp->expired_at)->format('j F Y') }}
                        </td>
                        {{-- <td>
                                    <div class="progress" style="height: 20px">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"
                                            aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td> --}}
                        <td class="text-center">
                            <a class="btn btn-warning" href="#">
                                <span class="rounded-3" id="icon">
                                    <i class="ti ti-pencil"></i>
                                </span>
                            </a>
                            <button class="btn btn-secondary view-employee" data-bs-toggle="modal" data-bs-target="#employeeModal{{ $emp->id }}">
                                <span class="rounded-3" id="icon">
                                    <i class="ti ti-search"></i>
                                </span>
                            </button>
                            <a class="btn btn-danger delete-planning" href="#" data-min-id="{{ $emp->id }}">
                                <span class="rounded-3" id="icon">
                                    <i class="ti ti-x"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($activeEmployees as $emp)
<div class="modal fade" id="employeeModal{{ $emp->id }}" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content p-3">
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="text-center">
                            <img src="{{ asset('uploads/doc/' . $emp->employee->photo) }}" class="rounded-1 img-fluid" width="150">
                            <div class="mt-n2">
                                <span class="badge bg-primary">{{ $emp->employee->role }}</span>
                                <h3 class="card-title mt-3">{{ $emp->employee->name }}</h3>
                                <h6 class="card-subtitle">{{ $emp->line->name }} ({{ $emp->shift->name }})</h6>
                                <h6 class="card-subtitle">
                                    {{ Carbon\Carbon::parse($emp->active_from)->format('j F Y') }} -
                                    {{ Carbon\Carbon::parse($emp->expired_at)->format('j F Y') }}
                                </h6>
                            </div>
                            <div class="row mt-3 justify-content-center">
                                <div class="col-6">
                                    <div class="py-2 px-3 bg-light rounded d-flex align-items-center">
                                        <div class="ms-2 text-start">
                                            <h6 class="fw-normal text-muted mb-2">Skill</h6>
                                            @foreach ($skills as $skill)
                                            @php
                                            $employeeSkillIds = $empSkills
                                            ->where('employee_id', $emp->employee_id)
                                            ->pluck('skill_id')
                                            ->all();
                                            $employeeSkills = $allSkills->whereIn('id', $employeeSkillIds);
                                            @endphp
                                            @endforeach
                                            @foreach ($employeeSkills as $skill)
                                            <h4 class="mb-0 fs-5">{{ $skill->name }}</h4>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="py-2 px-3 bg-light rounded d-flex align-items-center">
                                        <div class="ms-2 text-start">
                                            <h6 class="fw-normal text-muted mb-2">Level</h6>
                                            @foreach ($employeeSkills as $skill)
                                            <div class="progress mb-2" style="height: 15px; width: 10vw">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $skill->level * 20 }}%;" aria-valuenow="{{ $skill->level }}" aria-valuemin="0" aria-valuemax="5">
                                                    {{ $skill->level }}
                                                </div>
                                            </div>
                                            @endforeach
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
@endforeach
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
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

    $(document).ready(function() {
        // clear all local storage when page load
        localStorage.clear();

        $(document).ready(function() {
            // initialize datatable
            $('#henkatenHistory').DataTable({
                scrollX: true,
            });
        });

        $('#addMp').on('click', function() {
            var newRow = `<div class="row mb-3">
                                <div class="col-lg-9 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible employee_name"
                                        style="width: 100%; height: 36px"
                                        tabindex="-1" aria-hidden="true" name="employee_name[]" required>
                                        <option>Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <select class="form-select mr-sm-2 pos" id="inlineFormCustomSelect" name="pos[]">
                                        <option value="default">-- select pos --</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <button data-repeater-delete=""
                                        class="btn btn-danger waves-effect waves-light remove-mp-row" type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>`;

            // Append the new row
            $('.repeater-mp-container').append(newRow);

            // Initialize Select2 for the Select elements in the new row
            $('.repeater-mp-container').find('.select2').select2();
        });

        $('.repeater-mp-container').on('click', '.remove-mp-row', function() {
            if (confirm("Are you sure you want to remove this item?")) {
                $(this).closest('.row.mb-3').remove();
            }
        });

        // PIC
        $('#addPic').on('click', function() {
            var newRow = `<div class="row mb-3">
                                <div class="col-lg-11 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible pic"
                                        style="width: 100%; height: 36px"
                                        tabindex="-1" aria-hidden="true" id="pic_name" name="pic_name[]" required>
                                        <option value="0">Select PIC</option>
                                        @foreach ($pics as $pic)
                                            <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light remove-pic-row"
                                        type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>`;

            // Append the new row
            $('.repeater-pic-container').append(newRow);

            // Initialize Select2 for the Select elements in the new row
            $('.repeater-pic-container').find('.select2').select2();
        });

        $('.repeater-pic-container').on('click', '.remove-pic-row', function() {
            if (confirm("Are you sure you want to remove this item?")) {
                $(this).closest('.row.mb-3').remove();
            }
        });

        // save line id at local storage
        $('#line').on('change', function() {
            localStorage.setItem('line', $(this).val());
        });

        let skillCount = 0;
        let minimumSkillCount = 0;
        // get employee skill when changed
        $('.repeater-mp-container').on('change', '.employee_name', function() {
            let selectedOption = $(this).find('option:selected');
            let employee_name = selectedOption.text();
            $.ajax({
                type: 'get',
                url: "{{ url('employee/getSkillEmp') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    employee: $(this).val(),
                },
                success: function(data) {
                    if (data.status == 'success') {
                        // set skill id into local storage
                        let skills = data.data;
                        skillCount = skills.length;
                        skills.forEach((item, index) => {
                            localStorage.setItem(
                                `${item.skill.name}_${employee_name}`, item
                                .skill.level);
                        });
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

        // get skill based on pos and line id
        $('.repeater-mp-container').on('change', '.pos', function() {
            let selectedOption = $(this).find('option:selected');
            let pos = selectedOption.text();
            $.ajax({
                type: 'get',
                url: "{{ url('employee/getSkillPos') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    pos: $(this).val(),
                    line: localStorage.getItem('line')
                },
                success: function(data) {
                    let flag = 0
                    if (data.status == 'success') {
                        let minimumSkills = data.data;
                        minimumSkillCount = minimumSkills.length
                        console.log(minimumSkillCount);
                        if (minimumSkillCount == 0) {
                            console.log('tidak memiliki skill')
                            flag++;
                        }

                        if (skillCount < minimumSkillCount) {
                            console.log('tidak memiliki semua skill yang dibutuhkan')
                            flag++;
                        }

                        minimumSkills.forEach((item, index) => {
                            // compare with skill id at local storage
                            for (let i = 0; i < localStorage.length; i++) {
                                let key = localStorage.key(i);
                                if (key.startsWith(item.skill.name)) {
                                    let employeeSkill = localStorage.getItem(key);
                                    let minimumSkills = item.skill.level;
                                    if (employeeSkill < minimumSkills) {
                                        console.log('level skill kurang')
                                        flag++;
                                    }
                                }
                            }
                        });

                        if (flag !== 0) {
                            localStorage.setItem('pass', false)
                            $(".submit-planning").prop("disabled", true);
                            notif('error', 'Skill tidak memenuhi kriteria pos!')
                        } else {
                            localStorage.setItem('pass', true)
                            $(".submit-planning").removeAttr("disabled");
                            notif('success', 'Skill memenuhi kriteria pos!')
                        }
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

        // get pic when line changed changed
        $('.shift').on('change', function() {
            let line = $('#line').val();
            let shift = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{ url('employee/getPic') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    shift: shift,
                    line: line,
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.pic').val(data.employee);
                        $('.repeater-pic-container').append(
                            `<input type="hidden" name="pic_name" value="${data.employee}">`
                        )
                        $('.pic').trigger('change');
                        $('.pic').prop("disabled", true);
                    } else if (data.status == 'error') {
                        console.log(data.message);
                        $('.pic').val('0');
                        $('.pic').trigger('change');
                        $('.pic').removeAttr("disabled");
                    }
                },
                error: function(xhr) {
                    console.log(xhr.status);
                }
            });
        })

        $('#line').on('change', function() {
            let line = $(this).val();
            let shift = $('.shift').val();
            $.ajax({
                type: 'get',
                url: "{{ url('employee/getPic') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    shift: shift,
                    line: line,
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.pic').val(data.employee);
                        $('.repeater-pic-container').append(
                            `<input type="hidden" name="pic_name" value="${data.employee}">`
                        )
                        $('.pic').trigger('change');
                        $('.pic').prop("disabled", true);
                    } else if (data.status == 'error') {
                        console.log(data.message);
                        $('.pic').val('0');
                        $('.pic').trigger('change');
                        $('.pic').removeAttr("disabled");
                    }
                },
                error: function(xhr) {
                    console.log(xhr.status);
                }
            });
        })

        $('#addPlanning').on('click', function() {
            $("#addPlanningCard").toggle();

            $("#icon").html($("#addPlanningCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })
    });

    $(document).ready(function() {
        $('.delete-planning').on('click', function(e) {
            e.preventDefault();

            var employeeId = $(this).data('min-id');

            if (confirm('Are you sure you want to delete this planning?')) {
                $.ajax({
                    url: `{{ url('/employee/planning/${employeeId}') }}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        // Handle success, e.g., redirect or update UI
                        window.location.reload();
                    },
                    error: function(error) {
                        console.error('Error deleting planning:', error);
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>