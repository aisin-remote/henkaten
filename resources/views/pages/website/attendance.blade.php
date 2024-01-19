@extends('layouts.root.main')

@section('main')
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card shadow" style="padding: 40px;border-radius:16px">
                <div class="card bg-success">
                    <div class="row pb-4">
                        <div class="col-12 pt-4">
                            <h2 id="shift" class="text-center fw-bolder mb-3 text-white">{{ $shift->name }}</h2>
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="text-center text-white">Jam Masuk</h4>
                                    <h4 class="text-center text-white fw-bolder">
                                        {{ Carbon\Carbon::parse($shift->time_start)->format('H:i') }}</h4>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-center text-white">Jam Pulang</h4>
                                    <h4 class="text-center text-white fw-bolder">
                                        {{ Carbon\Carbon::parse($shift->time_end)->format('H:i') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
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
        <div class="col-md-6">
            <div class="card shadow-xs" style="padding: 40px; border-radius:16px">
                <div class="row">
                    <div class="col-12">
                        <table class="table text-nowrap align-middle mb-0 table-bordered" id="masterSkill"
                            style="width:100%; font-size: 12px">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Shift</th>
                                    <th class="align-middle">Time In</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
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
                                    <tr>
                                        <td>{{ $employee->employee->name }}</td>
                                        <td>{{ $employee->shift->name }}</td>
                                        @if ($attendance)
                                            <td class="text-center">{{ $attendance->attendance[0]->time_in }}</td>
                                            <td class="text-center">
                                                <span class="mb-1 badge bg-light-success text-success">
                                                    Hadir
                                                </span>
                                            </td>
                                        @else
                                            <td class="text-center">--:--</td>
                                            <td class="text-center">
                                                <span class="mb-1 badge bg-light-danger text-danger">
                                                    Belum hadir
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
