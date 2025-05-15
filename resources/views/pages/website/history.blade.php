@extends('layouts.root.main')

@section('main')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-info shadow-xs" style="padding: 40px;padding-top:60px; border-radius:16px">
                <h3>Filter</h3>
                <p class="mb-3">Select field to filter</p>
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
                    <div class="col-8">
                        <h4 class="fw-4">
                            Henkaten History
                            <h6 class="text-muted">
                                {{ Carbon\Carbon::now()->format('l, j F Y') }}
                            </h6>
                        </h4>
                    </div>
                    <div class="col-4 text-end">
                        <form action="{{ route('henkaten.export') }}" method="GET">
                            <div class="row align-items-end">
                                <div class="col-md-4 text-center">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                                </div>

                                <div class="col-md-4 text-center">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                                </div>

                                <input type="hidden" name="origin_id"
                                    value="{{ $henkatenHistory->first()->line->origin_id }}">

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-info w-100">
                                        <i class="fas fa-file-excel me-2"></i>Export
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-0 table-bordered" id="masterSkill" font-size: 12px">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle"
                                style="position: -webkit-sticky;
                            position: sticky;
                            left: 0;
                            z-index: 1;">
                                Date</th>
                            <th rowspan="2" class="align-middle">Type</th>
                            <th rowspan="2" class="align-middle">Line</th>
                            <th rowspan="2" class="align-middle">Time</th>
                            <th rowspan="2" class="align-middle text-center" style="max-width: 300px">Abnormality</th>
                            <th rowspan="2" class="align-middle text-center">Henkaten Document</th>
                            <th rowspan="2" class="align-middle">Category</th>
                            <th rowspan="2" class="align-middle">Table Henkaten No.</th>
                            <th rowspan="2" class="align-middle text-center" style="max-width: 300px">
                                Troubleshoot
                            </th>
                            <th rowspan="2" class="align-middle text-center">Troubleshoot Document</th>
                            <th rowspan="2" class="align-middle text-center">Troubleshoot Time</th>
                            <th rowspan="2" class="align-middle text-center">status</th>
                            <th class="text-center">Safety</th>
                            <th colspan="4" class="text-center">Quality Inspection</th>
                            <th rowspan="2" class="align-middle text-center">Done by</th>
                            <th colspan="3" class="align-middle text-center">Approval</th>
                        </tr>
                        <tr>
                            <th>Result Check</th>
                            <th>Report Abnormality</th>
                            <th class="text-center">Part</th>
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
                                <td
                                    style="position: -webkit-sticky;
                                position: sticky;
                                left: 0;
                                z-index: 1; background-color: #f9f9f9;">
                                    {{ Carbon\Carbon::parse($henkaten->date)->format('Y-m-d') }}</td>
                                <td>{{ strtoupper($henkaten->{"4M"}) }}</td>
                                <td>{{ $henkaten->line->name }}</td>
                                <td>{{ Carbon\Carbon::parse($henkaten->date)->format('H:i:s') }}</td>
                                <td style="max-width: 300px; white-space: normal;">{{ $henkaten->abnormality }}</td>
                                <td class="text-center">
                                    @if ($henkaten->photo)
                                        @if (pathinfo($henkaten->photo, PATHINFO_EXTENSION) === 'xlsx' ||
                                                pathinfo($henkaten->photo, PATHINFO_EXTENSION) === 'xls')
                                            <button class="btn btn-info">
                                                <a href="{{ asset('uploads/ts_henkaten/' . $henkaten->photo) }}" download
                                                    style="color: white">
                                                    Download File
                                                </a>
                                            </button>
                                        @else
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#{{ $henkaten->id }}Photo">
                                                Show File
                                            </button>
                                        @endif
                                    @else
                                        No Document
                                    @endif
                                </td>
                                <td>{{ $henkaten->category }}</td>
                                <td class="text-center">{{ optional($henkaten->henkatenManagement)->table_no }}</td>
                                @php
                                    if ($henkaten->troubleshoot === null) {
                                        $colorApp = 'danger';
                                        $text = 'Waiting Troubleshoot';
                                    }
                                @endphp
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

                                        if ($henkaten->approval->ldr !== null) {
                                            $colorApp = 'success';
                                            $text = 'solved';
                                        } else {
                                            $colorApp = 'warning';
                                            $text = 'Pending Approval';
                                        }

                                        $userRole = auth()->user()->role;
                                        $isLeader = $userRole === 'LDR';
                                        $isSupervisor = $userRole === 'SPV';
                                        $isManager = $userRole === 'MGR';

                                        $ldrApproved = $henkaten->approval->ldr !== null;
                                        $spvApproved = $henkaten->approval->spv !== null;
                                        $mgrApproved = $henkaten->approval->mgr !== null;
                                    @endphp
                                    <td style="max-width: 300px; white-space: normal;">
                                        {{ $henkaten->troubleshoot ? $henkaten->troubleshoot->troubleshoot : 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($henkaten->troubleshoot->photo)
                                            @if (pathinfo($henkaten->troubleshoot->photo, PATHINFO_EXTENSION) === 'xlsx' ||
                                                    pathinfo($henkaten->troubleshoot->photo, PATHINFO_EXTENSION) === 'xls')
                                                <button class="btn btn-info">
                                                    <a href="{{ asset('uploads/ts_henkaten/' . $henkaten->troubleshoot->photo) }}"
                                                        download style="color: white">
                                                        Download File
                                                    </a>
                                                </button>
                                            @else
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#{{ $henkaten->troubleshoot->id }}Photo">
                                                    Show File
                                                </button>
                                            @endif
                                        @else
                                            No Document
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="d-block fw-bold text-dark">
                                            {{ Carbon\Carbon::parse($henkaten->troubleshoot->created_at)->format('Y-m-d') }}
                                        </span>
                                        <span class="text-primary small fw-bold">
                                            {{ Carbon\Carbon::parse($henkaten->troubleshoot->created_at)->format('H:i:s') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $colorApp }}">
                                            {{ $text }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-light-{{ $colorResult }} text-{{ $colorResult }}">{{ $henkaten->troubleshoot->result_check }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $henkaten->troubleshoot->inspection_report }}</td>
                                    <td class="text-center">{{ $henkaten->troubleshoot->part }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-light-{{ $colorBefore }} text-{{ $colorBefore }}">{{ $henkaten->troubleshoot->before_treatment }}</span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge bg-light-{{ $colorAfter }} text-{{ $colorAfter }}">{{ $henkaten->troubleshoot->after_treatment }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $henkaten->troubleshoot->employee->name ?? $henkaten->troubleshoot->done_by }}
                                    </td>
                                    @php
                                        $approvals = [
                                            'ldr' => [
                                                'approved' => $henkaten->approval->ldr,
                                                'waiting' => null,
                                                'canApprove' => $isLeader,
                                            ],
                                            'spv' => [
                                                'approved' => $henkaten->approval->spv,
                                                'waiting' => !$ldrApproved ? 'Waiting LDR' : null,
                                                'canApprove' => $isSupervisor,
                                            ],
                                            'mgr' => [
                                                'approved' => $henkaten->approval->mgr,
                                                'waiting' => !$ldrApproved
                                                    ? 'Waiting LDR'
                                                    : (!$spvApproved
                                                        ? 'Waiting SPV'
                                                        : null),
                                                'canApprove' => $isManager,
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($approvals as $role => $data)
                                        <td class="text-center">
                                            @if ($data['approved'])
                                                <span class="btn btn-success fw-bolder" data-toggle="tooltip"
                                                    title="approved by {{ $data['approved'] }}">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                            @else
                                                @if ($data['waiting'])
                                                    <button class="btn btn-danger approve"
                                                        data-history-id="{{ $henkaten->id }}" disabled>
                                                        {{ $data['waiting'] }}
                                                    </button>
                                                @elseif ($data['canApprove'])
                                                    <button class="btn btn-danger approve"
                                                        data-history-id="{{ $henkaten->id }}">
                                                        Approve
                                                    </button>
                                                @else
                                                    <button class="btn btn-danger approve"
                                                        data-history-id="{{ $henkaten->id }}" disabled>
                                                        Waiting {{ strtoupper($role) }}
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                @else
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">N/A</td>
                                    <td class="text-center text-danger">
                                        <span class="badge bg-{{ $colorApp }}">
                                            {{ $text }}
                                        </span>
                                    </td>
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

    @foreach ($henkatenHistory as $henkaten)
        {{-- modal approve --}}
        <div class="modal fade modal-md" id="{{ $henkaten->id }}Approve" tabindex="-1"
            aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Approval
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.troubleshootApproval') }}" method="POST"
                        class="mt-3 henkatenApproval">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <input type="hidden" name="origin" id="origin-approval">
                            <input type="hidden" name="henkaten_id" value="{{ $henkaten->id }}">
                            <input type="hidden" name="line" value="{{ $henkaten->line_id }}">
                            <input type="hidden" name="4M" value="{{ $henkaten->{"4M"} }}">
                            <input type="hidden" name="status" value="{{ $henkaten->status }}">
                            Do you really want to approve?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary approveSubmitButton">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                <span class="button-text">Approve</span>
                            </button>
                            <button type="button"
                                class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of modal --}}

        @if ($henkaten)
            <div class="modal fade modal-lg" id="{{ $henkaten->id }}Photo" tabindex="-1"
                aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myLargeModalLabel">
                                Document
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            <img src="{{ asset('uploads/ts_henkaten/' . $henkaten->photo) }}" alt=""
                                class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($henkaten->troubleshoot)
            <div class="modal fade modal-lg" id="{{ $henkaten->troubleshoot->id }}Photo" tabindex="-1"
                aria-labelledby="bs-example-modal-xl" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myLargeModalLabel">
                                Document
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            <img src="{{ asset('uploads/ts_henkaten/' . $henkaten->troubleshoot->photo) }}"
                                alt="" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach


@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        let table = $('#masterSkill').DataTable({
            scrollX: true,
            order: [
                [0, 'desc']
            ]
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

        $(document).on('click', '.approve', function() {
            const historyId = $(this).data('history-id');
            $(`#${historyId}Approve`).modal('show');
        });

        $('.henkatenApproval').submit(function() {
            const submitButton = $(this).find('.approveSubmitButton');
            const spinner = submitButton.find('.spinner-border');
            const buttonText = submitButton.find('.button-text');

            // Disable button, show spinner, and change text to "Loading..."
            submitButton.prop('disabled', true);
            spinner.removeClass('d-none');
            buttonText.text('Loading...');
            const origin = localStorage.getItem('origin_id'); // replace with your key

            // Set the value to the hidden input
            $('#origin-approval').val(origin);

            return true
        });

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
