<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{strtoupper($data['stream'])}} CERTIFICATE OF {{ strtoupper($student->name) }}</title>
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

<h2 style="position: relative; top:22px; margin-left: 80px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 15px">{{$data['result_serail_number']}}</h2>

<h2 style="position: relative; top:290px; margin-left: 20px; text-align: center; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px; margin-bottom: -30px">{{ $data['result_session'] }}</h2>

<h2 style="position: relative; top:342px; margin-left: 180px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{ $student['name'] }}</h2>

<h2 style="position: relative; top:342px; margin-left: 175px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{ $student['father_name'] }}</h2>

<h2 style="position: relative; top:343px; margin-left: 180px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{ $student['mother_name'] }}</h2>

<h2 style="position: relative; top:346px; margin-left: 130px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{ $data['course_name']  }}</h2>

<h2 style="position: relative; top:347px; margin-left: 150px; text-align: left; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{$data['institute_name']}}</h2>

<h2 style="position: relative; top:208px; margin-right: 40px; text-align: right; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{$data['para_reg_no']}}</h2>

<h2 style="position: relative; top:210px; margin-right: 85px; text-align: right; display: block; font-weight: bold;color: #6e6c6c;font-size: 13px">{{$data['result_cum_roll_number']}}</h2>

<h2 style="position: relative; top:210px; margin-right: 190px; text-align: right; font-weight: bold;color: #6e6c6c;font-size: 13px">{{ $data['date_of_birth'] }}</h2>
@php
    $isSingleRecord = count($data['results']) === 1;
    $isLargeDataset = count($data['results']) > 6;
    $fontSize = $isSingleRecord ? '13px' : ($isLargeDataset ? '6px' : '8px');

    $columnWidths = $isSingleRecord
        ? ['all_entries'=>'20px' , 'subject'=>'423px']
        : ['all_entries'=>'', 'subject'=>''];

    $tableWidth = $isSingleRecord ? '100%' : ($isLargeDataset ? '33.33%' : '50%');

@endphp
<div style="position: relative; top:250px; margin-left: 30px; margin-right: 30px;">
    @if($data['lateral'])
        <h4 style="margin-bottom: 8px; text-align: center; font-weight: bold; color: #6e6c6c; font-size: {{ $fontSize }};">
            Lateral Entry
        </h4>
    @endif
    <table style="width: 100%; border-collapse: collapse;">
        @foreach($data['results'] as $key => $singleResults)
            @if($key % ($isLargeDataset ? 3 : 2) == 0) <!-- Open a new row for every 3 tables if large dataset, otherwise 2 -->
            <tr>
                @endif

                <!-- Table Cell for Each Result -->
                <td style="width: {{ $tableWidth }}; vertical-align: top; padding: 2px;">

                    <h4 style="
                    position: absolute;
    top: -56px;
    right: 120px;
    /*transform: translateX(-50%);*/
    font-weight: bold;
    color: #6e6c6c;
    text-transform: uppercase;
    font-size: 13px;
    margin-left: 170px;
    ">
                        {{$singleResults['duration']}}
                    </h4>

                    <table style="width: 100%; border: 2px solid #6e6c6c; border-collapse: collapse; margin-bottom: -10px; margin-top: 20px">
                        <thead>
                        <tr>
                            <th style="border: 2px solid #6e6c6c; padding: 2px;white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">S. No.</th>
                            <th style="border: 2px solid #6e6c6c; padding: 2px; white-space: nowrap;font-size: {{ $fontSize }}; width: {{$columnWidths['subject']}}">Subjects</th>
                            <th style="border: 2px solid #6e6c6c; padding: 2px;white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Max. Marks</th>
                            <th style="border: 2px solid #6e6c6c; padding: 2px; white-space: nowrap;font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Theory</th>
                            <th style="border: 2px solid #6e6c6c; padding: 2px;white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Practical</th>
                            <th style="border: 2px solid #6e6c6c; padding: 2px; white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Marks. Obt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalMaxMarks = 0;
                            $totalObtainedMarks = 0;
                        @endphp

                        @foreach($singleResults['subjects'] as $index => $singleResult)
                            @php
                                $totalMaxMarks += $singleResult['subject_max_marks'];
                                $totalObtainedMarks += $singleResult['total_marks'];
                            @endphp
                            <tr>
                                <td style="border: 2px solid #6e6c6c; padding: 2px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$index+1}}</td>
                                <td style="border: 2px solid #6e6c6c; padding: 2px; font-size: {{ $fontSize }}; width: {{$columnWidths['subject']}}">{{$singleResult['subject_name']}}</td>
                                <td style="border: 2px solid #6e6c6c; padding: 2px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['subject_max_marks']}}</td>
                                <td style="border: 2px solid #6e6c6c; padding: 2px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['subject_obtained_marks']}}</td>
                                <td style="border: 2px solid #6e6c6c; padding: 2px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['practical_obtained_marks']}}</td>
                                <td style="border: 2px solid #6e6c6c; padding: 2px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['total_marks']}}</td>
                            </tr>
                        @endforeach

                        <!-- Total Row -->
                        <tr>
                            <td colspan="2" style="border: 2px solid #6e6c6c; padding: 5px; font-weight: bold; text-align: right;">Total:</td>
                            <td style="border: 2px solid #6e6c6c; padding: 5px; font-weight: bold;">{{ $totalMaxMarks }}</td>
                            <td colspan="2" style="border: 2px solid #6e6c6c;"></td>
                            <td style="border: 2px solid #6e6c6c; padding: 5px; font-weight: bold;">{{ $totalObtainedMarks }}</td>
                        </tr>
                        </tbody>
                    </table>

                </td>

                @if($key % ($isLargeDataset ? 3 : 2) == ($isLargeDataset ? 2 : 1)) <!-- Close the row after 3 or 2 tables -->
            </tr>
            @endif
        @endforeach

        @if(count($data['results']) % ($isLargeDataset ? 3 : 2) != 0) <!-- If there are leftover tables, close the last row -->
        <td colspan="{{ ($isLargeDataset ? 3 : 2) - (count($data['results']) % ($isLargeDataset ? 3 : 2)) }}" style="width: {{ $tableWidth }};"></td>
        </tr>
        @endif
    </table>
</div>
@if($data['qr_code'])
<img style="
    position: absolute;
    bottom: 150px;
    transform: translateX(-50%);
    text-align: left; margin: 0 auto 0 100px;" src="{{ $data['qr_code'] }}" alt="QR Code">
@endif
<h4 style="
    position: absolute;
    bottom: 38px;
    transform: translateX(-50%);
    font-weight: bold;
    color: #6e6c6c;
    text-transform: uppercase;
    font-size: 13px;
    margin-left: 170px;
">
    {{$data['footer_result_date']}}
</h4>
</body>
</html>
