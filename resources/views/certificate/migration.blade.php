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
<h2 style="position: relative;top: 545px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 44px;margin-left: 250px;">{{$data['reg_no']}}</h2>
<h2 style="position: relative;top: 950px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 60px;text-align: center;">{{ $student->name }}</h2>
<h2 style="position: relative;top: 1120px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;margin-left: 350px;">{{$data['roll_number']}}</h2>
<h2 style="position: relative;top: 1000px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;margin-left: 1700px;">{{ $student->mother_name }}</h2>
<h2 style="position: relative;top: 1150px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;margin-left: 350px;">{{ $student->father_name }}</h2>
<h2 style="position: relative;top: 1300px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 50px;margin-left: 400px;">{{ $data['course_name'] }}</h2>
<h2 style="position: relative;top: 1550px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 60px;margin-left: 90px;">{{$data['institute_name']}}</h2>

<p style="position: relative; top:1850px; margin-left: 90px; padding-right: 20px;display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">This
    Board has no objection in his/her joining any recognised college/ institute or taking examination of any University
    or Board established by law.</p>

<h4 style="position: relative; top:2300px; margin-left: 300px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px;">{{$data['footer_date']}}</h4>

</body>
</html>
