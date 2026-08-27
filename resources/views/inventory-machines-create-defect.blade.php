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

    <title>Add Machine Item Defect</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }

        body {
            font-family: "Poppins";
            color: #fff;
            height: 100vh;
            width: 100%;
            background-image: url('{{ asset('assets/images/machine6.jpg') }}');
            background-size: cover;
            background-position: center center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
            width: 380px;
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 7px 7px 80px #000;
        }

        .form-container header {
            font-size: 2em;
            text-align: center;
            margin-bottom: 1.5em;
        }

        label {
            color: #fff;
        }

        .input-field input,
        .input-field select {
            width: 100%;
            padding: 10px;
            color: #222;
            border: none;
            margin: 10px 0;
            border-radius: 5px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .back-btn,
        .submit-btn {
            width: 45%;
            padding: 8px;
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

        .custom-alert-message {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 25px;
            border: 1px solid #c3e6cb;
            margin-top: 20px;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .custom-alert-message::before {
            content: "\f00c";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #155724;
            margin-right: 10px;
        }

        .custom-alert-message.fade-out {
            animation: fadeOut 2s forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <header>Machine Item Defect</header>

        <form action="{{ route('machine-defects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <div class="input-field">
                    <label>Select Machine:</label>
                    <select name="machine_id" id="select_machine" required>
                        @foreach ($machineDefects as $machineDefect)
                            <option value="{{ $machineDefect->id }}">{{ $machineDefect->item_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-field">
                    <label>Quantity:</label>
                    <input type="number" placeholder="Enter Quantity" name="quantity" required>
                </div>

                <div class="input-field">
                    <label>Defect:</label>
                    <select name="defect" id="defect" required>
                        <optgroup label="Option">
                            <option value="None">None</option>
                            <option value="Loose Cables">Loose Cables</option>
                            <option value="Treadmill No Safety Keys">Treadmill no safety keys</option>
                            <option value="Damaged Cables">Damaged Cables</option>
                            <option value="Missing Bearing">Missing bearing</option>
                            <option value="Broke Belt">Broke Belt</option>
                            <option value="Inflated Balloons">Inflated balloons</option>
                        </optgroup>
                    </select>
                </div>

                <div class="input-field">
                    <label>Date:</label>
                    <input type="date" name="date" required>
                </div>

            </div>

            @if(session('success'))
                <div class="custom-alert-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="buttons">
                <a href="{{ url()->previous() }}" class="back-btn">Back</a>
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Z5JfMFfQp1m49jWm8yNFf0/3pEj9/h6+6j5LLFujVnY" crossorigin="anonymous">
        </script>

</body>

</html>