@extends('layouts.app')
@section('title', 'Edit Prefix')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('updatePrefix') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-6 mb-3">
                <label for="prefix_name" class="form-label">Prefix Name</label>
                <input type="text" name="prefix_name" id="prefix_name" class="form-control"
                       value="{{$prefix->prefix}}"
                       placeholder="Enter Prefix Name"
                >
                <input type="hidden" name="id" id="id" class="form-control"
                       value="{{$prefix->id}}"
                >
            </div>
            <div class="col-6 mb-3">
                <label for="assign_prefix" class="form-label">Assign Prefix</label>
                <select id="assign_prefix" name="assign_prefix" class="form-select" aria-label="Default select example">
                    <option value="{{$prefix->prefix_assign_to}}">{{$prefix->prefix_assign_to}}</option>
                    @foreach ($assignPrefixes as $assignPrefix)
                        <option value="{{$assignPrefix}}">{{$assignPrefix}}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-info w-auto mx-auto">Update Prefix</button>
        </form>
    </div>
@endsection
