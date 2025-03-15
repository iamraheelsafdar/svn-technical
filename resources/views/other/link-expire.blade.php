{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Link Expired</title>--}}
{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            text-align: center;--}}
{{--            padding: 50px;--}}
{{--            background-color: #f8d7da;--}}
{{--        }--}}
{{--        .container {--}}
{{--            max-width: 500px;--}}
{{--            margin: auto;--}}
{{--            padding: 20px;--}}
{{--            background: white;--}}
{{--            border: 1px solid #dc3545;--}}
{{--            border-radius: 10px;--}}
{{--            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);--}}
{{--        }--}}
{{--        .error-text {--}}
{{--            color: #dc3545;--}}
{{--            font-size: 22px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--        .btn {--}}
{{--            display: inline-block;--}}
{{--            margin-top: 20px;--}}
{{--            padding: 10px 20px;--}}
{{--            background: #dc3545;--}}
{{--            color: white;--}}
{{--            text-decoration: none;--}}
{{--            border-radius: 5px;--}}
{{--        }--}}
{{--        .btn:hover {--}}
{{--            background: #c82333;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="container">--}}
{{--    <p class="error-text">❌ This link has expired!</p>--}}
{{--    <p>Please request a new one to proceed.</p>--}}
{{--    <a href="{{ url('/request-new-link') }}" class="btn">Request New Link</a>--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}
@extends('layouts.app')
@section('title', 'Forget Password')
@section('content')
    <section class="login-section" style="background-image:url({{ asset('assets/img/loginPageImage.png') }});">
        <div class="overlay"></div>
        <div class="login-form-container">
            <div class="form-box">
                <p class="error-text">❌ This link has expired!</p>
                <p>Please request a new one to proceed.</p>
                <div class="mt-3">
                    <a href="{{ route('loginPage') }}" class="text-primary">Back to login</a>
                </div>
            </div>
        </div>
    </section>
@endsection
