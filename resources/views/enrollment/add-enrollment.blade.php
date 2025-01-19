@extends('layouts.app')
@section('title', 'Add Enrollment')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('addEnrollment') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-6 col-md-6 col-lg-6 mb-3">
                <label for="enrollment_name" class="form-label">Enrollment Name</label>
                <input type="text" name="enrollment_name" id="enrollment_name" class="form-control"
                       value="{{ old('enrollment_name') }}"
                       placeholder="Enter Enrollment Name">
            </div>

            <div class="col-6 col-md-6 col-lg-6 mb-3 mb-3">
                <label for="prefix" class="form-label">Enrollment Prefix</label>
                <select name="prefix" class="form-select" aria-label="Default select example">
                    @foreach ($enrollmentDetails['prefix'] as $key => $prefix)
                        @dump($key)
                        <option value="{{$prefix}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-6 mb-3 mb-3">
                <label for="stream" class="form-label">Stream Type</label>
                <select name="stream" class="form-select" aria-label="Default select example">
                    @foreach ($enrollmentDetails['stream'] as $key => $stream)
                        <option value="{{$stream}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-6 mb-3 mb-3">
                <label for="session_year" class="form-label">Session Year</label>
                <select name="session_year" class="form-select" aria-label="Default select example">
                    @foreach (range(date('Y'), 1990) as $year)
                        <option value="{{$year}}">{{$year}}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary form-button w-auto mx-auto">Submit</button>
        </form>
    </div>
@endsection
