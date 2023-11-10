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
                                    <img src="{{ asset('uploads/doc/' . $emp->employee->photo) }}"
                                        class="rounded img-fluid me-2" width="40" alt="{{ $emp->employee->name }}">
                                    <span class="ps-2 fw-semibold">{{ $emp->employee->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $color }} p-2 px-3">
                                        {{ $emp->employee->role }}
                                    </span>
                                </td>
                                <td>{{ Carbon\Carbon::parse($emp->active_from)->format('j F Y') }} -
                                    {{ Carbon\Carbon::parse($emp->expired_at)->format('j F Y') }}</td>
                                <td>{{ $emp->line->name }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <button class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        $('#henkatenHistory').DataTable({
            scrollX: true,
        });
    });
</script>
