@extends('layouts.root.main')

@section('main')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-info shadow-xs" style="padding: 40px;padding-top:60px; border-radius:16px">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="select form-control" data-select2-id="select2-data-1-ok7p" tabindex="-1"
                                    aria-hidden="true" id="line">
                                    <option data-select2-id="select2-data-3-mma1" selected disabled>-- Select Line --
                                    </option>
                                    @foreach ($lines as $line)
                                        <option value="{{ $line->name }}">{{ $line->name }}</option>
                                    @endforeach
                                </select>
                                <select class="select form-control" id="type">
                                    <option selected disabled>-- Select Type --</option>
                                    <option value="MAN">MAN</option>
                                    <option value="METHOD">METHOD</option>
                                    <option value="MATERIAL">MATERIAL</option>
                                    <option value="MACHINE">MACHINE</option>
                                </select>
                                <input id="date" type="date" class="form-control" placeholder="Delivery date">
                                <button class="btn btn-light-danger text-danger font-medium" id="reset"
                                    type="button">Reset</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: white;">
                <div class="row">
                    <div class="col-10">
                        <h4 class="fw-4">
                            Henkaten History
                            <h6 class="text-muted">
                                {{ Carbon\Carbon::now()->format('l, j F Y') }}
                            </h6>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-0 table-bordered" id="masterSkill"
                    style="width:100%; font-size: 12px">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle">Date</th>
                            <th rowspan="2" class="align-middle">Type</th>
                            <th rowspan="2" class="align-middle">Line</th>
                            <th rowspan="2" class="align-middle">Time</th>
                            <th rowspan="2" class="align-middle">Abnormality</th>
                            <th rowspan="2" class="align-middle">Category</th>
                            <th rowspan="2" class="align-middle">Table Henkaten No.</th>
                            <th rowspan="2" class="align-middle text-center">Troubleshoot</th>
                            <th class="text-center">Safety</th>
                            <th colspan="4" class="text-center">Quality Inspection</th>
                            <th rowspan="2" class="align-middle">Done by</th>
                            <th colspan="3" class="align-middle text-center">Approval</th>
                        </tr>
                        <tr>
                            <th>Result Check</th>
                            <th>Report Abnormality</th>
                            <th>Part</th>
                            <th>Before</th>
                            <th>After</th>
                            <th class="text-center">Leader</th>
                            <th class="text-center">Supervisor</th>
                            <th class="text-center">Manager</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($henkatenHistory as $henkaten)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($henkaten->date)->format('Y-m-d') }}</td>
                                <td>{{ strtoupper($henkaten->{"4M"}) }}</td>
                                <td>{{ $henkaten->line->name }}</td>
                                <td>{{ Carbon\Carbon::parse($henkaten->date)->format('H:i:s') }}</td>
                                <td>{{ $henkaten->abnormality }}</td>
                                <td>{{ $henkaten->category }}</td>
                                <td class="text-center">{{ $henkaten->henkatenManagement->table_no }}</td>
                                @if ($henkaten->troubleshoot !== null)
                                    @php
                                        if ($henkaten->troubleshoot->before_treatment == 'ng') {
                                            $colorBefore = 'danger';
                                        } else {
                                            $colorBefore = 'success';
                                        }

                                        if ($henkaten->troubleshoot->after_treatment == 'ng') {
                                            $colorAfter = 'danger';
                                        } else {
                                            $colorAfter = 'success';
                                        }

                                        if ($henkaten->troubleshoot->result_check == 'ng') {
                                            $colorResult = 'danger';
                                        } else {
                                            $colorResult = 'success';
                                        }
                                    @endphp
                                    <td class="text-center">
                                        {{ $henkaten->troubleshoot ? $henkaten->troubleshoot->troubleshoot : 'N/A' }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-{{ $colorResult }}">{{ $henkaten->troubleshoot->result_check }}</span>
                                    </td>
                                    <td class="text-center">{{ $henkaten->troubleshoot->inspection_report }}</td>
                                    <td class="text-center">{{ $henkaten->troubleshoot->part }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-{{ $colorBefore }}">{{ $henkaten->troubleshoot->before_treatment }}</span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge bg-{{ $colorAfter }}">{{ $henkaten->troubleshoot->after_treatment }}</span>
                                    </td>
                                    <td class="text-center">{{ $henkaten->troubleshoot->employee->name }}</td>
                                    <td class="text-center">
                                        {{ $henkaten->approval->ldr !== null ? 'Approved by ' . $henkaten->approval->ldr : 'Waiting...' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $henkaten->approval->spv !== null ? 'Approved by ' . $henkaten->approval->spv : 'Waiting...' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $henkaten->approval->mgr !== null ? 'Approved by ' . $henkaten->approval->mgr : 'Waiting...' }}
                                    </td>
                                @else
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                @endif
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
        let table = $('#masterSkill').DataTable({
            scrollX: true,
        });

        $('#line').on('change', function() {
            // get all filter values
            let line = $('#line').val();

            if (line) {
                table.column(2).search(line);
            } else {
                table.column(2).search('');
            }

            table.draw();
        })

        $('#type').on('change', function() {
            // get all filter values
            let type = $('#type').val();

            if (type) {
                table.column(1).search(type);
            } else {
                table.column(1).search('');
            }

            table.draw();
        })

        $('#date').on('change', function() {
            // get all filter values
            let date = $('#date').val();

            if (date) {
                table.column(0).search(date);
            } else {
                table.column(0).search('');
            }

            table.draw();
        })

        $('#reset').on('click', function() {
            $('#line').val('-- Select Line --').trigger(
                'change'); // Reset the filter and trigger change event
            $('#type').val('-- Select Type --').trigger(
                'change'); // Reset the filter and trigger change event
            $('#date').val('').trigger(
                'change'); // Reset the filter and trigger change event
        });
    });
</script>
