@extends('layouts.master')

@section('title', 'Edit Linkage With Industry Information - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Linkage With Industry Information</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('linkage_industry.info') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('linkage_industry.info.update') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{$data->id}}">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Company Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="company_name" value="{{ $data->company_name }}" class="form-control form-control-success" required>
                                        @if ($errors->has('company_name'))
                                            <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Company Logo<span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <div id="image-preview">
                                            @if (!empty($data->company_logo) && file_exists($data->company_logo))
                                                <img src="{{ asset($data->company_logo) }}" height="100" width="100" alt="Company Logo">
                                            @endif
                                        </div>
                                        <input type="file" name="company_logo" id="photo"
                                               class="form-control-file form-control-success">
                                        @if ($errors->has('company_logo'))
                                            <span class="text-danger">{{ $errors->first('company_logo') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Company Website URL <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="company_website" value="{{ $data->company_website }}" class="form-control form-control-success" required>
                                        @if ($errors->has('company_website'))
                                            <span class="text-danger">{{ $errors->first('company_website') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Company Address <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="company_address" value="{{ $data->company_address }}" class="form-control form-control-success" required>
                                        @if ($errors->has('company_address'))
                                            <span class="text-danger">{{ $errors->first('company_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Contact Person Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="contact_person_name" value="{{ $data->contact_person_name }}" class="form-control form-control-success" required>
                                        @if ($errors->has('contact_person_name'))
                                            <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Contact Number <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="number" name="contact_number" value="{{ $data->contact_number }}" class="form-control form-control-success" required>
                                        @if ($errors->has('contact_number'))
                                            <span class="text-danger">{{ $errors->first('contact_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Contact Email <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="email" name="contact_email" value="{{ $data->contact_email }}" class="form-control form-control-success" required>
                                        @if ($errors->has('contact_email'))
                                            <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Description<span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <textarea name="description" id="description"
                                                  class="form-control form-control-success">{{ $data->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </div>
                                </div>
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
    $(document).on('change', '#photo', function (e) {
            const file = e.target.files[0] || e.dataTransfers.files[0];
            let reader = new FileReader();
            reader.onload = function (ev) {
                let img = document.createElement('img');
                img.height = '100';
                img.width = '100';
                img.src = ev.target.result;
                img.style.marginRight = '5px';
                img.style.marginBottom = '5px';
                $('#image-preview').html(img);
            };
            reader.readAsDataURL(file);
        });
</script>
@endpush

