@extends('layouts.root.main')

@section('main')
<div class="row">
    <div class="card">
        <div class="card-header" style="background-color: white;">
            <div class="row">
                <div class="col-10">
                    <h4 class="fw-4">
                        Master Skill
                        <h6 class="text-muted">
                            {{ Carbon\Carbon::now()->format('l, j F Y') }}
                        </h6>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <table class="table text-nowrap align-middle mb-0" id="masterSkill" style="width:100%; font-size: 12px">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="align-middle">Date</th>
                        <th rowspan="2" class="align-middle">Line</th>
                        <th rowspan="2" class="align-middle">Time</th>
                        <th rowspan="2" class="align-middle">Abnormality</th>
                        <th rowspan="2" class="align-middle">Category</th>
                        <th rowspan="2" class="align-middle">Table Henkaten No.</th>
                        <th rowspan="2" class="align-middle">Troubleshoot</th>
                        <th class="text-center">Safety</th>
                        <th colspan="4" class="text-center">Quality Inspection</th>
                        <th rowspan="2" class="align-middle">Done by</th>
                        <th rowspan="2" class="align-middle">Approval</th>
                    </tr>
                    <tr>
                        <th>Result Check</th>
                        <th>Report Abnormality</th>
                        <th>Part</th>
                        <th>Before</th>
                        <th>After</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($henkatenHistory as $henkaten)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($henkaten->date)->format('Y-m-d') }}</td>
                        <td>{{ $lines[$loop->index] }}</td>
                        <td>{{ Carbon\Carbon::parse($henkaten->date)->format('H:i:s') }}</td>
                        <td>{{ $henkaten->abnormality }}</td>
                        <td>{{ $henkaten->category }}</td>
                        <td>{{ $henkaten->henkaten_management_id }}</td>
                        @php
                        $relatedHandle = $handle->where('henkaten_id', $henkaten->id)->first();

                        if ($relatedHandle->before_treatment == 'ng'){
                        $colorBefore = 'danger';
                        } else {
                        $colorBefore = 'success';
                        }

                        if ($relatedHandle->after_treatment == 'ng'){
                        $colorAfter = 'danger';
                        } else {
                        $colorAfter = 'success';
                        }

                        if ($relatedHandle->result_check == 'ng'){
                        $colorResult = 'danger';
                        } else {
                        $colorResult = 'success';
                        }
                        @endphp
                        <td>{{ $relatedHandle ? $relatedHandle->troubleshoot : 'N/A' }}</td>
                        <td><span class="badge bg-{{ $colorResult }}">{{ $relatedHandle->result_check }}</span></td>
                        <td>{{ $relatedHandle->inspection_report }}</td>
                        <td>{{ $relatedHandle->part }}</td>
                        <td><span class="badge bg-{{ $colorBefore }}">{{ $relatedHandle->before_treatment }}</span></td>
                        <td><span class="badge bg-{{ $colorAfter }}">{{ $relatedHandle->after_treatment }}</span></td>
                        <td>{{ $name[$loop->index] }}</td>
                        <td>{{ $henkaten->approval !== null ? $henkaten->approval : 'Waiting...' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        $('#masterSkill').DataTable({
            scrollX: true,
        });
    });
</script>