
@extends('layouts.master')

@section('title', 'Temp - European IT Solutions Institute')

@push('css')
    <style>
        a {
            text-decoration: none !important;
        }

        .header-right p {
            font-size: 14px !important;
        }

        .header-right h2 {
            font-size: 30px !important;
            color: #0C9FCE !important;
        }

        .header-right h5 {
            font-size: 15px !important;
            color: #0C9FCE !important;
        }

        .registration-title h2 {
            background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 2%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 90%);
            line-height: 1.4rem;
        }

        .student-information p {
            font-size: 30px !important;
        }

        .name-field span {
            margin-left: 100px !important;
        }

        ._table {
            width: auto !important;
        }

        table {
            background: none !important;
        }

        .info {
            margin-top: 50px;
        }

        body {
            background: white !important;
        }

        .student-photo {
            height: 200px;
            width: 200px;
            object-fit: cover !important;
        }
        .trcolor{
            background-color : #ECECEC !important;
        }
        .header_image img{
            height: 60px !important;
        }
        .text-bold{
            font-weight: 800;
        }
        .text-end{
            text-align:end !important;
        }
        .p-6{
            padding: 2rem;
        }
        .description-table td{
            padding: 5px !important;
        }
        .b-none{
            border: none;
        }
        .t-b{
            color: #000000;
        }
        .displayNumbers{
            display: none;
        }
        .mt-7{
            margin-top: 3rem;
        }
    </style>
    
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span>
                            <h4>Student Report</h4>
                        </span>
                        
                    </div>
                    <div class="card-body">
                    @if (session('error'))
                        <p class="alert alert-danger text-center">
                            {{ session('error') }}
                        </p>
                    @elseif(session('success'))
                        <p class="alert alert-success text-center">
                            {{ session('success') }}
                        </p>
                    @endif
                        <div class="row">
                            <div class="col-md-12 "> 

                                @if($gender == null)
                                    @foreach($c_students as $cs_count => $cs)
                                        @php 
                                            $studentsChunked = $cs->chunk(25); 
                                        @endphp
                                        @foreach($studentsChunked as $c_count => $c_student)
                                        @php 
                                            $ts = 0; 
                                        @endphp
                                        <div class="card mt-5">
                                            <div class="card-header">
                                                <span style="float:right">
                                                    <button type="button" class="btn btn-dark btn-sm print-btn" onclick="printdoc('print-{{$cs_count.$c_count}}')">
                                                        <i class="fa fa-print"></i> Print
                                                    </button>
                                                </span>
                                            </div>   
                                            <div class="card-body print-{{$cs_count.$c_count}}">
                                                <div class="row mt-3">

                                                    <div class="col-md-3 header_image">
                                                        <img src="{{asset('images/EUITSols Institute New.png')}}"  alt="logo">
                                                    </div>

                                                    <div class="col-md-8 offset-1 header-right mb-3">
                                                        <h2 class="text-right  p-0 m-0 font-weight-bold">
                                                            European IT Solutions Institute
                                                        </h2>
                                                        <p class="text-right p-0 m-0">
                                                            Noor Mansion (3rd Floor), Plot#04, Main Road#01, Mirpur-10,
                                                            Dhaka-1216
                                                        </p>
                                                        <p class="text-right p-0 m-0">
                                                            <strong>Mobile:</strong> +880 188 9977 950, +880 188 9977 951</p>
                                                        <p class="text-right p-0 m-0">
                                                            <strong>Email:</strong> info@europeanit-inst.com,
                                                            <strong>Web:</strong> www.europeanit-inst.com
                                                        </p>
                                                    </div>
                                                    <div class="p-6 d-flex align-items-center justify-content-between w-100">
                                                        <table class="table table-borderless description-table">
                                                            <tr>
                                                                <td class="text-bold">Course Name</td>
                                                                <td>:</td>
                                                                <td>{{ optional($c_student->first()->course)->title }}</td>
                                                            </tr>                               
                                                            <tr>
                                                                <td class="text-bold">Batch Name</td>
                                                                <td>:</td>
                                                                <td>EUIT{{ optional($c_student->first()->course)->title_short_form }}{{ date('Y', strtotime($c_student->first()->created_at)) }}{{ sprintf('%02d', ++$c_count) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold">Year</td>
                                                                <td>:</td>
                                                                <td>{{ date('Y', strtotime($c_student->first()->created_at)) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold">Exam name</td>
                                                                <td>:</td>
                                                                <td>Course Completion Examination</td>
                                                            </tr>
                                                        </table>
                                                        <table class="table table-borderless description-table">
                                                            <tr>
                                                                <td class="text-bold text-end">Course Duration</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">3 Months</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold text-end">Total Hours</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">360</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold text-end">Total Student</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">{{ $c_student->count() }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold text-end">Total Marks</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">100</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="registration-title col-md-7 offset-md-3">
                                                        <h2 class="text-center text-white py-2">Marksheet</h2>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered text-center display"  id="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">SL</th>
                                                            <th class="align-middle">ID</th>
                                                            <th class="align-middle">Name</th>
                                                            <th class="align-middle">Phone</th>
                                                            <th class="align-middle">Father's Name</th>
                                                            <th class="align-middle">Mother's Name</th>
                                                            <th class="align-middle">Mark</th>
                                                            <th class="align-middle">Pass/Fail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($c_student as $key => $cs)
                                                    
                                                            <tr class="details">
                                                                <td class="align-middle">{{ ++$ts }}</td>
                                                                <td class="align-middle">{{ $cs->student->year.$cs->student->reg_no }}</td>
                                                                <td class="align-middle">{{ $cs->student->name }}</td>
                                                                <td class="align-middle">{{ $cs->student->phone }}</td>
                                                                <td class="align-middle">{{ $cs->student->fathers_name }}</td>
                                                                <td class="align-middle">{{ $cs->student->mothers_name }}</td>
                                                                <td class="align-middle mark-input">
                                                                    <input type="text" class="form-control mark b-none text-center t-b">
                                                                    <p class="displayNumbers mb-0"></p>
                                                                    <span class="d-none gender">{{ $cs->student->gender }}</span>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <p class="displayStatus mb-0"></p>
                                                                </td>
                                                            
                                                            </tr>
                                                        @endforeach
                                                    </tbody>  
                                                </table> 
                                                <div class="mt-5 totalCount">
                                                    <p>Total Number of Trainees Completed : <span class="totalTrainees"  ></span></p>
                                                    <p>Percentage   of Course   Completed : <span class="courseCompleted"></span></p>
                                                    <p>Total Number of Female   Trainees  : <span class="totalFemale"></span></p>
                                                </div>
                                                <div class="mt-7 d-flex align-items-center justify-content-between">
                                                        <p class="border-top pt-2">Mentor Signature</p>
                                                        <p class="border-top pt-2">Course Co Ordinator Signature</p>
                                                        <p class="border-top pt-2">Authorized Signature</p>
                                                </div>
                                            </div>                                               
                                        </div>
                                        @endforeach                                                
                                    @endforeach
                                @else
                                    @php 
                                        $c = 0;
                                    @endphp
                                        <div class="card mt-5">
                                            <div class="card-header">
                                                <span style="float:right">
                                                    <button type="button" class="btn btn-dark btn-sm print-btn" onclick="printdoc('print-14587')">
                                                        <i class="fa fa-print"></i> Print
                                                    </button>
                                                </span>
                                            </div>   
                                            <div class="card-body print-14587">
                                                <div class="row mt-3">

                                                    <div class="col-md-3 header_image">
                                                        <img src="{{asset('images/EUITSols Institute New.png')}}"  alt="logo">
                                                    </div>

                                                    <div class="col-md-8 offset-1 header-right mb-3">
                                                        <h2 class="text-right  p-0 m-0 font-weight-bold">
                                                            European IT Solutions Institute
                                                        </h2>
                                                        <p class="text-right p-0 m-0">
                                                            Noor Mansion (3rd Floor), Plot#04, Main Road#01, Mirpur-10,
                                                            Dhaka-1216
                                                        </p>
                                                        <p class="text-right p-0 m-0">
                                                            <strong>Mobile:</strong> +880 188 9977 950, +880 188 9977 951</p>
                                                        <p class="text-right p-0 m-0">
                                                            <strong>Email:</strong> info@europeanit-inst.com,
                                                            <strong>Web:</strong> www.europeanit-inst.com
                                                        </p>
                                                    </div>
                                                    <div class="p-6 d-flex align-items-center justify-content-between w-100">
                                                        <table class="table table-borderless description-table">  
                                                            <tr>
                                                                <td class="text-bold">Course Duration</td>
                                                                <td class="">:</td>
                                                                <td class="">3 Months</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold">Year</td>
                                                                <td>:</td>
                                                                <td>{{ $year ?? 'null' }}</td>
                                                            </tr>
                                                        </table>
                                                        <table class="table table-borderless description-table">
                                                            
                                                            <tr>
                                                                <td class="text-bold text-end">Total Hours</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">360</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold text-end">Total Student</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">{{ $count }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold text-end">Total Marks</td>
                                                                <td class="text-end">:</td>
                                                                <td class="text-end">100</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="registration-title col-md-7 offset-md-3">
                                                        <h2 class="text-center text-white py-2">
                                                        Marksheet
                                                        <br><span style="font-size: 0.9rem; text-transform: capitalize;">List of {{$gender}} students</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered text-center display"  id="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">SL</th>
                                                            <th class="align-middle">ID</th>
                                                            <th class="align-middle">Name</th>
                                                            <th class="align-middle">Phone</th>
                                                            <th class="align-middle">Father's Name</th>
                                                            <th class="align-middle">Mother's Name</th>
                                                            <th class="align-middle">Course</th>
                                                            <th class="align-middle">Mark</th>
                                                            <th class="align-middle">Pass/Fail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($c_students as $cs_count => $c_s)
                                                        @foreach($c_s as $key => $cs)

                                                    
                                                            <tr class="details">
                                                                <td class="align-middle">{{ ++$c }}</td>
                                                                <td class="align-middle">{{ $cs->student->year.$cs->student->reg_no }}</td>
                                                                <td class="align-middle">{{ $cs->student->name }}</td>
                                                                <td class="align-middle">{{ $cs->student->phone }}</td>
                                                                <td class="align-middle">{{ $cs->student->fathers_name }}</td>
                                                                <td class="align-middle">{{ $cs->student->mothers_name }}</td>
                                                                <td class="align-middle">{{ optional($cs->course)->title }}</td>

                                                                <td class="align-middle mark-input">
                                                                    <input type="text" class="form-control mark b-none text-center t-b">
                                                                    <p class="displayNumbers mb-0"></p>
                                                                    <span class="d-none gender">{{ $cs->student->gender }}</span>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <p class="displayStatus mb-0"></p>
                                                                </td>
                                                            
                                                            </tr>
                                                        @endforeach                                             
                                                    @endforeach
                                                    </tbody>  
                                                </table> 
                                                <div class="mt-5 totalCount">
                                                    <p>Total Number of Trainees Completed : <span class="totalTrainees"  ></span></p>
                                                    <p>Percentage   of Course   Completed : <span class="courseCompleted"></span></p>
                                                    <p>Total Number of Female   Trainees  : <span class="totalFemale"></span></p>
                                                </div>
                                                <div class="mt-7 d-flex align-items-center justify-content-between">
                                                        <p class="border-top pt-2">Mentor Signature</p>
                                                        <p class="border-top pt-2">Course Co Ordinator Signature</p>
                                                        <p class="border-top pt-2">Principal Signature</p>
                                                </div>
                                                
                                                <div class="mt-2 text-center">
                                                        <p class="" style="font-size: 10px"># This is a software generated marksheet</p>
                                                </div>

                                            </div>                                               
                                        </div>
                                @endif
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
<script>
    $(document).ready(function() {
        $('.mark').on('input, click, change', function(){
            console.log($(this).val());

            var mark = parseInt($(this).val());
            $(this).siblings('.displayNumbers').text(mark);
            var statusElement = $(this).closest('tr').find('.displayStatus');

            if (mark >= 60) {
                statusElement.text('Pass');
            } else if (mark == 0) {
                statusElement.text('Dropout');
            } else {
                statusElement.text('Fail');
            }

            calculateTotals(this);

        });
    });

    function calculateTotals(selector) {
        var totalTrainees = 0;
        var notCompletedTrainees = 0;
        var totalFemale = 0;

        var countDiv = $(selector).closest('.card-body').find('.totalCount');

        $(selector).closest('tbody').find('tr').each(function(e) {
            let mark = parseInt($(this).find('.mark').val());
            console.log("Mark", mark);
            if (mark == 0) {
                notCompletedTrainees++;
            }

            
            totalTrainees++;

            let gender = $(this).find('.gender').html();
            if(gender == 'female'){
                totalFemale++;
            }
        });

        var percentageCompleted = ((totalTrainees - notCompletedTrainees) / totalTrainees) * 100;

        countDiv.find('.totalTrainees').text(totalTrainees - notCompletedTrainees);
        countDiv.find('.courseCompleted').text(percentageCompleted.toFixed(2) + '%');
        countDiv.find('.totalFemale').text(totalFemale);
    }

    function printdoc(cn){
        console.log(cn);
        var rp = document.body.innerHTML;
        var pc = document.querySelector('.'+cn).innerHTML;
        document.body.innerHTML = pc;
        document.title = 'student-list';

        $('.mark').hide();
        $('.displayNumbers').show();

        window.print();
        document.body.innerHTML = rp;

    };
</script>
@endpush




