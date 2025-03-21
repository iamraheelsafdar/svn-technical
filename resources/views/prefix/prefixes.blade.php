@extends('layouts.app')
@section('title', "Total ({$prefixes['total']}) Prefixes")
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Prefix Name</th>
                <th>Prefix Assign To</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <form action="{{route('prefixesPage')}}" method="GET" class="d-flex justify-content-end">
                <tr>
                    <th>#</th>
                    <th>
                        <input class="form-control border-0" type="text" name="prefix_name"
                               value="{{ request()->input('prefix_name') }}" placeholder="Search Prefix"/>
                    </th>
                    <th>
                        <select class="form-control border-0" name="assign_prefix">
                            <option value="" {{ old('assign_prefix', request()->input('assign_prefix')) == null ? 'selected' : 'disabled' }}>Select Status</option>
                            @foreach($assignedPrefixes as $assignedPrefix)
                                <option value="{{$assignedPrefix}}" {{ old('assign_prefix', request()->input('assign_prefix')) == $assignedPrefix ? 'selected' : '' }}>
                                    {{$assignedPrefix}}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select class="form-control border-0" name="status">
                            <option value="" {{ old('status', request()->input('status')) == null ? 'selected' : 'disabled' }}>Select Status</option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </th>
                    <th>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="{{ request()->input('date') }}" placeholder="dd-mm-yyyy"/>
                    </th>
                    <th class="d-flex text-nowrap mx-auto text-center justify-content-center" >
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{route('prefixesPage')}}" class="btn btn-dark d-block ms-2" type="submit">Clear</a>
                        <a href="{{ route('addPrefixPage') }}" class="btn btn-warning ms-2">Add Prefix</a>
                    </th>


                </tr>
            </form>
            </thead>
            <tbody>


            @forelse ($prefixes['data'] as $key => $prefix)
                <tr>
                    <td>{{ ($prefixes['current_page'] - 1) * $prefixes['per_page'] + $key + 1 }}</td>
                    <td>{{ $prefix['prefix'] }}</td>
                    <td>{{ $prefix['prefix_assign_to'] }}</td>
                    <td>
                        <div class="form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle{{ $prefix['id'] }}"
                                data-id="{{ $prefix['id'] }}"
                                data-type="prefix"
                                {{ $prefix['status'] ? 'checked' : '' }}
                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td>{{ $prefix['created_at'] }}</td>
                    <td>
                        <a href="{{ route('updatePrefixView', ['prefix_id' => $prefix['id']]) }}" class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('pagination.pagination', ['dataToPaginate' => $prefixes])
@endsection
