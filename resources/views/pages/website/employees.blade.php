@extends('layouts.root.main')

@section('main')
<div class="row">
    <div class="card">
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
            </div>
        </div>
        <div class="card-body p-3">
            <table class="table text-nowrap align-middle mb-0" id="henkatenHistory" style="width:100%">
                <thead>
                    <tr>
                        <th>Shift</th>
                        <th>Name</th>
                        <th>role</th>
                        <th>Active Date</th>
                        <th>Line</th>
                        <th>Henkaten History</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $emp)
                    @php
                    if ($emp->employee->role == 'JP') {
                    $color = 'danger';
                    } else {
                    $color = 'warning';
                    }
                    @endphp
                    <tr>
                        <td>{{ $emp->shift->name }}</td>
                        <td class="ps-0 text-truncate">
                            <img src="{{ asset('uploads/doc/' . $emp->employee->photo) }}" class="rounded img-fluid me-2" width="40" alt="{{ $emp->employee->name }}">
                            <span class="ps-2 fw-semibold">{{ $emp->employee->name }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $color }} p-2 px-3">
                                {{ $emp->employee->role }}
                            </span>
                        </td>
                        <td>{{ Carbon\Carbon::parse($emp->active_from)->format('j F Y') }} -
                            {{ Carbon\Carbon::parse($emp->expired_at)->format('j F Y') }}
                        </td>
                        <td>{{ $emp->line->name }}</td>
                        <td>
                            <div class="progress" style="height: 20px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 25%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-primary view-employee" data-bs-toggle="modal" data-bs-target="#employeeModal{{ $emp->id }}">Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($employees as $emp)
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
                                <h6 class="card-subtitle">{{ Carbon\Carbon::parse($emp->active_from)->format('j F Y') }} -
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
                                            $employeeSkillIds = $empSkills->where('employee_id', $emp->employee_id)->pluck('skill_id')->all();
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
    $(document).ready(function() {
        // initialize datatable
        $('#henkatenHistory').DataTable({
            scrollX: true,
        });
    });

    $(document).ready(function() {
        $('.view-employee').on('click', function() {
            // Menampilkan modal dengan ID yang sesuai
            var targetModal = $(this).data('bs-target');
            $(targetModal).modal('show');
        });
    });
</script>