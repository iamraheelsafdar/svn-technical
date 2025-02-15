<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramedical Registration Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

    </style>
</head>

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: contain;">
<h2 style="position: relative; top:53px; margin-left: 195px; display: block; font-weight: bold;color: #6e6c6c;">{{$data['reg_no']}}</h2>
<img
    style="display: block; margin-left: 410px; text-align: center; width: auto;height: 150px; position: relative; top: 550px"
    src="{{$data['student_image']}}" alt="">
<table
    style="width: 80%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; position: relative; top: 583px; margin-left: 80px">
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; padding: 10px 6px; font-weight: bold; font-size: 17px; margin-left: 6px ">
            Student Name
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 17px; margin-left: 6px">{{ $student->name }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-weight: bold; font-size: 17px; margin-left: 6px">
            Father's Name
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 17px; margin-left: 6px">{{$student->father_name}}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-weight: bold; font-size: 17px; margin-left: 6px">
            Date Of Birth
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 17px; margin-left: 6px">{{ $data['date_of_birth'] }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-weight: bold; font-size: 17px; margin-left: 6px">
            Name Of Course
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 17px; margin-left: 6px">{{ $data['course_name'] }}</td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-weight: bold; font-size: 17px; margin-left: 6px">
            Name Of Institute
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 17px; margin-left: 6px">
            SWAMI VIVEKANAND INSTITUTE OF PARAMEDICAL SCIENCE, SOHNA
        </td>
    </tr>
    <tr>
        <th style="white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-weight: bold; font-size: 17px; margin-left: 6px">
            Date Of Registration
        </th>
        <td style="width: 100%; white-space: nowrap; border-collapse: collapse; border: 1px solid #000; text-align: left; text-transform: uppercase; padding: 10px 6px; font-size: 17px; margin-left: 6px">{{$data['footer_date']}}</td>
    </tr>
</table>
<h4 style="position: relative; top:770px; margin-left: 125px; display: block; font-weight: bold;color: #6e6c6c; text-transform: uppercase">{{$data['footer_date']}}</h4>

</body>
</html>
