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

                                <p class="font-weight-bold">Employment History</p>

                                <form action="{{ route('mentor.employment-history.store') }}" method="POST" enctype="multipart/form-data"
                                      class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">

                                    <div id="block-wrapper">

                                        @if (old('office_name'))

                                            @for ($i = 0; $i < count(old('office_name')); $i++)

                                                <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                    @if ($i !== 0)
                                                        <div class="btn-close"><i class="fa fa-times"></i></div>
                                                    @endif

                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Organization <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="office_name[]" value="{{ old('office_name.'.$i) }}"
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
                                                            <input type="text" name="address[]" value="{{ old('address.'.$i) }}"
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
                                                            <input type="text" name="designation[]" value="{{ old('designation.'.$i) }}"
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
                                                            <input type="text" name="responsibility[]" value="{{ old('responsibility.'.$i) }}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('responsibility.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('responsibility.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">From</label>
                                                        <div class="col-md-9">
                                                            <input type="date" name="from[]" value="{{ old('from.'.$i) }}"
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

                                        @else
                                            <div class="shadow-sm border px-3 pt-3 block mb-2">
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
                                        @endif

                                    </div>

                                    <p class="">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                        <button type="button" id="add-block"
                                                class="btn btn-outline-dark btn-sm float-right">
                                            <i class="fa fa-plus-square"></i> Add Another Employment History
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
    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('career_objective', {height: 100});

        $(document).on('click', '#add-block', function () {
            let block = `
                <div class="shadow-sm border px-3 pt-3 block mb-2">
                    <div class="btn-close"><i class="fa fa-times"></i></div>
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
            $('#block-wrapper').append(block);
        });

        $(document).on('click', '.btn-close', function () {
            $(this).closest('.block').remove();
        });
    </script>
@endpush