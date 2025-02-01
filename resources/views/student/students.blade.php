@extends('layouts.app')
@section('title', 'Students')
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Student Image</th>
                @if(auth()->user()->role == "Admin")
                    <th>Lateral Entry</th>
                @endif
                <th>Course Name</th>
                <th>Course Type-Duration</th>
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
                    </th>
                    @if(auth()->user()->role == "Admin")
                        <th>
                            <select class="form-control border-0" name="lateral_entry">
                                <option
                                    value="" {{ old('lateral_entry', request()->input('lateral_entry')) == null ? 'selected' : 'disabled' }}>
                                    Select Lateral Status
                                </option>
                                <option
                                    value="1" {{ old('lateral_entry', request()->input('lateral_entry')) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option
                                    value="0" {{ old('lateral_entry', request()->input('lateral_entry')) == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </th>
                    @endif
                    <th>
                        <input type="text" value="{{ request()->input('course_name') }}" name="course_name"
                               list="courses" class="form-control border-0" placeholder="Search Course"/>
                        <datalist id="courses">
                            @foreach($students['data'] as $student)
                                @foreach($student['courses'] as $course)
                                    <option value="{{$course}}">{{$course}}</option>
                                @endforeach
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
                            <a href="{{ route('studentsView') }}" class="btn btn-warning ms-2">Add Student</a>
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
                    <td><img
                            src="{{isset($student) && $student['photo'] ? asset('storage/' . $student['photo']) : asset('assets/img/profileImage.png')}}"
                            alt="photo" class="student-photo"></td>
                    @if(auth()->user()->role == "Admin")
                        <td>
                            <div class="form-switch">
                                <input
                                    class="form-check-input toggle-status text-center"
                                    type="checkbox"
                                    id="statusToggle{{ $student['id'] }}"
                                    data-id="{{ $student['id'] }}"
                                    data-type="lateral"
                                    {{ $student['lateral'] ? 'checked' : '' }}
                                    onclick="showConfirmationModal(this)"
                                >
                            </div>
                        </td>
                    @endif
                    <td>{{ $student['course_name'] }}</td>
                    <td>{{ ucfirst($student['course_type']) }}-{{ $student['course_duration'] }}</td>
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
                                <input
                                    class="form-check-input toggle-status text-center"
                                    type="checkbox"
                                    disabled
                                    {{ $student['status'] ? 'checked' : '' }}
                                >
                            </div>
                        @endif
                    </td>
                    @if(auth()->user()->role == "Admin")
                        <td>

                            <a href="{{ route('updateStudentView', ['id' => $student['id']]) }}" class="btn btn-danger"><i
                                    class="bi bi-pencil-square"></i> Edit</a>
                        </td>
                    @else
                        <td>-</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('pagination.pagination', ['dataToPaginate' => $students])
@endsection
