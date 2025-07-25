<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - Limitless Fitness Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 600px;
        }

        .status-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .status-success {
            color: #28a745;
        }

        .status-warning {
            color: #ffc107;
        }

        .status-error {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="status-card">
        <div class="status-icon status-success">✅</div>
        <h2 class="text-success mb-3">Application is Running</h2>
        <p class="text-muted mb-4">
            The Limitless Fitness Studio application is currently running and accessible.
            Some features may be temporarily unavailable due to high database traffic.
        </p>

        <div class="row text-start">
            <div class="col-md-6">
                <h5>Available Features:</h5>
                <ul class="list-unstyled">
                    <li>✅ Homepage</li>
                    <li>✅ Static Pages</li>
                    <li>✅ Application Status</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>Temporarily Limited:</h5>
                <ul class="list-unstyled">
                    <li>⚠️ User Authentication</li>
                    <li>⚠️ Database Operations</li>
                    <li>⚠️ Dynamic Content</li>
                </ul>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <a href="/readmorebtn" class="btn btn-outline-primary">Read More</a>
            <a href="/learnmorebtn" class="btn btn-outline-primary">Learn More</a>
        </div>

        <p class="text-muted mt-3 small">
            Database connection limit reached. This will reset automatically in approximately 1 hour.
        </p>
    </div>
</body>

</html>