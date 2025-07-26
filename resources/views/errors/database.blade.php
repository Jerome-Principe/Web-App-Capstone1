<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Error - Limitless Fitness Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: 1rem;
        }

        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }

        .retry-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .retry-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }

        .status-indicator.healthy {
            background-color: #28a745;
        }

        .status-indicator.degraded {
            background-color: #ffc107;
        }

        .status-indicator.unhealthy {
            background-color: #dc3545;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .countdown {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="error-card">
        <div class="error-icon">⚠️</div>
        <h2 class="text-danger mb-3">
            @if(isset($isConnectionLimit) && $isConnectionLimit)
                Database Connection Limit Reached
            @else
                Database Connection Error
            @endif
        </h2>
        <p class="text-muted mb-4">
            @if(isset($isConnectionLimit) && $isConnectionLimit)
                We've reached our database connection limit due to high traffic.
                This is a temporary issue that will resolve automatically.
                <br><br>
                <strong>Estimated recovery time:</strong> {{ $retryAfter ?? 30 }} seconds
            @else
                We're experiencing high traffic right now. Our database connections are temporarily exhausted.
                <br><br>
                <strong>Please try again in a few moments.</strong>
            @endif
        </p>

        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="{{ url()->previous() }}" class="retry-btn">Go Back</a>
            <a href="{{ url('/') }}" class="retry-btn">Home</a>
            <button onclick="window.location.reload()" class="retry-btn">Retry Now</button>
        </div>

        <div class="countdown mt-3">
            <span class="status-indicator degraded"></span>
            <span id="countdown-text">Retrying in <span id="countdown">{{ $retryAfter ?? 30 }}</span> seconds...</span>
        </div>

        <p class="text-muted mt-3 small">
            If this problem persists, please contact support.
        </p>
    </div>

    <script>
        // Auto-refresh after retry time (default 30 seconds)
        var retryTime = {{ $retryAfter ?? 30 }} * 1000;
        var countdown = retryTime / 1000;

        // Update countdown every second
        var countdownInterval = setInterval(function () {
            countdown--;
            document.getElementById('countdown').textContent = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                document.getElementById('countdown-text').innerHTML = '<span class="status-indicator healthy"></span> Retrying now...';
                window.location.reload();
            }
        }, 1000);

        // Allow manual retry
        document.addEventListener('keydown', function (e) {
            if (e.key === 'F5' || (e.ctrlKey && e.key === 'r')) {
                e.preventDefault();
                window.location.reload();
            }
        });
    </script>
</body>

</html>