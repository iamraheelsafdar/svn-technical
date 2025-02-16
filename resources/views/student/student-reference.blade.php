@extends('layouts.app')
@section('title', 'Student Reference')
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Reference</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <form action="{{route('studentsReference')}}" method="GET" class="d-flex justify-content-end">
                <tr>
                    <th>#</th>
                    <th>
                        <input class="form-control border-0" type="text" name="reference"
                               value="{{ request()->input('reference') }}" placeholder="Search Reference"/>
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
                    <th>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="{{ request()->input('date') }}" placeholder="dd-mm-yyyy"/>
                    </th>
                    <th class="d-flex text-nowrap mx-auto text-center justify-content-center">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{ route('addStudentReference') }}" class="btn btn-warning ms-2">Add Reference</a>
                    </th>
                </tr>
            </form>
            </thead>
            <tbody>


            @forelse ($references['data'] as $key => $reference)
                <tr>
                    <td>{{ ($references['current_page'] - 1) * $references['per_page'] + $key + 1 }}</td>
                    <td>{{ $reference['reference'] }}</td>
                    <td>
                        <div class="form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle{{ $reference['id'] }}"
                                data-id="{{ $reference['id'] }}"
                                data-type="reference"
                                {{ $reference['status'] ? 'checked' : '' }}
                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td>{{ $reference['created_at'] }}</td>
                    <td>
                        <a href="{{ route('updateStudentReference', ['id' => $reference['id']]) }}"
                           class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

        @include('pagination.pagination', ['dataToPaginate' => $references])
@endsection
