<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * { font-family: sans-serif; }
        .container { width: 90%; margin: 20px auto; }
        .name { font-family: Lobster; margin: 0; }
        .designation { margin: 5px 0px; font-family: sans-serif; letter-spacing: 1px; }
        .content-header { border-bottom: 1px solid gray; font-family: Lobster; margin: 0; }
        .date { float: left; width: 30%; }
        .description { float: left; width: 70%; }
        .clearfix { content: ''; clear: both; display: block; }
        .float-left { float: left; }
        .float-right { float: right; }
        .phone { font-size: 15px; }
        .email { font-size: 15px; margin-top: -10px; }
        .objective { margin: -5px 0px 0px 0px; }
        .objective p { font-size: 15px; line-height: 1.6; color: #6D6D6D !important; text-align: justify; }
        .content-header { padding: 5px 0px; }
        .date { margin: 15px 0px; font-weight: bold; }
        .designation-2 { margin: 0; padding: 0; }
        .description h3 { font-size: 18px; margin: 0; }
        .description ul { margin-left: -25px; }
        .description ul li { line-height: 1.6; font-size: 15px; color: #6D6D6D !important; }
        .description p { padding: 9px 0px; font-style: italic; color: #6D6D6D !important; }
        .skill { padding: 5px 0px !important; font-style: normal !important; font-size: 15px; }
        .software-wrap { margin-top: -12px !important; }
        .software { font-style: normal !important; padding: 5px 0px !important; font-size: 15px !important; }
        .certification-wrap { margin-top: -12px !important; }
        .certification-date { padding-top: 5px !important; display: block; font-size: 15px !important; }
        .certification { padding: 5px 0px !important; font-style: normal !important; font-size: 15px !important; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="header">
            <div class="float-left">
                <h1 class="name">John Smith</h1>
                <h4 class="designation">IT Project Manager</h4>
                <p class="phone"><strong>Phone :</strong> 7774-98-4009</p>
                <p class="email"><strong>Email :</strong> john@gmail.com</p>
            </div>
            <div class="float-right">
                <img src="{{ public_path() }}/assets/img/avatar-1.jpg" height="150" alt="Photo">
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="objective">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, quasi necessitatibus. Tempore saepe distinctio corporis laudantium consectetur, doloribus deleniti in deserunt facilis, tempora cupiditate possimus! Qui enim ab iure alias quam, cum, quis ipsam quae sapiente iste odit? Consequuntur quidem harum at eligendi voluptatum.
            </p>
        </div>
        <div class="content-wrapper">
            <h2 class="content-header">Experience</h2>
            <div class="content">
                <div class="date">
                    2006-12-Present
                </div>
                <div class="description">
                    <h3>Senior Project Manager</h3>
                    <p class="designation-2">Seton Hospital, ME</p>
                    <ul>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="content">
                <div class="date">
                    2006-12-Present
                </div>
                <div class="description">
                    <h3>Senior Project Manager</h3>
                    <p class="designation-2">Seton Hospital, ME</p>
                    <ul>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="content-wrapper">
            <h2 class="content-header">Education</h2>
            <div class="content">
                <div class="date float-left">
                    2006-12-Present
                </div>
                <div class="description float-right">
                    <h3>Senior Project Manager</h3>
                    <ul>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="content">
                <div class="date float-left">
                    2006-12-Present
                </div>
                <div class="description float-right">
                    <h3>Senior Project Manager</h3>
                    <ul>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                        <li>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero minima voluptates itaque.
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        
        <div class="content-wrapper">
            <h2 class="content-header">Software</h2>
            <div class="content">
                <div class="date float-left">
                    
                </div>
                <div class="description float-right software-wrap">
                    <p class="software">Microsoft Project</p>
                    <p class="software">Microsoft Project</p>
                    <p class="software">Microsoft Project</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="content-wrapper">
            <h2 class="content-header">Certification</h2>
            <div class="content">
                <div class="date float-left">
                    <span class="certification-date">2006-12-Present</span>
                </div>
                <div class="description float-right certification-wrap">
                    <p class="certification">Microsoft Project</p>
                    <p class="certification">Microsoft Project</p>
                    <p class="certification">Microsoft Project</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</body>
</html>