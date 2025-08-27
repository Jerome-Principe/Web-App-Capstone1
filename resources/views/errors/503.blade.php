<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Temporarily Unavailable - 503</title>
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
            color: white;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 500px;
            margin: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .error-code {
            font-size: 72px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
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

        .retry-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .retry-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .countdown {
            margin-top: 20px;
            opacity: 0.8;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">503</div>
        <h1 class="error-title">Service Temporarily Unavailable</h1>
        <p class="error-message">
            We're experiencing technical difficulties and are working to resolve them quickly.
            <br><br>
            Please try again in a few moments.
        </p>
        <a href="javascript:void(0)" class="retry-button" onclick="retryConnection()">Try Again</a>
        <div class="countdown" id="countdown">
            Automatic retry in <span id="timer">30</span> seconds
        </div>
    </div>

    <script>
        let timeLeft = 30;
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