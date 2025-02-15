<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramedical Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

    </style>
</head>

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: contain;">
<h2 style="position: relative; top:63px; margin-left: 35px; display: block; font-weight: bold;color: #6e6c6c;font-size: 16px">{{$data['reg_no']}}</h2>
<h2 style="position: relative; top:30px; margin-left: 390px; display: block; font-weight: bold;color: #6e6c6c;font-size: 16px">{{$data['reg_no']}}</h2>
<h2 style="position: relative; top:-2px; margin-left: 770px; display: block; font-weight: bold;color: #6e6c6c;font-size: 16px">{{$data['reg_no']}}</h2>
<img
    style="display: block; margin-left: 800px; text-align: center; width: auto;height: 100px; position: relative; top: 270px"
    src="{{$data['student_image']}}" alt="">
<h2 style="position: relative; top:280px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 20px">{{ $student->name }}</h2>
<h2 style="position: relative; top:305px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $data['course_name']  }}</h2>
<h2 style="position: relative; top:280px; text-align: center; display: block;color: #6e6c6c;font-size: 24px">{{ $student->name  }}</h2>
<h2 style="position: relative; top:365px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px">{{ $data['year']  }}</h2>
<h2 style="position: relative; top:490px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $data['course_name']  }}</h2>
<h2 style="position: relative; top:515px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $student->name }}</h2>
<h2 style="position: relative; left:85px;top:605px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px">{{ $data['year']  }}</h2>

<h4 style="position: relative; top:728px; margin-left: 155px; display: block; font-weight: bold;color: #6e6c6c; text-transform: uppercase">{{$data['footer_date']}}</h4>

</body>
</html>
