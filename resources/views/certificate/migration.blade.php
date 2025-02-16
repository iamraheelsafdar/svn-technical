<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migration Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

    </style>
</head>

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: cover;">
<h2 style="position: relative; top:213px; margin-left: 95px; display: block; font-weight: bold;color: #000000; font-size: 18px;">{{$data['reg_no']}}</h2>
<h2 style="position: relative; top:345px; text-align: center; margin: 0 auto; display: block; font-weight: bold;color: #000000;">{{ $student->name }}</h2>
<h2 style="position: relative; top:455px; margin-left: 115px; display: block; font-weight: bold;color: #000000; font-size: 18px;">
    {{$data['roll_number']}}</h2>
<h2 style="position: relative; top:416px; margin-left: 660px; display: block; font-weight: bold;color: #000000;font-size: 18px;">{{ $student->mother_name }}</h2>
<h2 style="position: relative; top:487px; margin-left: 125px; display: block; font-weight: bold;color: #000000;font-size: 18px;">{{ $student->father_name }}</h2>
<h2 style="position: relative; top:538px; margin-left: 145px; display: block; font-weight: bold;color: #000000;font-size: 18px;">{{ $data['course_name'] }}</h2>
<h2 style="position: relative; top:630px; margin-left: 33px; display: block; font-size: 20px;font-weight: bold;color: #000000;">{{$data['institute_name']}}</h2>

<p style="position: relative; top:730px; margin-left: 33px; padding-right: 20px;display: block; font-weight: bold;color: #000000;">This
    Board has no objection in his/her joining any recognised college/ institute or taking examination of any University
    or Board established by law.</p>

<h4 style="position: relative; top:950px; margin-left: 103px; display: block; font-weight: bold;color: #000000;">{{$data['footer_date']}}</h4>

</body>
</html>
