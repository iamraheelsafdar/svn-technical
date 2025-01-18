@extends('layouts.app')
@section('title', 'Forget Password')
@section('content')
    <section class="login-section" style="background-image:url({{ asset('assets/img/loginPageImage.png') }});">
        <div class="overlay"></div>
        <div class="login-form-container">
            <div class="form-box">
                <h2 class="mb-4 text-dark">Forgot Password</h2>
                <form method="POST" action="{{ route('forgotPassword') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter email">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Forgot Password</button>
                </form>
                <div class="mt-3">
                    <a href="{{ route('loginPage') }}" class="text-primary">Back to login</a>
                </div>
            </div>
        </div>
    </section>
@endsection
