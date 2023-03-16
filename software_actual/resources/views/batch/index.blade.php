@extends('layouts.master')

@section('title', 'Batches - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
    <style>
        .accordion-container {
            position: relative;
            width: 100%;
            border: 1px solid rgba(0, 121, 193, 0.11);
            border-top: none;
            outline: 0;
            cursor: pointer
        }

        .accordion-container .article-title {
            display: block;
            position: relative;
            margin: 0;
            padding: 0.625em 0.625em 0.625em 2em;
            border-top: 1px solid rgba(0, 121, 193, 0.11);
            font-size: 1.25em;
            font-weight: normal;
            cursor: pointer;
        }

        .accordion-container .article-title:hover,
        .accordion-container .article-title:active,
        .accordion-container .content-entry.open .article-title {
            background-color: #4680ff;
            color: white;
        }

        .accordion-container .article-title:hover i:before,
        .accordion-container .article-title:hover i:active,
        .accordion-container .content-entry.open i {
            color: white;
        }

        .accordion-container .content-entry i {
            position: absolute;
            top: 3px;
            left: 12px;
            font-style: normal;
            font-size: 1.625em;
            color: #0079c1;
        }

        .accordion-container .content-entry i:before {
            content: "+ ";
        }

        .accordion-container .content-entry.open i:before {
            content: "- ";
        }

        .accordion-content {
            display: none;
            padding-left: 2.3125em;
        }

        #content {
            width: 100%;
        }

        .accordion-container,
        #description p {
            line-height: 1.5;
        }

        #description h2 {
            text-align: center;
        }
        
        .accordion-container .content-entry .custom-button i {
            position: unset !important;
        }

        .accordion-container .content-entry .custom-button i:before {
            content: "" !important;
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
                        <h4>Batches</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('batch.create') }}"
                           class="btn btn-primary btn-sm">Add Batch</a>
                    </span>
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

                        <nav style="margin-bottom: 10px;">
                            <div class="nav nav-tabs nav-fill" id="nav-tab"
                                 role="tablist">
                                <a class="nav-item nav-link active"
                                   id="nav-home-tab" data-toggle="tab"
                                   href="#industrial" role="tab"
                                   aria-controls="industrial"
                                   aria-selected="true">Industrial</a>
                                <a class="nav-item nav-link"
                                   id="nav-profile-tab" data-toggle="tab"
                                   href="#professional"
                                   role="tab" aria-controls="professional"
                                   aria-selected="false">Professional</a>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active"
                                 id="industrial" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <section id="content">
                                    <div id="accordion" class="accordion-container">
                                        @if (count($in_batches) > 0)
                                            @foreach ($in_batches as $key1 => $in_batch)
                                                <article class="content-entry">
                                                    <h4 class="article-title"><i></i> {{$key1}}</h4>
                                                    <div class="accordion-content">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <th>Batch</th>
                                                                <th>Lab/Classroom Name</th>
                                                                <th>Available Students</th>
                                                                <th>Status</th>
                                                                <th>Duration Changing</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            @foreach($in_batch as $ib)
                                                                <tr>
                                                                    <td>{{ batch_name(optional($ib->course)->title_short_form, $ib->year, $ib->month, $ib->batch_number) }}</td>
                                                                    <td>{{ $ib->lab->lab_name ?? 'N/A'}}</td>
                                                                    <td>{{$ib->students->count()}}</td>
                                                                    <td>
                                                                        @php    
                                                                            $start_date = Carbon\Carbon::parse($ib->start_date);
                                                                            $end_date = Carbon\Carbon::parse($ib->end_date);
                                                                            $previous_end_date = Carbon\Carbon::parse($ib->previous_end_date);
                                                                        @endphp
                                                                        @if(!empty($ib->start_date) && !empty($ib->end_date))
                                                                            @if($now < $start_date && $ib->status ==1)
                                                                                {{$now->diffInDays($start_date)}} day's to start
                                                                            @elseif($now > $start_date && $now < $end_date && $ib->status ==1)
                                                                                {{$now->diffInDays($end_date)}} day's to end
                                                                            @else
                                                                                @if($now <= $end_date)
                                                                                    Hold
                                                                                @else
                                                                                    Ended
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @if(empty($ib->start_date) && !empty($ib->end_date))
                                                                                Batch start not set!
                                                                            @elseif(!empty($ib->start_date) && empty($ib->end_date))
                                                                                Batch end not set!
                                                                            @else
                                                                                Batch date not set!
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if(!empty($ib->previous_end_date) && !empty($ib->end_date) && !empty($ib->start_date))
                                                                            {{$ib->endChangeCalculate($ib->previous_end_date, $ib->end_date)}}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('batch.details', $ib->id)}}"
                                                                           class="btn btn-sm btn-outline-primary mb-2"
                                                                           >Details</a>
                                                                        <a href="{{route('batch.edit', $ib->id)}}"
                                                                           class="btn btn-sm btn-outline-info mb-2"
                                                                           >Edit</a>
                                                                        <a href="{{route('batch.delete', $ib->id)}}"
                                                                           onclick="return confirm('Are you sure to delete this?')"
                                                                           class="btn btn-sm btn-outline-danger mb-2"
                                                                           >Delete</a>
                                                                        @if(!empty($ib->start_date) && !empty($ib->end_date))
                                                                            @if($now <= $end_date)
                                                                                <a href="{{route('batch.status', $ib->id)}}"
                                                                                onclick="return confirm('Are you sure you want to change status?')"
                                                                                class="btn btn-sm @if($ib->status == 1) btn-outline-danger @else btn-outline-info @endif mb-2"
                                                                                > @if($ib->status == 1) Hold Batch @else Start Batch @endif</a>
                                                                            @else
                                                                               <a href="javascript:void(0)"
                                                                               class="btn btn-sm btn-outline-secondary disabled mb-2"
                                                                               >Batch Ended
                                                                               </a>
                                                                            @endif
                                                                        @else
                                                                            @if(empty($ib->start_date) && !empty($ib->end_date))
                                                                                <a href="{{route('batch.edit', $ib->id)}}"class="btn btn-sm btn-outline-info mb-2">Set Start Date</a>
                                                                            @elseif(!empty($ib->start_date) && empty($ib->end_date))
                                                                                <a href="{{route('batch.edit', $ib->id)}}"class="btn btn-sm btn-outline-info mb-2">Set End Date</a>
                                                                            @else
                                                                                <a href="{{route('batch.edit', $ib->id)}}"class="btn btn-sm btn-outline-info mb-2">Set Batch Date</a>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </article>
                                            @endforeach
                                        @endif
                                    </div>
                                </section>

                            </div>
                            <div class="tab-pane fade" id="professional"
                                 role="tabpanel"
                                 aria-labelledby="nav-profile-tab">
                                <section id="content">
                                    <div id="accordion" class="accordion-container">
                                        @if (count($pro_batches) > 0)
                                        @foreach ($pro_batches as $key2 => $pro_batch)
                                        <article class="content-entry">
                                            <h4 class="article-title"><i></i> {{$key2}}</h4>
                                            <div class="accordion-content">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th>Batch</th>
                                                        <th>Lab/Classroom Name</th>
                                                        <th>Available Students</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach($pro_batch as $pb)
                                                        <tr>
                                                            <td>{{ batch_name(optional($pb->course)->title_short_form, $pb->year, $pb->month, $pb->batch_number) }}</td>
                                                            <td>{{ $pb->lab->lab_name ?? 'N/A'}}</td>
                                                            <td>{{$pb->students->count()}}</td>
                                                            <td>
                                                                @php    
                                                                    $start_date = Carbon\Carbon::parse($pb->start_date);
                                                                    $end_date = Carbon\Carbon::parse($pb->end_date);
                                                                    $previous_end_date = Carbon\Carbon::parse($pb->previous_end_date);
                                                                @endphp
                                                                @if(!empty($pb->start_date) && !empty($pb->end_date))
                                                                @if($now < $start_date && $pb->status ==1)
                                                                    {{$now->diffInDays($start_date)}} day's to start
                                                                @elseif($now > $start_date && $now < $end_date && $pb->status ==1)
                                                                    {{$now->diffInDays($end_date)}} day's to end
                                                                @else
                                                                    @if($now <= $end_date)
                                                                        Hold
                                                                    @else
                                                                        Ended
                                                                    @endif
                                                                @endif
                                                                @else
                                                                    @if(empty($pb->start_date) && !empty($pb->end_date))
                                                                        Batch start not set!
                                                                    @elseif(!empty($pb->start_date) && empty($pb->end_date))
                                                                        Batch end not set!
                                                                    @else
                                                                        Batch date not set!
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(!empty($pb->previous_end_date) && !empty($pb->end_date) && !empty($pb->start_date))
                                                                    {{$pb->endChangeCalculate($pb->previous_end_date, $pb->end_date)}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{route('batch.details', $pb->id)}}"
                                                                   class="btn btn-sm btn-outline-primary mb-2"
                                                                   >Details</a>
                                                                <a href="{{route('batch.edit', $pb->id)}}"
                                                                   class="btn btn-sm btn-outline-info mb-2"
                                                                   >Edit</a>
                                                                <a href="{{route('batch.delete', $pb->id)}}"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   class="btn btn-sm btn-outline-danger mb-2"
                                                                   >Delete</a>
                                                                @if(!empty($pb->start_date) && !empty($pb->end_date))
                                                                    @if($now <= $end_date)
                                                                        <a href="{{route('batch.status', $pb->id)}}"
                                                                        onclick="return confirm('Are you sure you want to change status?')"
                                                                        class="btn btn-sm @if($pb->status == 1) btn-outline-danger @else btn-outline-info @endif mb-2"
                                                                        > @if($pb->status == 1) Hold Batch @else Start Batch @endif</a>
                                                                    @else
                                                                        <a href="javascript:void(0)"
                                                                        class="btn btn-sm btn-outline-secondary disabled mb-2"
                                                                        >Batch Ended
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if(empty($pb->start_date) && !empty($pb->end_date))
                                                                        <a href="{{route('batch.edit', $pb->id)}}"class="btn btn-sm btn-outline-info mb-2">Set Start Date</a>
                                                                    @elseif(!empty($pb->start_date) && empty($pb->end_date))
                                                                        <a href="{{route('batch.edit', $pb->id)}}"class="btn btn-sm btn-outline-info mb-2">Set End Date</a>
                                                                    @else
                                                                        <a href="{{route('batch.edit', $pb->id)}}"class="btn btn-sm btn-outline-info mb-2">Set Batch Date</a>
                                                                    @endif
                                                               @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </article>
                                    @endforeach
                                    @endif
                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        title: 'Batches',
                        exportOptions: {
                            columns: ':not(.not-export)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Batches',
                        exportOptions: {
                            columns: ':not(.not-export)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Batches',
                        exportOptions: {
                            columns: ':not(.not-export)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    'print', 'pageLength'
                ]
            });

            $('#table_two').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        title: 'Batches',
                        exportOptions: {
                            columns: ':not(.not-export)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Batches',
                        exportOptions: {
                            columns: ':not(.not-export)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Batches',
                        exportOptions: {
                            columns: ':not(.not-export)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    'print', 'pageLength'
                ]
            });
        });

        $(function () {
            let Accordion = function (el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                let links = this.el.find('.article-title');
                links.on('click', {
                    el: this.el,
                    multiple: this.multiple
                }, this.dropdown)
            };

            Accordion.prototype.dropdown = function (e) {
                let $el = e.data.el;
                let $this = $(this),
                    $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.accordion-content').not($next).slideUp().parent().removeClass('open');
                }
            };
            new Accordion($('.accordion-container'), false);
        });
    </script>
@endpush
