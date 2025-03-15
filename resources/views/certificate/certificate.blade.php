<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{strtoupper($data['stream'])}} CERTIFICATE OF {{ strtoupper($student->name) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: contain;">
<h2 style="position: relative; top:58px; margin-left: 30px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 15px">{{$data['serial_number']}}</h2>
<h2 style="position: relative; top:25px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 15px">{{$data['para_reg_no']}}</h2>
<h2 style="position: relative; top:-6px; margin-right: 30px; text-align: right; display: block; font-weight: bold;color: #6e6c6c;font-size: 15px">{{$data['roll_number']}}</h2>

@if($data['stream'] == 'PARAMEDICAL')
<img style="display: block; margin-left: 680px; text-align: center; width: auto;height: 70px; position: relative; top: 210px" src="{{$data['student_image']}}" alt="">

@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
<img style="display: block; margin-left: 680px; text-align: center; width: auto;height: 70px; position: relative; top: 230px" src="{{$data['student_image']}}" alt="">
@endif

@if($data['stream'] == 'ITI')
<img style="display: block; margin-left: 680px; text-align: center; width: auto;height: 70px; position: relative; top: 230px" src="{{$data['student_image']}}" alt="">
@endif

<h2 style="position: relative; top:215px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 20px">{{ $student->name }}</h2>
<h2 style="position: relative; top:240px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 24px">{{ $data['course_name']  }}</h2>
<p style="position: relative; top:220px; text-align: center; display: block;color: #6e6c6c;font-size: 16px">{{ $data['division']  }}</p>

@if($data['stream'] == 'PARAMEDICAL')
<h2 style="position: relative; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px; top:290px;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
<h2 style="position: relative; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px; top: 295px;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'ITI')
<h2 style="position: relative; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px; top: 295px;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'ITI')
<h2 style="position: relative; top:365px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $data['course_name']  }}</h2>
@else
<h2 style="position: relative; top:385px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $data['course_name']  }}</h2>
@endif

@if($data['stream'] == 'ITI')
<h2 style="position: relative; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px;top:375px;">{{ $student->name }}</h2>
<h2 style="position: relative; left:85px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px; top: 415px">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'PARAMEDICAL')
<h2 style="position: relative; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px;top:400px">{{ $student->name }}</h2>
<h2 style="position: relative; left:85px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px; top:458px">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
<h2 style="position: relative; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px;top:395px">{{ $student->name }}</h2>
<h2 style="position: relative; left:85px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px; top: 450px">{{ $data['year_completion']  }}</h2>
@endif



<h4 style="position: relative; top:550px; margin-left: 135px; display: block; font-weight: bold;color: #6e6c6c; text-transform: uppercase">{{$data['footer_date']}}</h4>

</body>
</html>
