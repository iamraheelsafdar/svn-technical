@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <section class="login-section" style="background-image:url({{ asset('assets/img/loginPageImage.png') }});">
        <div class="overlay"></div>
        <div class="login-form-container">
            <div class="form-box">
                <h2 class="mb-4 text-dark">Login to <span class="title">RGTMI</span></h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control"
                               placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 form-button">Login</button>
                </form>
                <div class="mt-3">
                    <a href="{{ route('forgotPasswordPage') }}" class="text-primary">Forgot password?</a>
                </div>
            </div>
        </div>
    </section>
@endsection
