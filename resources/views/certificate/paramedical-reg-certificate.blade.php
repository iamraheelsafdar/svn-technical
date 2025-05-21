<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARAMEDICAL REGISTRATION CERTIFICATE OF {{ strtoupper($student->name ) }}</title>
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

<h2 style="position: absolute;top: 162px;transform: translateX(-50%);font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 44px;margin-left: 780px;">{{$data['para_reg_no']}}</h2>
<img style="position: absolute;top: 1600px;transform: translateX(-50%); display: block;margin-left: 1250px; width: auto;height: 400px;" src="{{$data['student_image']}}" alt="">

<table style="width: 90%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; position: absolute;top: 2100px;transform: translateX(-50%); margin-left: 1250px;">
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px;  font-size: 44px; margin-left: 6px ">Student Name</th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px; font-size: 44px; margin-left: 6px">{{ $student->name }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px;  font-size: 44px; margin-left: 6px">Father's Name</th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px; font-size: 44px; margin-left: 6px">{{$student->father_name}}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px;  font-size: 44px; margin-left: 6px">Date Of Birth</th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px; font-size: 44px; margin-left: 6px">{{ $data['date_of_birth'] }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px;  font-size: 44px; margin-left: 6px">Name Of Course</th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px; font-size: 44px; margin-left: 6px">{{ $data['course_name'] }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px;  font-size: 44px; margin-left: 6px">Name Of Institute</th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px; font-size: 44px; margin-left: 6px">{{$data['institute_name']}}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px;  font-size: 44px; margin-left: 6px">Date Of Registration</th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #4d4d4d; text-align: left; text-transform: uppercase; padding: 28px 20px; font-size: 44px; margin-left: 6px">{{$data['footer_date']}}</td>
    </tr>
</table>
<h4 style="position: absolute;top: 3168px;transform: translateX(-50%);color: #4d4d4d;text-transform: uppercase;font-size: 44px;margin-left: 475px;">{{$data['footer_date']}}</h4>

</body>
</html>
