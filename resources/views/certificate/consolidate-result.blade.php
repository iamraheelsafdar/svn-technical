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
@if($data['stream'] == 'TECHNOLOGY & MGMT')
    <h2 style="position: relative; top:70px; margin-left: 260px; text-align: left; display: block; font-weight: bold;color: #4d4d4d;font-size: 39px">{{$data['result_serail_number']}}</h2>
    <h2 style="position: absolute; left: 500px; top:675px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{$data['para_reg_no']}}</h2>
    <h2 style="position: absolute; left: 1880px; top:675px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{$data['result_cum_roll_number']}}</h2>
    <h2 style="position: absolute; left: 580px; top:765px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{ $student['name'] }}</h2>
    <h2 style="position: absolute; left: 1880px; top:765px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{ $data['date_of_birth'] }}</h2>
    <h2 style="position: absolute; left: 550px; top:855px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{ $student['father_name'] }}</h2>
    <h2 style="position: absolute; left: 1880px; top:855px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{ $data['result_session'] }}</h2>
    <h2 style="position: absolute; left: 560px; top:950px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{ $student['mother_name'] }}</h2>
    <h2 style="position: absolute; left: 580px; top:1035px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{ $data['course_name']  }}</h2>
    <h2 style="position: absolute; left: 550px; top:1125px; display: block; font-weight: bold;color: #4d4d4d;font-size: 44px">{{$data['institute_name']}}</h2>
@endif


@php
    $isSingleRecord = count($data['results']) <= 2;
    $isLargeDataset = count($data['results']) > 6;
    $fontSize = $isSingleRecord ? '39px' : '16px';

    $columnWidths = $isSingleRecord
        ? ['all_entries'=>'50px' , 'subject'=>'500px']
        : ['all_entries'=>'', 'subject'=>''];

    $tableWidth = $isSingleRecord ? '100%' : ($isLargeDataset ? '33.33%' : '50%');

    // Initialize totals array
    $totals = [];

    foreach ($data['results'] as $singleResults) {
        $duration = $singleResults['duration'];

        if (!isset($totals[$duration])) {
            $totals[$duration] = ['obtained' => 0, 'max' => 0];
        }

        foreach ($singleResults['subjects'] as $subject) {
            $totals[$duration]['obtained'] += $subject['total_marks'];
            $totals[$duration]['max'] += $subject['subject_max_marks'];
        }
    }

    // Calculate grand total
    $grandTotalObtained = array_sum(array_column($totals, 'obtained'));
    $grandTotalMax = array_sum(array_column($totals, 'max'));
//    $tableTop = $data['lateral'] ? '650px' : '700px';
@endphp
<div style="position: relative; top:1100px; margin-left: 125px; margin-right: 125px;">
    @if($data['lateral'])
        <h4 style="position:absolute;top: 10px; left: 0; right: 0; text-align: center; font-weight: bold; color: #4d4d4d; font-size: 39px;">
            Lateral Entry
        </h4>
    @endif
    <table style="width: 100%; border-collapse: collapse; margin-top: 18px">
        @foreach($data['results'] as $key => $singleResults)
            @if($key % ($isLargeDataset ? 3 : 2) == 0) <!-- Open a new row for every 3 tables if large dataset, otherwise 2 -->
            <tr>
                @endif

                <!-- Table Cell for Each Result -->
                <td style="width: {{ $tableWidth }}; vertical-align: top; padding: 10px;">

                    <h4 style="margin-bottom: 15px; text-align: center; font-weight: bold; color: #4d4d4d; font-size: 39px;">
                        {{$singleResults['duration']}}
                    </h4>

                    <table style="width: 100%; border: 2px solid #4d4d4d; border-collapse: collapse; margin-bottom: -10px">
                        <thead>
                        <tr>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">S.No.</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['subject']}}">Subjects</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">M.M</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">T</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">P</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">M.O</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($singleResults['subjects'] as $index => $singleResult)
                            <tr>
                                <td style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$index+1}}</td>
                                <td style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['subject']}}">{{$singleResult['subject_name']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['subject_max_marks']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['subject_obtained_marks']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['practical_obtained_marks']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['total_marks']}}</td>
                            </tr>
                        @endforeach
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


<div style="position:absolute; bottom: {{$isSingleRecord ? '700px' : '500px'}} ; text-align: right; right: 0">
    <table style="border: 2px solid #4d4d4d; border-collapse: collapse; margin-left: auto; margin-right: 135px">
        <thead>
        <tr>
            <th style="text-align: left;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">Duration</th>
            <th style="text-align: left;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">Obtained Marks</th>
        </tr>
        </thead>
        <tbody>
        @foreach($totals as $duration => $marks)
            <tr>
                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">{{ $duration }}</td>
                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">{{ $marks['obtained'] }}/{{ $marks['max'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; font-weight: bold;">Total Marks</td>
            <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; font-weight: bold;">{{ $grandTotalObtained }}/{{ $grandTotalMax }}</td>
        </tr>
        </tbody>
    </table>
</div>


<h4 style="
    position: absolute;
    bottom: 520px;
    transform: translateX(-50%);
    font-weight: bold;
    color: #4d4d4d;
    text-transform: uppercase;
    font-size: 44px;
    margin-left: 600px;
">
    {{$data['footer_result_date']}}
</h4>
</body>
</html>
