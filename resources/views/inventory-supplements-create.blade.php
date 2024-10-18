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
    <link rel="stylesheet" href="{{asset('assets/css/supplements-form.css')}}">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Supplement Form</title>
</head>

<body>
    <div class="container">
        <header>Add Supplement Item</header>

        <form action="{{ route('supplements.store') }}" method="POST">
            @csrf
            <div class="form first">
                <div class="details personal">
                    <div class="fields">

                        <div class="input-field">
                            <label>Item Name</label>
                            <input type="text" placeholder="Enter Item Name" class="form-control" id="name" name="name"
                                required>
                        </div>

                        <div class="input-field">
                            <label>Quantity</label>
                            <input type="text" placeholder="Enter Quantity" class="form-control" id="quantity"
                                name="quantity" required>
                        </div>

                        <div class="input-field">
                            <label>Price</label>
                            <input type="number" placeholder="Enter Price" class="form-control" id="price" name="price"
                                required>
                        </div>

                        <div class="input-field">
                            <label>Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                        <div class="input-field">
                            <label>Time</label>
                            <input type="time" class="form-control" id="time" name="time" required>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="custom-alert-message">
                        {{ session('success') }}
                    </div>
                @endif

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        setTimeout(function () {
                            const alert = document.querySelector('.custom-alert-message');
                            if (alert) {
                                alert.classList.add('fade-out');
                            }
                        }, 3000); // 3000ms = 3 seconds
                    });
                </script>

                <button class="nextBtn">
                    <span class="btnText">Submit</span>
                </button>

            </div>
        </form>

    </div>
</body>

</html>