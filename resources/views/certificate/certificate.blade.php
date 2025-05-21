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

    <h2 style="position: absolute;white-space: nowrap;top: 70px;;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;left: 2060px;">{{$data['serial_number']}}</h2>
    <h2 style="position: absolute;white-space: nowrap;top: 70px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px;left: 400px;">{{$data['para_reg_no']}}</h2>
{{--    <h2 style="position: absolute;white-space: nowrap;top: 168px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 39px; text-align: right;right: 90px">{{$data['roll_number']}}</h2>--}}
    <img style="position: absolute;top: 800px;transform: translateX(-50%); display: block;margin-left: 2225px; width: auto;height: 215px;" src="{{$data['student_image']}}" alt="">
    <h2 style="position: absolute;top: 850px;color: #4d4d4d;text-transform: uppercase;font-size: 55px; left: 0px; right: 0px; text-align: center">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 1000px;color: #4d4d4d;text-transform: uppercase;font-size: 60px;left: 0px;right: 0px; text-align: center;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <p style="position: absolute;top: 1100px;color: #4d4d4d;text-transform: uppercase;font-size: 39px;left: 0px; right: 0px; text-align: center;">{{ $data['division']  }}</p>
    <h2 style="position: absolute;top: 1450px;color: #4d4d4d;text-transform: uppercase;font-size: 39px;left: 0px; right: 0px; text-align: center;">{{ $data['year_completion']  }}</h2>
    <h2 style="position: absolute;top: 2075px;color: #4d4d4d;text-transform: uppercase;font-size: 60px;left: 0px;right: 0px; text-align: center;white-space: nowrap">{{ $data['course_name']  }}</h2>
    <h2 style="position: absolute;top: 2325px;color: #4d4d4d;text-transform: uppercase;font-size: 55px; left: 0px; right: 0px; text-align: center">{{ $student->name }}</h2>
    <h2 style="position: absolute;top: 2668px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left: 1640px; font-weight: bold;">{{ $data['year_completion']  }}</h2>
    <h4 style="position: absolute;top:2775px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 39px;margin-left:600px; font-weight: bold;">{{$data['footer_date']}}</h4>

@if($data['qr_code'])
    <img style="position: absolute;bottom: 800px;transform: translateX(-50%);text-align: left; margin: 0 auto 0 280px;" src="{{ $data['qr_code'] }}" alt="QR Code">
@endif

</body>
</html>
