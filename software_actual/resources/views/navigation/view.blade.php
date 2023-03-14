@extends('layouts.master')
@section('title', 'Navigaton Control - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
    <style>
        body 
        {
            
        }
        i
        {
            
        }
        .submenu
        {
            
            margin-left: 145px !important;
        }
        .menu_margin{
            margin-left:150px;
        }
        .form-check-input{
            margin-top: 4px !important;
        }
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


@endpush
@if (!empty($message))
    <p class="message">{{$message}}</p>
@endif

@section('content')
    <div class="container">

                <div class="card">
                    <div class="card-header">
                        <h4> Navigaton Control Menu</h4>
                    </div>

                    <div class="card-body bg-secondary bg-gradient">
                        <div class="row align-items-center">
                            <div class="col-md-12 menu_margin" >

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                    {{ session('success') }}
                                    </p>
                                 @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                    {{ session('error') }}
                                    </p>
                                @endif
                                <div class="col-md-10  m-auto">
                                    <div class="menu">
                                    <form action ="{{ route('nav_assign.save') }}" method="post" >
                                        @csrf
                                        <div class="row align-items-center">
                                        @php

                                            print_r($output_2);

                                        @endphp


                                        <button class="btn btn-info col-md-7" type="submit">submit</button>

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
    <script type="text/javascript">

    function toggle_visibility(submenu) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }

</script>
@endpush
