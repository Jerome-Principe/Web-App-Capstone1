<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Verify OTP</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Poppins";
        color: #fff;
    }

    section {
        position: relative;
        height: 100vh;
        width: 100%;
        background-image: url({{ asset('assets/images/BGround.jpg') }});
        background-size: cover;
        background-position: center center;
    }

    .form-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
        width: 380px;
        padding: 50px 30px;
        border-radius: 10px;
        box-shadow: 7px 7px 60px #000;
    }

    label {
        color: #fff;
    }

    h1 {
        text-transform: uppercase;
        font-size: 2em;
        text-align: center;
        margin-bottom: 2em;
        color: #fff;
    }

    .control input {
        width: 100%;
        display: block;
        padding: 10px;
        color: #222;
        border: none;
        outline: none;
        margin: 1em 0;
    }

    .control input[type="submit"] {
        background: crimson;
        color: #fff;
        text-transform: uppercase;
        font-size: 1.2em;
        opacity: .7;
        transition: opacity .3s ease;
    }

    .control input[type="submit"]:hover {
        opacity: 1;
    }

    .link {
        text-align: center;
    }

    .link a {
        text-decoration: underline;
        color: #fff;
        opacity: .7;
        transition: opacity .3s ease;
    }

    .link a:hover {
        opacity: 1;
    }

    .control label {
        color: white;
    }

    .control input {
        color: white;
        background-color: transparent;
        border: 1px solid #ccc;
    }

    .control input:focus {
        border-color: crimson;
        outline: none;
    }

    .control button {
        background: crimson;
        color: #fff;
        text-transform: uppercase;
        font-size: 0.7em;
        border: none;
        padding: 8px 16px;
        opacity: .7;
        transition: opacity .3s ease;
    }

    .control button:hover {
        background: darkred;
        color: #f9f9f9;
        transform: scale(1.05);
        opacity: 1;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Hover effect for Back to Login link */
    .back-link {
        color: #fff;
        text-decoration: underline;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .back-link:hover {
        opacity: 1;
        color: lightgray;
    }

    .btn-reset {
        background: #d4a574 !important;
        color: #fff !important;
        text-transform: uppercase;
        font-size: 1em;
        border: none;
        padding: 12px 24px;
        border-radius: 5px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 20px;
    }

    .btn-reset:hover {
        background: #c19a6b !important;
        transform: scale(1.02);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
</style>

<body>
    <section>
        <div class="form-container">
            <h1>Verify OTP</h1>

            <div class="mb-4 text-sm" style="color: white; text-align: center;">
                <p>Enter the recovery OTP sent to your email.</p>
                <p>Don't share this code with anyone - it's your key to regaining access.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger mb-4"
                    style="background: rgba(220, 53, 69, 0.9); border: 1px solid #dc3545; color: white; padding: 12px; border-radius: 5px;">
                    <ul class="mb-0" style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="alert alert-success mb-4"
                    style="background: rgba(40, 167, 69, 0.9); border: 1px solid #28a745; color: white; padding: 12px; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.otp.verify') }}">
                @csrf

                <!-- Hidden Email Field -->
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- OTP Input Field -->
                <div class="control">
                    <label for="otp">Enter OTP Code :</label>
                    <input id="otp" type="text" name="otp" placeholder="Enter 6 Digit code" required autofocus
                        maxlength="6" pattern="[0-9]{6}" />
                    <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                </div>

                <div class="control d-flex justify-content-between mt-4">
                    <!-- Back to Login Link -->
                    <a href="{{ route('login') }}" class="back-link">Back to Login?</a>
                </div>

                <!-- Verify OTP Button -->
                <button type="submit" class="btn-reset">
                    VERIFY & CONTINUE
                </button>
            </form>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Z5JfMFfQp1m49jWm8yNFf0/3pEj9/h6+6j5LLFujVnY"
        crossorigin="anonymous"></script>

</body>

</html>