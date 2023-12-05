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

        @if (session()->has('warning'))
            <div class="alert alert-warning alert-dismissible bg-warning text-white border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                <strong>Warning - </strong> {{ session('warning') }}
            </div>
        @endif
        <div class="card shadow" id="addEmployeeCard" style="display: none">
            <div class="border-bottom title-part-padding">
                <h3 class="card-title mb-0">Add New Employee</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="mt-4"
                    id="employee-form">
                    @csrf
                    @method('POST')
                    <div class="">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <label class="mb-1">Employee</label>
                                <input type="text" class="form-control" placeholder="Employee Name" name="name"
                                    required>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <label class="mb-1">NPK</label>
                                <input type="text" class="form-control" placeholder="NPK" name="npk" required>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <label class="mb-1">Role</label>
                                <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="role" required>
                                    <option selected>-- select role --</option>
                                    <option value="Operator">Operator</option>
                                    <option value="JP">JP</option>
                                    <option value="Leader">Leader</option>
                                    <option value="SPV">SPV</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label class="mb-1">Employee Photo</label>
                                <input class="form-control" type="file" id="photo" name="photo" required>
                                <small class="text-danger">*Foto Karyawan</small>
                            </div>
                        </div>
                        <div class="position-relative text-center my-4">
                            <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                                Add employee skills below</p>
                            <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div>
                        <div class="repeater-container">
                            <div class="row mb-3">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="mb-1">Skill</label>
                                    <select class="select2 form-select select2-hidden-accessible"
                                        style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true"
                                        name="skill_name[]">
                                        <option value="0">Select</option>
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="mb-1">Level</label>
                                    <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="level[]">
                                        <option value="0">-- select level --</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <div class="mb-2" style="color: white">sss</div>
                                    <button class="btn btn-danger waves-effect waves-light remove-row" type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info waves-effect waves-light mb-3" id="addSkill">
                            <div class="d-flex align-items-center">
                                Add Skill
                                <i class="ti ti-circle-plus ms-1 fs-5"></i>
                            </div>
                        </button>
                        <div class="mb-3">
                            <button
                                class="btn rounded-pill px-4 btn-success text-light font-weight-medium waves-effect waves-light"
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
        <div class="card shadow">
            <div class="card-header" style="background-color: white !important">
                <div class="row">
                    <div class="col-10">
                        <h4 class="fw-4">
                            Registered Employee
                        </h4>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-primary px-4 py-2" id="addEmployee">
                            <span class="rounded-3 pe-2" id="icon">
                                <i class="ti ti-plus"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">Add Employee</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-0" id="masterSkill" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NPK</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masterEmployee as $emp)
                            @php
                                if ($emp->role == 'JP') {
                                    $color = 'danger';
                                } elseif ($emp->role == 'Operator') {
                                    $color = 'warning';
                                } else {
                                    $color = 'dark';
                                }
                            @endphp
                            <tr>
                                <td class="ps-0 text-truncate">
                                    <img src="{{ asset('uploads/doc/' . $emp->photo) }}" class="rounded img-fluid me-2"
                                        width="40" alt="{{ $emp->name }}">
                                    <span class="ps-2 fw-semibold">{{ $emp->name }}</span>
                                </td>
                                <td>{{ $emp->npk }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $color }} p-2 px-3">
                                        {{ $emp->role }}
                                    </span>
                                </td>
                                <td>
                                    <div
                                        style="background-color: lightgreen; width:10px; height:10px; border-radius:100%; display:inline-block; margin-right:2px">
                                    </div>
                                    {{ $emp->status }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning"
                                        href="{{ route('editEmployee', ['id' => $emp->id]) }}">
                                        <span class="rounded-3" id="icon">
                                            <i class="ti ti-pencil"></i>
                                        </span>
                                    </button>
                                    <button class="btn btn-secondary view-employee" data-bs-toggle="modal"
                                        data-bs-target="#employeeModal{{ $emp->id }}">
                                        <span class="rounded-3" id="icon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                    </button>
                                    <form action="{{ route('employee.destroy', ['id' => $emp->id]) }}" method="post"
                                        style="display: inline-block !important" class="delete-button" id="form-delete">
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
                            Are you sure you want to delete this employee?
                        </p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    @foreach ($masterEmployee as $emp)
        <div class="modal fade" id="employeeModal{{ $emp->id }}" tabindex="-1" role="dialog"
            aria-labelledby="employeeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-12">
                                <div class="text-center">
                                    <img src="{{ asset('uploads/doc/' . $emp->photo) }}" class="rounded-1 img-fluid"
                                        width="150">
                                    <div class="mt-n2">
                                        <span class="badge bg-primary">{{ $emp->role }}</span>
                                        <h3 class="card-title mt-3">{{ $emp->name }}</h3>
                                        <h6 class="card-subtitle">{{ $emp->npk }}</h6>
                                    </div>
                                    <div class="row mt-3 justify-content-center">
                                        <div class="col-6">
                                            <div class="py-2 px-3 bg-light rounded d-flex align-items-center">
                                                <div class="ms-2 text-start">
                                                    <h6 class="fw-normal text-muted mb-2">Skill</h6>
                                                    @foreach ($skills as $skill)
                                                        @php
                                                            $employeeSkillIds = $empSkills
                                                                ->where('employee_id', $emp->id)
                                                                ->pluck('skill_id')
                                                                ->all();
                                                            $employeeSkills = $allSkills->whereIn('id', $employeeSkillIds);
                                                        @endphp
                                                    @endforeach
                                                    @if (!$employeeSkills->isEmpty())
                                                        @foreach ($employeeSkills as $skill)
                                                            <h4 class="mb-0 fs-5">{{ $skill->name }}</h4>
                                                        @endforeach
                                                    @else
                                                        <span class="badge bg-warning">Tidak Memiliki Skill</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="py-2 px-3 bg-light rounded d-flex align-items-center">
                                                <div class="ms-2 text-start">
                                                    <h6 class="fw-normal text-muted mb-2">Level</h6>
                                                    @if (!$employeeSkills->isEmpty())
                                                        @foreach ($employeeSkills as $skill)
                                                            <div class="progress mb-2" style="height: 15px; width: 10vw">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: {{ $skill->level * 20 }}%;"
                                                                    aria-valuenow="{{ $skill->level }}" aria-valuemin="0"
                                                                    aria-valuemax="5">
                                                                    {{ $skill->level }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <span class="badge bg-warning">Tidak Memiliki Skill</span>
                                                    @endif
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
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('.view-employee').on('click', function() {
            // Menampilkan modal dengan ID yang sesuai
            var targetModal = $(this).data('bs-target');
            $(targetModal).modal('show');
        });
    });

    $(document).ready(function() {
        $('#addSkill').on('click', function() {
            var newRow = `<div class="row mb-3">
            <div class="col-lg-9 col-sm-12">
                <select class="select2 form-select select2-hidden-accessible"
                    style="width: 100%; height: 36px" tabindex="-1"
                    aria-hidden="true" id="themeSelect" name="skill_name[]">
                    <option value="0">Select</option>
                    @foreach ($skills as $skill)
                        <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-sm-12">
                <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="level[]">
                    <option selected value="0">-- select level --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="col-lg-1 col-sm-12">
                <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light remove-row"
                    type="button">
                    <i class="ti ti-circle-x fs-5"></i>
                </button>
            </div>
        </div>`;

            // Append the new row
            $('.repeater-container').append(newRow);

            // Initialize Select2 for the Select elements in the new row
            $('.repeater-container').find('.select2').select2();
        });

        $('.repeater-container').on('click', '.remove-row', function() {
            if (confirm("Are you sure you want to remove this item?")) {
                $(this).closest('.row.mb-3').remove();
            }
        });
    });

    $(document).ready(function() {
        // initialize datatable
        $('#masterSkill').DataTable({
            scrollX: true,
            columnDefs: [{
                orderable: false,
                targets: 0
            }],
            order: [],
        });

        $('input[name="npk"]').on('input', function() {
            var inputValue = $(this).val();
            if (inputValue.length < 6) {
                $(this).addClass('is-invalid');
                $(this).siblings('.error-message').remove();
                $(this).after(
                    '<span class="error-message text-danger">NPK harus terdiri dari 6 karakter</span>'
                );
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.error-message').remove();
            }
        });

        $('#employee-form').submit(function(event) {
            if ($('input[name="npk"]').val().length < 6) {
                event.preventDefault();
                $('input[name="npk"]').addClass('is-invalid');
                $('input[name="npk"]').siblings('.error-message').remove();
                $('input[name="npk"]').after(
                    '<span class="error-message text-danger">NPK harus terdiri dari 6 karakter</span>'
                );
            }
        });

        $('#addEmployee').on('click', function() {
            $("#addEmployeeCard").toggle();

            $("#icon").html($("#addEmployeeCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })

        let deleteForm; // Variable to store the form to be submitted

        // Handle click on delete button
        $('.delete-button').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Store the form associated with the delete button
            deleteForm = $(this).closest('form');

            // Show the confirmation modal
            $('#confirmationModal').modal('show');
        });

        // Handle click on confirm delete button
        $('#confirmDelete').on('click', function(event) {
            if (deleteForm) {
                // Submit the stored form for deletion
                console.log('Before submit');
                deleteForm.submit();
                console.log('After submit');
            }
        });
    });
</script>
