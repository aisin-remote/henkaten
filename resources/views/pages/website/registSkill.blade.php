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
                <h3 class="card-title mb-0">Add New Skill/Job</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('skill.regist') }}" method="POST" class="mt-4 skillForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="origin" id="origin">
                    <div class="email-repeater mb-3">
                        <div data-repeater-list="repeater-group">
                            <div data-repeater-item="" class="row mb-3">
                                <div class="col-lg-11 col-sm-12">
                                    <label class="mb-1">Skill/Job Name</label>
                                    <input type="text" class="form-control" placeholder="Skill Name" name="name"
                                        required>
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
                            Registered Skill/Job
                        </h4>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-primary px-4 py-2" id="addSkill">
                            <span class="rounded-3 pe-2" id="icon">
                                <i class="ti ti-plus"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">Add Skill/Job</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-0" id="masterSkill" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masterSkill as $master)
                            <tr>
                                <td>
                                    <span class="actual">{{ $master->name }}</span>
                                    <input id="editActual" class="form-control editActual" type="text"
                                        value="{{ $master->name }}" data-width="100"
                                        style="border-radius:6px; display:none">
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-warning edit" id="edit"><i
                                            class="far fa-edit"></i></button>
                                    <button class="btn btn-icon btn-success save mb-1" style="display: none"><i
                                            class="fas fa-check"></i></button>
                                    <button class="btn btn-icon btn-danger cancel" style="display: none"><i
                                            class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
<script src="{{ asset('js/iziToast.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        var table = $('#masterSkill').DataTable({
            scrollX: true,
        });

        $('#addSkill').on('click', function() {
            $("#addSkillCard").toggle();

            $("#icon").html($("#addSkillCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })

        $('.skillForm').on('submit', function() {
            // Get the value from local storage
            const origin = localStorage.getItem('origin_id'); // replace with your key

            // Set the value to the hidden input
            $('#origin').val(origin);
        });

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
            // hide span
            $(this).closest('tr').find('.actual').hide();

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

        $(document).on('click', '#masterSkill .save', function() {
            let $row = $(this).closest('tr');

            // get customer part
            let old = $row.find('.actual').html();

            // get edit value
            let newActual = $row.find('.editActual').val();

            let requestOptions = {
                method: 'GET', // Adjust the method if needed
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token for security
                }
            };

            fetch(`/skill/edit/${old}/${newActual}`, requestOptions)
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

        $(document).on('click', '#masterSkill .cancel', function() {
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
</script>
