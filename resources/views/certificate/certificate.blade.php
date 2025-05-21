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

@if($data['stream'] == 'ITI')
    <h2 style="position: absolute;white-space: nowrap;top: 170px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 230px;">{{$data['certificate_serial_number']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 170px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{$data['para_reg_no']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 170px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px; text-align: right;right: 90px">{{$data['roll_number']}}</h2>
    <img style="position: absolute;top: 1070px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">
    <h2 style="position: absolute;top: 1230px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 55px;margin-left: 1250px;">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 1430px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <p style="position: absolute;top: 1535px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{ $data['division']  }}</p>
    <h2 style="position: absolute;top: 1880px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{ $data['year_completion']  }}</h2>
    <h2 style="position: absolute;top: 2270px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <h2 style="position: absolute;top: 2475px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 55px;margin-left: 1250px;">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 2805px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1470px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
    <h4 style="position: absolute;top:3320px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left:500px; font-weight: bold;">{{$data['footer_date']}}</h4>
@endif

@if($data['stream'] == 'PARAMEDICAL')
    <h2 style="position: absolute;white-space: nowrap;top: 168px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 230px;">{{$data['certificate_serial_number']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 168px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{$data['para_reg_no']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 168px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px; text-align: right;right: 90px">{{$data['roll_number']}}</h2>
    <img style="position: absolute;top: 1000px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">
    <h2 style="position: absolute;top: 1230px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 55px;margin-left: 1250px;">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 1430px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <p style="position: absolute;top: 1535px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{ $data['division']  }}</p>
    <h2 style="position: absolute;top: 1850px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{ $data['year_completion']  }}</h2>
    <h2 style="position: absolute;top: 2300px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <h2 style="position: absolute;top: 2540px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 55px;margin-left: 1250px;">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 2903px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1450px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
    <h4 style="position: absolute;top:3305px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left:500px; font-weight: bold;">{{$data['footer_date']}}</h4>
@endif

@if($data['stream'] == 'TECHNOLOGY & MGMT')
    <h2 style="position: absolute;white-space: nowrap;top: 168px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 230px;">{{$data['certificate_serial_number']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 168px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{$data['para_reg_no']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 168px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px; text-align: right;right: 90px">{{$data['roll_number']}}</h2>
    <img style="position: absolute;top: 1050px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">
    <h2 style="position: absolute;top: 1200px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 55px;margin-left: 1250px;">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 1420px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <p style="position: absolute;top: 1525px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{ $data['division']  }}</p>
    <h2 style="position: absolute;top: 1880px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1250px;">{{ $data['year_completion']  }}</h2>
    <h2 style="position: absolute;top: 2300px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 1250px;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <h2 style="position: absolute;top: 2540px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 55px;margin-left: 1250px;">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 2878px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1450px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
    <h4 style="position: absolute;top:3298px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left:400px; font-weight: bold;">{{$data['footer_date']}}</h4>
@endif

@if($data['qr_code'])
    <img style="position: absolute;bottom: 500px;transform: translateX(-50%);text-align: left; margin: 0 auto 0 280px;" src="{{ $data['qr_code'] }}" alt="QR Code">
@endif

</body>
</html>
