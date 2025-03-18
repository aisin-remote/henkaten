@extends('layouts.root.main')

@section('main')
    <style>
        .toggle-wrapper {
            position: relative;
            display: inline-block;
            width: 100px;
            height: 40px;
        }

        .toggle-input {
            display: none;
        }

        .toggle-label {
            display: block;
            width: 100%;
            height: 100%;
            background-color: #dc3545;
            border-radius: 20px;
            position: relative;
            cursor: pointer;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s;
        }

        .toggle-label::before {
            content: "Belum Hadir";
            position: absolute;
            width: 100%;
            text-align: center;
            transition: opacity 0.3s;
        }

        .toggle-input:checked+.toggle-label {
            background-color: #198754;
        }

        .toggle-input:checked+.toggle-label::before {
            content: "Hadir";
        }
    </style>
    <div class="row mt-1">
        <div class="col-md-2">
            <div class="card shadow" style="padding: 40px;border-radius:16px">
                <div class="card bg-warning">
                    <div class="row pb-4">
                        <div class="col-12 pt-4">
                            <h2 id="shift" class="text-center fw-bolder mb-1 text-white">{{ $shift->name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="code" type="text" class="form-control" placeholder="Scan here..."
                                    autofocus autocomplete="off">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-xs" style="padding: 40px; border-radius:16px">
                        <div class="row">
                            <div class="card bg-secondary">
                                <div class="row pb-4">
                                    <div class="col-12 pt-4">
                                        <h2 id="shift" class="text-center fw-bolder mb-1 text-white">
                                            JP
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($pics as $pic)
                            @php
                                $currentDate = Carbon\Carbon::now()->format('Y-m-d');
                                $attendance = $pic
                                    ->with('attendance')
                                    ->whereHas('attendance', function ($query) use ($pic, $currentDate) {
                                        $query
                                            ->where('pic_active_id', $pic->id)
                                            ->where('created_at', 'LIKE', $currentDate . '%');
                                    })
                                    ->has('attendance')
                                    ->first();

                            @endphp
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="d-flex gap-3">
                                    <img src="{{ asset('uploads/doc/' . $pic->employee->photo) }}"
                                        class="rounded-1 img-fluid" width="40" loading="lazy">
                                    <div>
                                        <h6 class="mb-1 fs-4 fw-semibold">{{ $pic->employee->name }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="status-container">
                                    @if ($attendance)
                                        <div class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="attendanceDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                                data-id="{{ $attendance->attendance[0]->id ?? '' }}">
                                                Hadir - [{{ $attendance->attendance[0]->time_in }}]
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item rollback-dropdown" href="#"
                                                        data-value="Belum Hadir">Belum
                                                        Hadir</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="dropdown">
                                            <button class="btn btn-danger dropdown-toggle" type="button"
                                                id="attendanceDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                                data-npk="{{ $pic->employee->npk ?? '' }}">
                                                Belum Hadir
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" data-value="Hadir">Hadir</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach ($lines as $line)
                    <div class="col-md-4">
                        <div class="card shadow-xs" style="padding: 40px; border-radius:16px">
                            <div class="row">
                                <div class="card bg-secondary">
                                    <div class="row pb-4">
                                        <div class="col-12 pt-4">
                                            <h2 id="shift" class="text-center fw-bolder mb-1 text-white">
                                                {{ $line->name }}</h2>
                                        </div>
                                    </div>
                                </div>
                                @if ($employees->has($line->id))
                                    @foreach ($employees[$line->id] as $employee)
                                        @php
                                            $currentDate = Carbon\Carbon::now()->format('Y-m-d');
                                            $attendance = $employee
                                                ->with('attendance')
                                                ->whereHas('attendance', function ($query) use (
                                                    $employee,
                                                    $currentDate,
                                                ) {
                                                    $query
                                                        ->where('employee_active_id', $employee->id)
                                                        ->where('created_at', 'LIKE', $currentDate . '%');
                                                })
                                                ->has('attendance')
                                                ->first();

                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between mt-4">
                                            <div class="d-flex gap-3">
                                                <img src="{{ asset('uploads/doc/' . $employee->employee->photo) }}"
                                                    class="rounded-1 img-fluid" width="40" loading="lazy">
                                                <div>
                                                    @if ($employee->line->name == $line->name)
                                                        <h6 class="mb-1 fs-4 fw-semibold">{{ $employee->employee->name }}
                                                        </h6>
                                                        <p class="fs-3 mb-0">POS {{ $employee->pos->pos }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="status-container">
                                                @if ($attendance)
                                                    {{-- @php
                                                        dd($attendance);
                                                    @endphp --}}
                                                    <div class="dropdown">
                                                        <button class="btn btn-success dropdown-toggle" type="button"
                                                            id="attendanceDropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                            data-id="{{ $attendance->attendance[0]->id ?? '' }}">
                                                            Hadir - [{{ $attendance->attendance[0]->time_in }}]
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item rollback-dropdown" href="#"
                                                                    data-value="Belum Hadir">Belum Hadir</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @else
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle" type="button"
                                                            id="attendanceDropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                            data-npk="{{ $employee->employee->npk ?? '' }}">
                                                            Belum Hadir
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Hadir">Hadir</a></li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted text-center">
                                        No active employees for this line.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        var table = $('#masterSkill').DataTable({
            scrollX: true,
        });

        const status = localStorage.getItem('notifStatus');
        const message = localStorage.getItem('notifMessage');

        if (status && message) {
            // Show the notification using your notif function
            notif(status, message);

            // Clear the stored notification so it doesn't show again
            localStorage.removeItem('notifStatus');
            localStorage.removeItem('notifMessage');
        }

        // toast
        function notif(status, message) {
            if (status == 'success') {
                toastr.success(message, "Success!", {
                    progressBar: true,
                });
            } else {
                toastr.error(message, "Error!", {
                    progressBar: true,
                });
            }
        }

        $(document).on('click', ".rollback-dropdown", function() {
            let selectedValue = $(this).data("value");
            let btn = $(this).closest(".dropdown").find("button");
            let id = btn.data("id"); // Retrieve `npk` from button's data attribute

            // Change text
            btn.text(selectedValue);

            // Change button color
            if (selectedValue === "Hadir") {
                btn.removeClass("btn-danger").addClass("btn-success");
            } else {
                btn.removeClass("btn-success").addClass("btn-danger");
            }

            // **Send AJAX request only if "Hadir" is selected**
            if (selectedValue === "Belum Hadir") {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('employee/attendance/rollback') }}",
                    _token: "{{ csrf_token() }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            // Store notification in localStorage
                            localStorage.setItem('notifStatus', data.status);
                            localStorage.setItem('notifMessage', data.message);

                            // Reload the page
                            window.location.reload();
                        } else {
                            notif(data.status, data.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        if (xhr.status === 0) {
                            notif("error", 'Connection Error');
                        } else {
                            notif("error", xhr.status);
                        }
                    }
                });
            }
        });

        $(document).on('click', ".dropdown-item", function() {
            let selectedValue = $(this).data("value");
            let btn = $(this).closest(".dropdown").find("button");
            let npk = btn.data("npk"); // Retrieve `npk` from button's data attribute

            // Change text
            btn.text(selectedValue);

            // Change button color
            if (selectedValue === "Hadir") {
                btn.removeClass("btn-danger").addClass("btn-success");
            } else {
                btn.removeClass("btn-success").addClass("btn-danger");
            }

            // **Send AJAX request only if "Hadir" is selected**
            if (selectedValue === "Hadir") {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('employee/attendance/store') }}",
                    _token: "{{ csrf_token() }}",
                    data: {
                        npk: npk,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            // Store notification in localStorage
                            localStorage.setItem('notifStatus', data.status);
                            localStorage.setItem('notifMessage', data.message);

                            // Reload the page
                            window.location.reload();
                        } else {
                            notif(data.status, data.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        if (xhr.status === 0) {
                            notif("error", 'Connection Error');
                        } else {
                            notif("error", xhr.status);
                        }
                    }
                });
            }
        });

        var barcode = "";
        $('#code').keypress(function(e) {
            e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                barcodecomplete = barcode;
                barcode = "";
                console.log(barcodecomplete.length)
                console.log(barcodecomplete)
                if (barcodecomplete.length === 13) {
                    // substr barcode
                    let npk = barcodecomplete.substr(0, 6);
                    // ajax request
                    $.ajax({
                        type: 'get',
                        url: "{{ url('employee/attendance/store') }}",
                        _token: "{{ csrf_token() }}",
                        data: {
                            npk: npk,
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'success') {
                                // Store the notification message and status in localStorage
                                localStorage.setItem('notifStatus', data.status);
                                localStorage.setItem('notifMessage', data.message);

                                window.location.reload(); // Reload after notification
                            } else {
                                notif(data.status, data.message);
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            if (xhr.status == 0) {
                                notif("error", 'Connection Error');
                                return;
                            }
                            notif("error", xhr.status);
                            return;
                        }
                    });
                } else {
                    notif('error', 'Barcode tidak sesuai!');
                }
            } else {
                barcode = barcode + String.fromCharCode(e.which);
            }
        });
    });
</script>
