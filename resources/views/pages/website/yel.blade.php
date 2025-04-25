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
                <h3 class="card-title mb-0">Add New yel-yel</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('yell.regist') }}" method="POST" class="mt-4">
                    @csrf
                    @method('POST')
                    <div class="email-repeater mb-3">
                        <div data-repeater-list="repeater-group">
                            <div data-repeater-item="" class="row mb-3">
                                <div class="col-lg-11 col-sm-12">
                                    <label class="mb-1">Name</label>
                                    <input type="text" class="form-control" placeholder="yel-yel" name="name"
                                        required>
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
                                Add yel-yel
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
                            Master yel-yel
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
                            <span class="d-none d-sm-inline-block">Add yel-yel</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table align-middle mb-0" id="masterYell" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item no. 1</th>
                            <th>Item no. 2</th>
                            <th>Item no. 3</th>
                            <th class="text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($yells as $yell)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                @foreach (['item_no_1', 'item_no_2', 'item_no_3'] as $item)
                                    <td>
                                        <span class="actual">{{ $yell->$item }}</span>
                                        <input class="form-control editActual" type="text" value="{{ $yell->$item }}"
                                            style="display: none; border-radius: 6px;">
                                    </td>
                                @endforeach

                                <td class="text-center">
                                    <button class="btn btn-icon btn-warning edit"><i class="far fa-edit"></i></button>
                                    <button class="btn btn-icon btn-success save mb-2" style="display: none"><i
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
        $('#masterYell').DataTable({
            scrollX: true,
        });

        $('#addSkill').on('click', function() {
            $("#addSkillCard").toggle();

            $("#icon").html($("#addSkillCard").is(":visible") ? '<i class="ti ti-minus"></i>' :
                '<i class="ti ti-plus"></i>');
        })
    });

    $(document).ready(function() {
        // Edit
        $(document).on('click', '#masterYell .edit', function() {
            let $row = $(this).closest('tr');

            $row.find('.actual').hide();
            $row.find('.editActual').show();

            $row.find('.save, .cancel').show();
            $row.find('.edit').hide();
        });

        // Save
        $(document).on('click', '#masterYell .save', function() {
            let $row = $(this).closest('tr');
            let changedItems = [];

            // Loop semua kolom .actual dan .editActual berpasangan
            $row.find('td').each(function(index) {
                const $actual = $(this).find('.actual');
                const $edit = $(this).find('.editActual');

                // Jika td ini punya elemen actual & editActual
                if ($actual.length && $edit.length) {
                    let oldValue = $actual.text().trim();
                    let newValue = $edit.val().trim();

                    if (oldValue !== newValue) {
                        // Tentukan nama kolom berdasarkan urutan
                        let column = 'item_no_' + (index); // item_no_1, _2, _3

                        changedItems.push({
                            old: oldValue,
                            new: newValue,
                            column: column
                        });
                    }
                }
            });

            if (changedItems.length === 0) {
                notif('info', 'Tidak ada perubahan data.');
                return;
            }

            // Kirim per item yang berubah (loop tiap perubahan)
            changedItems.forEach(function(change) {
                $.ajax({
                    url: `/yell/edit?old=${encodeURIComponent(change.old)}&new=${encodeURIComponent(change.new)}&column=${change.column}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            notif('success', data.message);
                        } else {
                            notif('error', data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        notif('error', 'Terjadi kesalahan AJAX: ' + error);
                    }
                });
            });

            // Setelah update, tampilkan nilai baru
            $row.find('.actual').each(function(i) {
                let newValue = $row.find('.editActual').eq(i).val();
                $(this).text(newValue).show();
            });

            $row.find('.editActual').hide();
            $row.find('.save, .cancel').hide();
            $row.find('.edit').show();
        });

        // Cancel
        $(document).on('click', '#masterYell .cancel', function() {
            let $row = $(this).closest('tr');

            $row.find('.actual').show();
            $row.find('.editActual').each(function(i) {
                $(this).val($(this).siblings('.actual').text()).hide();
            });

            $row.find('.save, .cancel').hide();
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
