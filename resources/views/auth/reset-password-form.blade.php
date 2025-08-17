<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Password Reset</title>
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
            <h1>Password Reset</h1>

            <div class="mb-4 text-sm" style="color: white; text-align: center;">
                <p>Let's keep your account secure - choose a strong new password with a mix of letters, numbers, and
                    symbols.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.reset.store') }}">
                @csrf

                <!-- Hidden Email Field -->
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- New Password Field -->
                <div class="control">
                    <label for="password">New Password :</label>
                    <input id="password" type="password" name="password" placeholder="Enter new password" required
                        autofocus />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password Field -->
                <div class="control">
                    <label for="password_confirmation">Confirm Password :</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Re-enter new password" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="control d-flex justify-content-between mt-4">
                    <!-- Back to Login Link -->
                    <a href="{{ route('login') }}" class="back-link">Back to Login?</a>
                </div>

                <!-- Reset Password Button -->
                <button type="submit" class="btn-reset">
                    RESET PASSWORD
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