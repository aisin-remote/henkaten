@extends('layouts.root.main_2')

@section('main')
    <div class="row">
        <h2 style="font-weight: bolder">Welcome to Digital Henkaten</h2>
        <h5 style="color: darkgrey">Please Select Plant or Line Group</h5>
        @foreach ($origins as $origin)
            @php
                $statusMappings = [
                    'off' => [
                        'priority' => 1,
                        'overall' => 'OFF',
                    ],
                    'running' => [
                        'priority' => 2,
                        'overall' => 'RUNNING',
                    ],
                    'henkaten' => [
                        'priority' => 3,
                        'overall' => 'HENKATEN',
                    ],
                    'stop' => [
                        'priority' => 4,
                        'overall' => 'STOP',
                    ],
                ];

                // Reset summary array for each origin
                $worstPriority = 0;
                $overallStatuses = []; // Reset the array here for each origin
                $overall_status = '';

                foreach ($origin->line as $line) {
                    // Summary of all line statuses
                    foreach (['man', 'machine', 'method', 'material'] as $property) {
                        $status = $line->{"status_$property"};

                        if (isset($statusMappings[$status])) {
                            $priority = $statusMappings[$status]['priority'];
                            if ($priority > $worstPriority) {
                                $worstPriority = $priority;
                                $overall_status = $statusMappings[$status]['overall'];
                            }
                        }
                    }

                    // Store the overall status for each line
                    $overallStatuses[] = $overall_status;
                }

                // Determine the overall status for all lines for this origin
                $worstOverallPriority = 0;
                $overall_status_all_lines = '';

                foreach ($overallStatuses as $status) {
                    // Find the corresponding priority for the status
                    foreach ($statusMappings as $mapping) {
                        if ($mapping['overall'] == $status) {
                            $priority = $mapping['priority'];
                            if ($priority > $worstOverallPriority) {
                                $worstOverallPriority = $priority;
                                $overall_status_all_lines = $status;
                            }
                        }
                    }
                }

                if ($overall_status_all_lines == 'HENKATEN') {
                    $color = 'warning';
                } elseif ($overall_status_all_lines == 'RUNNING') {
                    $color = 'success';
                } elseif ($overall_status_all_lines == 'STOP') {
                    $color = 'danger';
                } else {
                    $color = 'dark';
                }

                $overall_status_all_lines = $overall_status_all_lines ? $overall_status_all_lines : 'No Lines Detected';
                if ($overall_status_all_lines == 'RUNNING') {
                    $status = 'No Henkaten';
                } else {
                    $status = $overall_status_all_lines;
                }
            @endphp
            <div class="col-md-4 mt-4">
                <div class="card bg-{{ $color }} card-hover">
                    <div class="card-body text-center">
                        <a href="/dashboard/{{ $origin->id }}" class="origin-btn" data-origin-id="{{ $origin->id }}">
                            <div class="text-white p-3">
                                <h2 class="text-white fs-7" style="font-weight: bolder">{{ $origin->name }}</h2>
                                <h5 class="fw-light text-white">{{ $status }}</h5>
                            </div>
                        </a>
                    </div>
                    <div class="card-footer text-info bg-white">
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <h6 class="text-center" style="font-weight: bolder">Latest Henkaten</h6>
                            </div>
                        </div>
                        @foreach ($origin->line as $line)
                            @php
                                $statusMappings = [
                                    'off' => [
                                        'priority' => 1,
                                        'overall' => 'OFF',
                                    ],
                                    'running' => [
                                        'priority' => 2,
                                        'overall' => 'RUNNING',
                                    ],
                                    'henkaten' => [
                                        'priority' => 3,
                                        'overall' => 'HENKATEN',
                                    ],
                                    'stop' => [
                                        'priority' => 4,
                                        'overall' => 'STOP',
                                    ],
                                ];

                                // Reset summary array for each origin
                                $worstPriority = 0;
                                $overallStatuses = []; // Reset the array here for each origin
                                $overall_status = '';

                                // Summary of all line statuses
                                foreach (['man', 'machine', 'method', 'material'] as $property) {
                                    $status = $line->{"status_$property"};

                                    if (isset($statusMappings[$status])) {
                                        $priority = $statusMappings[$status]['priority'];
                                        if ($priority > $worstPriority) {
                                            $worstPriority = $priority;
                                            $overall_status = $statusMappings[$status]['overall'];
                                        }
                                    }
                                }

                                // Get the latest henkaten
                                $latestHenkaten = $line->henkaten()->latest()->first();

                                if ($overall_status == 'HENKATEN') {
                                    $color = 'warning';
                                } elseif ($overall_status == 'STOP') {
                                    $color = 'danger';
                                }

                            @endphp
                            @if ($overall_status !== 'RUNNING' && $latestHenkaten)
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#{{ $line->name }}"
                                                aria-expanded="false" aria-controls="collapseOne">
                                                <span class="mb-1 badge bg-dark me-2">
                                                    {{ $line->name }}
                                                </span>
                                                <span class="mb-1 badge bg-danger">
                                                    {{ $latestHenkaten->category }}
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="{{ $line->name }}" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                            <div class="accordion-body">
                                                {{ $latestHenkaten->abnormality }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<!-- Load jQuery -->
<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src={{ asset('js/pusher.min.js') }}></script>
<script>
    $(document).ready(function() {
        var pusher = new Pusher('8ee9e8a15df964407aec', {
            cluster: 'ap1',
            forceTLS: true
        });

        // websocket
        pusher.subscribe('henkaten').bind('DashboardUpdated', function(data) {
            // reload the page
            window.location.reload();
        });
        // Use class selector for origin buttons
        $(document).on('click', '.origin-btn', function(e) {
            e.preventDefault(); // Prevent the default behavior

            // Retrieve the origin_id from the data attribute
            const originId = $(this).data('origin-id');

            // Store the origin_id in local storage
            localStorage.setItem('origin_id', originId);

            // store the origin_id to cookie
            document.cookie = "origin=" + localStorage.getItem('origin_id') + "; path=/";

            // Optionally redirect to the link after setting the local storage
            window.location.href = $(this).attr('href');
        });
    });
</script>
