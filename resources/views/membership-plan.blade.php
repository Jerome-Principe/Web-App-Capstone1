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
    <link rel="stylesheet" href="{{asset('assets/css/membership-plan.css')}}">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Membership Plan</title>
</head>

<body>
    <div class="container">
        <header>Membership Plan</header>
        <div class="sub-container">
            <p class="title">Gym Rates</p>
            <div class="details">
                <button type="submit" class="btn1" onclick="window.location.href='bronze-plan';">
                    Bronze<br>₱800<br>1 Month
                </button>
                <button type="submit" class="btn2" onclick="window.location.href='silver-plan';">
                    Silver<br>₱2000<br>3 Month
                </button>
                <button type="submit" class="btn3" onclick="window.location.href='gold-plan';">
                    Gold<br>₱3500<br>6 Month
                </button>
            </div>
        </div>
    </div>
</body>

</html>