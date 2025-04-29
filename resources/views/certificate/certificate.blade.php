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
<h2 style="position: absolute;top: 165px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 230px;">{{$data['serial_number']}}</h2>
<h2 style="position: absolute;top: 165px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1250px;">{{$data['para_reg_no']}}</h2>
<h2 style="position: absolute;top: 165px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 2080px;">{{$data['roll_number']}}</h2>

@if($data['stream'] == 'PARAMEDICAL')
<img style="position: absolute;top: 1000px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">

@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
<img style="position: absolute;top: 1050px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">
@endif

@if($data['stream'] == 'ITI')
<img style="position: absolute;top: 1050px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">
@endif

<h2 style="position: absolute;top: 1200px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 60px;margin-left: 1250px;">{{ $student->name }}</h2>
<h2 style="position: absolute;top: 1420px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 65px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
<p style="position: absolute;top: 1525px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1250px;">{{ $data['division']  }}</p>

@if($data['stream'] == 'PARAMEDICAL')
<h2 style="position: absolute;top: 1880px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1250px;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
<h2 style="position: absolute;top: 1880px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1250px;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'ITI')
<h2 style="position: absolute;top: 1880px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1250px;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'ITI')
<h2 style="position: absolute;top: 2225px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 65px;margin-left: 1250px;">{{ $data['course_name']  }}</h2>
@else
<h2 style="position: absolute;top: 2300px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 65px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
@endif

@if($data['stream'] == 'ITI')
<h2 style="position: absolute;top: 2440px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 60px;margin-left: 1250px;">{{ $student->name }}</h2>
<h2 style="position: absolute;top: 2760px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1450px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'PARAMEDICAL')
<h2 style="position: absolute;top: 2540px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 60px;margin-left: 1250px;">{{ $student->name }}</h2>
<h2 style="position: absolute;top: 2900px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1450px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
<h2 style="position: absolute;top: 2540px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 60px;margin-left: 1250px;">{{ $student->name }}</h2>
<h2 style="position: absolute;top: 2875px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1450px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
@endif



<h4 style="position: absolute;top: 3280px;transform: translateX(-50%);color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 400px; font-weight: bold;">{{$data['footer_date']}}</h4>

</body>
</html>
