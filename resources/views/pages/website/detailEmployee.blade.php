@extends('layouts.root.main')

@section('main')
<div class="container">
    <div class="row">
        <div class="col-12">
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
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Employee Profile</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('uploads/doc/' . $employee->photo) }}" alt="{{ $employee->name }}" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                    </div>

                    <h4 class="mb-3">Personal Information</h4>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-sm-12">
                            <label for="name" class="form-label">Employee Name</label>
                            <p class="form-control-plaintext">{{ $employee->name }}</p>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <label for="npk" class="form-label">NPK</label>
                            <p class="form-control-plaintext">{{ $employee->npk }}</p>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label for="role" class="form-label">Role</label>
                            <p class="form-control-plaintext">{{ $employee->role }}</p>
                        </div>
                    </div>

                    <h4 class="mb-3">Skills</h4>
                    <div class="repeater-container">
                        @foreach ($skills as $skill)
                        <?php
                        $level = null;
                        $name = null;
                        ?>
                        @foreach ($allSkills as $s)
                        @if($skill->skill_id == $s->id)
                        <?php
                        $level = $s->level;
                        $name = $s->name;
                        ?>
                        @endif
                        @endforeach

                        <div class="row mb-3">
                            <div class="col-lg-9 col-sm-12">
                                <label for="skill" class="form-label">Skill</label>
                                <p class="form-control-plaintext">{{ $name }}</p>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <label for="level" class="form-label">Level</label>
                                <p class="form-control-plaintext">{{ $level }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection