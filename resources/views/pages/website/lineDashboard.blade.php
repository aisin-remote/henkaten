@extends('layouts.root.main')
<style>
    /* Style for the toggle switch */
    .form-switch input[type="checkbox"] {
        position: relative;
        width: 50px;
        height: 25px;
        -webkit-appearance: none;
        appearance: none;
        background-color: #ddd;
        outline: none;
        cursor: pointer;
        border-radius: 50px;
        transition: background-color 0.3s ease;
    }

    /* Toggle circle (inside the switch) */
    .form-switch input[type="checkbox"]::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        top: 2.5px;
        left: 2.5px;
        background-color: #fff;
        transition: left 0.3s ease;
    }

    /* Toggle switch active state (pastel green) */
    .form-switch input[type="checkbox"]:checked {
        background-color: #b0e57c;
        /* Pastel green */
    }

    /* Move the circle when checked */
    .form-switch input[type="checkbox"]:checked::before {
        left: 27.5px;
    }
</style>


@section('main')
    <div class="row">
        @foreach ($lines as $line)
            <div class="col-md-12 col-lg-4 dc-card" id="{{ $line->id }}">
                <div class="card overflow-hidden shadow card-hover" style="width:100%">
                    <div class="card-body bg-info text-white text-center p-10">
                        <div class="d-inline-block">
                            <h3 class="text-light fw-bolder">{{ $line->name }}</h3>
                        </div>
                    </div>
                    @php
                        $statusMappings = [
                            'running' => [
                                'priority' => 1,
                                'overall' => 'RUNNING',
                                'shape' => 'circle',
                                'color' => 'success',
                            ],
                            'henkaten' => [
                                'priority' => 2,
                                'overall' => 'HENKATEN',
                                'shape' => 'triangle',
                                'color' => 'warning',
                            ],
                            'stop' => ['priority' => 3, 'overall' => 'STOP', 'shape' => 'x', 'color' => 'danger'],
                            'off' => ['priority' => 4, 'overall' => 'OFF', 'shape' => 'zzz', 'color' => 'dark'],
                        ];

                        // summaery all line
                        $worstPriority = 0;
                        $overall_status = $shape_status = $color_status = '';

                        // summary of all line
                        foreach (['man', 'machine', 'method', 'material'] as $property) {
                            $status = $line->{"status_$property"};

                            if (isset($statusMappings[$status])) {
                                $priority = $statusMappings[$status]['priority'];
                                if ($priority > $worstPriority) {
                                    $worstPriority = $priority;
                                    $overall_status = $statusMappings[$status]['overall'];
                                    $shape_status = $statusMappings[$status]['shape'];
                                    $color_status = $statusMappings[$status]['color'];
                                }
                            }
                        }

                        $overallStatuses[] = $overall_status;

                        // Check if the function exists before declaring it
                        if (!function_exists('mapStatus')) {
                            function mapStatus($status)
                            {
                                switch ($status) {
                                    case 'running':
                                        return 'NO HENKATEN';
                                    case 'henkaten':
                                        return 'HENKATEN';
                                    case 'stop':
                                        return 'STOP';
                                    default:
                                        return 'OFF';
                                }
                            }
                        }

                        if (!function_exists('mapStatusToShape')) {
                            function mapStatusToShape($status)
                            {
                                switch ($status) {
                                    case 'running':
                                        return 'circle';
                                    case 'henkaten':
                                        return 'triangle';
                                    case 'stop':
                                        return 'x';
                                    case 'off':
                                        return 'zzz';
                                    default:
                                        return '';
                                }
                            }
                        }

                        if (!function_exists('mapStatusToColor')) {
                            function mapStatusToColor($status)
                            {
                                switch ($status) {
                                    case 'running':
                                        return 'success';
                                    case 'henkaten':
                                        return 'warning';
                                    case 'stop':
                                        return 'danger';
                                    default:
                                        return 'dark';
                                }
                            }
                        }

                        // Assign status for each status property
                        $status_man = mapStatus($line->status_man);
                        $status_method = mapStatus($line->status_method);
                        $status_material = mapStatus($line->status_material);
                        $status_machine = mapStatus($line->status_machine);

                        // Assign shapes for each status property
                        $shape_man = mapStatusToShape($line->status_man);
                        $shape_method = mapStatusToShape($line->status_method);
                        $shape_material = mapStatusToShape($line->status_material);
                        $shape_machine = mapStatusToShape($line->status_machine);

                        // Assign color for each status property
                        $color_man = mapStatusToColor($line->status_man);
                        $color_method = mapStatusToColor($line->status_method);
                        $color_material = mapStatusToColor($line->status_material);
                        $color_machine = mapStatusToColor($line->status_machine);

                        if ($lineGroups == 'ELECTRIC' && $overall_status == 'RUNNING') {
                            $overall_status = 'NO HENKATEN';
                        }
                    @endphp
                    <div class="card-body bg-{{ $color_status }} text-white text-center p-1 pt-2">
                        <div class="d-inline-block">
                            <h4 class="text-light fw-bold">{{ $overall_status }}</h4>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-12">
                                <div class="row text-center">
                                    <div class="col border-end">
                                        <div class="mb-2">MEN</div>
                                        <i class="ti ti-{{ $shape_man }} fs-7 mb-2"></i>
                                    </div>
                                    <div class="col border-end">
                                        <div class="mb-2">MACHINE</div>
                                        <i class="ti ti-{{ $shape_machine }} fs-7 mb-2"></i>
                                    </div>
                                    <div class="col border-end">
                                        <div class="mb-2">METHOD</div>
                                        <i class="ti ti-{{ $shape_method }} fs-7 mb-2"></i>
                                    </div>
                                    <div class="col">
                                        <div class="mb-2">MATERIAL</div>
                                        <i class="ti ti-{{ $shape_material }} fs-7 mb-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($overall_status == 'RUNNING' || $overall_status == 'OFF')
                        <div class="position-absolute top-0 end-0 m-2">
                            <div class="d-flex align-items-center">
                                @if ($overall_status === 'RUNNING')
                                    <span class="text-white" style="margin-right: -25px">OFF</span>
                                @endif
                                <label class="form-switch me-2 mb-0">
                                    <input type="checkbox" id="toggleSwitch{{ $line->id }}"
                                        {{ $overall_status === 'RUNNING' ? 'checked' : '' }}>
                                </label>
                                @if ($overall_status === 'OFF')
                                    <span class="text-white">ON</span>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
