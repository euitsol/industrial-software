@extends('layouts.master')

@section('title', '')

@push('css')

@endpush

@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item active">
            <a data-toggle="tab" href="#home" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
            <a data-toggle="tab" href="#menu1" class="nav-link">Menu 1</a>
        </li>
        <li class="nav-item">
            <a data-toggle="tab" href="#menu2" class="nav-link">Menu 2</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h3>HOME</h3>
            <p>Some content.</p>
        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Some content in menu 1.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Menu 2</h3>
            <p>Some content in menu 2.</p>
        </div>
    </div>
@endsection

@push('js')

@endpush

