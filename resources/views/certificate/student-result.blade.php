@extends('layouts.app')
@section('title', 'Student Result')
@section('content')
    <section class="login-section">
        <div class="login-form-container">
            <div class="form-box p-0" style="max-width: 1100px;">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left: Student Image -->
                            <div class="col-md-3 text-center">
                                <img src="{{$data['student_image']}}" class="img-fluid w-100 rounded" alt="Student Image">
                            </div>

                            <!-- Right: Student Details -->
                            <div class="col-md-9" style="text-align: left">
                                <h4>Student Details</h4>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{$data['student_name']}}</td>
                                        <th>Father's Name:</th>
                                        <td>{{$data['father_name']}}</td>
                                    </tr>
                                    <tr>
                                        <th>Mother's Name:</th>
                                        <td>{{$data['mother_name']}}</td>
                                        <th>DOB:</th>
                                        <td>{{$data['dob']}}</td>
                                    </tr>
                                    <tr>
                                        <th>Enrollment No:</th>
                                        <td>{{$data['para_reg_no']}}</td>
                                        <th>Roll Number:</th>
                                        <td>{{$data['result_cum_roll_number']}}</td>
                                    </tr>
                                    <tr>
                                        <th>Year/Sem:</th>
                                        <td>{{ implode(', ', array_column($data['results'], 'duration')) }}</td>
                                        <th>Division:</th>
                                        <td>{{ $data['division'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Institute:</th>
                                        <td colspan="3">{{$data['institute_name']}}</td>
                                    </tr>
                                    <tr>
                                        <th>Course Name:</th>
                                        <td colspan="3">{{$data['course_name']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @foreach($data['results'] as $key => $singleResults)

                            <h4>
                                {{$singleResults['duration']}}
                            </h4>

                            <table class="table table-bordered border" style="border: none; text-align: left">
                                <thead>
                                <tr>
                                    <th>
                                        S. No.
                                    </th>
                                    <th>
                                        Subjects
                                    </th>
                                    <th>
                                        Max. Marks
                                    </th>
                                    <th>
                                        Theory
                                    </th>
                                    <th>
                                        Practical
                                    </th>
                                    <th>
                                        Marks. Obt
                                    </th>
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
                                        <td>{{$index+1}}</td>
                                        <td>{{$singleResult['subject_name']}}</td>
                                        <td>{{$singleResult['subject_max_marks']}}</td>
                                        <td>{{$singleResult['subject_obtained_marks']}}</td>
                                        <td>{{$singleResult['practical_obtained_marks']}}</td>
                                        <td>{{$singleResult['total_marks']}}</td>
                                    </tr>
                                @endforeach

                                <!-- Total Row -->
                                <tr>
                                    <td colspan="2">
                                        Total:
                                    </td>
                                    <td>{{ $totalMaxMarks }}</td>
                                    <td colspan="2"></td>
                                    <td>{{ $totalObtainedMarks }}</td>
                                </tr>
                                </tbody>
                            </table>

                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
