@extends('layouts.app')
@section('title', 'Add Student')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('addStudent') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input required type="text" name="student_name" id="student_name" class="form-control"
                       value="{{ old('student_name') }}"
                       placeholder="Enter Student Name">
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="father_name" class="form-label">Father Name</label>
                <input required type="text" name="father_name" id="father_name" class="form-control"
                       value="{{ old('father_name') }}"
                       placeholder="Enter Father Name">
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="mother_name" class="form-label">Mother Name</label>
                <input required type="text" name="mother_name" id="mother_name" class="form-control"
                       value="{{ old('mother_name') }}"
                       placeholder="Enter Mother Name">
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="logo" class="form-label">Select State</label>
                <select name="state" class="form-select" aria-label="Default select example">
                    @php
                        $states = array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal
                Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and
                Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and
                Kashmir","Jharkhand","Karnataka","Lakshadweep","Puducherry","Kerala","Madhya
                Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Odisha","Punjab","Rajasthan","Sikkim","Tamil
                Nadu","Telangana","Tripura","Uttarakhand","Uttar Pradesh","West Bengal");
                    @endphp
                    <option value="Rajasthan" selected>Rajasthan</option>
                    @foreach ($states as $state)
                        <option value="{{$state}}">{{$state}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="stream_name" class="form-label">Select Stream</label>
                <select id="stream_id" required class="form-control" name="stream_id">
                    <option value="" {{ old('stream_id', request()->input('stream_id')) == null ? 'selected' : '' }}>
                        Select Stream
                    </option>
                    @foreach($courseDetails['streams'] as $stream)
                        <option value="{{ $stream['stream_id'] }}" {{ request()->input('stream_id') == $stream['stream_id'] ? 'selected' : '' }}>
                            {{ ucfirst($stream['stream_name']) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="course" class="form-label">Enrollment</label>
                <div id="course-container">
                    <input list="courses" id="course-input" name="course" class="form-control" placeholder="Search Course" >
                    <datalist id="courses"></datalist>
                </div>
            </div>

            <div id="lateral-container" class="col-12 col-md-6 col-lg-6 mb-3" style="display: none;">
                <label for="lateral" class="form-label">Lateral Entry</label>
                <select id="lateral" required class="form-control" name="lateral">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <!-- Lateral Duration Section -->
            <div class="col-12 col-md-3 col-lg-3 mb-3" id="reduce-lateral-container" style="display: none;">
                <label for="lateral_duration" class="form-label">Reduce Lateral</label>
                <select id="lateral_duration" class="form-control" name="lateral_duration"></select>
            </div>


            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select required class="form-control" name="gender">
                    <option
                        value="" {{ old('gender', request()->input('gender')) == null ? 'selected' : '' }}>
                        Select Gender
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
                        value="" {{ old('mode', request()->input('mode')) == null ? 'selected' : '' }}>
                        Select Mode
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
                <input required class="form-control" type="text" id="dateInput" name="dob"
                       value="{{ request()->input('dob') }}" placeholder="dd-mm-yyyy"/>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="admission_date" class="form-label">Admission Date</label>
                <input required class="form-control" type="text" id="dateInput" name="admission_date"
                       value="{{ request()->input('admission_date') }}" placeholder="dd-mm-yyyy"/>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_image" class="form-label">Student Image</label>
                <div class="d-flex align-items-center">
                    <input required type="file" name="student_image" id="student_image" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_qualification" class="form-label">Last Qualification Mark Sheet</label>
                <div class="d-flex align-items-center">
                    <input required type="file" name="student_qualification" id="student_qualification"
                           class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_id" class="form-label">Identity Card</label>
                <div class="d-flex align-items-center">
                    <input required type="file" name="student_id" id="logo" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3 mb-3">
                <label for="student_signature" class="form-label">Signature</label>
                <div class="d-flex align-items-center">
                    <input required type="file" name="student_signature" id="student_signature" class="form-control">
                </div>
            </div>

            <div class="col-12 mx-auto text-center">
                <button type="submit" class="btn btn-warning w-auto mx-auto">Add Student</button>
            </div>
        </form>
    </div>
    <script>
        const streamsData = @json($courseDetails['streams']);
    </script>
    <script src="{{asset('assets/js/addStudent.js')}}"></script>
@endsection
