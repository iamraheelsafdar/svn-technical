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
    $isSingleRecord = count($data['results']) === 1;
    $isLargeDataset = count($data['results']) > 6;
    $fontSize = $isSingleRecord ? '44px' : ($isLargeDataset ? '30px' : '35px');
    $columnWidths = $isSingleRecord? ['all_entries'=>'20px' , 'subject'=>'1180px'] : ['all_entries'=>'', 'subject'=>''];
    $tableWidth = $isSingleRecord ? '100%' : ($isLargeDataset ? '33.33%' : '50%');
@endphp

<div style="position: relative; top:1200px; margin-left: 125px; margin-right: 125px;">
    <table style="width: 100%; border-collapse: collapse;">
        @foreach($data['results'] as $key => $singleResults)
            @if($key % ($isLargeDataset ? 3 : 2) == 0) <!-- Open a new row for every 3 tables if large dataset, otherwise 2 -->
            <tr>
                @endif
                <!-- Table Cell for Each Result -->
                <td style="width: {{ $tableWidth }}; vertical-align: top; padding: 10px;">
                    <h4 style="position: absolute;top: -390px;left: 1850px;font-weight: bold;color: #4d4d4d;text-transform: uppercase;font-size: 44px;">{{$singleResults['duration']}}</h4>

                    <table style="width: 100%; border: 2px solid #4d4d4d; border-collapse: collapse; margin-bottom: -10px; margin-top: 20px">
                        <thead>
                        <tr>
                            <th style="border: 2px solid #4d4d4d; padding: 10px;white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">S. No.</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; white-space: nowrap;font-size: {{ $fontSize }}; width: {{$columnWidths['subject']}}">Subjects</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px;white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Max. Marks</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; white-space: nowrap;font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Theory</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px;white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Practical</th>
                            <th style="border: 2px solid #4d4d4d; padding: 10px; white-space: nowrap; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">Marks. Obt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalMaxMarks = 0;
                            $totalObtainedMarks = 0;
                            $practicalObtainedMarks = 0;
                            $subjectObtainedMarks = 0;
                        @endphp

                        @foreach($singleResults['subjects'] as $index => $singleResult)
                            @php
                                $totalMaxMarks += $singleResult['subject_max_marks'];
                                $totalObtainedMarks += $singleResult['total_marks'];
                                $subjectObtainedMarks += is_numeric($singleResult['subject_obtained_marks']) ? $singleResult['subject_obtained_marks'] : 0;
                                $practicalObtainedMarks += is_numeric($singleResult['practical_obtained_marks']) ? $singleResult['practical_obtained_marks'] : 0;
                            @endphp
                            <tr>
                                <td style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$index+1}}</td>
                                <td style="border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['subject']}}">{{$singleResult['subject_name']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['subject_max_marks']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['subject_obtained_marks']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['practical_obtained_marks']}}</td>
                                <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }}; width: {{$columnWidths['all_entries']}}">{{$singleResult['total_marks']}}</td>
                            </tr>
                        @endforeach
                        <!-- Total Row -->
                        <tr>
                            <td colspan="2" style="border: 2px solid #4d4d4d; padding: 10px; font-weight: bold; text-align: right;">Total:</td>
                            <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-weight: bold;">{{ $totalMaxMarks }}</td>
                            <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-weight: bold;">{{ $subjectObtainedMarks }}</td>
                            <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-weight: bold;">{{ $practicalObtainedMarks == 0 ? '--' : $practicalObtainedMarks }}</td>
                            <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-weight: bold;">{{ $totalObtainedMarks }}</td>
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

@if(isset($data['summary']))
    @php
        $summaryData = $data['summary'][0]; // Access the first (and only) array
        $rows = [];
        $total = '';

        foreach ($summaryData as $entry) {
            if (isset($entry['year']) && isset($entry['marks'])) {
                $rows[] = [
                    'duration' => $entry['year'],
                    'marks' => $entry['marks'],
                ];
            } elseif (isset($entry['total_marks'])) {
                $total = $entry['total_marks'];
            }
        }
    @endphp

    <div style="position:absolute; bottom: 700px; text-align: right; right: 0">
        <table style="border: 2px solid #4d4d4d; border-collapse: collapse; margin-left: auto; margin-right: 135px">
            <tbody>
            @foreach($rows as $row)
                <tr>
                    <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">
                        {{ $row['duration'] }}
                    </td>
                    <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">
                        {{ $row['marks'] }}
                    </td>
                </tr>
            @endforeach
            @if($total)
                <tr>
                    <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">
                        Total-Marks
                    </td>
                    <td style="text-align: center;border: 2px solid #4d4d4d; padding: 10px; font-size: {{ $fontSize }};">
                        {{ $total }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endif

@if($data['qr_code'])
<img style="position: absolute;bottom: 700px;transform: translateX(-50%);text-align: left; margin: 0 auto 0 350px;" src="{{ $data['qr_code'] }}" alt="QR Code">
@endif

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
