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
            <h3 class="card-title mb-0">Edit Employee</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('employee.update', ['id' => $employee->id]) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('POST')
                <div class="">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <input type="text" class="form-control" placeholder="Employee Name" name="name" value="{{ $employee->name }}" required>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <input type="text" class="form-control" placeholder="NPK" name="npk" value="{{ $employee->npk }}" required>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="role" required>
                                <option value="Operator" {{ $employee->role === 'Operator' ? 'selected' : '' }}>Operator</option>
                                <option value="JP" {{ $employee->role === 'JP' ? 'selected' : '' }}>JP</option>
                                <option value="Leader" {{ $employee->role === 'Leader' ? 'selected' : '' }}>Leader</option>
                                <option value="SPV" {{ $employee->role === 'SPV' ? 'selected' : '' }}>SPV</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <input class="form-control" type="file" id="photo" name="photo" value="{{ $employee->photo }}">
                            <small class="text-danger">*Update if you want to change the employee's photo</small>
                        </div>
                    </div>
                    <div class="position-relative text-center my-4">
                        <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                            Edit employee skills below</p>
                        <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                    </div>
                    <div class="repeater-container">
                        @foreach ($skills as $skill)
                        <div class="row mb-3">
                            <div class="col-lg-9 col-sm-12">
                                <select class="select2 form-select select2-hidden-accessible" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="skill_name[]">
                                    <option value="0">Select</option>
                                    @foreach ($allSkills as $s)
                                    @if($skill->skill_id == $s->id)
                                    <?php
                                    $level = $s->level;
                                    $name = $s->name;
                                    ?>
                                    @endif>
                                    @endforeach
                                    @foreach ($nameSkills as $skill)
                                    <option value="{{ $skill->name }}" {{ $name === $skill->name ? 'selected' : '' }}>{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="level[]">
                                    <option value="" disabled> Select </option>
                                    <option value="1" {{ $level === "1" ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $level === "2" ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $level === "3" ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $level === "4" ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $level === "5" ? 'selected' : '' }}>5</option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-sm-12">
                                <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light remove-row" type="button">
                                    <i class="ti ti-circle-x fs-5"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-info waves-effect waves-light mb-3" id="addSkill">
                        <div class="d-flex align-items-center">
                            Add Skill
                            <i class="ti ti-circle-plus ms-1 fs-5"></i>
                        </div>
                    </button>
                    <div class="mb-3">
                        <button class="btn rounded-pill px-4 btn-success text-light font-weight-medium waves-effect waves-light" type="submit">
                            <i class="ti ti-send fs-5"></i>
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#addSkill').on('click', function() {
            var newRow = `<div class="row mb-3">
            <div class="col-lg-9 col-sm-12">
                <select class="select2 form-select select2-hidden-accessible"
                    style="width: 100%; height: 36px" tabindex="-1"
                    aria-hidden="true" id="themeSelect" name="skill_name[]">
                    <option value="0">Select</option>
                    @foreach ($nameSkills as $skill)
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
</script>