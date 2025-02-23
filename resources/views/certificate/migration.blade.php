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
<h2 style="position: relative; top:170px; margin-left: 85px; display: block; font-weight: bold;color: #000000; font-size: 17px;">{{$data['reg_no']}}</h2>
<h2 style="position: relative; top:290px; text-align: center; margin: 0 auto; display: block; font-weight: bold;color: #000000;">{{ $student->name }}</h2>
<h2 style="position: relative; top:353px; margin-left: 115px; display: block; font-weight: bold;color: #000000; font-size: 18px;">{{$data['roll_number']}}</h2>
<h2 style="position: relative; top:313px; margin-left: 550px; display: block; font-weight: bold;color: #000000;font-size: 18px;">{{ $student->mother_name }}</h2>
<h2 style="position: relative; top:367px; margin-left: 125px; display: block; font-weight: bold;color: #000000;font-size: 18px;">{{ $student->father_name }}</h2>
<h2 style="position: relative; top:400px; margin-left: 145px; display: block; font-weight: bold;color: #000000;font-size: 18px;">{{ $data['course_name'] }}</h2>
<h2 style="position: relative; top:470px; margin-left: 33px; display: block; font-size: 18px;font-weight: bold;color: #000000;">{{$data['institute_name']}}</h2>

<p style="position: relative; top:580px; margin-left: 33px; padding-right: 20px;display: block; font-weight: bold;color: #000000;font-size: 14px">This
    Board has no objection in his/her joining any recognised college/ institute or taking examination of any University
    or Board established by law.</p>

<h4 style="position: relative; top:725px; margin-left: 103px; display: block; font-weight: bold;color: #000000;">{{$data['footer_date']}}</h4>

</body>
</html>
