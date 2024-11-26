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
                                Add Content
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
        <div class="card shadow p-3">
            <div class="card-header" style="background-color: white !important">
                <div class="row">
                    <div class="col-8">
                        <h4 class="fw-4">
                            Registered Henkaten Item
                        </h4>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <button class="btn btn-warning px-4 py-2 me-3" data-bs-toggle="modal"
                            data-bs-target="#bs-example-modal-sm">
                            <span class="rounded-3 pe-2" id="icon">
                                <i class="ti ti-plane"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">Import Henkaten Item</span>
                        </button>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($henkatenManagements as $master)
                            <tr>
                                <td>
                                    <span class="actualTable"
                                        data-table-id="{{ $master->table_no }}">{{ $master->table_no }}</span>
                                    <input type="text" class="form-control editTable" style="display: none">
                                </td>
                                <td>
                                    <span class="actual4M" data-type-id="{{ $master->{"4M"} }}">{{ $master->{"4M"} }}</span>
                                    <input type="text" class="form-control edit4M" style="display: none">
                                </td>
                                <td>
                                    <span class="actualItem"
                                        data-item-id="{{ $master->henkaten_item }}">{{ $master->henkaten_item }}</span>
                                    <input type="text" class="form-control editItem" style="display: none">
                                </td>
                                <td>
                                    <button class="btn btn-warning edit">
                                        <span class="rounded-3" id="icon">
                                            <i class="ti ti-edit"></i>
                                        </span>
                                    </button>
                                    <button class="btn btn-icon btn-success save mb-1" style="display: none">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger cancel mb-1" style="display: none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal import --}}
    <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="{{ route('henkaten.import') }}" method="POST" enctype="multipart/form-data"
                    class="me-2 importForm">
                    @method('POST')
                    @csrf
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Import Henkaten Item
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="origin" id="origin">
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary font-medium waves-effect">Import</button>
                        <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
<script src="{{ asset('js/iziToast.min.js') }}"></script>
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

        $('.importForm').on('submit', function() {
            // Get the value from local storage
            const origin = localStorage.getItem('origin_id'); // replace with your key

            // Set the value to the hidden input
            $('#origin').val(origin);
        });
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

        $(document).on('click', '#masterSkill .edit', function() {
            var $row = $(this).closest('tr');

            // hide span
            $(this).closest('tr').find('.actualTable').hide();
            $(this).closest('tr').find('.actual4M').hide();
            $(this).closest('tr').find('.actualItem').hide();

            var currentTableValue = $row.find('.actualTable').data('table-id');
            var current4MValue = $row.find('.actual4M').data('type-id');
            var currentItemValue = $row.find('.actualItem').data('item-id');

            $row.find('.editTable').val(currentTableValue);
            $row.find('.edit4M').val(current4MValue);
            $row.find('.editItem').val(currentItemValue);

            // show input
            $(this).closest('tr').find('.editTable').show();
            $(this).closest('tr').find('.edit4M').show();
            $(this).closest('tr').find('.editItem').show();

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

        $(document).on('click', '#masterSkill .cancel', function() {
            let $row = $(this).closest('tr');

            // show span
            $row.find('.actualTable').show();
            $row.find('.actual4M').show();
            $row.find('.actualItem').show();

            // hide input
            $row.find('.editTable').hide();
            $row.find('.edit4M').hide();
            $row.find('.editItem').hide();

            // hide save button
            $row.find('.save').hide();

            // hide cancel button
            $row.find('.cancel').hide();

            // show edit button
            $row.find('.edit').show();
        });

        $(document).on('click', '#masterSkill .save', function() {
            let $row = $(this).closest('tr');

            let table = $row.find('.actualTable').html();
            let type = $row.find('.actual4M').html();
            let item = $row.find('.actualItem').html();
            let newTable = $row.find('.editTable').val();
            let newType = $row.find('.edit4M').val();
            let newItem = $row.find('.editItem').val();

            let requestOptions = {
                method: 'GET', // Adjust the method if needed
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token for security
                }
            };

            fetch(`/henkatenManagement/edit/${table}/${type}/${item}/${newTable}/${newType}/${newItem}`,
                    requestOptions)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        notif('success', data.message);

                        // update span content
                        $row.find('.actualTable').html(data.table).show();
                        $row.find('.actual4M').html(data.type).show();
                        $row.find('.actualItem').html(data.item).show();

                        // hide input
                        $row.find('.editTable').hide();
                        $row.find('.edit4M').hide();
                        $row.find('.editItem').hide();

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
    });
</script>
