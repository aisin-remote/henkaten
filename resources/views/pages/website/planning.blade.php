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
                            <select class="select2 form-select select2-hidden-accessible shift"
                                style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" id="shift"
                                name="shift" required>
                                <option>Select Shift</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <select class="select2 form-select select2-hidden-accessible" style="width: 100%; height: 36px"
                                tabindex="-1" aria-hidden="true" id="line" name="line" required>
                                <option>Select Line</option>
                                @foreach ($lines as $line)
                                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="repeater-pic-container">
                            <div class="row mb-3">
                                <div class="col-lg-12 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible pic"
                                        style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" id="pic_name"
                                        name="pic_name[]" required>
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
                                <div class="col-lg-3 col-sm-12 align-items-center">
                                    <div class="mb-4 row align-items-center">
                                        <label for="exampleInputPassword1"
                                            class="form-label fw-semibold col-sm-3 col-form-label">Pos</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" placeholder="Employee Name"
                                                name="pos[]" value="Pos 1" disabled>
                                            <input type="hidden" class="form-control" placeholder="Employee Name"
                                                name="pos[]" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible employee_id"
                                        style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                        name="employee_id[]" required>
                                        <option value="0">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-sm-12">
                                    <div class="mb-4 row align-items-center">
                                        <label for="exampleInputPassword1"
                                            class="form-label fw-semibold col-sm-3 col-form-label">Pos</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" placeholder="Employee Name"
                                                name="pos[]" value="Pos 2" disabled>
                                            <input type="hidden" class="form-control" placeholder="Employee Name"
                                                name="pos[]" value="2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible employee_id"
                                        style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                        name="employee_id[]" required>
                                        <option value="0">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="pb-1 text-muted">Active from</label>
                            <input type="date" class="form-control" placeholder="Designation" name="active_from"
                                required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <button
                                class="btn rounded-pill px-4 btn-success text-light font-weight-medium waves-effect waves-light submit-planning"
                                type="submit">
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
                        <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3"
                            id="addPlanning">
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
                            <th>Line</th>
                            <th>Shift</th>
                            <th>Planning Date</th>
                            <th><span class="badge bg-warning">POS 1</span></th>
                            <th><span class="badge bg-danger">POS 2</span></th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedArray as $groupKey => $employees)
                            @php
                                // Split the group key to get shift, line, and week
                                [$shift, $line, $start, $end] = explode('|', $groupKey);
                                $modalId = Str::slug($shift . $line . $start . $end);
                            @endphp
                            <tr>
                                <td>{{ $line }}</td>
                                <td>{{ $shift }}</td>
                                <td>{{ Carbon\Carbon::parse($start)->format('j F Y') }} -
                                    {{ Carbon\Carbon::parse($end)->format('j F Y') }}</td>
                                @foreach ($employees as $employee)
                                    <td>{{ $employee->name }}</td>
                                @endforeach
                                <td class="text-center">
                                    <a class="btn btn-secondary view-employee mb-1" data-bs-toggle="modal"
                                        data-bs-target="#{{ $modalId }}EmployeeDetail">
                                        <span class="rounded-3" id="icon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                    </a>
                                    <form
                                        action="{{ route('employee.planning.destroy', [
                                            'first_id' => $employees[0]->employee_id,
                                            'second_id' => $employees[1]->employee_id,
                                            'shift' => $employees[0]->shift_id,
                                            'line' => $employees[0]->line_id,
                                            'active_from' => $start,
                                        ]) }}"
                                        method="post" class="delete-button">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <span class="rounded-3" id="icon">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

    @foreach ($groupedArray as $groupKey => $employees)
        @php
            // Split the group key to get shift, line, and week
            [$shift, $line, $start, $end] = explode('|', $groupKey);
            $modalId = Str::slug($shift . $line . $start . $end);
        @endphp
        <div class="modal fade" id="{{ $modalId }}EmployeeDetail" tabindex="-1" role="dialog"
            aria-labelledby="employeeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            @foreach ($employees as $emp)
                                <div class="col-lg-6 col-md-12">
                                    <div class="text-center">
                                        <img src="{{ asset('uploads/doc/' . $emp->photo) }}" class="rounded-1 img-fluid"
                                            width="150">
                                        <div class="mt-n2">
                                            <span class="badge bg-primary">{{ $emp->role }}</span>
                                            <h3 class="card-title mt-3">{{ $emp->name }}</h3>
                                            <h6 class="card-subtitle mt-1">{{ $emp->npk }}
                                            </h6>
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <button class="btn btn-light-danger text-danger"
                                                        style="width: 100% !important">POS
                                                        {{ strtoupper($emp->pos) }}</button>
                                                </div>
                                            </div>
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
                                                            <div class="progress mb-2" style="height: 15px; width: 8vw">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: {{ $skill->level * 20 }}%;"
                                                                    aria-valuenow="{{ $skill->level }}" aria-valuemin="0"
                                                                    aria-valuemax="5">
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
        } else if (status == 'error') {
            toastr.error(message, "Error!", {
                progressBar: true,
            });
        } else {
            toastr.warning(message, "Warning!", {
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

        $('.repeater-pic-container').on('click', '.remove-pic-row', function() {
            if (confirm("Are you sure you want to remove this item?")) {
                $(this).closest('.row.mb-3').remove();
            }
        });

        // save line id at local storage
        $('#line').on('change', function() {
            localStorage.setItem('line', $(this).val());
        });

        $('.repeater-mp-container').on('change', '.pos', function() {
            localStorage.setItem('pos', $(this).closest('.repeater-mp-container').find(
                '.pos option:selected').val());
        });
        $('.repeater-mp-container').on('change', '.employee_name', function() {
            localStorage.setItem('employee', $(this).closest('.repeater-mp-container').find(
                '.employee_name option:selected').val())
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
                                `${item.skill.name}_${selectedOption.val()}`,
                                item
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

        // Define a named function
        function handleInputChange() {
            let pos = $(this).closest('.repeater-mp-container').find(
                '.pos option:selected').val();
            let employeeId = $(this).closest('.repeater-mp-container').find(
                '.employee_name option:selected').val();
            $.ajax({
                type: 'get',
                url: "{{ url('employee/getSkillPos') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    pos: localStorage.getItem('pos'),
                    employee: localStorage.getItem('employee'),
                    line: localStorage.getItem('line')
                },
                success: function(data) {
                    console.log(data);
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
                            let foundSkills = [];
                            // compare with skill id at local storage
                            for (let i = 0; i < localStorage.length; i++) {
                                let key = localStorage.key(i);
                                if (key.startsWith(item.skill.name) && key.endsWith(
                                        `_${localStorage.getItem('employee')}`)) {
                                    let employeeSkill = localStorage.getItem(key);
                                    let minimumSkills = item.skill.level;
                                    if (employeeSkill < minimumSkills) {
                                        console.log('level skill kurang')
                                        flag++;
                                    }
                                    foundSkills.push(item.skill
                                        .name); // Add the found skill to the array
                                }
                            }
                            // Check if all required skills are present
                            if (foundSkills.length < minimumSkillCount) {
                                localStorage.setItem('pass', false)
                                $(".submit-planning").prop("disabled", true);
                                notif('error', 'Skill tidak memenuhi kriteria pos!')
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
                    } else {
                        localStorage.setItem('pass', false)
                        $(".submit-planning").prop("disabled", true);
                        notif(data.status, data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        localStorage.setItem('pass', false)
                        notif("error", 'Connection Error');
                        return;
                    }
                    localStorage.setItem('pass', false)
                    $(".submit-planning").prop("disabled", true);
                    notif("error", 'Internal Server Error');
                }
            });
        }

        $('#addPlanning').on('click', function() {
            $("#addPlanningCard").toggle();

            $("#icon").html($("#addPlanningCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })

        // Handle click on delete button
        $('.delete-button').on('click', function() {
            // Show the confirmation modal
            $('#confirmationModal').modal('show');

            // Get the form action URL from the delete button's data attribute
            var actionUrl = $(this).data('action');

            // Set the action attribute of the confirmation form
            $('#confirmationForm').attr('action', actionUrl);
        });

        // Handle click on confirm delete button
        $('#confirmDelete').on('click', function() {
            // Submit the form for deletion
            $('#confirmationForm').submit();
        });

        var deleteForm; // Variable to store the form to be submitted

        // Handle click on delete button
        $('.delete-button').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Store the form associated with the delete button
            deleteForm = $(this).closest('form');

            // Show the confirmation modal
            $('#confirmationModal').modal('show');
        });

        // Handle click on confirm delete button
        $('#confirmDelete').on('click', function() {
            if (deleteForm) {
                // Submit the stored form for deletion
                deleteForm.submit();
            }
        });
    });
</script>
