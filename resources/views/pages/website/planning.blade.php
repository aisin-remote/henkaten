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
                <form action="{{ route('employeePlanning.store') }}" method="POST" class="mt-4" id="planning-form">
                    @csrf
                    @method('POST')
                    @php
                        $flag = false;
                        $flag = $origin->name !== 'DC' ? true : false;
                    @endphp
                    <div class="row">
                        <input type="hidden" name="origin" id="origin">
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
                                        <option value="0">Select JP</option>
                                        @foreach ($pics as $pic)
                                            <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="repeater-mp-container">
                            @if ($flag === false)
                                @for ($i = 1; $i <= 2; $i++)
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="exampleInputPassword1"
                                                    class="form-label fw-semibold col-sm-3 col-form-label">Pos</label>
                                                <div class="col-9">
                                                    <input type="text" class="form-control" placeholder="Employee Name"
                                                        name="pos[]" value="Pos {{ $i }}" disabled>
                                                    <input type="hidden" class="form-control" placeholder="Employee Name"
                                                        name="pos[]" value="{{ $i }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <select class="select2 form-select select2-hidden-accessible employee_id"
                                                style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                                name="employee_id[]" required>
                                                <option value="0">Select Employee</option>
                                                @foreach ($operators as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="pb-1 text-muted">Active from</label>
                            <input type="date" class="form-control" placeholder="Designation" name="active_from" required
                                min="{{ date('Y-m-d') }}">
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
                            Employee Planning List This Week
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
                            <th class="text-center"><span class="badge bg-info">Employee List</span></th>
                            <th class="text-center">Action</th>
                            @if (request()->segment(3) == env('ORIGIN_ELC') ||
                                    request()->segment(3) == env('ORIGIN_SEAT') ||
                                    request()->segment(3) == env('ORIGIN_HANDLE'))
                                <th class="text-center">Change Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedArray as $groupKey => $employees)
                            @php
                                // Split the group key to get shift, line, and week
                                [$shift, $line, $start, $end, $line_id, $shift_id] = explode('|', $groupKey);
                                $modalId = Str::slug($shift . $line . $start . $end . $line_id . $shift_id);
                            @endphp
                            <tr>
                                <td class="w-20">
                                    <span class="actual-line line"
                                        data-line-id="{{ $line_id }}">{{ $line }}</span>
                                    <select id="editActualLine" class="form-select editActualLine"
                                        style="border-radius:6px; display:none">
                                        @foreach ($lines as $line)
                                            <option value="{{ $line->id }}">{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="w-20">
                                    <span class="actual shift"
                                        data-shift-id="{{ $shift_id }}">{{ $shift }}</span>
                                    <select id="editActual" class="form-select editActual"
                                        style="border-radius:6px; display:none">
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($start)->format('j F Y') }}
                                    -
                                    {{ Carbon\Carbon::parse($end)->format('j F Y') }}
                                    <input type="hidden" value="{{ $end }}" class="expired">
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="list-group">
                                                @foreach (array_slice($employees, 0, 4) as $employee)
                                                    <li class="list-group-item">
                                                        {{ $employee->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="list-group">
                                                @foreach (array_slice($employees, 4, 3) as $employee)
                                                    <li class="list-group-item">
                                                        {{ $employee->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-secondary view-employee mb-1" data-bs-toggle="modal"
                                        data-bs-target="#{{ $modalId }}EmployeeDetail">
                                        <span class="rounded-3" id="icon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                    </a>
                                    @php
                                        $employeeData = [];
                                        foreach ($employees as $employee) {
                                            array_push($employeeData, $employee->employee_id);
                                        }
                                        $data = [
                                            'employees_id' => $employeeData,
                                            'shift' => $employees[0]->shift_id,
                                            'line' => $employees[0]->line_id,
                                            'active_from' => $start,
                                        ];
                                    @endphp
                                    <form action="{{ route('employee.planning.destroy', $data) }}" method="post"
                                        class="delete-button">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <span class="rounded-3" id="icon">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                {{-- @if (request()->segment(3) == env('ORIGIN_ELC')) --}}
                                <td class="text-center" style="display: none" id="elc">
                                    <button class="btn btn-icon btn-warning edit fw-bolder" id="edit">
                                        Change Shift
                                    </button>
                                    <button class="btn btn-icon btn-success save mb-1" style="display: none">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger cancel mb-1" style="display: none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                                {{-- @elseif(request()->segment(3) == env('ORIGIN_SEAT') || request()->segment(3) == env('HANDLE')) --}}
                                <td class="text-center" style="display: none" id="body">
                                    <button class="btn btn-icon btn-warning fw-bolder edit-body" id="edit-body">
                                        Change Line/Shift
                                    </button>
                                    <button class="btn btn-icon btn-success save-body mb-1" style="display: none">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger cancel-body mb-1" style="display: none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                                {{-- @endif --}}
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
            [$shift, $line, $start, $end, $line_id, $shift_id] = explode('|', $groupKey);
            $modalId = Str::slug($shift . $line . $start . $end . $line_id . $shift_id);
        @endphp

        <div class="modal fade" id="{{ $modalId }}EmployeeDetail" tabindex="-1" role="dialog"
            aria-labelledby="employeeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="owl-carousel owl-theme" id="carousel_{{ $modalId }}">
                                @foreach ($employees as $emp)
                                    <div class="item" data-employee="{{ json_encode($emp) }}">
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/doc/' . $emp->photo) }}" class="rounded-1 img"
                                                width="150"
                                                style="width: 150px !important; margin-left: auto;
                                            margin-right: auto;"
                                                loading="lazy">
                                            <div class="mt-n2">
                                                <span class="badge bg-primary">{{ $emp->role }}</span>
                                                <h3 class="card-title mt-3">{{ $emp->name }}</h3>
                                                <h6 class="card-subtitle mt-1">{{ $emp->npk }}</h6>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
<script src="{{ asset('js/iziToast.min.js') }}"></script>
<script>
    // toast
    let employees = @json($operators);

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
        // initialize datatable
        var table = $('#henkatenHistory').DataTable({
            scrollX: true,
        });

        $('#addSkill').on('click', function() {
            $("#addSkillCard").toggle();

            $("#icon").html($("#addSkillCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })

        $('#planning-form').on('submit', function() {
            // Get the value from local storage
            const origin = localStorage.getItem('origin_id'); // replace with your key

            // Set the value to the hidden input
            $('#origin').val(origin);
        });

        const originId = localStorage.getItem('origin_id');
        const elcOrigin = "{{ env('ORIGIN_ELC') }}"; // Get the ORIGIN_ELC from the environment
        const seatOrigin = "{{ env('ORIGIN_SEAT') }}"; // Get the ORIGIN_ELC from the environment
        const handleOrigin = "{{ env('ORIGIN_HANDLE') }}"; // Get the ORIGIN_ELC from the environment

        // Conditionally display sections based on localStorage value
        if (originId == elcOrigin) {
            // Show the section for ORIGIN_ELC
            $('#elc').show();
        } else if (originId == seatOrigin || originId == handleOrigin) {
            // Show the section for other origins
            $('#body').show();
        }

        $(document).on('click', '#henkatenHistory .edit', function() {
            var $row = $(this).closest('tr');

            // hide span
            $(this).closest('tr').find('.actual').hide();

            var currentShiftValue = $row.find('.actual').data('shift-id');
            $row.find('.editActual').val(currentShiftValue);

            // show input
            $(this).closest('tr').find('.editActual').show();

            // show save button
            $(this).closest('tr').find('.save').css({
                display: 'inline'
            });

            // show cancel button
            $(this).closest('tr').find('.cancel').css({
                display: 'inline'
            });

            // hide edit button
            $(this).closest('tr').find('.edit').hide();
        });

        $(document).on('click', '#henkatenHistory .edit-body', function() {
            // Find the current row
            var $row = $(this).closest('tr');

            // Hide the span elements
            $row.find('.actual-line').hide();
            $row.find('.actual').hide();

            // Get the current value from the hidden actual-line element (make sure it's the correct element)
            var currentLineValue = $row.find('.actual-line').data('line-id');
            var currentShiftValue = $row.find('.actual').data('shift-id');

            // Set the select input to the current value (must match one of the option values)
            $row.find('.editActualLine').val(currentLineValue);
            $row.find('.editActual').val(currentShiftValue);

            // Show the input fields
            $row.find('.editActualLine').show();
            $row.find('.editActual').show();

            // Show save and cancel buttons
            $row.find('.save-body').css({
                display: 'inline'
            });
            $row.find('.cancel-body').css({
                display: 'inline'
            });

            // Hide the edit button
            $row.find('.edit-body').hide();
        });



        $(document).on('click', '#henkatenHistory .save', function() {
            let $row = $(this).closest('tr');

            let shift = $row.find('.shift').html();
            let line = $row.find('.line').html();
            let expired = $row.find('.expired').val();
            let newShift = $row.find('.editActual').val();

            let requestOptions = {
                method: 'GET', // Adjust the method if needed
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token for security
                }
            };

            fetch(`/employee/planning/changeShift/${line}/${shift}/${expired}/${newShift}`,
                    requestOptions)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        notif('success', data.message);

                        // update span content
                        $row.find('.actual').html(data.data).show();

                        // hide input
                        $row.find('.editActual').hide();

                        // hide save button
                        $row.find('.save').hide();

                        // hide cancel button
                        $row.find('.cancel').hide();

                        // show edit button
                        $row.find('.edit').show();

                    } else if (data.status === 'error') {
                        notif('error', data.message);
                    }
                })
                .catch(error => {
                    notif('error', error.message);
                });
        });

        $(document).on('click', '#henkatenHistory .save-body', function() {
            let $row = $(this).closest('tr');

            let shift = $row.find('.shift').html();
            let line = $row.find('.line').html();
            let expired = $row.find('.expired').val();
            let newShift = $row.find('.editActual').val();
            let newLine = $row.find('.editActualLine').val();

            let requestOptions = {
                method: 'GET', // Adjust the method if needed
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token for security
                }
            };

            fetch(`/employee/planning/changeShift/${line}/${shift}/${expired}/${newShift}/${newLine}`,
                    requestOptions)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        notif('success', data.message);

                        // update span content
                        $row.find('.actual').html(data.data).show();
                        $row.find('.actual-line').html(data.line).show();

                        // hide input
                        $row.find('.editActual').hide();
                        $row.find('.editActualLine').hide();

                        // hide save button
                        $row.find('.save-body').hide();

                        // hide cancel button
                        $row.find('.cancel-body').hide();

                        // show edit button
                        $row.find('.edit-body').show();

                    } else if (data.status === 'error') {
                        notif('error', data.message);
                    }
                })
                .catch(error => {
                    notif('error', error.message);
                });
        });

        $(document).on('click', '#henkatenHistory .cancel', function() {
            let $row = $(this).closest('tr');

            // show span
            $row.find('.actual').show();

            // hide input
            $row.find('.editActual').hide();

            // hide save button
            $row.find('.save').hide();

            // hide cancel button
            $row.find('.cancel').hide();

            // show edit button
            $row.find('.edit').show();
        });

        $(document).on('click', '#henkatenHistory .cancel-body', function() {
            let $row = $(this).closest('tr');

            // show span
            $row.find('.actual-line').show();
            $row.find('.actual').show();

            // hide input
            $row.find('.editActualLine').hide();
            $row.find('.editActual').hide();

            // hide save button
            $row.find('.save-body').hide();

            // hide cancel button
            $row.find('.cancel-body').hide();

            // show edit button
            $row.find('.edit-body').show();
        });

        function notif(type, message) {
            if (type === 'error') {
                iziToast.error({
                    title: 'Error!',
                    message: message,
                    position: 'bottomRight'
                });
            } else if (type === 'success') {
                iziToast.success({
                    title: 'Success!',
                    message: message,
                    position: 'bottomRight'
                });
            }
        }
    });

    $(document).ready(function() {
        let owl = $('.owl-carousel');
        owl.owlCarousel({
            margin: 20,
            autoplay: true,
            loop: owl.children().length > 1,
            autoWidth: false,
            touchDrag: true,
            nav: true,
            items: 1
        })
        // clear all local storage when page load
        function clearLocalStorageExcept(excludedKeys) {
            // Loop through all keys in local storage
            Object.keys(localStorage).forEach(key => {
                // If the current key is not in the excludedKeys array, remove it
                if (!excludedKeys.includes(key)) {
                    localStorage.removeItem(key);
                }
            });
        }

        // Usage
        const keysToKeep = ['origin_id'];
        clearLocalStorageExcept(keysToKeep);


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

        $('#line').on('change', function() {
            let line = $('#line option:selected').text();
            let area = line.substring(0, 2);
            let name;

            // if (area !== 'DC') {
            // ajax request get total employee in line
            $.ajax({
                type: 'get',
                url: "{{ url('line/employees') }}",
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    line: line
                },
                success: function(data) {
                    if (data.status == 'success') {

                        // add form based on employee
                        let html = '';
                        for (let i = 1; i <= data.total; i++) {
                            if (area === 'DS' && i == 1) {
                                name = 'Haito'
                                tag =
                                    `<input type="text" class="form-control" placeholder="Employee Name" name="pos[]" value="${name}" disabled>`
                            } else if (line === 'ASAN01' && i == 6) {
                                name = 'MH';
                                tag =
                                    `<input type="text" class="form-control" placeholder="Employee Name" name="pos[]" value="${name}" disabled>`;
                            } else {
                                name = 'Pos';
                                tag =
                                    `<input type="text" class="form-control" placeholder="Employee Name" name="pos[]" value="${name} ${i}" disabled>`
                            }
                            html += `
                        <div class="row mb-3">
                            <div class="col-lg-3 col-sm-12">
                                <div class="mb-4 row align-items-center">
                                    <label for="exampleInputPassword1" class="form-label fw-semibold col-sm-3 col-form-label">${name}</label>
                                    <div class="col-9">
                                        ${tag}
                                        <input type="hidden" class="form-control" placeholder="Employee Name" name="pos[]" value="${i}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <select class="select2 form-select select2-hidden-accessible employee_id" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="employee_id[]" required>
                                    <option value="0">Select Employee</option>`;

                            // Assuming employees is a JavaScript array
                            employees.forEach(employee => {
                                html +=
                                    `<option value="${employee.id}">${employee.name}</option>`;
                            });

                            html += `
                                </select>
                            </div>
                        </div>`;
                        }
                        // Check if the container element exists
                        let container = $('.repeater-mp-container');
                        if (container.length) {
                            container.html(html);
                            // Re-initialize select2
                            container.find('.select2').select2();
                        } else {
                            console.error("Container element not found");
                        }
                    } else {
                        notif(data.status, data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        localStorage.setItem('pass', false)
                        notif("error", 'Connection Error');
                        return;
                    }
                }
            });
            // }
        });

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
