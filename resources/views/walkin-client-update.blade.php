<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Update Walk-in Client</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }

        body {
            font-family: "Poppins";
            height: 100vh;
            width: 100%;
            background-image: url('{{asset('assets/images/stronger.jpg')}}');
            background-size: cover;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
            width: 650px;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 7px 7px 80px #000;
            color: #fff;
        }

        .form-container header {
            font-size: 2em;
            text-align: left;
            margin-bottom: 1.5em;
            color: #fff;
        }

        label {
            color: #fff;
        }

        .form-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            height: 45px;
            box-sizing: border-box;
            appearance: none;
            /* Removes default arrow on some browsers */
            background-color: white;
            /* Ensures white background for the dropdown */
            color: #333;
            /* Default text color */
            font-family: inherit;
            /* Ensures same font as the input */
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .back-btn,
        .submit-btn {
            width: 150px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease, opacity 0.3s ease;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        .submit-btn {
            background-color: crimson;
            color: white;
        }

        .submit-btn:hover {
            opacity: 0.9;
        }
    </style>

</head>

<body>

    <div class="form-container">
        <header>Update Walk-in Client</header>
        <p><strong>Personal Details</strong></p>

        <form action="{{ route('walkins.update', $walkin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <div>
                    <label for="firstname">Firstname:</label>
                    <input type="text" placeholder="Enter your firstname" id="firstname" name="firstname"
                        value="{{ $walkin->firstname }}" required>
                </div>
                <div>
                    <label for="lastname">Lastname:</label>
                    <input type="text" placeholder="Enter your lastname" id="lastname" name="lastname"
                        value="{{ $walkin->lastname }}" required>
                </div>
                <div>
                    <label for="middlename">Middle name:</label>
                    <input type="text" placeholder="Enter your middle name" id="middlename" name="middlename"
                        value="{{ $walkin->middlename }}">
                </div>
                <div>
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="{{ $walkin->date }}" required>
                </div>
                <div>
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" value="{{ $walkin->time }}" required>
                </div>
                <div>
                    <label for="amount">Amount:</label>
                    <input type="number" placeholder="Enter the amount" id="amount" name="amount"
                        value="{{ $walkin->amount }}" required>
                </div>
                <div>
                    <label for="payment">Mode of Payment:</label>
                    <select name="payment" id="payment">
                        <option value="Cash" {{ $walkin->payment == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Gcash" {{ $walkin->payment == 'Gcash' ? 'selected' : '' }}>Gcash</option>
                    </select>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ url()->previous() }}" class="back-btn">Back</a>
                <button type="submit" class="submit-btn">Save</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Z5JfMFfQp1m49jWm8yNFf0/3pEj9/h6+6j5LLFujVnY"
        crossorigin="anonymous"></script>

</body>

</html>