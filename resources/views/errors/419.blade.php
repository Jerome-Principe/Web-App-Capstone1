<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired - 419</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .error-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 500px;
            margin: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .error-code {
            font-size: 72px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .error-title {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .error-message {
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }
        .security-info {
            margin-top: 30px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 14px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">419</div>
        <h1 class="error-title">Session Expired</h1>
        <p class="error-message">
            Your session has expired for security reasons. This usually happens when:
            <br><br>
            • You've been inactive for too long<br>
            • Your browser was closed and reopened<br>
            • You clicked an old link or button
        </p>
        
        <div class="action-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
            <a href="{{ url('/') }}" class="btn">Go to Homepage</a>
            <button onclick="history.back()" class="btn">Go Back</button>
        </div>
        
        <div class="security-info">
            <strong>🛡️ Security Notice:</strong><br>
            This protection helps keep your account secure by preventing unauthorized actions.
        </div>
    </div>

    <script>
        // Auto-redirect to login after 10 seconds if user doesn't take action
        let countdown = 10;
        const timer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = "{{ route('login') }}";
            }
        }, 1000);
        
        // Clear timer if user clicks any button
        document.querySelectorAll('.btn, button').forEach(btn => {
            btn.addEventListener('click', () => clearInterval(timer));
        });
    </script>
</body>
</html>
