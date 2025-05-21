<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{strtoupper($data['stream'])}} MIGRATION OF {{ strtoupper($student->name) }}</title>
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

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: cover;">
@if($data['stream'] == 'TECHNOLOGY & MGMT')
    <h2 style="position: absolute;white-space: nowrap;top: 113px;;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 34px;left: 380px;">{{$data['reg_no']}}</h2>
    <h2 style="position: absolute;top: 1175px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;text-align: center;left: 0px; right: 0px">{{ $student->name }}</h2>
{{--    <h2 style="position: relative;top: 1175px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 45px;margin-left: 350px;">{{$data['roll_number']}}</h2>--}}
{{--    <h2 style="position: relative;top: 1075px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 45px;margin-left: 1710px;">{{ $student->mother_name }}</h2>--}}
    <h2 style="position: absolute;top: 1425px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;text-align: center;left: 0px; right: 0px">{{ $student->father_name }}</h2>
    <h2 style="position: absolute;top: 1700px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;text-align: center;left: 0px; right: 0px">{{ $data['para_reg_no'] }}</h2>
    <h2 style="position: absolute;top: 1950px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;text-align: center;left: 0px; right: 0px">{{ $data['course_name'] }}</h2>
    <h2 style="position: absolute;top: 2200px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;margin-left: 350px;">{{$data['institute_name']}}</h2>
{{--    <p style="position: relative; top:1900px; margin-left: 90px; padding-right: 20px;display: block; font-weight: bold;color: #4d4d4d;font-size: 39px; margin-right: 30px">This Board has no objection in his/her joining any recognised college/ institute or taking examination of any University or Board established by law.</p>--}}
    <h4 style="position: absolute; bottom:140px; margin-left: 450px; display: block; font-weight: bold;color: #4d4d4d;font-size: 50px;">{{$data['footer_date']}}</h4>
@endif
</body>
</html>
