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

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: contain;">
<h2 style="position: relative; top:203px; margin-left: 95px; display: block; font-weight: bold;color: #6e6c6c;">{{$data['reg_no']}}</h2>
<h2 style="position: relative; top:345px; text-align: center; margin: 0 auto; display: block; font-weight: bold;color: #6e6c6c;">{{ $student->name }}</h2>
<h2 style="position: relative; top:423px; margin-left: 115px; display: block; font-weight: bold;color: #6e6c6c;">
    123</h2>
<h2 style="position: relative; top:373px; margin-left: 655px; display: block; font-weight: bold;color: #6e6c6c;">{{ $student->mother_name }}</h2>
<h2 style="position: relative; top:433px; margin-left: 125px; display: block; font-weight: bold;color: #6e6c6c;">{{ $student->father_name }}</h2>
<h2 style="position: relative; top:600px; margin-left: 33px; display: block; font-weight: bold;color: #6e6c6c;">SWAMI
    VIVEKANAND INSTITUTE OF TECHNOLOGY & MANAGEMENT , SOHNA</h2>

<p style="position: relative; top:700px; margin-left: 33px; padding-right: 20px;display: block; font-weight: bold;color: #6e6c6c;">This
    Board has no objection in his/her joining any recognised college/ institute or taking examination of any University
    or Board established by law.</p>

<h4 style="position: relative; top:923px; margin-left: 103px; display: block; font-weight: bold;color: #6e6c6c;">{{$data['footer_date']}}</h4>

</body>
</html>
