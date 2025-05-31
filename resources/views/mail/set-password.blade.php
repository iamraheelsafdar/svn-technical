@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <section class="login-section" style="background-image:url({{ asset('assets/img/loginPageImage.png') }});">
        <div class="overlay"></div>
        <div class="login-form-container">
            <div class="form-box">
                <h2 class="mb-4 text-dark">Set Password <span class="title">RGTMI</span></h2>
                <form method="POST" action="{{ route('setPassword') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{$user->email}}">
                    <input type="hidden" name="remember_token" value="{{$user->remember_token}}">
                    <div class="mb-3">
                        <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control"
                               placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control"
                               placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 form-button">Set Password</button>
                </form>
            </div>
        </div>
    </section>
@endsection
