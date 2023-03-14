@extends('layouts.master')
@section('title', 'Navigaton Control - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
    <style>
        .btn-custom {
            border: 1px solid #9e9b9b73;
            background: #d2cfcf5c !important;
            border-radius: 0 !important;
            padding: 4px 22px !important;
            color: #000;
            opacity: 1 !important;
            text-align: center;
            cursor: pointer;
            transition:.4s;
        }

        a {
            text-decoration: none !important;
        }

        .btn-custom:hover {
            background: #2066FF !important;
            color: #ffffff !important;
        }

        #fade {
            margin-top:25px !important;
            display: none;

         }
    </style>

@php
$sl_count = 0;
@endphp
@endpush
@if (!empty($message))
    <p class="message">{{$message}}</p>
@endif

@section('content')
    <div class="container">

                <div class="card">
                    <div class="card-header">
                        <h4> Navigaton Control</h4>
                    </div>

                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-12">

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
                                    <div class="col-md-5">

                                        <form action="{{ route('nav_assign.search') }}" method="post">
                                        @csrf
                                            <div class="form-group">
                                                <label for="user_type" class="form-control-label">User Type</label>
                                                <select name="user_type" id="user_type" class="form-control mb-3">
                                                    <option value="" >Enter User Type......</option>
                                                        @foreach ($users->unique('role') as $ut)
                                                            <option value="{{$ut->role}}" > {{$ut->role}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="user_name" class="form-control-label">User Name</label>
                                                <select name="user_name" id="user_name" class="form-control">
                                                    <option value="" >Enter User Name......</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="fade">
                                                <input type="submit" id="Search" value="Search" class="btn-custom">
                                                <input type="reset" id="Reset" value="Reset" class="btn-custom">
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col-md-5">

                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>SL </th>
                                                <th>Username </th>
                                                <th>Role </th>
                                            </tr>
                                        @foreach ($users as $us)
                                        <tr>
                                            @php
                                                $sl_count ++;
                                            @endphp
                                            <td>{{$sl_count}}</td>
                                            <td>{{$us->username}}</td>
                                            <td>{{$us->role}}</td>
                                        </tr>
                                        @endforeach
                                        </table>



                                    </div>
                                </div>

                            </div>
                </div>
            </div>
        </div>
    </div>






@endsection

@push('js')
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>




<script>
        $(function () {
            if ('' !== $('#user_type')) {
                $('#user_name').prop('disabled', true);
                $('#view').prop('disabled', true);


            }

            $(document).on('change', '#user_type', function () {
                let user_type = $(this).val();
                if ('' !== user_type) {
                    let _url = "{{route('user.type', ':user_type')}}";
                    let __url = _url.replace(':user_type', user_type);
                    $.ajax({
                        url: __url,
                        method: "GET",
                        success: function (response) {
                            if ('' !== response) {
                                $('#user_name').prop('disabled', false);
                                let output = '<option value="" >Enter User Name......</option>'+ response;
                                $('#user_name').html(output);
                            }
                        }
                    });
                }
            });


            $(document).on('change', '#user_name', function () {
                 $('#fade').fadeIn("slow");
            });

});
    </script>


@endpush


