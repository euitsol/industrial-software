@extends('layouts.master')

@section('title', 'Add Visited Institute - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Add Visited Institute</h4>
                        </span>
                        <span class="float-right">
                            <a href={{ route('iv') }} class="btn btn-primary">Back</a>
                        </span>
                    </div>

                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('iv.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Institute Name <span
                                                        class="text-danger">*</span> </label>
                                            <div class="col-md-9">
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                       class="form-control form-control-success" required>
                                                <small>Please enter the name of institute</small>
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="type">Type <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="type" id="type" class="form-control form-control-success" required>
                                                <option selected disabled value="">Choose...</option>
                                                    <option value="1">Private</option>
                                                    <option value="2">Public</option>
                                            </select>
                                            <small>Please select a institute type</small>
                                            @if ($errors->has('type'))
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="division">Division <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="division" id="division" onchange="divisionsList();"  class="form-control form-control-success" required>
                                                <option disabled selected>Select Division</option>
                                                <option value="Barishal">Barishal</option>
                                                <option value="Chattogram">Chattogram</option>
                                                <option value="Dhaka">Dhaka</option>
                                                <option value="Khulna">Khulna</option>
                                                <option value="Mymensingh">Mymensingh</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                                <option value="Rangpur">Rangpur</option>
                                                <option value="Sylhet">Sylhet</option>
                                            </select>

                                            <small>Please select a division name</small>
                                            @if ($errors->has('division'))
                                                <span class="text-danger">{{ $errors->first('division') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="district">District <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="district" id="district" class="form-control form-control-success" required>
                                                <option selected disabled value="">Choose...</option>
                                            </select>
                                            <small>Please select a district name</small>
                                            @if ($errors->has('type'))
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Address</label>
                                        <div class="col-md-9">
                                            <textarea name="address" id="address"
                                                      class="form-control form-control-success">{{ old('address') }}</textarea>
                                            <small>Please add full address if you have</small>
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Website</label>
                                        <div class="col-md-9">
                                            <input type="text" name="website" value="{{ old('website') }}" class="form-control form-control-success" >
                                            <small>Please enter full link of the website if you have</small>
                                            @if ($errors->has('website'))
                                                <span class="text-danger">{{ $errors->first('website') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Facebook</label>
                                        <div class="col-md-9">
                                            <input type="text" name="facebook" value="{{ old('facebook') }}" class="form-control form-control-success" >
                                            <small>Please enter full link of the facebook profile/page if you have</small>
                                            @if ($errors->has('facebook'))
                                                <span class="text-danger">{{ $errors->first('facebook') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <p class = "text-center bg-gray-100 border py-2">Contact Number</p>
                                    </div>

                                    <div class = "contact-wrap">
                                        <p class="text-center mt-2 mb-2">Contact Person - 1</p>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="contact[0][name]" class="form-control form-control-success" required>
                                                        <small>Name<span class="text-danger">*</span></small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="contact[0][designation]" class="form-control form-control-success" >
                                                        <small>Designation</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" name="contact[0][phone]" class="form-control form-control-success" >
                                                        <small>Phone</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="email" name="contact[0][email]" class="form-control form-control-success" >
                                                        <small>Email</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea name="contact[0][comment]" class="form-control form-control-success" ></textarea>
                                                        <small>Comment</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="appendDiv"></div>
                                        <div class="clearfix mb-3">
                                            <a href="javascript:void(0);" data-count="0" class="float-right" id="addNew">+ add new contact</a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 mt-3 m-auto">
                                            <input type="submit" value="Submit" class="btn btn-primary w-100">
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
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        function divisionsList() {
        	// get value from division lists
        	var diviList = document.getElementById('division').value;
        
        	// set barishal division districts
        	if(diviList == 'Barishal'){		
        		var disctList = '<option disabled selected>Select District</option><option value="Barguna">Barguna</option><option value="Barishal">Barishal</option><option value="Bhola">Bhola</option><option value="Jhalokati">Jhalokati</option><option value="Patuakhali">Patuakhali</option><option value="Pirojpur">Pirojpur</option>';
        	}
        	// set Chattogram division districts
        	else if(diviList == 'Chattogram') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Brahmanbaria">Brahmanbaria</option><option value="Bandarban">Bandarban</option><option value="Chandpur">Chandpur</option><option value="Chattogram">Chattogram</option><option value="Cumilla">Cumilla</option><option value="Cox\'s Bazar">Cox\'s Bazar</option><option value="Feni">Feni</option><option value="Khagrachhari">Khagrachhari</option><option value="Noakhali">Noakhali</option><option value="Rangamati">Rangamati</option>';	
        	}
        	// set Dhaka division districts
        	else if(diviList == 'Dhaka') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Dhaka">Dhaka</option><option value="Faridpur">Faridpur</option><option value="Gazipur">Gazipur</option><option value="Gopalganj">Gopalganj</option><option value="Kishoreganj">Kishoreganj</option><option value="Madaripur">Madaripur</option><option value="Manikganj">Manikganj</option><option value="Munshiganj">Munshiganj</option><option value="Narayanganj">Narayanganj</option><option value="Narsingdi">Narsingdi</option><option value="Rajbari">Rajbari</option><option value="Shariatpur">Shariatpur</option><option value="Tangail">Tangail</option>';
        	}
        	// set Khulna division districts
        	else if(diviList == 'Khulna') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Bagerhat">Bagerhat</option> <option value="Chuadanga">Chuadanga</option> <option value="Jashore">Jashore</option><option value="Jhenaidah">Jhenaidah</option><option value="Khulna">Khulna</option><option value="Kushtia">Kushtia</option><option value="Magura">Magura</option><option value="Meherpur">Meherpur</option><option value="Narail">Narail</option><option value="Satkhira">Satkhira</option>';
        	}
        	// set Mymensingh division districts
        	else if(diviList == 'Mymensingh') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Jamalpur">Jamalpur</option> <option value="Mymensingh">Mymensingh</option> <option value="Netrokona">Netrokona</option><option value="Sherpur">Sherpur</option>';
        	}
        	// set Rajshahi division districts
        	else if(diviList == 'Rajshahi') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Bogura">Bogura</option> <option value="Joypurhat">Joypurhat</option> <option value="Naogaon">Naogaon</option><option value="Natore">Natore</option><option value="Chapainawabganj">Chapainawabganj</option><option value="Pabna">Pabna</option><option value="Rajshahi">Rajshahi</option><option value="Sirajganj">Sirajganj</option>';
        	}
        	// set Rangpur division districts
        	else if(diviList == 'Rangpur') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Dinajpur">Dinajpur</option> <option value="Gaibandha">Gaibandha</option> <option value="Kurigram">Kurigram</option><option value="Lalmonirhat">Lalmonirhat</option><option value="Nilphamari">Nilphamari</option><option value="Panchagarh">Panchagarh</option><option value="Rangpur">Rangpur</option><option value="Thakurgaon">Thakurgaon</option>';
        	}
        	// set Sylhet division districts
        	else if(diviList == 'Sylhet') {
        		var disctList = '<option disabled selected>Select Division</option><option value="Habiganj">Habiganj</option> <option value="Moulvibazar">Moulvibazar</option> <option value="Sunamganj">Sunamganj</option><option value="Sylhet">Sylhet</option>';
        	}

        	document.getElementById("district").innerHTML= disctList;
        }

    </script>
    <script>
        $('#addNew').click( function (){
            let count = $(this).data('count');
            let append_content = `      <p class="text-center mt-2 mb-2">Contact Person - ${count+2}</p>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="contact[${count+1}][name]" class="form-control form-control-success" required>
                                                        <small>Name<span class="text-danger">*</span></small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="contact[${count+1}][designation]" class="form-control form-control-success" >
                                                        <small>Designation</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" name="contact[${count+1}][phone]" class="form-control form-control-success" >
                                                        <small>Phone</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="email" name="contact[${count+1}][email]" class="form-control form-control-success" >
                                                        <small>Email</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea name="contact[${count+1}][comment]" class="form-control form-control-success" ></textarea>
                                                        <small>Comment</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
            $('#appendDiv').append(append_content);
            $(this).data('count', count+1);
        });
    </script>
@endpush