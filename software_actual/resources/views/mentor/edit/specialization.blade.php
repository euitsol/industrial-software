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

                                <p class="font-weight-bold">Specialization</p>

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                @if ($mentor->specializations->count() > 0)

                                    @foreach ($mentor->specializations as $key => $ms)

                                        <div class="shadow-sm border px-3 pt-3 block mb-2 old">

                                            <form action="{{ route('mentor.specialization.update') }}"
                                                  method="POST" class="form-horizontal">
                                                @csrf

                                                <a href="{{route('mentor.specialization.delete', $ms->id)}}"
                                                   class="btn-close"
                                                   onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>

                                                <input type="hidden" name="s_id" value="{{$ms->id}}">

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Field Title <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="field_title"
                                                               value="{{$ms->field_title}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('field_title'))
                                                            <span class="text-danger">{{ error_clean($errors->first('field_title')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Description</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="description"
                                                               value="{{$ms->description}}"
                                                               class="form-control form-control-success">
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

                                <form action="{{ route('mentor.specialization.store') }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">
                                    <input type="hidden" name="_mode" value="edit">

                                    <div id="block-wrapper">

                                        @if (old('field_title'))
                                            @for ($i = 0; $i < count(old('field_title')); $i++)

                                                <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                    <div class="btn-close btn-close-new"><i class="fa fa-times"></i></div>

                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Field Title <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="field_title[]"
                                                                   value="{{old('field_title.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('field_title.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('field_title.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Description</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="description[]"
                                                                   value="{{old('description.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                        </div>
                                                    </div>

                                                </div>

                                            @endfor

                                        @endif

                                    </div>

                                    <p>
                                        <input type="submit" value="Submit" id="submit-btn" style="display: none;"
                                               class="btn btn-primary">
                                        <button type="button" id="add-block"
                                                class="btn btn-outline-dark btn-sm float-right">
                                            <i class="fa fa-plus-square"></i> Add <span id="changeable">Another</span> Specialization
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
        if ($('#block-wrapper').children('.block').length > 0) {
            $('#submit-btn').show();
        } else {
            $('#submit-btn').hide();
        }

        $(document).on('click', '#add-block', function () {
            let block = `
                <div class="shadow-sm border px-3 pt-3 block mb-2">

                    <div class="btn-close btn-close-new"><i class="fa fa-times"></i></div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Field Title <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="field_title[]" class="form-control form-control-success">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Description</label>
                        <div class="col-md-9">
                        <input type="text" name="description[]" class="form-control form-control-success">
                    </div>
                </div>
            `;
            $('#block-wrapper').append(block);
            if ($('#block-wrapper').children('.block').length > 0) {
                $('#submit-btn').show();
                $('#changeable').text('Another');
            }
        });

        $(document).on('click', '.btn-close-new', function () {
            $(this).closest('.block').remove();
            if ($('#block-wrapper').children('.block').length < 1) {
                $('#submit-btn').hide();
                $('#changeable').text('New');
            }
        });

        if ($('.old').length == 0) {
            $('#changeable').text('New');
        }

        $('#edit-mentor a').filter(function () {
            return this.href === location.href;
        }).addClass('text-light').closest("div").addClass('bg-primary');
    </script>
@endpush