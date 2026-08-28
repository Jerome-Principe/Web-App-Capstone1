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
    <link rel="stylesheet" href="{{asset('assets/css/learnmorebtn.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <style>
        .container .mycard {
            position: relative;
            width: 300px;
            height: 320px;
            padding: 0;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .container .mycard:hover {
            height: 320px;
            transform: translateY(-8px);
        }

        .container .mycard .cimg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            box-shadow: none;
        }

        .container .mycard .cimg img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0;
            transition: transform 0.5s ease;
        }

        .container .mycard:hover .cimg img {
            transform: scale(1.1);
        }

        .container .mycard .card-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 24px;
            text-align: center;
            background: linear-gradient(to top, rgba(18, 18, 18, 0.95), rgba(18, 18, 18, 0.6));
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .container .mycard:hover .card-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .container .mycard .card-overlay h2 {
            margin-bottom: 8px;
            color: #FFB800;
            font-weight: bold;
        }

        .container .mycard .card-overlay p {
            margin-bottom: 0;
            color: #FFFFFF;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #FFB800;
            color: #121212;
            font-weight: 700;
            font-size: 1rem;
            padding: 12px 32px;
            border-radius: 50px;
            text-decoration: none;
            border: 2px solid #FFB800;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-back-home:hover {
            background-color: #FF9900;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 184, 0, 0.4);
        }

        .btn-back-home i {
            transition: transform 0.3s ease;
        }

        .btn-back-home:hover i {
            transform: translateX(-6px);
        }
    </style>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>learnmore</title>
</head>

<body>
    <div class="mainBody">
        <div class="Header" data-aos="fade-down" data-aos-duration="800">
            <h5>EST. 2021</h5>
            <h1>LIMITLESS FITNESS STUDIO</h1>
        </div>
        <div class="cbground">
            <img src="{{asset('assets/images/GYM1.jpg')}}" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="200">
            <p data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                Fitness enthusiasts from all around the city can easily reach Limitless Fitness Studio because to its
                handy location at #6 Network Ave Meralco Village Lias Marilao Bulacan,
                Marilao, Philippines. Our state-of-the-art facility is easily accessible by car, bicycle, or public
                transportation because it is located close to important transportation hubs.
                The class is surrounded by a bustling neighborhood with lots of different parks, stores, and cafés,
                making it the ideal place for a stroll before or after a workout. There is plenty of
                parking close by, and the studio is easily accessible by foot from the 7/11 MERALCO VILLAGE, a
                well-known landmark that helps people find us.
            </p>
        </div>

        <div class="section-title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
            <div>
                <h2>Explore Our Fitness Areas</h2>
            </div>
        </div>
        <div class="mainContainer">

            <div class="container">

                <div class="mycard" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="cimg">
                        <img src="{{asset('assets/images/machine2.jpg')}}" alt="Weight training area">
                    </div>
                    <div class="card-overlay">
                        <h2>Weight Training Area</h2>
                        <p>
                            This area is where the weight training involves, using resistance whether it's
                            bodyweight or
                            dumbbells to perform exercises that challenge all muscle groups in the body.
                        </p>
                    </div>
                </div>
                <div class="mycard" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="cimg">
                        <img src="{{asset('assets/images/machine6.jpg')}}" alt="Cardio area">
                    </div>
                    <div class="card-overlay">
                        <h2>Cardio Area</h2>
                        <p>
                            This area involves the cardio where you can use the stationary bike and treadmills.
                        </p>
                    </div>
                </div>
                <div class="mycard" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="cimg">
                        <img src="{{asset('assets/images/locker.jpg')}}" alt="Locker rooms">
                    </div>
                    <div class="card-overlay">
                        <h2>Locker rooms</h2>
                        <p>
                            This is where you can put your things while in the gym.
                        </p>
                    </div>
                </div>
                <div class="mycard" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="cimg">
                        <img src="{{asset('assets/images/lifestyle.jpg')}}" alt="Happy community">
                    </div>
                    <div class="card-overlay">
                        <h2>Happy Community</h2>
                        <p>
                            At Limitless Fitness Studio, we believe that a supportive and joyful community is the
                            cornerstone of personal and collective growth.
                            Our members are more than just fitness enthusiasts; they are friends, motivators, and
                            cheerleaders for one another.
                        </p>
                    </div>
                </div>
                <div class="mycard" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                    <div class="cimg">
                        <img src="{{asset('assets/images/inclinepress.jpg')}}" alt="Motivation area">
                    </div>
                    <div class="card-overlay">
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
                <div class="mycard" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                    <div class="cimg">
                        <img src="{{asset('assets/images/GYM2.jpg')}}" alt="Limitless fitness area">
                    </div>
                    <div class="card-overlay">
                        <h2>Limitless</h2>
                        <p>
                            Positivity is contagious at Limitless Fitness Studio.
                            Our community members cheer each other on, celebrate successes, and provide
                            encouragement
                            during challenges. Every achievement is recognized, and every effort is appreciated.
                        </p>
                    </div>
                </div>
                <!-- Add this new section below the last "mycard" -->
                <div class="description">
                    <p>
                        Limitless Fitness Studio is more than just a gym; it is a space that offers an extraordinary
                        experience for individuals passionate about health and fitness. The facility boasts
                        specialized
                        areas designed to cater to every aspect of a comprehensive workout routine. From the weight
                        training area, equipped with state-of-the-art machines and free weights, to the cardio
                        section
                        featuring treadmills and stationary bikes, every corner of the gym is optimized to help you
                        achieve your fitness goals. The clean and secure locker rooms ensure a hassle-free
                        environment,
                        allowing members to focus entirely on their training sessions.
                    </p>
                    <p>
                        Beyond the physical amenities, Limitless Fitness Studio shines as a vibrant and motivating
                        community hub. Members come together in an atmosphere of positivity and encouragement,
                        fostering
                        connections that go beyond fitness. Whether you're pushing your limits in the incline press
                        zone
                        or engaging with like-minded individuals in the lifestyle and happiness spaces, the studio's
                        inclusive culture ensures that every member feels supported and celebrated. At Limitless
                        Fitness
                        Studio, it’s not just about building stronger bodies; it's about creating a community that
                        inspires and uplifts.
                    </p>

                    <div class="text-center my-5">
                        <a href="/" class="btn-back-home"><i class="fa fa-arrow-left me-2"></i> Back to Home</a>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 100 });
    </script>
</body>

</html>