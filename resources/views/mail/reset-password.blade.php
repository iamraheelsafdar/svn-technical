<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .email-body h2 {
            margin-top: 0;
        }
        .email-body p {
            margin: 10px 0;
        }
        .reset-button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .reset-button:hover {
            background-color: #0056b3;
        }
        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
            padding: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        Set Your Password
    </div>
    <div class="email-body">
        <p>Hi {{$user->name}},</p>
        <p>We received a request to reset your password for your IGNITM account. If you made this request, you can reset your password by clicking the button below:</p>
        <a href="{{env('LIVE_URL')}}set-password/{{$user->email}}/{{$user->remember_token}}" class="reset-button">Reset Password</a>
        <p>If the button above doesn’t work, copy and paste the following link into your browser:</p>
        <p><a href="{{env('LIVE_URL')}}set-password/{{$user->email}}/{{$user->remember_token}}">{{env('LIVE_URL')}}set-password/{{$user->email}}/{{$user->remember_token}}</a></p>
        <p>This link will expire in 24 hour, so be sure to reset your password soon.</p>
        <p>If you didn’t request a password reset, please ignore this email. Your account is secure.</p>
        <p>If you have any questions, feel free to contact our support team at <a href="mailto:support@ignitm.com">support@ignitm.com</a>.</p>
        <p>Thank you,</p>
        <p>The SVNTECHNICAL Team</p>
    </div>
    <div class="email-footer">
        &copy; {{date('Y')}} SVNTECHNICAL. All rights reserved.
    </div>
</div>
</body>
</html>
