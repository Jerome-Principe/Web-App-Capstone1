<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification - Limitless Fitness Studio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }

        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #e74c3c;
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            letter-spacing: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Limitless Fitness Studio</h1>
        <p>Account Verification</p>
    </div>

    <div class="content">
        <h2>Hello!</h2>
        <p>Thank you for registering with Limitless Fitness Studio. To complete your account setup, please use the
            following verification code:</p>

        <div class="otp-code">{{ $otpCode }}</div>

        <div class="warning">
            <strong>Important:</strong> This code will expire in 10 minutes. Please do not share this code with anyone.
            Our team will never ask for this code.
        </div>

        <p>If you didn't request this verification code, please ignore this email.</p>

        <p>Best regards,<br>
            <strong>Limitless Fitness Studio Team</strong>
        </p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Limitless Fitness Studio. All rights reserved.</p>
    </div>
</body>

</html>