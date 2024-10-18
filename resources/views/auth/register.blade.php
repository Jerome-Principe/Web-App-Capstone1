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
    <link rel="stylesheet" href="Register.css">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Register</title>
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

    .control input {
        width: 100%;
        display: block;
        padding: 10px;
        color: #222;
        border: none;
        outline: none;
        margin: 1em 0;
    }

    .btn-register {
        background: crimson;
        color: #fff;
        text-transform: uppercase;
        font-size: 0.9em;
        width: 100%;
        border: none;
        padding: 8px 16px;
        opacity: .7;
        transition: opacity .3s ease;
    }

    .btn-register:hover {
        background: darkred;
        color: #f9f9f9;
        transform: scale(1.05);
        opacity: 1;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);


    }

    .link {
        text-align: left;
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
</style>

<body>
    <section>
        <div class="form-container">
            <h1>Register</h1>

            <!-- Display All Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Laravel Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Field -->
                <div class="control">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="control">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="control">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button and Already Registered Link -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="link">
                        <a href="{{ route('login') }}">Already Registered?</a>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-register">Register</button>
                    </div>
                </div>

            </form>

        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Z5JfMFfQp1m49jWm8yNFf0/3pEj9/h6+6j5LLFujVnY" crossorigin="anonymous">
        </script>
</body>

</html>