@extends('layouts.web')

@section('title', 'Registration - European IT Solutions Institute')

@push('css')    
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        h1{
            color: #88B04B;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p{
            color: #404F5E;
            font-size:20px;
            margin: 0;
        }
        i{
            color: #9ABC66;
            font-size: 100px;
        }
    </style>
@endpush


@section('content')
    <div class="container">
        <div class="p-2 justify-content-center">
            <div class="">
                <div style="margin:0 auto; display:flex; align-items: center; justify-content: center;">
                    <i class="checkmark">✓</i>
                </div>
                <h1 class="text-center">Success!</h1> 
                <p class="text-justify">To finalize your admission and secure your spot in the course, please proceed with the payment of the course fee</p>
            </div>
        </div>
    </div>