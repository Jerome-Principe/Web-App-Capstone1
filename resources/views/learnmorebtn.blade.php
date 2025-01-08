<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/learnmorebtn.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Learn More</title>
</head>

<body>
    <div class="mainBody">
        <div class="Header text-center mt-5">
            <h5>EST. 2021</h5>
            <h1>LIMITLESS FITNESS STUDIO</h1>
        </div>

        <div class="cbground text-center my-4">
            <img src="{{ asset('assets/images/GYM1.jpg') }}" alt="Gym">
            <p>
                Fitness enthusiasts from all around the city can easily reach Limitless Fitness Studio thanks to its
                location at #6 Network Ave, Meralco Village, Lias Marilao, Bulacan, Philippines. Our facility is close
                to key transportation hubs and surrounded by parks, shops, and cafés, making it a convenient spot for
                fitness lovers.
            </p>
        </div>

        <div class="section-title text-center mb-4">
            <h2>Explore Our Fitness Areas</h2>
        </div>

        <div class="mainContainer container">
            <!-- Weight Training Area -->
            <div class="mycard">
                <div class="cimg">
                    <img src="{{ asset('assets/images/machine2.jpg') }}" alt="Weight Training">
                </div>
                <div class="cdetail">
                    <h2>Weight Training Area</h2>
                    <p>
                        This area is where weight training involves using resistance, whether it's bodyweight or
                        dumbbells, to challenge all muscle groups in the body.
                    </p>
                </div>
            </div>

            <!-- Cardio Area -->
            <div class="mycard">
                <div class="cimg">
                    <img src="{{ asset('assets/images/machine6.jpg') }}" alt="Cardio Area">
                </div>
                <div class="cdetail">
                    <h2>Cardio Area</h2>
                    <p>
                        This area involves cardio exercises where you can use stationary bikes and treadmills.
                    </p>
                </div>
            </div>

            <!-- Locker Rooms -->
            <div class="mycard">
                <div class="cimg">
                    <img src="{{ asset('assets/images/locker.jpg') }}" alt="Locker Rooms">
                </div>
                <div class="cdetail">
                    <h2>Locker Rooms</h2>
                    <p>
                        A secure space to store your belongings while you focus on your fitness goals.
                    </p>
                </div>
            </div>


            <div class="mycard">
                <div class="cimg">
                    <img src="{{asset('assets/images/lifestyle.jpg')}}">
                </div>
                <div class="cdetail">
                    <h2>Happy Community</h2>
                    <p>
                        At Limitless Fitness Studio, we believe that a supportive and joyful community is the
                        cornerstone of personal and collective growth.
                        Our members are more than just fitness enthusiasts; they are friends, motivators, and
                        cheerleaders for one another.
                    </p>
                </div>
            </div>


            <div class="mycard">
                <div class="cimg">
                    <img src="{{asset('assets/images/inclinepress.jpg')}}">
                </div>
                <div class="cdetail">
                    <h2>Motivation</h2>
                    <p>
                        At Limitless Fitness Studio, we understand that motivation is the key to unlocking your
                        full
                        potential.
                        Our community is built on the foundation of mutual encouragement and support, driving
                        each
                        member to reach their fitness goals and beyond.
                    </p>
                </div>
            </div>


            <div class="mycard">
                <div class="cimg">
                    <img src="{{asset('assets/images/GYM2.jpg')}}">
                </div>
                <div class="cdetail">
                    <h2>Limitless</h2>
                    <p>
                        Positivity is contagious at Limitless Fitness Studio.
                        Our community members cheer each other on, celebrate successes, and provide
                        encouragement
                        during challenges. Every achievement is recognized, and every effort is appreciated.
                    </p>
                </div>
            </div>
        </div>

        <div class="description text-center my-5">
            <p>
                Limitless Fitness Studio is more than just a gym; it's a community that fosters positivity and growth.
                Our facility offers state-of-the-art equipment, inclusive spaces, and an uplifting atmosphere.
            </p>
            <a href="/" class="btn back-btn"><i class="fa fa-arrow-circle-left"></i> Back to Home</a>
        </div>
    </div>
</body>

</html>