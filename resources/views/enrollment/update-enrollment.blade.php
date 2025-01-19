@extends('layouts.app')
@section('title', 'Edit Enrollment')
@section('content')
{{--    @php--}}
{{--       --}}
{{--    @endphp--}}
    <div class="pb-4">
        <form class="row" action="{{ route('updateEnrollment') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="reg_number" class="form-control" readonly
                   value="{{ $enrollment->id }}"
            >
            <div class="col-6 mb-3">
                <label for="enrollment_name" class="form-label">Center Reg No</label>
                <input type="text" name="enrollment_name" id="enrollment_name" class="form-control"
                       value="{{ $enrollment->name }}"
                >
            </div>
            <div class="col-6 col-md-6 col-lg-6 mb-3 mb-3">
                <label for="session_year" class="form-label">Session Year</label>
                <select name="session_year" class="form-select" aria-label="Default select example">
                    <option value="{{ $enrollment->year_start }}">{{ $enrollment->year_start }}</option>
                    @foreach (range(date('Y'), 1990) as $year)
                        <option value="{{$year}}">{{$year}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-6 col-lg-6 mb-3 mb-3">
                <label for="prefix" class="form-label">Enrollment Prefix</label>
                <select name="prefix" class="form-select" aria-label="Default select example">

                    <option value="{{$savedPrefix->id}}">{{$savedPrefix->prefix}}</option>
                    @foreach ($prefixDropDown as $key => $prefix)
                        <option value="{{$prefix}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-6 col-lg-6 mb-3 mb-3">
                <label for="stream" class="form-label">Stream Type</label>
                <select name="stream" class="form-select" aria-label="Default select example">
                    <option value="{{$savedStream->id}}">{{$savedStream->name}}</option>
                    @foreach ($streamDropDown as $key => $stream)
                        <option value="{{$stream}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary form-button w-auto mx-auto">Update</button>
        </form>
    </div>
@endsection
