@extends('layouts.master')

@section('title', 'Add Marketing - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Add Marketing</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('unsuccess'))
                            <p class="alert alert-danger text-center">
                                {{ session('unsuccess') }}
                            </p>
                        @endif
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('marketing.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Student Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                   class="form-control form-control-success" required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Interested Course</label>
                                        <div class="col-md-9">
                                            <select name="course" class="form-control form-control-success" required>
                                                <option selected disabled value="">Choose...</option>
                                                @foreach ($courses as $c)
                                                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Mobile</label>
                                        <div class="col-md-9">
                                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                                   class="form-control form-control-success" required>
                                            @if ($errors->has('mobile'))
                                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                   class="form-control form-control-success" >
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Address</label>
                                        <div class="col-md-9">
                                            <textarea name="address" required
                                                      class="form-control form-control-success">{{ old('address') }}</textarea>
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Conversation Date</label>
                                        <div class="col-md-9">
                                            <input type="date" name="date" value="{{ old('date') }}"
                                                   class="form-control form-control-success" required>
                                            @if ($errors->has('date'))
                                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Next Conversation Date</label>
                                        <div class="col-md-9">
                                            <input type="date" name="nextDate" value="{{ old('nextDate') }}"
                                                   class="form-control form-control-success" required>
                                            @if ($errors->has('nextDate'))
                                                <span class="text-danger">{{ $errors->first('nextDate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Converse With</label>
                                        <div class="col-md-9">
                                            <input type="text" name="converseWith" value="{{ old('converseWith') }}"
                                                   class="form-control form-control-success" required
                                                   list="converseWith">
                                            @if ($errors->has('converseWith'))
                                                <span class="text-danger">{{ $errors->first('converseWith') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Comment</label>
                                        <div class="col-md-9">
                                            <textarea name="comment" required
                                                      class="form-control form-control-success">{{ old('comment') }}</textarea>
                                            @if ($errors->has('comment'))
                                                <span class="text-danger">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Submit" class="btn btn-primary">
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
    <datalist id="converseWith">
        @forelse($datalist['converse_with'] as $cw)
            <option value="{{$cw->converse_with}}">
        @empty
        @endforelse
    </datalist>
@endsection

