@extends('layouts.app')
@section('title', $student->name)
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('updateStudent') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="student_id" value="{{$student->id}}">
            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input required type="text" name="student_name" id="student_name" class="form-control"
                       value="{{$student->name}}"
                       placeholder="Enter Student Name">
            </div>
            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <label for="father_name" class="form-label">Father Name</label>
                <input required type="text" name="father_name" id="father_name" class="form-control"
                       value="{{$student->father_name}}"
                       placeholder="Enter Father Name">
            </div>
            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <label for="mother_name" class="form-label">Mother Name</label>
                <input required type="text" name="mother_name" id="mother_name" class="form-control"
                       value="{{$student->mother_name}}"
                       placeholder="Enter Mother Name">
            </div>

            <div class="col-6 col-md-6 col-lg-6 mb-3">
                <label for="stream_name" class="form-label">Stream</label>
                <select id="stream_id" required class="form-control" name="stream_id">
                    <option
                        value="{{$student->course->stream->name}}">
                        {{$student->course->stream->name}}
                    </option>
                    @foreach($courseDetails['streams'] as $stream)
                        <option
                            value="{{ $stream['stream_id'] }}" {{ request()->input('stream_id') == $stream['stream_id'] ? 'selected' : '' }}>
                            {{ ucfirst($stream['stream_name']) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-6 mb-3">
                <label for="course" class="form-label">Enrollment</label>
                <div id="course-container">
                    <input list="courses" id="course-input" name="course"
                           value="{{$student->course->name}}, {{$student->course->duration}} {{ucfirst($student->course->type)}}"
                           class="form-control" placeholder="Search Course">
                    <datalist id="courses"></datalist>
                </div>
            </div>


            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select required class="form-control" name="gender">
                    <option
                        value="{{ $student->gender }}">
                        {{ ucfirst($student->gender) }}
                    </option>
                    @php
                        $types = ['male', 'female', 'other'];
                        $selectedType = request()->input('gender'); // Get selected value from request
                    @endphp

                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ $selectedType == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="mode" class="form-label">Mode</label>
                <select required class="form-control" name="mode">
                    <option
                        value="{{ $student->mode }}">
                        {{ ucfirst($student->mode) }}
                    </option>

                    @php
                        $types = ['regular', 'dm', 'online', 'skill based'];
                        $selectedType = request()->input('mode'); // Get selected value from request
                    @endphp

                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ $selectedType == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="dob" class="form-label">Date Of Birth</label>
                <input class="form-control" type="text" id="dateInput" name="dob"
                       required value="{{ $student->dob }}" placeholder="dd-mm-yyyy"/>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="admission_date" class="form-label">Admission Date</label>
                <input class="form-control" type="text" id="dateInput" name="admission_date"
                       required value="{{ $student->admission_date }}" placeholder="dd-mm-yyyy"/>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_image" class="form-label">Student Image</label>
                <div class="d-flex align-items-center">
                    <img id="logoPreview"
                         src="{{ isset($student) && $student->photo ? asset('storage/' . $student->photo) : asset('assets/img/profileImage.png') }}"
                         alt="Profile Image Preview"
                         style="max-width: 46px; "
                         class="img-thumbnail">
                    <input type="file" name="student_image" id="student_image" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_qualification" class="form-label">Last Qualification Mark Sheet</label>
                <div class="d-flex align-items-center">
                    <img id="logoPreview"
                         src="{{ isset($student) && $student->qualification ? asset('storage/' . $student->qualification) : asset('assets/img/profileImage.png') }}"
                         alt="Profile Image Preview"
                         style="max-width: 46px;"
                         class="img-thumbnail">
                    <input type="file" name="student_qualification" id="student_qualification"
                           class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_id" class="form-label">Identity Card</label>
                <div class="d-flex align-items-center">
                    <img id="logoPreview"
                         src="{{ isset($student) && $student->identity_card ? asset('storage/' . $student->identity_card) : asset('assets/img/profileImage.png') }}"
                         alt="Profile Image Preview"
                         style="max-width: 46px;"
                         class="img-thumbnail">
                    <input type="file" name="student_id" id="logo" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_signature" class="form-label">Signature</label>
                <div class="d-flex align-items-center">
                    <img id="logoPreview"
                         src="{{ isset($student) && $student->signature ? asset('storage/' . $student->signature) : asset('assets/img/profileImage.png') }}"
                         alt="Profile Image Preview"
                         style="max-width: 46px;"
                         class="img-thumbnail">
                    <input type="file" name="student_signature" id="student_signature" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-auto mx-auto">Update Student</button>
        </form>
    </div>
    <script>
        const streamsData = @json($courseDetails['streams']);
    </script>
    <script src="{{asset('assets/js/addStudent.js')}}"></script>
@endsection
