@extends('layouts.root.main')

@section('main')
<div class="card shadow">
    <div class="border-bottom title-part-padding">
        <h3 class="card-title mb-0">Edit Minimum Requirement Skill</h3>
    </div>
    <div class="card-body">
        <!-- Form for editing MinimumSkill record -->
        <form action="{{ route('minimumSkill.update', $minimumSkill->id) }}" method="POST" class="mt-4">
            @csrf
            @method('POST')

            <div class="repeater-container">
                <div class="row mb-3">
                    <div class="col-lg-3 col-sm-12">
                        <select class="select2 form-select select2-hidden-accessible" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="line[]">
                            <option>-- select line --</option>
                            @foreach ($lines as $line)
                            <option value="{{ $line->id }}" {{ $line->id == $minimumSkill->line_id ? 'selected' : '' }}>{{ $line->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="pos[]">
                            <option>-- select pos --</option>
                            <option value="1" {{ $minimumSkill->pos == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $minimumSkill->pos == '2' ? 'selected' : '' }}>2</option>
                            <option value="lastman" {{ $minimumSkill->pos == 'lastman' ? 'selected' : '' }}>Lastman</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <?php
                        $lineName = $line->where('id', $minimumSkill->line_id)->pluck('name')->first();
                        $skillName = $skillName->where('id', $minimumSkill->skill_id)->first();
                        ?>
                        <select class="select2 form-select select2-hidden-accessible" style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="skill[]">
                            <option>-- select skill --</option>
                            @foreach ($skills as $skill)
                            <option value="{{ $skill->name }}" {{ $skill->name == $skillName->name ? 'selected' : '' }}>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="level[]">
                            <option selected>-- select level --</option>
                            <option value="1" {{ $skillName->level == "1" ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $skillName->level == "2" ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $skillName->level == "3" ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $skillName->level == "4" ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $skillName->level == "5" ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-sm-12">
                        <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light remove-row" type="button">
                            <i class="ti ti-circle-x fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" data-repeater-create="" class="btn btn-info waves-effect waves-light mb-3" id="addSkill">
                <div class="d-flex align-items-center">
                    Add Skill
                    <i class="ti ti-circle-plus ms-1 fs-5"></i>
                </div>
            </button>
            <div class="mb-3">
                <button class="btn rounded-pill px-4 btn-success text-light font-weight-medium waves-effect waves-light" type="submit">
                    <i class="ti ti-send fs-5"></i>
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#addSkill').on('click', function() {
            var newRow = `<div class="row mb-3">
                            <div class="col-lg-3 col-sm-12">
                                <select class="select2 form-select select2-hidden-accessible"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="line[]">
                                    <option>-- select line --</option>
                                    @foreach ($lines as $line)
                                        <option value="{{ $line->id }}">{{ $line->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="pos[]">
                                    <option selected>-- select pos --</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="lastman">Lastman</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <select class="select2 form-select select2-hidden-accessible"
                                    style="width: 100%; height: 36px" tabindex="-1" aria-hidden="true" name="skill[]">
                                    <option>-- select skill --</option>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="level[]">
                                    <option selected>-- select level --</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-sm-12">
                                <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light remove-row"
                                    type="button">
                                    <i class="ti ti-circle-x fs-5"></i>
                                </button>
                            </div>
                        </div>`;

            // Append the new row
            $('.repeater-container').append(newRow);

            // Initialize Select2 for the Select elements in the new row
            $('.repeater-container').find('.select2').select2();
        });

        $('.repeater-container').on('click', '.remove-row', function() {
            if (confirm("Are you sure you want to remove this item?")) {
                $(this).closest('.row.mb-3').remove();
            }
        });
    });
</script>