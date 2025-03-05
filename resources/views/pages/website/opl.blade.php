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
                <h3 class="card-title mb-0">OPL</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('form.submit') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="email-repeater mb-3">
                        <div data-repeater-list="repeater-group">
                            <div data-repeater-item="" class="row mb-3">
                                <div class="col-lg-11 col-sm-12">
                                    <label class="mb-1">Input File</label>
                                    <input type="file" class="form-control" placeholder="File" name="name" required>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <div class="mb-2" style="color: white">sss</div>
                                    <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light"
                                        type="button">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3">
                            <div class="d-flex align-items-center">
                                Add OPL
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
        <div class="card">
            <div class="card-header" style="background-color: white;">
                <div class="row">
                    <div class="col-10">
                        <h4 class="fw-4">
                            OPL
                            <h6 class="text-muted">
                                {{ Carbon\Carbon::now()->format('l, j F Y') }}
                            </h6>
                        </h4>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-primary px-4 py-2" id="addSkill">
                            <span class="rounded-3 pe-2" id="icon">
                                <i class="ti ti-plus"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">Add OPL</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-0" id="masterSkill" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opls as $opl)
                            @php
                                $filePath = asset('uploads/opl/' . $opl->file);
                                $fileExtension = strtolower(pathinfo($opl->file, PATHINFO_EXTENSION));
                            @endphp
                            <tr>
                                <td>{{ $opl->file }}</td>
                                <td>
                                    @if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']))
                                        <!-- Open in Modal -->
                                        <button class="btn btn-primary btn-sm view-file" data-file="{{ $filePath }}"
                                            data-type="{{ $fileExtension }}">
                                            View
                                        </button>
                                    @elseif (in_array($fileExtension, ['xls', 'xlsx', 'csv']))
                                        <!-- Download Excel -->
                                        <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>
                                            Download
                                        </a>
                                    @else
                                        <a href="{{ $filePath }}" class="btn btn-info btn-sm" target="_blank">
                                            View
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 100rem">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileViewer" src=""
                        style="width:100%; height:500px; border:none; display:none;"></iframe>
                    <img id="imageViewer" src="" style="max-width:100%; height:auto; display:none;" />
                </div>
            </div>
        </div>
    </div>
@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
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

        $(".view-file").click(function() {
            var fileSrc = $(this).data("file");
            var fileType = $(this).data("type");

            // Reset viewer
            $("#fileViewer").hide();
            $("#imageViewer").hide();

            // Show appropriate viewer
            if (fileType === "pdf") {
                $("#fileViewer").attr("src", fileSrc).show();
            } else {
                $("#imageViewer").attr("src", fileSrc).show();
            }

            // Show modal
            $("#fileModal").modal("show");
        });
    });

    $(document).ready(function() {
        $('.delete-skill').on('click', function(e) {
            // e.preventDefault();

            var id = $(this).data('min-id');

            if (confirm('Are you sure you want to delete this theme?')) {
                $.ajax({
                    type: 'POST',
                    url: `{{ url('/theme/${id}') }}`,
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
                        // window.location.reload();
                    }
                });
            }
        });
    });
</script>
