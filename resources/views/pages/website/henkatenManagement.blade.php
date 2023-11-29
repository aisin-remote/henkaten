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
        <div class="card shadow" id="addSkillCard" style="display: none">
            <div class="border-bottom title-part-padding">
                <h3 class="card-title mb-0">Add New Henkaten Table Management</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('henkatenManagement.store') }}" method="POST" class="mt-4">
                    @csrf
                    @method('POST')
                    <div class="email-repeater mb-3">
                        <div data-repeater-list="repeater-group">
                            <div data-repeater-item="" class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="mb-1">Table Management No.</label>
                                    <input type="text" class="form-control" placeholder="Table No" name="table_no"
                                        required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="mb-1">4M</label>
                                    <select class="select form-select" style="width: 100%; height: 36px" tabindex="-1"
                                        aria-hidden="true" id="4M" name="4M" required>
                                        <option value="0">Select 4M</option>
                                        <option value="method">METHOD</option>
                                        <option value="man">MAN</option>
                                        <option value="machine">MACHINE</option>
                                        <option value="material">MATERIAL</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="mb-1">Henkaten Item Name</label>
                                    <input type="text" class="form-control" placeholder="Henkaten Item"
                                        name="henkaten_item" required>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <div class="mb-2" style="color: white">ccc</div>
                                    <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light"
                                        type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3">
                            <div class="d-flex align-items-center">
                                Add Skill
                                <i class="ti ti-circle-plus ms-1 fs-5"></i>
                            </div>
                        </button>
                    </div>
                    <div class="mb-3">
                        <button
                            class="btn rounded-pill px-4 btn-success text-light font-weight-medium waves-effect waves-light"
                            type="submit">
                            <i class="ti ti-send fs-5"></i>
                            Submit
                        </button>
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
                            Registered Henkaten Item
                        </h4>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-primary px-4 py-2" id="addSkill">
                            <span class="rounded-3 pe-2" id="icon">
                                <i class="ti ti-plus"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">Add Henkaten Item</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-0" id="masterSkill" style="width:100%">
                    <thead>
                        <tr>
                            <th>Table No.</th>
                            <th>4M</th>
                            <th>Henkaten Item</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($henkatenManagements as $master)
                            <tr>
                                <td>{{ $master->table_no }}</td>
                                <td>{{ $master->{"4M"} }}</td>
                                <td>{{ $master->henkaten_item }}</td>
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
        $('#masterSkill').DataTable({
            scrollX: true,
        });

        $('#addSkill').on('click', function() {
            $("#addSkillCard").toggle();

            $("#icon").html($("#addSkillCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })
    });

    $(document).ready(function() {
        $('.delete-skill').on('click', function(e) {
            e.preventDefault();

            var name = $(this).data('min-id');

            if (confirm('Are you sure you want to delete this skill?')) {
                $.ajax({
                    url: `{{ url('/skill/${name}') }}`,
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
                        console.error('Error deleting skill:', error);
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
