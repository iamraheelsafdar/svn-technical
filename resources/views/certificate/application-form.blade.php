<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <style>

        h3 {
            text-align: center;
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 20px;
            margin-top: 0;
        }

        h5 {
            margin: 12px 0;
            font-size: 16px;
        }

        u {
            color: #007BFF;
            text-decoration: none;
        }

        .underline {
            text-decoration: underline;
        }


        .checkbox {
            margin-left: 14px;
            margin-bottom: 4px;
            font-size: 18px;
            list-style-type: disclosure-closed;
        }

        p {
            line-height: 2;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            float: right;
        }

        .signature-box {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            border-top: 2px solid #eee;
            padding-top: 10px;
        }

        .signature {
            width: 45%;
            text-align: center;
        }

        .signature h5 {
            font-size: 16px;
            color: #555;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 10px;
            width: 100%;
        }

        .form-container {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container h5 {
            font-size: 16px;
        }

        .form-container .checkbox {
            font-size: 14px;
        }

        .checkbox-section {
            margin-top: 15px;
        }

        .official-use {
            margin-top: 30px;
            text-align: center;
            font-size: 18px;
            color: #444;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .profile-image {
                width: 90px;
                height: 90px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h3>APPLICATION FORM</h3>

    <div
        class="profile-image">{!! $student->photo ? '<img style="width:150px;" src="' . public_path('storage/' . $student->photo) . '" alt="">' : '' !!}</div>
    <h5>01. Enrollment No: <u>{{$student->enrollment}}</u></h5>
    <h5>02. Application for Admission to: <u>{{$student->course->name}}</u></h5>
    <h5>03. Name on Certificate: <u>{{$student->name}}</u></h5>
    <h5>04. Date of Birth: <u>{{\Carbon\Carbon::parse($student->dob)->format('m-d-Y')}}</u></h5>


    <h5>05. Gender: <u>{{ucfirst($student->gender)}}</u>
    </h5>

    <h5>06. Nationality: <u>Indian</u></h5>
    <h5>07. Father’s / Husband’s Name: <u>{{$student->father_name}}</u></h5>
    <h5>08. Mother’s Name: <u>{{$student->mother_name}}</u></h5>

    <h5 class="section">09. Address of Correspondence: <u>{{$student->state}}</u></h5>

    <h5 class="section">10. Declaration by the Candidate:</h5>
    <div class="signature-box">
        <h5>Student’s
            Signature: {!! $student->signature ? '<img style="width:60px;" src="' . public_path('storage/' . $student->signature) . '" alt="">' : '_____________________' !!}
            Date: <u>{{\Carbon\Carbon::parse($student->admission_date)->format('m-d-Y')}}</u>
        </h5>
    </div>

    <h5 class="section">11. Declaration by the Counselor:</h5>
    <p>I, _____________________, hereby declare that I have seen the original academic documents of my
        client and if anything goes wrong in the process of documentation then I am the person who should be held
        responsible.</p>

    <div class="signature-box">
        <div class="signature">
            <h5>Signature: _______________ Date: _______________</h5>
        </div>
    </div>

    <h5 class="section checkbox-section">12. Please check the attached documents below:</h5>
    <ul>
        <li class="checkbox">Photo Copy of Marksheets and Certificates</li>
        <li class="checkbox">Duly filled application form attached with 2 passport size colour photographs</li>
        <li class="checkbox">Proof of Identification</li>
        <li class="checkbox">Experience Certificate</li>
        <li class="checkbox">Fees once paid are non-refundable</li>
        <li class="checkbox">Student will have to pay Rs. 500/- as cheque bounce charges</li>
    </ul>
    <h5 class="official-use">FOR OFFICIAL USE ONLY</h5>

    <div class="signature-box">
        <h5>Team Manager Signature:____________ Accountant Signature: ___________ </h5>
    </div>

</div>

</body>
</html>
