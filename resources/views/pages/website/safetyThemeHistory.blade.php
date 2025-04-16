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
                    <div class="col-12">
                        <h4 class="fw-4">
                            Safet Theme History
                            <h6 class="text-muted">
                                {{ Carbon\Carbon::now()->format('l, j F Y') }}
                            </h6>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table text-nowrap align-middle mb-5 table-bordered" id="masterSkill">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Safety Theme</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($safetyThemeHistories as $safetyThemeHistory)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td id="date">{{ $safetyThemeHistory->active_date }}</td>
                                <td>
                                    {{ $safetyThemeHistory->custom_theme ?: ($safetyThemeHistory->theme ? $safetyThemeHistory->theme->name : '-') }}
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
<script>
    $(document).ready(function() {
        // initialize datatable
        let table = $('#masterSkill').DataTable({
            order: [
                [0, 'asc']
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
                table.column(1).search(date);
            } else {
                table.column(1).search('');
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
