@extends('layouts.app')
@section('title', 'Update Student Reference')
@section('content')
    <div class="pb-4">
        <form class="row g-3" action="{{ route('updateStudentReference') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-4">
                <label for="reference" class="visually-hidden">Password</label>
                <input type="text" class="form-control" id="reference" name="reference" value="{{ $reference->reference}}" placeholder="Enter Reference Name">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-danger mb-3">Update Reference</button>
            </div>
        </form>
    </div>
@endsection
