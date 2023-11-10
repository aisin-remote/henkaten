@extends('layouts.root.main')

@section('main')
<div class="row">
    <div class="card">
        <div class="card-header" style="background-color: white;">
            <div class="row">
                <div class="col-10">
                    <h4 class="fw-4">
                        Master Employee
                        <h6 class="text-muted">
                            {{ Carbon\Carbon::now()->format('l, j F Y') }}
                        </h6>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <table class="table text-nowrap align-middle mb-0" id="masterSkill" style="width:100%">
                <thead>
                    <tr>
                        <th>Photos</th>
                        <th>Name</th>
                        <th>NPK</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($masterEmployee as $emp)
                    <tr>
                        <td> <img src="{{ $emp->photo ? asset('uploads/doc/' . $emp->photo) : asset('path_to_default_image') }}" alt="" class="rounded-circle" width="60" height="60"> </td>
                        <td>{{ $emp->name }}</td>
                        <td>{{ $emp->npk }}</td>
                        <td>{{ $emp->role }}</td>
                        <td>{{ $emp->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        $('#masterSkill').DataTable({
            scrollX: true,
            columnDefs: [
                { orderable: false, targets: 0 } 
            ],
            order: [], 
        });
    });
</script>