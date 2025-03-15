@extends('layouts.app')
@section('title', 'Result of ' . $result['student_name'])
@section('content')
    {{--    @dd($result)--}}
    <div class="pb-4">
        <a class="text-center text-white btn btn-danger d-table mx-auto mb-3" href="#"><i class="bi bi-download"></i> Download Full Result</a>
        <div class="row" style="height: 800px; overflow:scroll;">
            @foreach($result['results'] as $key => $singleResults)
                <div class="col-12 col-md-12 col-lg-12"
                     style="margin-top: 10px;margin-bottom: 20px; padding-top: 10px;padding-bottom: 10px;color: #fff !important;">
                    <div class="text-cener bg-primary py-2 px-2 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 ">{{$singleResults['duration']}}</h4>
                        <a class="text-end text-white btn btn-danger  d-block" href="#"><i class="bi bi-download"></i> Download Result</a>

                    </div>
                    <table class="table table-striped pagination-table">
                        <thead>
                        <tr class="text-start">
                            <th>S.No.</th>
                            <th>Subjects</th>
                            <th>Max. Marks</th>
                            <th>Theory</th>
                            <th>Practical</th>
                            <th>Marks Obt.</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($singleResults['subjects'] as $index => $singleResult)
                            <tr class="text-dark text-start">
                                <td>{{$index+1}}</td>
                                <td>{{$singleResult['subject_name']}}</td>
                                <td>{{$singleResult['subject_max_marks']}}</td>
                                <td>{{$singleResult['subject_obtained_marks']}}</td>
                                <td>{{$singleResult['practical_obtained_marks']}}</td>
                                <td>{{$singleResult['total_marks']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>


    </div>
@endsection
