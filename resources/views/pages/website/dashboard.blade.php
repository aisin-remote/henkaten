@extends('layouts.root.main')

@section('main')
    @php
        $modalTitle = $pivot && $pivot->theme ? 'Change Theme' : 'Add Theme';
    @endphp

    <!-- theme modal -->
    <div class="modal fade" id="modalTheme" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="themeModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div id="formModalTheme">
                            @php
                                $themeName = $pivot->theme->name ?? ($pivot->custom_theme ?? 'Set Theme');
                            @endphp
                            @if ($themeName !== 'Set Theme')
                                <div class="mb-3">
                                    <label class="mb-2">Current Theme</label>
                                    <input type="text" class="form-control" placeholder="" disabled
                                        value="{{ $themeName }}">
                                </div>
                            @endif
                        </div>

                        <label class="mb-2">New Theme</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            tabindex="-1" aria-hidden="true" id="themeSelect">
                            <option value="null">Select</option>
                            @foreach ($themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>

                        <div class="position-relative text-center my-4">
                            <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                                or set with custom theme
                            </p>
                            <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div>

                        <div class="mt-3">
                            <label class="mb-2">Custom Theme</label>
                            <input type="text" class="form-control" id="customThemeInput" placeholder="Custom Theme"
                                name="custom_theme">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="themeForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    @php
        $modalTitle = $pivot && $pivot->firstPic ? 'Change PIC' : 'Add PIC';
    @endphp

    {{-- 1 PIC modal --}}
    <div class="modal fade" id="firstPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->firstPic)
                            <div class="mb-3">
                                <label class="mb-2">Current PIC</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->firstPic->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="firstPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="firstPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- end of modal --}}
    @php
        $modalTitle = $pivot && $pivot->secondPic ? 'Change PIC' : 'Add PIC';
    @endphp

    {{-- 2 PIC modal --}}
    <div class="modal fade" id="secondPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->secondPic)
                            <div class="mb-3">
                                <label class="mb-2">Current PIC</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->secondPic->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="secondPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="secondPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    @php
        $modalTitle = $pivot && $pivot->theme ? 'Change Theme' : 'Add Theme';
    @endphp

    <!-- theme modal -->
    <div class="modal fade" id="modalTheme" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="themeModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->theme)
                            <div class="mb-3">
                                <label class="mb-2">Current Theme</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->theme->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New Theme</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            tabindex="-1" aria-hidden="true" id="themeSelect">
                            <option>Select</option>
                            @foreach ($themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>

                        <div class="position-relative text-center my-4">
                            <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                                or set with custom theme
                            </p>
                            <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div>

                        <div class="mt-3">
                            <label class="mb-2">Custom Theme</label>
                            <input type="text" class="form-control" id="customThemeInput" placeholder="Custom Theme"
                                name="custom_theme">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="themeForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    @php
        $modalTitle = $pivot && $pivot->firstPic ? 'Change PIC' : 'Add PIC';
    @endphp

    {{-- 1 PIC modal --}}
    <div class="modal fade" id="firstPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->firstPic)
                            <div class="mb-3">
                                <label class="mb-2">Current PIC</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->firstPic->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="firstPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="firstPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- end of modal --}}
    @php
        $modalTitle = $pivot && $pivot->secondPic ? 'Change PIC' : 'Add PIC';
    @endphp

    {{-- 2 PIC modal --}}
    <div class="modal fade" id="secondPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($pivot && $pivot->secondPic)
                            <div class="mb-3">
                                <label class="mb-2">Current PIC</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="{{ $pivot->secondPic->name }}">
                            </div>
                        @endif

                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="secondPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="secondPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    <div class="row" style="margin-top: -30px">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card shadow-md card-hover">
                <div class="card-body p-3 d-flex align-items-center gap-3" id="themeContainer">
                    <div>
                        <h5 class="fw-semibold mb-0">Tema Safety</h5>
                        <span
                            class="fs-2 d-flex align-items-center py-1 d-inline">{{ Carbon\Carbon::now()->format('j F Y') }}
                            <span id="time" class="fs-2 px-2"></span></span>
                    </div>
                    @php
                        $themeName = $pivot->theme->name ?? ($pivot->custom_theme ?? 'Set Theme');
                    @endphp

                    <button type="button"
                        class="btn btn-{{ $themeName !== 'Set Theme' ? 'secondary' : 'light' }} py-2 px-5 ms-auto"
                        data-bs-toggle="modal" data-bs-target="#modalTheme"
                        style="border: 3px {{ $themeName !== 'Set Theme' ? 'none' : 'dotted' }} {{ $themeName !== 'Set Theme' ? 'lightgrey' : '#686868' }}">
                        <h4 class="fw-bolder pt-1" style="color: {{ $themeName !== 'Set Theme' ? 'white' : '#686868' }}">
                            {{ $themeName !== 'Set Theme' ? $themeName : 'Set Theme' }}
                        </h4>
                    </button>
                </div>
            </div>
        </div>

        @php
            $firstPic = $pivot ? $pivot->firstPic : null;

            if ($pivot && $firstPic) {
                if ($firstPic->role == 'JP') {
                    $color = 'warning';
                } else {
                    $color = 'danger';
                }
            }
        @endphp

        <div class="col-lg-3 col-sm-12" id="firstPicContainer">
            <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal"
                id="firstPic">
                @if ($firstPic)
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <img src="{{ $firstPic->photo ? asset('uploads/doc/' . $firstPic->photo) : asset('path_to_default_image') }}"
                            alt="" class="rounded-circle" width="60" height="60">
                        <div>
                            <h6 class="fw-semibold mb-0">{{ $firstPic->name }}</h6>
                            <span class="fs-2 d-flex align-items-center py-1"><i
                                    class="ti ti-map-pin text-dark fs-3 me-1"></i>{{ $firstPic->npk }}</span>
                        </div>
                        <button class="btn btn-{{ $color }} py-1 px-3 ms-auto">{{ $firstPic->role }}</button>
                    </div>
                @else
                    <form action="#" class="dropzone dz-clickable p-3 rounded-1">
                        <p class="text-center pt-3">Add First PIC</p>
                    </form>
                @endif
            </div>
        </div>

        @php
            $secondPic = $pivot ? $pivot->secondPic : null;

            if ($pivot && $secondPic) {
                if ($secondPic->role == 'JP') {
                    $color = 'warning';
                } else {
                    $color = 'danger';
                }
            }
        @endphp

        <div class="col-lg-3 col-sm-12" id="secondPicContainer">
            <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="" id="secondPic">
                @if ($secondPic)
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <img src="{{ $secondPic->photo ? asset('uploads/doc/' . $secondPic->photo) : asset('path_to_default_image') }}"
                            alt="" class="rounded-circle" width="60" height="60">
                        <div>
                            <h6 class="fw-semibold mb-0">{{ $secondPic->name }}</h6>
                            <span class="fs-2 d-flex align-items-center py-1"><i
                                    class="ti ti-map-pin text-dark fs-3 me-1"></i>{{ $secondPic->npk }}</span>
                        </div>
                        <button class="btn btn-{{ $color }} py-1 px-3 ms-auto">{{ $secondPic->role }}</button>
                    </div>
                @else
                    <form action="#" class="dropzone dz-clickable p-3 rounded-1">
                        <p class="text-center pt-3">Add Second PIC</p>
                    </form>
                @endif
            </div>
        </div>

        @php
            $statusMappings = [
                'running' => ['priority' => 1, 'overall' => 'RUNNING', 'shape' => 'circle', 'color' => 'success'],
                'henkaten' => ['priority' => 2, 'overall' => 'HENKATEN', 'shape' => 'triangle', 'color' => 'warning'],
                'stop' => ['priority' => 3, 'overall' => 'STOP', 'shape' => 'x', 'color' => 'danger'],
            ];

            $items = ['man', 'method', 'machine', 'material'];
            $summaryResultsItem = [];

            // function to get summary each item
            if (!function_exists('getOverallItem')) {
                function getOverallItem($lines, $item, $statusMappings)
                {
                    $worstPriorityItem = 0;
                    $overallStatusItem = '';

                    foreach ($lines as $line) {
                        $statusItem = $line->{"status_$item"};
                        if (isset($statusMappings[$statusItem])) {
                            $priorityItem = $statusMappings[$statusItem]['priority'];
                            if ($priorityItem > $worstPriorityItem) {
                                $worstPriorityItem = $priorityItem;
                                $overallStatusItem = $statusMappings[$statusItem]['overall'];
                            }
                        }
                    }
                    return $overallStatusItem;
                }
            }

            foreach ($items as $item) {
                $summaryResultsItem[$item] = getOverallItem($lines, $item, $statusMappings);
            }
        @endphp
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="text-white">
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-4 py-4">
                                    <div class="card-body p-3 d-flex align-items-center gap-3">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <h1 class="fw-bolder text-center pt-3"
                                                    style="font-size: 1em; display:block; font-weight:900 !important; font-size:80px !important">
                                                    OVERALL
                                                    <br>
                                                    @php
                                                        $origin = '';
                                                        if (auth()->user()->origin->name == 'DC') {
                                                            $origin = 'DIE CASTING';
                                                        } elseif (auth()->user()->origin->name == 'MA') {
                                                            $origin = 'MACHINING';
                                                        } elseif (auth()->user()->origin->name == 'ASSY') {
                                                            $origin = 'ASSEMBLING';
                                                        } else {
                                                            $origin = 'ELECTRIC';
                                                        }
                                                    @endphp
                                                    {{ $origin }}
                                                </h1>
                                            </div>
                                            <div class="col-lg-3 text-center" id="overallShape">
                                                <img src="{{ asset('assets/images/running.svg') }}" class="dark-logo"
                                                    width="240" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($items as $item)
                                @php
                                    $overallStatus = $summaryResultsItem[$item];

                                    if (!function_exists('overallMapStatusToShape')) {
                                        function overallMapStatusToShape($status)
                                        {
                                            switch ($status) {
                                                case 'RUNNING':
                                                    return 'circle';
                                                case 'HENKATEN':
                                                    return 'triangle';
                                                case 'STOP':
                                                    return 'x';
                                                default:
                                                    return '';
                                            }
                                        }
                                    }

                                    if (!function_exists('overallMapStatusToColor')) {
                                        function overallMapStatusToColor($status)
                                        {
                                            switch ($status) {
                                                case 'RUNNING':
                                                    return 'success';
                                                case 'HENKATEN':
                                                    return 'warning';
                                                case 'STOP':
                                                    return 'danger';
                                                default:
                                                    return 'dark';
                                            }
                                        }
                                    }

                                    $shape = overallMapStatusToShape($overallStatus);
                                    $color = overallMapStatusToColor($overallStatus);
                                @endphp
                                <div class="col-md-3 col-sm-12">
                                    <div class="card overflow-hidden card-hover">
                                        <div class="card-body bg-white text-center text-muted p-10">
                                            <div class="p-30">
                                                <i class="ti ti-{{ $shape }} fs-7 mb-2"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer text-white bg-{{ $color }} p-30">
                                            <div class=" no-block align-items-center">
                                                <div class="text-center">
                                                    <h3 class="font-weight-medium text-white fs-6">
                                                        {{ strtoupper($item) }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-4 py-4">
                                    <div class="card-body p-3 align-items-center" style="max-height: 18em; width: 100%;"
                                        data-simplebar>
                                        @if (!$histories->isEmpty())
                                            <div class="accordion" id="accordionExample">
                                                @foreach ($histories as $history)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#history-{{ $loop->index }}"
                                                                aria-expanded="false" aria-controls="collapseOne">
                                                                <span
                                                                    class="mb-1 badge bg-dark me-2">{{ $history->line->name }}</span>
                                                                @if ($history->status == 'henkaten')
                                                                    <span
                                                                        class="mb-1 badge bg-info me-2">{{ $history->{"4M"} }}
                                                                    </span>
                                                                    <span
                                                                        class="mb-1 badge bg-warning">{{ $history->status }}
                                                                    </span>
                                                                    <p class="ps-2 pt-2">
                                                                        at
                                                                        {{ Carbon\Carbon::parse($history->date)->format('j F Y, g:i A') }}
                                                                    </p>
                                                                @else
                                                                    <span
                                                                        class="mb-1 badge bg-info me-2">{{ $history->{"4M"} }}
                                                                    </span>
                                                                    <span
                                                                        class="mb-1 badge bg-danger">{{ $history->status }}
                                                                    </span>
                                                                    <p class="ps-2 pt-2">
                                                                        at
                                                                        {{ Carbon\Carbon::parse($history->date)->format('j F Y, g:i A') }}
                                                                    </p>
                                                                @endif
                                                            </button>
                                                        </h2>
                                                        <div id="history-{{ $loop->index }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="headingOne"
                                                            data-bs-parent="#accordionExample" style="">
                                                            <div class="accordion-body">
                                                                <strong>{{ $history->abnormality }} :
                                                                    {{ $history->category }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <h1 class="fw-bolder text-center"
                                                style="font-size: 5em; display:block; font-weight:900 !important">
                                                NO HENKATEN
                                            </h1>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="row vertical-carousel">
                <div class="carousel-inner">
                    @foreach ($lines as $line)
                        <div class="col-md-12 col-lg-4 carousel-item dc-card" id="{{ $line->id }}">
                            <div class="card overflow-hidden shadow card-hover" style="width:100%">
                                <div class="card-body bg-info text-white text-center p-10">
                                    <div class="d-inline-block">
                                        <h3 class="text-light fw-bolder">{{ $line->name }}</h3>
                                    </div>
                                </div>
                                @php
                                    $statusMappings = [
                                        'running' => ['priority' => 1, 'overall' => 'RUNNING', 'shape' => 'circle', 'color' => 'success'],
                                        'henkaten' => ['priority' => 2, 'overall' => 'HENKATEN', 'shape' => 'triangle', 'color' => 'warning'],
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
                                                default:
                                                    return 'zzz';
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
                                                case 'off':
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
                            </div>
                        </div>
                    @endforeach

                    @php
                        // Determine the overall status for all lines
                        $worstOverallPriority = 0;
                        $overall_status_all_lines = ''; // Different variable name for overall status for all lines

                        foreach ($overallStatuses as $status) {
                            $priority = array_search($status, array_column($statusMappings, 'overall'));
                            if ($priority >= $worstOverallPriority) {
                                $worstOverallPriority = $priority;
                                $overall_status_all_lines = $status;
                            }
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>

    {{-- hidden for  --}}
    <input type="hidden" value="{{ $overall_status_all_lines }}" id="overall_line_status"></input>

    <!-- pic modal 1-->
    <div class="modal fade" id="firstPicModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add PIC</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true" id="firstPicSelect"
                            required>
                            <option data-select2-id="select2-data-3-t8ia" value="0">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="firstPicForm">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    <!-- pic modal 2 -->
    <div class="modal fade" id="secondPicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add PIC</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <label class="mb-2">New PIC</label>
                        <select class="select2 form-control select2-hidden-accessible" style="width: 100%; height: 36px"
                            data-select2-id="select2-data-1-lmv6" tabindex="-1" aria-hidden="true"
                            id="secondPicSelect">
                            <option data-select2-id="select2-data-3-t8ia">Select</option>
                            @foreach ($employees as $employee)
                                <option data-select2-id="select2-data-3-t8ia" value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="form2">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    let pivot = @json($pivot);
    $(document).ready(function() {

        // reload page based on websocket signal
        var pusher = new Pusher('8ee9e8a15df964407aec', {
            cluster: 'ap1',
            forceTLS: true
        });

        // websocket
        pusher.subscribe('henkaten').bind('DashboardUpdated', function(data) {
            // reload the page
            window.location.reload();
        });

        var themeSelect = document.getElementById('themeSelect');
        var customThemeInput = document.getElementById('customThemeInput');
        $('#themeSelect').on('change', function() {
            var theme = $(this).val();
            if (theme !== 'null') {
                customThemeInput.disabled = true;
            } else {
                customThemeInput.disabled = false;
            }
        });
        $('#customThemeInput').on('input', function() {
            var customTheme = $(this).val();
            if (customTheme !== null && customTheme.length > 0) {
                themeSelect.disabled = true;
            } else {
                themeSelect.disabled = false;
            }
        });
    });

    function initApp() {
        let first_pic = pivot ? pivot.first_pic : null;
        if (first_pic) {
            localStorage.setItem('firstPic', 'set');
        }

        if (!localStorage.getItem('firstPic')) {
            $('#firstPicContainer').html('');
            $('#firstPicContainer').html(`
                    <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal" id="firstPic">
                        <form action="#" class="dropzone dz-clickable p-3 rounded-1">
                            <p class="text-center pt-3">Add First PIC</p>
                        </form>
                    </div>
                `);
        }
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

    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const formattedTime = `${hours}:${minutes}:${seconds}`;
        const timeElement = document.getElementById('time');
        timeElement.textContent = formattedTime;
    }

    $(document).ready(function() {
        initApp();

        // overall line status dashboard
        let overallStatus = $('#overall_line_status').val();

        function getShape(status) {
            switch (overallStatus) {
                case 'RUNNING':
                    return `<img src="{{ asset('assets/images/running.svg') }}" class="dark-logo"
                                                    width="240" alt="" />`;
                case 'HENKATEN':
                    return `<img src="{{ asset('assets/images/henkaten.svg') }}" class="dark-logo"
                                                    width="240" alt="" />`;
                case 'STOP':
                    return `<img src="{{ asset('assets/images/stop.svg') }}" class="dark-logo"
                                                    width="240" alt="" />`;
            }
        }

        $('#overallShape').html(getShape(overallStatus));

        // Update the time every second
        setInterval(updateTime, 1000);

        // Initial call to display the time immediately
        updateTime();

        $('#themeSelect').select2({
            dropdownParent: $('#modalTheme')
        });

        $('#firstPicSelect').select2({
            dropdownParent: $('#firstPicModal')
        });

        $('#secondPicSelect').select2({
            dropdownParent: $('#secondPicModal')
        });

        // submit form 1
        $('#firstPicForm').on('click', function() {
            let pic = $('#firstPicSelect').val();
            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/selectFirstPic/${pic}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        // set local storage
                        localStorage.setItem('firstPic', 'set');

                        $('#firstPicModal').modal('hide');

                        setTimeout(() => {
                            notif('success', data.message);
                        }, 500);

                        let color = data.role == 'Leader' ? 'danger' : 'warning';
                        let photo = data.photo;

                        $('#firstPicContainer').html('');
                        $('#firstPicContainer').html(`
                        <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#firstPicModal" id="firstPic">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('uploads/doc/${photo}') }}"
                                    alt="" class="rounded-circle" width="60" height="60">
                                <div>
                                    <h6 class="fw-semibold mb-0">${data.name}</h6>
                                    <span class="fs-2 d-flex align-items-center py-1"><i
                                            class="ti ti-map-pin text-dark fs-3 me-1"></i>${data.npk}</span>
                                </div>
                                <button class="btn btn-${color} py-1 px-3 ms-auto">${data.role}</button>
                            </div>
                        </div>
                        `);
                    } else {
                        notif('error', data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        notif("error", 'Connection Error');
                        return;
                    }
                    notif("error", 'Internal Server Error');
                }
            });
        });

        // submit form 2
        $('#secondPicForm').on('click', function() {
            let pic = $('#secondPicSelect').val();
            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/selectSecondPic/${pic}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        // set local storage
                        localStorage.setItem('secondPic', 'set');

                        $('#secondPicModal').modal('hide');

                        setTimeout(() => {
                            notif('success', data.message);
                        }, 500);

                        let color = data.role == 'Leader' ? 'danger' : 'warning';
                        let photo = data.photo;

                        $('#secondPicContainer').html('');
                        $('#secondPicContainer').html(`
                        <div class="card shadow-md card-hover" data-bs-toggle="modal" data-bs-target="#secondPicModal" id="secondPic">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('uploads/doc/${photo}') }}"
                                    alt="" class="rounded-circle" width="60" height="60">
                                <div>
                                    <h6 class="fw-semibold mb-0">${data.name}</h6>
                                    <span class="fs-2 d-flex align-items-center py-1"><i
                                            class="ti ti-map-pin text-dark fs-3 me-1"></i>${data.npk}</span>
                                </div>
                                <button class="btn btn-${color} py-1 px-3 ms-auto">${data.role}</button>
                            </div>
                        </div>
                        `);
                    } else {
                        notif('error', data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        notif("error", 'Connection Error');
                        return;
                    }
                    notif("error", 'Internal Server Error');
                }
            });
        });

        // submit theme form
        $('#themeForm').on('click', function() {
            let theme = $('#themeSelect').val();
            if (theme == "null") {
                theme = $('#customThemeInput').val() + '-custom'
            }
            $.ajax({
                type: 'get',
                url: `{{ url('dashboard/selectTheme/${theme}') }}`,
                _token: "{{ csrf_token() }}",
                dataType: 'json',
                data: {
                    theme: theme
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {

                        $('#modalTheme').modal('hide');

                        setTimeout(() => {
                            notif('success', data.message);
                        }, 500);

                        $('#themeContainer').html('');
                        $('#themeContainer').html(`
                            <div>
                                <h5 class="fw-semibold mb-0">Tema Safety</h5>
                                <span
                                    class="fs-2 d-flex align-items-center py-1 d-inline">{{ Carbon\Carbon::now()->format('l, j F Y') }}
                                    <span id="time" class="fs-2 px-2"></span></span>
                            </div>

                            <button id="themeModal" type="button" class="btn btn-secondary py-2 px-5 ms-auto"
                                data-bs-toggle="modal" data-bs-target="#modalTheme">
                                <h4 class=" fw-bolder text-light pt-1">
                                    ${data.theme_name}
                                </h4>
                            </button>
                        `);
                        $('#formModalTheme').html('');
                        $('#formModalTheme').html(`
                            <div id="formModalTheme">
                            <div class="mb-3">
                                <label class="mb-2">Current Theme</label>
                                <input type="text" class="form-control" placeholder="" disabled
                                    value="${data.theme_name}">
                            </div>
                        `);
                    } else {
                        notif('error', data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 0) {
                        notif("error", 'Connection Error');
                        return;
                    }
                    notif("error", 'Internal Server Error');
                }
            });
        });

        $('#secondPic').on('click', function() {
            if (!localStorage.getItem('firstPic')) {
                notif('error', 'Tambah PIC pertama dahulu!');
                return;
            }

            $('#secondPic').attr('data-bs-target', '#secondPicModal');
        });

        $('.dc-card').on('click', function() {
            let idCard = $(this).attr('id');
            window.location.replace(`{{ url('/dashboard/${idCard}') }}`);
        });
    });
</script>
