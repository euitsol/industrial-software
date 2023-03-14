<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; line-height: 1.5em; }
        .container { padding: 40px; }
        .cv-title { text-align: center; margin-bottom: 30px; }
        .cv-title span { border-bottom: 2px solid black; }
        .float-left { float: left; }
        .float-right { float: right; }
        .clear { clear: both; }
        .photo { height: 100px; }
        .header { margin-bottom: 10px; }
        .title { margin-top: 25px; border-bottom: 1px solid peru; margin-bottom: 5px; font-style: italic; font-size: 20px; }
        .personal-info { font-size: 15px; }
        td { padding-right: 20px; }
        .education { font-size: 15px; }
    </style>

</head>
<body>

<div class="container">

    <h3 class="cv-title"> <span> Curriculum Vitae </span> </h3>

    <div class="header">
        <div class="float-left">
            <h2 class="name"> Elon Musk </h2>
            <h3 class="designation"> Chief Executive Officer </h3>
            <p> Mobile: 01784589553 </p>
            <p> E-mail: elon.musk@gmail.com </p>
        </div>

        <div class="float-right">
            @if (isset($image))
                <img src="{{ public_path($image) }}" class="photo" alt="">
            @else
                <img src="{{ public_path('/bubbly/img/avatar.png') }}" class="photo" alt="">
            @endif
        </div>

        <div class="clear"></div>
    </div>

    <div class="personal-info">
        <div class="title"> <h4>Personal Info</h4> </div>
        <table>
            <tr>
                <td>Date Of Birth</td>
                <td>:</td>
                <td> 7/7/1990 </td>
            </tr>
            <tr>
                <td>Blood Group</td>
                <td>:</td>
                <td> A+ </td>
            </tr>
            <tr>
                <td>Emergency Contact</td>
                <td>:</td>
                <td> 01785452365 </td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td> Noor Mansion (3rd Floor), Opposite of Radda MCH-FP Centre, Plot#04, Main Road#01, Mirpur-10, Dhaka-1216, Bangladesh. </td>
            </tr>
        </table>
    </div>

    <div class="education">
        <div class="title"> <h4>Education</h4> </div>
        <div class="education-info"> BSC in CSE </div>
    </div>

    <div class="reference">
        <div class="title"> <h4>Reference</h4> </div>
        <div class="reference-info">  </div>
    </div>

</div>

</body>
</html>