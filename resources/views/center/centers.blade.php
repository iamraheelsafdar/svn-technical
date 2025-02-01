@extends('layouts.app')
@section('title', 'Centers')
@section('content')
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Registration Date</th>
                <th>Registration Prefix</th>
                <th>Name</th>
                <th>Owner Name</th>
                <th>Email</th>
{{--                <th>Phone</th>--}}
{{--                <th>Address</th>--}}
                <th>State</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <form action="{{route('centersPage')}}" method="GET" class="d-flex justify-content-end">
                <tr>
                    <td>#</td>
                    <td>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="{{ request()->input('date') }}" placeholder="dd-mm-yyyy"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="prefix"
                               value="{{ request()->input('prefix') }}" placeholder="Search Registration Prefix"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="name"
                               value="{{ request()->input('name') }}" placeholder="Search Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="owner_name"
                               value="{{ request()->input('owner_name') }}" placeholder="Search Owner Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="email"
                               value="{{ request()->input('email') }}" placeholder="Search Email"/>
                    </td>
{{--                    <td>--}}
{{--                        <input class="form-control border-0" type="text" name="phone"--}}
{{--                               value="{{ request()->input('phone') }}" placeholder="Search Phone"/>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="form-control border-0" type="text" name="address"--}}
{{--                               value="{{ request()->input('address') }}" placeholder="Search Address"/>--}}
{{--                    </td>--}}
                    <td><input class="form-control border-0" type="text" name="state"
                               value="{{ request()->input('state') }}" placeholder="Search state"/></td>
                    <td>
                        <select class="form-control border-0" name="status">
                            <option value="" {{ old('status', request()->input('status')) == null ? 'selected' : 'disabled' }}>Select Status</option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </td>
                    <td></td>
                    <td class="d-flex text-nowrap" >
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{route('centersPage')}}" class="btn btn-dark w-100 d-block ms-2" type="submit">Clear</a>
                        <a href="{{ route('addCenterPage') }}" class="btn btn-warning ms-2">Add Center</a>
                    </td>

                </tr>
            </form>

            @forelse ($centers['data'] as $key => $center)
                <tr>
                    <td>{{ ($centers['current_page'] - 1) * $centers['per_page'] + $key + 1 }}</td>
                    <td>{{ $center['registration_date'] }}</td>
                    <td>{{ $center['registration_prefix'] }}</td>
                    <td>{{ $center['name'] }}</td>
                    <td>{{ $center['owner_name'] }}</td>
                    <td>{{ $center['email'] }}</td>
{{--                    <td>{{ $center['phone'] }}</td>--}}
{{--                    <td>{{ $center['address'] }}</td>--}}
                    <td>{{ $center['state'] }}</td>
                    <td class="align-items-center">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle{{ $center['id'] }}"
                                data-id="{{ $center['id'] }}"
                                data-type="center"
                                {{ $center['status'] ? 'checked' : '' }}
                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td>{{ $center['last_login'] }}</td>
                    <td>
                        <a href="{{ route('updateCenterView', ['id' => $center['id']]) }}" class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('pagination.pagination', ['dataToPaginate' => $centers])
@endsection
