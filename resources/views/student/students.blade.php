@extends('layouts.app')
@section('title', 'Students')
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Stream Name</th>
                <th>Student Image</th>
                @if(auth()->user()->role == "Admin")
                    <th>Lateral Entry</th>
                @endif
                <th>Course Name</th>
                <th>Course Duration-Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <form action="{{route('studentsView')}}" method="GET" class="d-flex justify-content-end">
                <tr>
                    <th></th>
                    <th>
                        <input class="form-control border-0" type="text" name="student_name"
                               value="{{ request()->input('student_name') }}" placeholder="Search Name"/>
                    </th>
                    <th>
                        <input type="text" value="{{ request()->input('stream_name') }}" name="stream_name"
                               list="stream_name" class="form-control border-0" placeholder="Search Stream"/>
                        <datalist id="stream_name">
                            @foreach($students['all_stream'] as $stream)
                                <option value="{{$stream}}">{{$stream}}</option>
                            @endforeach
                        </datalist>
                    </th>
                    <th></th>
                    @if(auth()->user()->role == "Admin")
                        <th>
                            <select class="form-control border-0" name="lateral_entry">
                                <option
                                    value="" {{ old('lateral_entry', request()->input('lateral_entry')) == null ? 'selected' : 'disabled' }}>
                                    Select Lateral Status
                                </option>
                                <option
                                    value="1" {{ old('lateral_entry', request()->input('lateral_entry')) == 1 ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ old('lateral_entry', request()->input('lateral_entry')) == '0' ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                        </th>
                    @endif
                    <th>
                        <input type="text" value="{{ request()->input('course_name') }}" name="course_name"
                               list="courses" class="form-control border-0" placeholder="Search Course"/>
                        <datalist id="courses">
                            @foreach($students['courses'] as $course)
                                <option value="{{$course}}">{{$course}}</option>
                            @endforeach
                        </datalist>
                    </th>
                    <th>
                        <select class="form-control border-0" name="course_type">
                            <option
                                value="" {{ old('course_type', request()->input('course_type')) == null ? 'selected' : '' }}>
                                Select Type
                            </option>

                            @php
                                $types = ['year', 'semester', 'monthly'];
                                $selectedType = request()->input('course_type'); // Get selected value from request
                            @endphp

                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ $selectedType == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select class="form-control border-0" name="status">
                            <option
                                value="" {{ old('status', request()->input('status')) == null ? 'selected' : 'disabled' }}>
                                Select Status
                            </option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </th>
                    <th class="d-flex text-nowrap mx-auto text-center justify-content-center">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{route('studentsView')}}" class="btn btn-dark d-block ms-2" type="submit">Clear</a>
                        @if(auth()->user()->role == "Center")
                            <a href="{{ route('addStudentView') }}" class="btn btn-warning ms-2">Add Student</a>
                        @endif
                    </th>
                </tr>
            </form>
            </thead>
            <tbody>


            @forelse ($students['data'] as $key => $student)
                <tr>
                    <td>{{ ($students['current_page'] - 1) * $students['per_page'] + $key + 1 }}</td>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['steam_name'] }}</td>
                    <td><img
                            src="{{isset($student) && $student['photo'] ? asset('storage/' . $student['photo']) : asset('assets/img/profileImage.png')}}"
                            alt="photo" class="student-photo"></td>
                    @if(auth()->user()->role == "Admin")
                        <td>
                            <div class="form-switch">
                                <span
                                    class="{{$student['lateral'] ? 'text-white btn btn-success py-0' : 'text-white btn btn-danger py-0'}}">{{$student['lateral'] ? 'Yes' : 'No'}}</span>
                                {{--                                <input--}}
                                {{--                                    class="form-check-input toggle-status text-center"--}}
                                {{--                                    type="checkbox"--}}
                                {{--                                    id="statusToggle{{ $student['id'] }}"--}}
                                {{--                                    data-id="{{ $student['id'] }}"--}}
                                {{--                                    data-type="lateral"--}}
                                {{--                                    {{ $student['lateral'] ? 'checked' : '' }}--}}
                                {{--                                    onclick="showConfirmationModal(this)"--}}
                                {{--                                >--}}
                            </div>
                        </td>
                    @endif
                    <td>{{ $student['course_name'] }}</td>
                    <td>{{ $student['course_duration'] }}-{{ ucfirst($student['course_type']) }}</td>
                    <td>
                        @if(auth()->user()->role == "Admin")
                            <div class="form-switch">
                                <input
                                    class="form-check-input toggle-status text-center"
                                    type="checkbox"
                                    id="statusToggle{{ $student['id'] }}"
                                    data-id="{{ $student['id'] }}"
                                    data-type="student"
                                    {{ $student['status'] ? 'checked' : '' }}
                                    onclick="showConfirmationModal(this)"
                                >
                            </div>
                        @else
                            <div class="form-switch">
                                <span
                                    class="{{$student['status'] ? 'text-white btn btn-success py-0' : 'text-white btn btn-danger py-0'}}">{{$student['status'] ? 'Active' : 'Inactive'}}</span>
                            </div>
                        @endif
                    </td>
                    @if(auth()->user()->role == "Admin")
                    <td style="white-space: nowrap; text-align: right !important;">

                        @if($student['steam_name'] == 'PARAMEDICAL' && $student['status']  && $student['result'])
                            <a href="{{ route('paramedicalRegCertificate', ['student_id' => $student['id']]) }}" class="btn btn-primary"><i class="bi bi-file-earmark-fill"></i> Reg Certificate</a>
                        @endif

                        @if($student['status'] && $student['result'])
                            <a href="{{ route('viewResult', ['student_id' => $student['id']]) }}" class="btn btn-primary"><i class="bi bi-file-earmark-fill"></i> View Result</a>
                            <a href="{{ route('certificate', ['student_id' => $student['id']]) }}" class="btn btn-primary"><i class="bi bi-file-earmark-fill"></i> Certificate</a>
                            <a href="{{ route('migrationForm', ['student_id' => $student['id']]) }}" class="btn btn-primary"><i class="bi bi-file-earmark-fill"></i> Migration</a>
                        @endif

                        @if($student['status'])


                        <a href="{{ route('createResultView', ['student_id'=> $student['id']]) }}" class="{{$student['result'] ? 'btn btn-warning' : 'btn btn-primary'}}"><i class="bi bi-pencil-square"></i>
                            {{$student['result'] ? 'Update Result' : 'Create Result'}}</a>

                                @if (!$student['result'])
                                    <button type="button" class="btn btn-primary autoResultBtn"
                                            data-student-id="{{ $student['id'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#autoResultModal">
                                        <i class="bi bi-robot"></i> Auto Create Result
                                    </button>
                                @endif

                            <a href="{{ route('updateStudentView', ['student_id' => $student['id']]) }}" class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit</a>
                        @endif
                        <a href="{{ route('applicationForm', ['student_id' => $student['id']]) }}" class="btn btn-primary"><i class="bi bi-file-earmark-fill"></i> Application Form</a>

                    </td>
                    @else
                            <td><a href="{{ route('applicationForm', ['student_id' => $student['id']]) }}" class="btn btn-primary"><i
                                        class="bi bi-file-earmark-fill"></i> Application Form</a></td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="autoResultModal" tabindex="-1" aria-labelledby="autoResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{route('autoResultCreation')}}">
                    @csrf
                    <input type="hidden" name="student_id" id="modalStudentId">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="autoResultModalLabel">Auto Create Result</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Enter Percentage (40-100)</label>
                            <input type="number" name="result_percentage" class="form-control" min="40" max="100" placeholder="Enter Percentage">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Create Result</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".autoResultBtn").forEach(button => {
                button.addEventListener("click", function() {
                    let studentId = this.getAttribute("data-student-id");
                    document.getElementById("modalStudentId").value = studentId;
                });
            });
        });
    </script>
    @include('pagination.pagination', ['dataToPaginate' => $students])

@endsection
