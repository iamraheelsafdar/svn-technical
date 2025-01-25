@extends('layouts.app')
@section('title', 'Update Course')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('updateCourse') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $course->id }}">
            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <label for="course_name" class="form-label">Course Name</label>
                <input type="text" name="course_name" id="course_name" class="form-control"
                       value="{{ $course->name }}"
                       placeholder="Enter Course Name">
            </div>

            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <label for="course_code" class="form-label">Course Code</label>
                <input type="text" name="course_code" id="course_code" class="form-control"
                       value="{{ $course->code }}"
                       placeholder="Enter Course Code">
            </div>

            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <label for="courseType" class="form-label">Course Type</label>
                <select class="form-select" id="courseType" name="course_type" required>
                    <option value="{{$course->type}}" selected>{{ucfirst($course->type)}}</option>
                    <option value="year">Year</option>
                    <option value="semester">Semester</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="duration" class="form-label">Duration (Years/Semesters/Monthly)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1"
                       value="{{ $course->duration }}"
                       placeholder="Select course type first" required>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="roll_number_prefix" class="form-label">Roll No Prefix</label>
                <select name="roll_number_prefix" class="form-select" aria-label="Default select example">
                    <option value="{{$course->prefix->id}}">{{$course->prefix->prefix}}</option>
                    @foreach ($courseDetails['coursePrefixes'] as $key => $prefix)
                        <option value="{{$prefix}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="stream_name" class="form-label">Stream Type</label>
                <select id="stream_name" name="stream_name" class="form-select" aria-label="Default select example">
                    <option value="{{$course->stream->id}}" selected>{{$course->stream->name}}</option>
                    @foreach ($courseDetails['streams'] as $stream)
                        <option value="{{ $stream['stream_id'] }}">{{ $stream['stream_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="enrollment" class="form-label">Enrollment</label>
                <div id="enrollment-container">
                    <select id="enrollment" name="enrollment" class="form-select" aria-label="Default select example">
                        @php
                            $name = $course->stream->enrollments->where('stream_id', $course->stream_id)->first()
                        @endphp
                        <option value="{{$name->id}}" >{{$name->name}}</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary form-button w-auto mx-auto">Update</button>
        </form>
    </div>
    <script>
        const streamsData = @json($courseDetails['streams']);
    </script>
    <script src="{{asset('assets/js/addCourse.js')}}"></script>
@endsection
