@extends('layouts.master')

@section('title', '')

@push('css')

@endpush

@section('content')
    <nav style="margin-bottom: 10px;">
        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
               href="#industrial" role="tab" aria-controls="industrial" aria-selected="true">Industrial</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#professional"
               role="tab" aria-controls="professional" aria-selected="false">Professional</a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="industrial" role="tabpanel"
             aria-labelledby="nav-home-tab">
            <div class="table-responsive">
                <table id="table_one" class="display nowrap">
                    <thead>
                    <tr>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="professional" role="tabpanel"
             aria-labelledby="nav-profile-tab">
            <div class="table-responsive">
                <table id="table_two" class="display nowrap">
                    <thead>
                    <tr>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush

