<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Link Custom Css File -->
    <link rel="stylesheet">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Loginform</title>
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
        background-image: url({{asset('assets/images/BGround.jpg')}});
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

    span {
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


    .forgot-password {
        text-align: left;
    }

    .register {
        text-align: right;
    }

    input[type="checkbox"] {
        width: 16px;
        height: 16px;
        border-radius: 5px;
        border: 2px solid #ccc;
        appearance: none;
        background-color: #fff;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    input[type="checkbox"]:checked {
        background-color: crimson;
        border-color: crimson;
    }

    input[type="checkbox"]:checked::after {
        content: "\2713";
        /* Unicode for check mark */
        font-size: 14px;
        color: #fff;
        position: absolute;
        top: 0;
        left: 2px;
        display: inline-block;
        width: 100%;
        text-align: center;
        line-height: 16px;
        /* Same as checkbox height */
    }
</style>

<body>
    <section>
        <div class="form-container">
            <h1>Login</h1>

            <!-- Laravel Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf <!-- Include CSRF token for form security -->

                <!-- Name / Email Field -->
                <div class="control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" autofocus>
                    <!-- Validation error display -->
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <!-- Password Field -->
                <div class="control">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    <!-- Validation error display -->
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="d-flex align-items-center mb-3">
                    <input type="checkbox" name="remember" id="remember" class="me-2">
                    <label for="remember" class="mb-0">Remember me</label>
                </div>

                <!-- Submit Button -->
                <div class="control">
                    <input type="submit" value="login" class="btn btn-primary">
                </div>

            </form>

            <!-- Forgot Password and Register Links -->
            <div class="link">
                <div class="d-flex justify-content-between">
                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    @endif

                    <!-- Register Link -->
                    <!-- @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="register">Register?</a>
                    @endif -->
                </div>
            </div>


        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Z5JfMFfQp1m49jWm8yNFf0/3pEj9/h6+6j5LLFujVnY" crossorigin="anonymous">
        </script>

</body>

</html>