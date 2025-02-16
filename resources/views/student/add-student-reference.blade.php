@extends('layouts.app')
@section('title', 'Add Student Reference')
@section('content')
    <div class="pb-4">
        <form class="row g-3" action="{{ route('addStudentReference') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-4">
                <label for="reference" class="visually-hidden">Reference Name</label>
                <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}"
                       placeholder="Enter Reference Name">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-warning mb-3">Add Reference</button>
            </div>
        </form>
    </div>
@endsection
