@extends('layouts.app')
@section('title', 'Courses')
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Stream Name</th>
                <th>Enrollment Prefix</th>
                <th>Duration</th>
                <th>Course Type</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <form action="{{route('coursesPage')}}" method="GET" class="d-flex justify-content-end">
                <tr>
                    <th>#</th>
                    <th>
                        <input class="form-control border-0" type="text" name="course_name"
                               value="{{ request()->input('course_name') }}" placeholder="Search Course Name"/>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" name="stream_name"
                               value="{{ request()->input('stream_name') }}" placeholder="Search Stream Name"/>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" name="enrollment"
                               value="{{ request()->input('enrollment') }}" placeholder="Search Enrollment"/>
                    </th>
                    <th></th>
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
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="{{ request()->input('date') }}" placeholder="dd-mm-yyyy"/>
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
                    <th class="d-flex text-nowrap">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{route('coursesPage')}}" class="btn btn-dark w-100 d-block ms-2"
                           type="submit">Clear</a>
                        <a href="{{ route('addCoursePage') }}" class="btn btn-warning ms-2">Add Course</a>
                    </th>

                </tr>
            </form>
            </thead>
            <tbody>


            @forelse ($courses['data'] as $key => $course)
                <tr>
                    <td>{{ ($courses['current_page'] - 1) * $courses['per_page'] + $key + 1 }}</td>
                    <td>{{ $course['course_name'] }}</td>
                    <td>{{ $course['stream_name'] }}</td>
                    <td>{{ $course['enrollment'] }}</td>
                    <td>{{ $course['duration'] }}</td>
                    <td>{{ ucfirst($course['course_type']) }}</td>
                    <td>{{ $course['created_at'] }}</td>
                    <td class="align-items-center">
                        <div class="form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle{{ $course['id'] }}"
                                data-id="{{ $course['id'] }}"
                                data-type="course"
                                {{ $course['status'] ? 'checked' : '' }}
                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td>
                        <a href="{{ count($course['subjects']) > 0 ? route('updateSubjectView', ['course_id' => $course['id']]) : route('addSubjectPage', ['course_id' => $course['id']]) }}"
                           class="btn {{count($course['subjects']) > 0 ? 'btn-danger': 'btn-success'}} "> {!! count($course['subjects']) > 0 ? '<i class="bi bi-pencil-square"></i> Edit Subject' : 'Add Subject' !!}</a>
                        <a href="{{ route('updateCourseView', ['course_id' => $course['id']]) }}"
                           class="btn btn-info"><i class="bi bi-pencil-square"></i> Edit Course</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('pagination.pagination', ['dataToPaginate' => $courses])
@endsection
