@extends('layouts.app')
@section('title', 'Enrollments')
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Enrollment Name</th>
                <th>Enrollment Prefix</th>
                <th>Stream Name</th>
                <th>Year Start</th>
                <th>Create At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <form action="{{route('enrollmentsPage')}}" method="GET" class="d-flex justify-content-end">
                <tr>
                    <th>#</th>
                    <th>
                        <input class="form-control border-0" type="text" name="enrollment_name"
                               value="{{ request()->input('enrollment_name') }}" placeholder="Search Enrollment Name"/>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" name="prefix_name"
                               value="{{ request()->input('prefix_name') }}" placeholder="Search Prefix Name"/>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" name="stream_name"
                               value="{{ request()->input('stream_name') }}" placeholder="Search Stream Name"/>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" name="enrollment_year"
                               value="{{ request()->input('enrollment_year') }}" placeholder="Search Enrollment Year"/>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="{{ request()->input('date') }}" placeholder="dd-mm-yyyy"/>
                    </th>
                    <th>
                        <select class="form-control border-0" name="status">
                            <option value="" {{ old('status', request()->input('status')) == null ? 'selected' : 'disabled' }}>Select Status</option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </th>
                    <th class="d-flex text-nowrap">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{route('enrollmentsPage')}}" class="btn btn-dark w-100 d-block ms-2" type="submit">Clear</a>
                        <a href="{{ route('addEnrollmentPage') }}" class="btn btn-warning ms-2">Add Enrollment</a>

                    </th>

                </tr>
            </form>
            </thead>
            <tbody>


            @forelse ($enrollments['data'] as $key => $enrollment)
                <tr>
                    <td>{{ ($enrollments['current_page'] - 1) * $enrollments['per_page'] + $key + 1 }}</td>
                    <td>{{ $enrollment['enrollment_name'] }}</td>
                    <td>{{ $enrollment['prefix_name'] }}</td>
                    <td>{{ $enrollment['stream_name'] }}</td>
                    <td>{{ $enrollment['enrollment_year'] }}</td>
                    <td>{{ $enrollment['created_at'] }}</td>
                    <td class="align-items-center">
                        <div class="form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle{{ $enrollment['id'] }}"
                                data-id="{{ $enrollment['id'] }}"
                                data-type="enrollment"
                                {{ $enrollment['status'] ? 'checked' : '' }}
                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('updateEnrollmentView', ['enrollment_id' => $enrollment['id']]) }}" class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('pagination.pagination', ['dataToPaginate' => $enrollments])
@endsection
