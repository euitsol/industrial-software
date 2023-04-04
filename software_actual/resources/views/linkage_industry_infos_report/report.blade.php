@extends('layouts.master')

@section('title', 'Linkage With Industry Information Report - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Linkage With Industry Information Report</h4>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                            <div class="mb-4 text-center">
                                <button type="button" onclick="printT('print')"
                                        class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                                </button>
                            </div>

                        <div class="clearfix">
                            <p class="float-left">
                                <i class="fa fa-money-bill"></i>
                                <b>Linkage With Industry Information Report:</b>  {{date('jS, F, Y', strtotime($from_date))}} - {{date('jS, F, Y', strtotime($to_date))}}
                                <br>
                            </p>
                            <p class="float-right">
                                <b>Print Date : </b> {{ date('D d F, Y') }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                @if(count($datas))
                                <tr>
                                    <th class="align-middle">SL</th>
                                    <th class="align-middle">Company Name</th>
                                    <th class="align-middle">Company Logo</th>
                                    <th class="align-middle">Company Website</th>
                                    <th class="align-middle">Company Address</th>
                                    <th class="align-middle">Added By</th>
                                    <th class="hide align-middle">Action</th>
                                </tr>
                                @endif
                                </thead>
                                <tbody>
                                @forelse ($datas as $key => $data)
                                    <tr>
                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                        <td class="align-middle"> {{ $data->company_name }} </td>
                                        <td class="align-middle text-center">
                                            @if (!empty($data->company_logo) && file_exists($data->company_logo))
                                                <img src="{{ asset($data->company_logo) }}" height="50" width="50" alt="Company Logo">
                                            @endif
                                        </td>
                                        <td class="align-middle"> {{ $data->company_website }} </td>
                                        <td class="align-middle"> {{ $data->company_address }} </td>
                                        <td class="align-middle"> {{ $data->created_user->name }} </td>
                                        <td class="hide align-middle">
                                            <a href="
                                            {{ route('linkage_industry_infos.report.view', $data->id) }}
                                            "
                                                class="btn btn-sm btn-dark">
                                                 <i class="fa fa-eye"></i>
                                             </a>
                                        </td>
                                    </tr>
                                @empty
                                    <h4 class="text-center">Empty</h4>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.hide').addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Job Placement Report';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
