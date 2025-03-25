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
<h2 style="position: absolute;top: 50px;transform: translateX(-50%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 260px;">{{$data['para_reg_no']}}</h2>
<h2 style="position: absolute;top: 452px;transform: translateX(-50%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 390px;">{{$student['name']}}</h2>
<h2 style="position: absolute;top: 520px;transform: translateX(-50%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 270px;">{{$data['para_reg_no']}}</h2>
<h2 style="position: absolute;top: 510px;transform: translateX(-10%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 12px;margin-left: 490px;">{{$data['institute_name']}}</h2>
<h2 style="position: absolute;top: 585px;transform: translateX(-50%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 250px;">{{$data['year_completion']}}</h2>
<h2 style="position: absolute;top: 585px;transform: translateX(-40%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 590px;">{{$data['division']}}</h2>
<h2 style="position: absolute;top: 715px;transform: translateX(-25%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 350px;">{{$data['course_name']}}</h2>
<h2 style="position: absolute;bottom: 105px;transform: translateX(-50%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 170px;">{{$data['footer_date']}}</h2>
<h2 style="position: absolute;bottom: 75px;transform: translateX(-50%);font-weight: bold;color: #000000;text-transform: uppercase;font-size: 14px;margin-left: 170px;">SOHNA</h2>


</body>
</html>
