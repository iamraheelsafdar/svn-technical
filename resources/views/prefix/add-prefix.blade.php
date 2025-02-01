@extends('layouts.app')
@section('title', 'Add Prefix')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('addPrefix') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-6 mb-3">
                <label for="prefix_name" class="form-label">Prefix Name</label>
                <input type="text" name="prefix_name" id="prefix_name" class="form-control"
                       value="{{ old('prefix_name') }}" placeholder="Enter Prefix Name"
                >
            </div>
            <div class="col-6 mb-3">
                <label for="assign_prefix" class="form-label">Assign Prefix</label>
                <select id="assign_prefix" name="assign_prefix" class="form-select" aria-label="Default select example">
                    @foreach ($assignPrefixes as $assignPrefix)
                        <option value="{{$assignPrefix}}">{{$assignPrefix}}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning w-auto mx-auto">Add Prefix</button>
        </form>
    </div>
@endsection
