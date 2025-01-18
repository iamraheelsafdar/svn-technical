@extends('layouts.app')
@section('title', 'Profile Setting')
@section('content')
    <div class="pb-4">
        <form class="row" action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ $profileSetting->name ?? old('name') }}"
                       placeholder="Enter email">
            </div>

            <div class="col-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ $profileSetting->email ?? old('email') }}"
                       placeholder="Enter email">
            </div>

            <div class="col-6 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control"
                       value="{{ $profileSetting->phone ?? old('phone') }}"
                       placeholder="Enter phone number">

            </div>

            <div class="col-6 mb-3">
                <label for="logo" class="form-label">Profile Image</label>
                <div class="d-flex align-items-center">
                    <img id="logoPreview"
                         src="{{ isset($profileSetting) && $profileSetting->profile_image ? asset('storage/' . $profileSetting->profile_image) : asset('assets/img/profileImage.png') }}"
                         alt="Profile Image Preview"
                         style="max-width: 46px; {{ isset($profileSetting) && $profileSetting->profile_image ? '' : 'display: none;' }}"
                         class="img-thumbnail">
                    <input type="file" name="profile_image" id="logo" class="form-control">
                </div>
            </div>

            <div class="col-6 mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control"
                       value="{{ old('new_password') }}"
                       placeholder="Enter new password">
            </div>
            <div class="col-6 mb-3">
                <label for="old_password" class="form-label">Old Password</label>
                <input type="password" name="old_password" id="old_password" class="form-control"
                       value="{{ old('old_password') }}"
                       placeholder="Enter old password">
            </div>


            <button type="submit" class="btn btn-primary form-button mx-auto w-auto">Submit</button>
        </form>
    </div>
@endsection
