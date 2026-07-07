<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background-color: #FFA500;
            padding: 30px;
            text-align: center;
        }

        .logo {
            max-width: 180px;
            height: auto;
        }

        .content {
            padding: 40px;
            text-align: center;
        }

        .greeting {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .otp-container {
            background-color: #f9f9f9;
            border: 2px dashed #FFA500;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 30px;
        }

        .otp-code {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 5px;
            color: #FFA500;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #FFA500;
            text-decoration: none;
        }

        .expiry-note {
            font-size: 13px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <img src="{{ $message->embed(public_path('assets/imgs/theme/ChennaiAngadiLogo.png')) }}" alt="Chennai Angadi" class="logo">
        </div>

        <div class="content">
            <div class="greeting">Hello, {{ $customerName }}!</div>
            <div class="message">
                You are receiving this email because we received a password reset request for your account. 
                Please use the following OTP (One-Time Password) to proceed:
            </div>

            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <div class="expiry-note">
                This OTP is valid for 15 minutes. If you did not request a password reset, no further action is required.
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Chennai Angadi. All rights reserved.<br>
            If you have any questions, contact us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a>
        </div>
    </div>
</body>

</html>
