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
<h2 style="position: absolute;top: 150px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 780px;">{{$data['para_reg_no']}}</h2>
<h2 style="position: absolute;top: 1400px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1400px;">{{$student['name']}}</h2>
<h2 style="position: absolute;top: 1600px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 885px;">{{$data['para_reg_no']}}</h2>
<h2 style="position: absolute;top: 1560px;transform: translateX(-10%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 40px;margin-left: 1500px;">{{$data['institute_name']}}</h2>
<h2 style="position: absolute;top: 1800px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 825px;">{{$data['year_completion']}}</h2>
<h2 style="position: absolute;top: 1800px;transform: translateX(-40%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1800px;">{{$data['division']}}</h2>
<h2 style="position: absolute;top: 2200px;transform: translateX(-25%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 1200px;">{{$data['course_name']}}</h2>
<h2 style="position: absolute;bottom: 325px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 525px;">{{$data['footer_date']}}</h2>
<h2 style="position: absolute;bottom: 225px;transform: translateX(-50%);font-weight: bold;color: #6e6c6c;text-transform: uppercase;font-size: 44px;margin-left: 525px;">SOHNA</h2>


</body>
</html>
