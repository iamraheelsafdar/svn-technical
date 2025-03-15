<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Your Password & Get Started!</title>
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
            margin-top: 12px;
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
        <p><b>Dear {{$user->name}},</b></p>
        <p>Welcome to SVN Technical! 🚀 We’re excited to have you on board. Your account has been successfully created, and you’re just one step away from accessing all our features.</p>
        <h4>Set Up Your Password:</h4>
        <p>To ensure your account security, please create a new password before logging in:</p>

        <p>🔹 Set Your Password Here:<br><a href="{{env('LIVE_URL')}}set-password/{{$user->email}}/{{$user->remember_token}}" class="reset-button">Set Password</a></p>
        <p>If the button above doesn’t work, copy and paste the following link into your browser:</p>
        <h4>Once your password is set, you can log in and start exploring:</h4>
        <p>Login Here: <a href="{{env('LIVE_URL')}}">SVN Technical Login</a></p>
        <h4>What’s Next?</h4>
        <p>
            ✅ Complete Your Profile – Get personalized recommendations.<br>
            ✅ Explore Our Features – Access tools, resources, and services designed for you.<br>
            ✅ Stay Updated – Look out for exclusive insights, updates, and special offers.</p>
        <h4>Need Help?</h4>

        <p>If you didn’t sign up for this account or need assistance, please contact us at <a href="mailto:support@svntechnical.com">support@svntechnical.com</a>.<br>
        🔹 Follow us for the latest updates:<br>
        📌 LinkedIn | 📌 Twitter | 📌 Facebook</p>
        <p>Thank you for joining us! We’re here to support you every step of the way.</p>
        <p><b>Best regards,</b></p>
        <p><b>The SVN Technical Team</b></p>
        <p>🌐 <a href="www.svntechnical.com">www.svntechnical.com</a></p>
    </div>
    <div class="email-footer">
        &copy; {{date('Y')}} SVNTECHNICAL. All rights reserved.
    </div>
</div>
</body>
</html>
