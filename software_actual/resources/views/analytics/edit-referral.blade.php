@extends('layouts.master')



@section('title', 'Analytics - Add Referral - European IT Solutions Institute')



@push('css')

@endpush



@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-10 col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <span class="float-left">

                            <h4>Edit Referral</h4>

                        </span>

                        <span class="float-right">

                            <a class="btn btn-sm btn-info" href="{{ route('analytics') }}">Back</a>

                        </span>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-8 offset-md-2">

                                <form action="{{ route('analytics.referral.update') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $referral->id }}">
                                    <div class="form-group row">

                                        <label class="col-md-3 form-control-label">Referral Name</label>

                                        <div class="col-md-9">

                                            <input type="text" name="name" value="{{ $referral->name }}" class="form-control" required>

                                            @if ($errors->has('name'))

                                                <span class="text-danger">{{ $errors->first('name') }}</span>

                                            @endif



                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label class="col-md-3 form-control-label"></label>

                                        <div class="col-md-9">

                                            <button type="submit" class="btn btn-success">Update</button>

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

@endpush