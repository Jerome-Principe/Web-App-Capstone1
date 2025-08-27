<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Temporarily Unavailable</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: 20px;
        }

        .error-code {
            font-size: 72px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .error-message {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .retry-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .retry-button:hover {
            transform: translateY(-2px);
        }

        .countdown {
            margin-top: 20px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">503</div>
        <h1 class="error-title">Service Temporarily Unavailable</h1>
        <p class="error-message">
            We're experiencing high traffic right now. Our system is working to restore normal service.
            <br><br>
            Please try again in a few moments.
        </p>
        <button class="retry-button" onclick="retryConnection()">Try Again</button>
        <div class="countdown" id="countdown">
            Automatic retry in <span id="timer">60</span> seconds
        </div>
    </div>

    <script>
        let timeLeft = 60;
        const timer = document.getElementById('timer');

        const countdown = setInterval(() => {
            timeLeft--;
            timer.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                location.reload();
            }
        }, 1000);

        function retryConnection() {
            location.reload();
        }
    </script>
</body>

</html>