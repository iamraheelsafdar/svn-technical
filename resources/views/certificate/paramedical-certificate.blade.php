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
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body style="background: url('{{ $data['certificate_image'] }}');height: 100%; width: 100%; background-size: contain;">
<h2 style="position: relative; top:58px; margin-left: 33px; display: block; font-weight: bold;color: #6e6c6c;font-size: 16px">{{$data['serial_number']}}</h2>
<h2 style="position: relative; top:25px; margin-left: 350px; display: block; font-weight: bold;color: #6e6c6c;font-size: 16px">{{$data['para_reg_no']}}</h2>
<h2 style="position: relative; top:-12px; margin-left: 570px; display: block; font-weight: bold;color: #6e6c6c;font-size: 16px">{{$data['roll_number']}}</h2>
<img
    style="display: block; margin-left: 800px; text-align: center; width: auto;height: 100px; position: relative; top: 270px"
    src="{{$data['student_image']}}" alt="">
<h2 style="position: relative; top:280px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 20px">{{ $student->name }}</h2>
<h2 style="position: relative; top:305px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $data['course_name']  }}</h2>
<h2 style="position: relative; top:280px; text-align: center; display: block;color: #6e6c6c;font-size: 24px">{{ $student->name  }}</h2>
<h2 style="position: relative; top:365px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px">{{ $data['year_completion']  }}</h2>
<h2 style="position: relative; top:490px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $data['course_name']  }}</h2>
<h2 style="position: relative; top:515px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 28px">{{ $student->name }}</h2>
<h2 style="position: relative; left:85px;top:605px; text-align: center; display: block;font-weight: bold; color: #6e6c6c;font-size: 18px">{{ $data['year_completion']  }}</h2>

<h4 style="position: relative; top:728px; margin-left: 155px; display: block; font-weight: bold;color: #6e6c6c; text-transform: uppercase">{{$data['footer_date']}}</h4>

</body>
</html>
