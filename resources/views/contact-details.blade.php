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
    <link rel="stylesheet" href="{{asset('assets/css/contact-details.css')}}">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Other Details</title>
</head>

<body>
    <div class="container">
        <header>Emergency Contact Details</header>

        <form action="#">
            <div class="form first">
                <div class="details personal">

                    <span class="title"><b><i>Relatives Details</i></b></span>
                    <div class="fields">

                        <div class="input-field">
                            <label>Emergency Contact</label>
                            <input type="text" placeholder="Enter your emergency contact" required>
                        </div>

                        <div class="input-field">
                            <label>Relationship</label>
                            <input type="text" placeholder="Enter your relationship" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" placeholder="Enter mobile number" required>
                        </div>

                    </div>

                    <span class="title"><b><i>Medical Questionnaires</i></b></span>
                    <div class="check-field">
                        <label>1. Have you ever or do you have any of the following?</label>
                        <div class="check">
                            <input type="checkbox">
                            <label>Health Disease</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Asthma</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Gout</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Cardiovascular Condition</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>High Blood Pressure</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Dizziness</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Arthritis</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Infectious Disease</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Black Outs</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Infectious Disease</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Diabetes</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Fainting</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Epilepsy</label>
                        </div>
                    </div>

                    <div class="fields">

                        <div class="input-field">
                            <label>Others:</label>
                            <input type="text" placeholder="Type here" required>
                        </div>

                    </div>

                    <div class="check-field">
                        <label>2. Have you ever or do you have any of the following?</label>
                        <div class="check">
                            <input type="checkbox">
                            <label>Knees</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Lower Back</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Neck</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Shoulders</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Hips</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Pelvis</label>
                        </div>
                        <div class="check">
                            <input type="checkbox">
                            <label>Flexibility</label>
                        </div>
                    </div>

                    <div class="fields">

                        <div class="input-field">
                            <label>Others:</label>
                            <input type="text" placeholder="Type here" required>
                        </div>

                    </div>

                    <div class="fields">

                        <div class="input-field">
                            <label>3. Are you pregnant? If YES, how many weeks?</label>
                            <input type="text" placeholder="Type here" required>

                            <label>4. Are you currently doing any regular physical activities?</label>
                            <input type="text" placeholder="Type here" required>

                            <label>5. Do you smoke, if yes how many per day? And for how long have you smoked?</label>
                            <input type="text" placeholder="Enter your emergency contact" required>

                            <label>6. Are you on medication? If yes, what and when do you take?</label>
                            <input type="text" placeholder="Enter your emergency contact" required>

                            <label>Date</label>
                            <input type="date" placeholder="Date" required>
                        </div>

                    </div>

                </div>

                <button class="nextBtn" onclick="window.location.href='payment-method';">
                    <span class="btnText">Next</span>
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </button>

            </div>
        </form>

    </div>
</body>

</html>