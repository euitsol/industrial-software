@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>New Mentor</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <p class="font-weight-bold">Specialization</p>

                                <form action="{{ route('mentor.specialization.store') }}" method="POST"
                                      enctype="multipart/form-data"
                                      class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">

                                    <div id="block-wrapper">

                                        @if (old('field_title'))
                                            @for ($i = 0; $i < count(old('field_title')); $i++)

                                                <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                    @if ($i !== 0)
                                                        <div class="btn-close"><i class="fa fa-times"></i></div>
                                                    @endif

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
                                        @else

                                            <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Field Title <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="field_title[]"
                                                               class="form-control form-control-success">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Description</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="description[]"
                                                               class="form-control form-control-success">
                                                    </div>
                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                    <p class="">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                        <button type="button" id="add-block"
                                                class="btn btn-outline-dark btn-sm float-right">
                                            <i class="fa fa-plus-square"></i> Add Another Specialization
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
        $(document).on('click', '#add-block', function () {
            let block = `
                <div class="shadow-sm border px-3 pt-3 block mb-2">

                    <div class="btn-close"><i class="fa fa-times"></i></div>

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
        });

        $(document).on('click', '.btn-close', function () {
            $(this).closest('.block').remove();
        });
    </script>
@endpush