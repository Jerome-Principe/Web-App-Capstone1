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
        }

        .error-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
        }

        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .retry-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
            transition: transform 0.3s ease;
        }

        .retry-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="error-card">
        <div class="error-icon">⚠️</div>
        <h2 class="text-danger mb-3">Database Connection Error</h2>
        <p class="text-muted mb-4">
            We're experiencing high traffic right now. Our database connections are temporarily exhausted.
            Please try again in a few moments.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url()->previous() }}" class="retry-btn">Go Back</a>
            <a href="{{ url('/') }}" class="retry-btn">Home</a>
        </div>
        <p class="text-muted mt-3 small">
            If this problem persists, please contact support.
        </p>
    </div>

    <script>
        // Auto-refresh after 30 seconds
        setTimeout(function () {
            window.location.reload();
        }, 30000);
    </script>
</body>

</html>