@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Mentor</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('mentor.show', $mentor->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        @include('partial.mentor_edit_nav')

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <p class="font-weight-bold">Employment History</p>

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                @if ($mentor->employmentHistories->count() > 0)

                                    @foreach ($mentor->employmentHistories as $key => $me)

                                        <div class="shadow-sm border px-3 pt-3 block mb-2 old">

                                            <form action="{{ route('mentor.employment-history.update') }}"
                                                  method="POST" class="form-horizontal">
                                                @csrf

                                                <a href="{{route('mentor.employment-history.delete', $me->id)}}" class="btn-close"
                                                   onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>

                                                <input type="hidden" name="e_h_id" value="{{$me->id}}">

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Organization
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="office_name"
                                                               value="{{$me->office_name}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('office_name'))
                                                            <span class="text-danger">{{ error_clean($errors->first('office_name')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Address <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="address" value="{{$me->address}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('address'))
                                                            <span class="text-danger">{{ error_clean($errors->first('address')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Designation
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="designation"
                                                               value="{{$me->designation}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('designation'))
                                                            <span class="text-danger">{{ error_clean($errors->first('designation')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Responsibility
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="responsibility"
                                                               value="{{$me->responsibility}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('responsibility'))
                                                            <span class="text-danger">{{ error_clean($errors->first('responsibility')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">From</label>
                                                    <div class="col-md-9">
                                                        <input type="date" name="from" value="{{$me->from}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('from'))
                                                            <span class="text-danger">{{ error_clean($errors->first('from')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">To</label>
                                                    <div class="col-md-9">
                                                        <input type="date" name="to" value="{{$me->to}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('to'))
                                                            <span class="text-danger">{{ error_clean($errors->first('to')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-9">
                                                        <input type="submit" value="Update" class="btn btn-info">
                                                    </div>
                                                </div>

                                            </form>

                                        </div>

                                    @endforeach

                                @endif

                                <form action="{{ route('mentor.employment-history.store') }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">
                                    <input type="hidden" name="_mode" value="edit">

                                    <div id="employment-history-block-wrapper">

                                        @if (old('office_name'))

                                            @for ($i = 0; $i < count(old('office_name')); $i++)

                                                <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                    <div class="btn-close btn-close-new"><i class="fa fa-times"></i></div>

                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Organization <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="office_name[]"
                                                                   value="{{ old('office_name.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('office_name.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('office_name.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Address <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="address[]"
                                                                   value="{{ old('address.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('address.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('address.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Designation <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="designation[]"
                                                                   value="{{ old('designation.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('designation.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('designation.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Responsibility <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="responsibility[]"
                                                                   value="{{ old('responsibility.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('responsibility.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('responsibility.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">From</label>
                                                        <div class="col-md-9">
                                                            <input type="date" name="from[]"
                                                                   value="{{ old('from.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('from.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('from.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">To</label>
                                                        <div class="col-md-9">
                                                            <input type="date" name="to[]" value="{{ old('to.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('to.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('to.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                            @endfor

                                        @endif

                                    </div>

                                    <p>
                                        <input type="submit" value="Submit" id="submit-btn" style="display: none;" class="btn btn-primary">
                                        <button type="button" id="add-block"
                                                class="btn btn-outline-dark btn-sm float-right">
                                            <i class="fa fa-plus-square"></i> Add <span id="changeable">Another</span> Employment History
                                        </button>
                                    </p>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        if ($('#employment-history-block-wrapper').children('.block').length > 0) {
            $('#submit-btn').show();
        } else {
            $('#submit-btn').hide();
        }

        $(document).on('click', '#add-block', function () {
            let employment_history_block_wrapper = `
                <div class="shadow-sm border px-3 pt-3 block mb-2">
                    <div class="btn-close btn-close-new"><i class="fa fa-times"></i></div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Organization <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="office_name[]" class="form-control form-control-success">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Address <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="address[]" class="form-control form-control-success">
                       </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Designation <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="designation[]" class="form-control form-control-success">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Responsibility <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="responsibility[]" class="form-control form-control-success">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">From</label>
                        <div class="col-md-9">
                            <input type="date" name="from[]" class="form-control form-control-success">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">To</label>
                        <div class="col-md-9">
                            <input type="date" name="to[]" class="form-control form-control-success">
                        </div>
                    </div>
                </div>
            `;
            $('#employment-history-block-wrapper').append(employment_history_block_wrapper);
            if ($('#employment-history-block-wrapper').children('.block').length > 0) {
                $('#submit-btn').show();
                $('#changeable').text('Another');
            }
        });

        $(document).on('click', '.btn-close-new', function () {
            $(this).closest('.block').remove();
            if ($('#employment-history-block-wrapper').children('.block').length < 1) {
                $('#submit-btn').hide();
                $('#changeable').text('New');
            }
        });

        if ($('.old').length === 0) {
            $('#changeable').text('New');
        }

        $('#edit-mentor a').filter(function () {
            return this.href === location.href;
        }).addClass('text-light').closest("div").addClass('bg-primary');
    </script>
@endpush



