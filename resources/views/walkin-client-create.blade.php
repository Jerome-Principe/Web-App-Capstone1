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
    <link rel="stylesheet" href="{{asset('assets/css/walkin-client.css')}}">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>Walkin Client</title>
</head>

<body>

    <div class="container">
        <header>Walkin Clients</header>

        <form action="{{route('walkin.store')}}" method="POST">
            @csrf
            <div class="form first">
                <div class="details personal">
                    <span class="title"><b><i>Personal Details</i></b></span>
                    <div class="fields">

                        <div class="input-field">
                            <label>Lastname</label>
                            <input type="text" name="lastname" placeholder="Enter your surname" required>
                        </div>

                        <div class="input-field">
                            <label>Firstname</label>
                            <input type="text" name="firstname" placeholder="Enter your firstname" required>
                        </div>

                        <div class="input-field">
                            <label>Middle name</label>
                            <input type="text" name="middlename" placeholder="Enter your middle name" required>
                        </div>

                        <div class="input-field">
                            <label>Date</label>
                            <input type="date" name="date" placeholder="Enter the date" required>
                        </div>

                        <div class="input-field">
                            <label>Time</label>
                            <input type="time" name="time" placeholder="Enter the time" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="gender" id="gender">
                                <optgroup label="Option:">
                                    <option value="gender" disabled selected>Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Age</label>
                            <input type="number" name="age" placeholder="Enter your age" required>
                        </div>

                        <div class="input-field">
                            <label>Address</label>
                            <select name="city" id="city">
                                <optgroup label="Option">
                                    <option value="city" disabled selected>City</option>
                                    <option value="Meycauayan">Meycauayan</option>
                                    <option value="Marilao">Marilao</option>
                                    <option value="Bocaue">Bocaue</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Province</label>
                            <select name="province" id="province">
                                <optgroup label="Option">
                                    <option value="province" disabled selected>Province</option>
                                    <option value="Bulacan">Bulacan</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Zip Code</label>
                            <select name="zipcode" id="zipcode">
                                <optgroup label="Option">
                                    <option value="zipcode" disabled selected>Zip Code</option>
                                    <option value="3018">3018</option>
                                    <option value="3019">3019</option>
                                    <option value="3020">3020</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Amount</label>
                            <input type="number" name="amount" placeholder="Enter the amount" required>
                        </div>

                        <div class="input-field">
                            <label>Mode of Payment</label>
                            <select name="payment" id="payment">
                                <optgroup label="Select your option:">
                                    <option value="payment" disabled selected>Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Gcash">Gcash</option>
                                </optgroup>
                            </select>
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

                <button type="submit" class="nextBtn">
                    <span class="btnText">SUBMIT</span>
                </button>

            </div>
        </form>

    </div>
    <br>
</body>

</html>