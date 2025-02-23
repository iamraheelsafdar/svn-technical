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
<h2 style="position: relative; top:50px; margin-left: 165px; display: block; font-weight: bold;color: #6e6c6c; font-size: 16px">{{$data['para_reg_no']}}</h2>
<img
    style="display: block; margin-left: 370px; text-align: center; width: auto;height: 70px; position: relative; top: 455px"
    src="{{$data['student_image']}}" alt="">
<table
    style="width: 80%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; position: relative; top: 483px; margin-left: 80px">
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; padding: 10px 6px;  font-size: 12px; margin-left: 6px ">
            Student Name
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 12px; margin-left: 6px">{{ $student->name }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px;  font-size: 12px; margin-left: 6px">
            Father's Name
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 12px; margin-left: 6px">{{$student->father_name}}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px;  font-size: 12px; margin-left: 6px">
            Date Of Birth
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 12px; margin-left: 6px">{{ $data['date_of_birth'] }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px;  font-size: 12px; margin-left: 6px">
            Name Of Course
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 12px; margin-left: 6px">{{ $data['course_name'] }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px;  font-size: 12px; margin-left: 6px">
            Name Of Institute
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 12px; margin-left: 6px">
            {{$data['institute_name']}}
        </td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px;  font-size: 12px; margin-left: 6px">
            Date Of Registration
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 12px; margin-left: 6px">{{$data['reg_date']}}</td>
    </tr>
</table>
<h4 style="position: relative; top:680px; margin-left: 115px; display: block; color: #6e6c6c; text-transform: uppercase">{{$data['footer_date']}}</h4>

</body>
</html>
