@extends('layouts.root.main')

@section('main')
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
                                                ->whereHas('attendance', function ($query) use ($employee, $currentDate) {
                                                    $query->where('employee_active_id', $employee->id)->where('created_at', 'LIKE', $currentDate . '%');
                                                })
                                                ->has('attendance')
                                                ->first();

                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between mt-4">
                                            <div class="d-flex">
                                                <img src="{{ asset('uploads/doc/' . $employee->employee->photo) }}"
                                                    class="rounded-1 img-fluid" width="150">
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
                                                    <span
                                                        class="badge bg-success text-light fs-2 rounded-4 py-1 px-2 lh-sm mt-3 fw-bold status">
                                                        Hadir
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-light fs-2 rounded-4 py-1 px-2 lh-sm mt-3 fw-bold status">
                                                        Belum hadir
                                                    </span>
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
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        var table = $('#masterSkill').DataTable({
            scrollX: true,
        });

        $(document).on('click', function() {
            $('#code').focus()
        })

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

        var barcode = "";
        $('#code').keypress(function(e) {
            e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                barcodecomplete = barcode;
                barcode = "";
                if (barcodecomplete.length === 13) {
                    // substr barcode
                    let npk = barcodecomplete.substr(0, 6);
                    // ajax request
                    $.ajax({
                        type: 'get',
                        url: "{{ url('employee/attendance') }}",
                        _token: "{{ csrf_token() }}",
                        data: {
                            npk: npk,
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'success') {
                                window.location.reload();
                                setTimeout(() => {
                                    notif(data.status, data.message);
                                }, 2000);
                            } else {
                                notif(data.status, data.message);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status == 0) {
                                notif("error", 'Connection Error');
                                return;
                            }
                            notif("error", 'Internal Server Error');
                            return;
                        }
                    });
                } else {
                    notif('error', 'Scan ulang barcode!');
                }
            } else {
                barcode = barcode + String.fromCharCode(e.which);
            }
        });
    });
</script>
