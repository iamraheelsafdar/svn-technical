@extends('layouts.app')
@section('title', 'Edit Center')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('updateCenter') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="reg_number" class="form-control" readonly
                   value="{{ $center->id }}"
            >
            <div class="col-6 mb-3">
                <label for="reg_number" class="form-label">Center Reg No</label>
                <input type="text" name="reg_number" id="reg_number" class="form-control" readonly
                       value="{{ $center->registration_prefix }}"
                >
            </div>
            <div class="col-6 mb-3">
                <label for="email" class="form-label">Center Email</label>
                <input type="email" id="email" class="form-control" name="email"
                       value="{{ $center->user->email }}"
                       placeholder="Enter email">
            </div>

            <div class="col-6 mb-3">
                <label for="name" class="form-label">Center Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ $center->user->name }}"
                       placeholder="Enter center name">
            </div>

            <div class="col-6 mb-3">
                <label for="owner_name" class="form-label">Center Owner Name</label>
                <input type="text" name="owner_name" id="owner_name" class="form-control"
                       value="{{  $center->owner_name }}"
                       placeholder="Enter center owner name">
            </div>

            <div class="col-6 mb-3">
                <label for="phone" class="form-label">Center Mobile</label>
                <input type="text" name="phone" id="phone" class="form-control"
                       value="{{ $center->user->phone }}"
                       placeholder="Enter center mobile">

            </div>
            <div class="col-6 mb-3">
                <label for="logo" class="form-label">Center Logo</label>
                <img src="" alt="">
                <div class="d-flex align-items-center">
                    <img id="profileImage" src="{{isset($center) && $center->user->profile_image ? asset('storage/' . $center->user->profile_image) : asset('assets/img/profileImage.png')}}"
                         alt="Logo Preview"
                         style="max-width: 46px;" class="img-thumbnail">
                    <input type="file" name="profile_image" id="logo" class="form-control">
                </div>
            </div>
            <div class="col-6 mb-3">
                <label for="logo" class="form-label">Select State</label>
                <select name="state" class="form-select" aria-label="Default select example">
                    @php
                        $states = array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal
                Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and
                Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and
                Kashmir","Jharkhand","Karnataka","Lakshadweep","Puducherry","Kerala","Madhya
                Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Odisha","Punjab","Rajasthan","Sikkim","Tamil
                Nadu","Telangana","Tripura","Uttarakhand","Uttar Pradesh","West Bengal");
                    @endphp
                    <option selected>{{$center->state}}</option>
                    @foreach ($states as $state)
                        <option value="{{$state}}">{{$state}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 mb-3">
                <label for="address" class="form-label">Center Address</label>
                <input type="text" name="address" id="address" class="form-control"
                       value="{{ $center->address }}"
                       placeholder="Enter center address">
            </div>
            <button type="submit" class="btn btn-danger w-auto mx-auto">Update Center</button>
        </form>
    </div>
@endsection
