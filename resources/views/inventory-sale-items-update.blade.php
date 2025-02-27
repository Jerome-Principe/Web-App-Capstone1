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

    <title>Update Sale Items</title>

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
            background-image: url('{{ asset('assets/images/GYM2.jpg') }}');
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
        <header>Update Drinks Item</header>

        <form action="{{ route('sales.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <div class="input-field">
                    <label for="item_name">Item Name:</label>
                    <input type="text" placeholder="Enter Item Name" id="item_name" name="item_name"
                        value="{{ $item->item_name }}" required>
                </div>

                <div class="input-field">
                    <label for="quantity">Quantity:</label>
                    <input type="number" placeholder="Enter Quantity" id="quantity" name="quantity"
                        value="{{ $item->quantity }}" required>
                </div>

                <div class="input-field">
                    <label for="price">Price:</label>
                    <input type="text" placeholder="Enter Price" id="price" name="price" value="{{ $item->price }}"
                        required>
                </div>

                <div class="input-field">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="{{$item->date }}" required>
                </div>

            </div>

            @if(session('success'))
                <div class="custom-alert-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="buttons">
                <a href="{{ url()->previous() }}" class="back-btn">Back</a>
                <button type="submit" class="submit-btn">Save</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Z5JfMFfQp1m49jWm8yNFf0/3pEj9/h6+6j5LLFujVnY" crossorigin="anonymous">
        </script>

</body>

</html>