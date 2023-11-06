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
        <div class="card shadow">
            <div class="border-bottom title-part-padding">
                <h3 class="card-title mb-0">Weekly Employees Planning</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('employeePlanning.store') }}" method="POST" class="mt-4">
                    @csrf
                    @method('POST')
                    <div class="">
                        <div class="col-12 mb-3">
                            <select class="select2 form-select select2-hidden-accessible" style="width: 100%; height: 36px"
                                tabindex="-1" aria-hidden="true" id="shift" name="shift" required>
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
                                <div class="col-lg-11 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible"
                                        style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" id="pic_name"
                                        name="pic_name[]" required>
                                        <option>Select PIC</option>
                                        @foreach ($pics as $pic)
                                            <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <button data-repeater-delete=""
                                        class="btn btn-danger waves-effect waves-light remove-pic-row" type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3"
                            id="addPic">
                            <div class="d-flex align-items-center">
                                Add PIC
                                <i class="ti ti-circle-plus ms-1 fs-5"></i>
                            </div>
                        </button>
                        <div class="repeater-mp-container">
                            <div class="row mb-3">
                                <div class="col-lg-9 col-sm-12">
                                    <select class="select2 form-select select2-hidden-accessible employee_name"
                                        style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                        name="employee_name[]" required>
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
                                        <option value="lastman">Lastman</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <button data-repeater-delete=""
                                        class="btn btn-danger waves-effect waves-light remove-mp-row" type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3"
                            id="addMp">
                            <div class="d-flex align-items-center">
                                Add MP
                                <i class="ti ti-circle-plus ms-1 fs-5"></i>
                            </div>
                        </button>
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

    $(document).ready(function() {
        // clear all local storage when page load
        localStorage.clear();

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
                                        <option value="lastman">Lastman</option>
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
                                    <select class="select2 form-select select2-hidden-accessible"
                                        style="width: 100%; height: 36px"
                                        tabindex="-1" aria-hidden="true" id="pic_name" name="pic_name[]" required>
                                        <option>Select PIC</option>
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
                        console.log(minimumSkills);
                        if (minimumSkillCount == 0) {
                            console.log('test1')
                            flag++;
                        }

                        if (minimumSkillCount !== skillCount) {
                            console.log('test2')
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
                                        console.log('test3')
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
    });
</script>