@endsection
<script src={{ asset('js/jquery-3.6.3.min.js') }} integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var storedOriginId = localStorage.getItem('origin_id');

        $('.dc-card').on('click', function() {
            let idCard = $(this).attr('id');
            if (storedOriginId) {
                window.location.replace(`{{ url('/line/${idCard}/${storedOriginId}') }}`);
            } else {
                window.location.replace(`{{ url('/line/${idCard}') }}`);
            }
        });

        $('.form-switch input').on('click', function(event) {
            event.stopPropagation(); // Prevent the card click event

            let switchElement = $(this);
            let cardId = switchElement.closest('.dc-card').attr('id'); // Get the card ID
            let isChecked = switchElement.is(':checked'); // Check if the switch is on or off

            // Prepare data to send to the server
            let switchStatus = isChecked ? 'running' : 'off'; // 'on' for ON, 'off' for OFF

            // Send an AJAX request to update the status
            $.ajax({
                url: "{{ url('dashboard/updateStatus') }}" + "/" + cardId,
                type: "GET",
                data: {
                    onOffSwitch: switchStatus,
                },
                success: function(response) {
                    // Handle success response (optional)
                    window.location.reload();

                    console.log('Status updated successfully:', response);
                },
                error: function(xhr, status, error) {
                    // Handle error response (optional)
                    console.log('Error updating status:', error);
                }
            });
        });
    });
</script>
