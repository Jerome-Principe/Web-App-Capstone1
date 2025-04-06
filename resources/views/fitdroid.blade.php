<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <title>Fitdroid</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">

    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/slick.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/LineIcons.2.0.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.4.5.2.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/default.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/fitdroidweb.css')}}">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Link Custom Css File -->


    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <header class="header-area">
        <div class="navbar-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="/">
                                <img src="{{asset('assets/images/LogoLimit2.png')}}" alt="Logo" height="50px"
                                    width="100%">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#courses">Courses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#team">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#schedules">Schedules</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#pricing">Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#trainee">Trainee</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#contact">Contact</a>
                                    </li>
                                </ul>
                            </div>
                            <li class="nav-item d-flex align-items-center ml-4">
                                <a href="/login" class="btn px-3 py-2"
                                    style="background-color: #343a40; border-color: #212529; color: white;">Login</a>
                            </li>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div id="home" class="header-hero bg_cover d-flex align-items-center"
            style=" background-image: url('{{asset('assets/images/BGround.jpg')}}');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="header-hero-content text-center">
                            <h3 class="header-title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
                                Limitless Fitness Studio Gym
                            </h3>
                            <p class="wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.5s"
                                style="font-size: 30px;"><i>Believe In Yourself I am ∞ Limitless</i></p>
                            <ul>
                                <li>
                                    <a href="https://drive.google.com/file/d/1_6SHcZFdJvG8u0vofgZBuaqCRUOE9s4t/view?usp=sharing
                                        FITDROID(3-18-25).apk" class="main-btn wow fadeInUp" data-wow-duration="1.3s"
                                        data-wow-delay="0.8s">Get Started
                                    </a>
                                </li>
                                <li><a href="/learnmorebtn" class="main-btn main-btn-2 wow fadeInUp"
                                        data-wow-duration="1.3s" data-wow-delay="1.2s">Learn More
                                </li></a>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <section id="courses" class="courses_area pt-105">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section_title text-center pb-25">
                        <span class="line"></span>
                        <h3 class="title">OUR COURSES</h3>
                        <p><i>At Limitless Fitness Studio, we believe in empowering our members to achieve their fitness
                                goals through expert guidance, personalized training,
                                and a diverse range of fitness courses tailored to suit every individual's needs and
                                preferences. Whether you're a seasoned fitness
                                enthusiast or just starting your wellness journey, our comprehensive selection of
                                courses offers something for everyone.
                            </i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/strengthconditioning.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Strenght & Conditioning</i></a></h4>
                        <p>
                            Strength and conditioning is a systematic approach to physical training that aims to improve
                            an individual's
                            performance in various sports, activities, or fitness goals. It involves resistance
                            training, cardiovascular
                            conditioning, and flexibility work to enhance strength, power, speed, agility, endurance,
                            and overall physical capabilities.
                            These programs are designed with specific goals in mind, overseen by qualified coaches.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/hightintensitytraining.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Hight Intensity Training</i></a></h4>
                        <p>
                            High-Intensity Training (HIT) is a form of exercise that focuses on performing short bursts
                            of intense activity followed by periods
                            of rest or lower-intensity exercise. The main goal of HIT is to maximize the effectiveness
                            of the workout in a shorter period of time compared to traditional training methods.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/athletictraining.png1.jpg')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Athletic Training</i></a></h4>
                        <p>
                            Athletic training is a healthcare profession dedicated to the prevention, diagnosis,
                            treatment, and rehabilitation of injuries and illnesses related to physical activity and
                            sports.
                            Athletic trainers (ATs) are highly qualified, multi-skilled health professionals who work
                            under the direction of or in collaboration with physicians to provide services to athletes,
                            active individuals, and teams.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Crossfit.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Circuit Crossfit</i></a></h4>
                        <p>
                            Circuit CrossFit is a high-intensity fitness program that combines circuit training with
                            CrossFit, incorporating elements from various sports like weightlifting, gymnastics, and
                            cardio,
                            and focusing on functional movements for overall fitness improvement.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Weighttraining.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Weight Training</i></a></h4>
                        <p>
                            Weight training, also known as resistance training or strength training, is a form of
                            exercise that involves lifting weights to improve muscle strength, endurance, and overall
                            fitness.
                            It uses various types of resistance to induce muscular contraction, which builds strength,
                            anaerobic endurance, and the size of skeletal muscles.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Bodybuilding.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Body Building</i></a></h4>
                        <p>
                            Bodybuilding is a sport and a physical activity focused on developing muscle size, symmetry,
                            and definition through structured resistance training, proper nutrition, and disciplined
                            lifestyle habits.
                            It involves rigorous workouts, precise dietary planning, and often participation in
                            competitions where athletes are judged based on their physique.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Aeroboxing.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Aeroboxing</i></a></h4>
                        <p>
                            Aeroboxing, also known as cardio boxing or aerobic boxing, is a fitness activity that
                            combines elements of traditional boxing with high-intensity aerobic exercise. It involves
                            performing boxing techniques
                            such as punches, footwork, and defensive moves in a fast-paced, rhythmic manner, often set
                            to music. The primary goal of aeroboxing is to improve cardiovascular fitness, burn
                            calories, and enhance overall physical conditioning.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Kickboxing1.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Kick Boxing</i></a></h4>
                        <p>
                            Kickboxing is a dynamic combat sport and fitness activity that combines elements of
                            traditional boxing with martial arts kicks. It emphasizes both striking and defensive
                            techniques, providing a comprehensive workout that enhances
                            cardiovascular fitness, muscle strength, and overall physical conditioning.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Taekwondo.png1.jpg')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Taekwondo</i></a></h4>
                        <p>
                            Taekwondo is a Korean martial art that emphasizes high, fast kicks, spinning kicks, jumping
                            kicks, and powerful strikes. It is known for its dynamic techniques and is both a
                            traditional martial art and a modern combat sport. The name "Taekwondo"
                            can be broken down into three parts: "Tae" means foot, "Kwon" means fist, and "Do" means way
                            or discipline, collectively translating to "the way of the foot and fist."
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/boxing1.jpg')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Boxing</i></a></h4>
                        <p>
                            Boxing is a combat sport that involves two opponents, typically of similar weight, who
                            engage
                            in a contest of skill, speed, and endurance inside a roped-off square ring. The primary
                            objective is to land punches on the opponent while avoiding being hit,
                            with the ultimate goal of winning by knockout, technical knockout, or decision from judges.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Cardio.jpg')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Cardio</i></a></h4>
                        <p>
                            Cardio, short for cardiovascular exercise, refers to any physical activity that raises your
                            heart rate and increases blood circulation throughout the body. It is named after the
                            cardiovascular system, which includes the heart and blood vessels, and encompasses
                            a wide range of exercises that benefit heart health and overall fitness.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Weightlifting.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Weight Lifting</i></a></h4>
                        <p>
                            Weightlifting, also known as weight training or resistance training, is a form of exercise
                            that involves lifting weights to build strength, muscle mass, and endurance. It typically
                            involves the use of various types of resistance, including free weights
                            (such as dumbbells and barbells), weight machines, resistance bands, or one's body weight.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Zumba.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Zumba</i></a></h4>
                        <p>
                            Zumba is a high-energy fitness program that combines Latin and international music with
                            dance-inspired movements. Developed in the 1990s by Colombian dancer and choreographer
                            Alberto "Beto" Perez, Zumba has become a popular exercise phenomenon worldwide, attracting
                            millions of
                            participants of all ages and fitness levels.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Yoga.jpg')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Yoga</i></a></h4>
                        <p>
                            Yoga is a holistic practice that originated in ancient India and encompasses physical
                            postures, breathing techniques, meditation, and ethical principles. It aims to promote
                            physical, mental, and spiritual well-being, cultivating harmony between mind, body, and
                            spirit.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_courses mt-30">
                        <img src={{asset('assets/images/Poledancing.png')}} alt="courses">
                        <h4 class="title"><a href="javascript:void(0)"><i>Pole Dancing</i></a></h4>
                        <p>
                            Pole dancing is a form of performance art and fitness that involves dance and acrobatics
                            performed around a vertical pole. It requires strength, flexibility, and coordination and
                            has gained popularity as both a recreational activity and a professional performance art.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <section id="about" class="about_area pt-115 pb-120">
        <div class="about_wrapper">
            <div class="about_bg bg_cover d-none d-lg-block"
                style=" background-image: url('{{asset('assets/images/machine4.jpg')}}');">
            </div>
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-10">
                        <div class="about_content">
                            <h2 class="about_title"> A YEARS OF EXPERIENCE </h2>
                            <div class="about_content_wrapper">
                                <div class="section_title">
                                    <span class="line"></span>
                                    <h3 class="title">Learn More About Us</h3>
                                    <p>At Limitless Fitness Studio, we are proud to celebrate our 3 years anniversary in
                                        the fitness industry, marking a significant milestone in our commitment to
                                        helping individuals achieve their health and wellness goals. Over the past year,
                                        we have dedicated ourselves to providing top-quality facilities,
                                        expert guidance, and unparalleled support to our members, creating a thriving
                                        community of fitness enthusiasts who are passionate about living their best
                                        lives.
                                    </p>
                                </div>
                                <a class="main-btn" href="/readmorebtn">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="counter" class="counter_area pt-70 pb-120 bg_cover"
        style="background-image: url('{{asset('assets/images/machine2.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="single_counter text-center mt-40">
                        <i class="lni lni-users"></i>
                        <span class="count counter">5345</span>
                        <p>Satisfied Trainee</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="single_counter text-center mt-40">
                        <i class="lni lni-thumbs-up"></i>
                        <span class="count counter">345</span>
                        <p>Courses Completed</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="single_counter text-center mt-40">
                        <i class="fa fa-male" aria-hidden="true"></i>
                        <span class="count counter">13</span>
                        <p>Trainers</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="single_counter text-center mt-40">
                        <i class="lni lni-cup"></i>
                        <span class="count counter">45</span>
                        <p>Awards Won</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="team" class="team_area pt-105 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section_title text-center pb-55">
                        <span class="line"></span>
                        <h3 class="title">OUR TEAM</h3>
                        <p><b>START TO CHANGE YOURSELF</b></p>
                        <p><i> A tiny step leads to a big difference. Our knowledgeable staff will develop a unique
                                program based on your health.
                                and physical requirements. Start it now.
                            </i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_team text-center">
                        <div class="team_image">
                            <img src={{asset('assets/images/sircholo.jpg')}} alt="team">
                        </div>
                        <div class="team_content">
                            <ul class="social">
                                <li><a href="https://www.facebook.com/profile.php?id=100080285593213"><i
                                            class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram-original"></i></a></li>
                            </ul>
                            <h5 class="team_name"><i>Villarmino Bato Cholo</i></h5>
                            <p><i class="fa fa-user mx-2" aria-hidden="true"></i> Owner</p>
                            <p><i class="fa fa-phone mx-2" aria-hidden="true"></i> 0969-091-8489
                                <hr>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_team text-center">
                        <div class="team_image">
                            <img src={{asset('assets/images/sircyrus.jpg')}} alt="team">
                        </div>
                        <div class="team_content">
                            <ul class="social">
                                <li><a href="https://www.facebook.com/ChronosTheGhost"><i
                                            class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram-original"></i></a></li>
                            </ul>
                            <h5 class="team_name"><i>Cyrus Villanueva</i></h5>
                            <p><i class="fa fa-certificate mx-2" aria-hidden="true" style="color: goldenrod;"></i>
                                Certified Personal Trainer Level. 3</p>
                            <p><i class="fa fa-phone mx-2" aria-hidden="true"></i> 0999-969-4619
                                <hr>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_team text-center">
                        <div class="team_image">
                            <div class="container">
                                <img src={{asset('assets/images/JayfrelNillosaRastica.jpg')}} alt="team">
                            </div>
                        </div>
                        <div class="team_content">
                            <ul class="social">
                                <li><a href="https://www.facebook.com/jrastica"><i
                                            class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram-original"></i></a></li>
                            </ul>
                            <h5 class="team_name"><i>Jayfrel Nillosa Rastica</i></h5>
                            <p><i class="fa fa-male mx-2" aria-hidden="true"></i>Boxing Trainer</p>
                            <p><i class="fa fa-phone mx-2" aria-hidden="true"></i> 0977-095-9774
                                <hr>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_team text-center">
                        <div class="team_image">
                            <img src={{asset('assets/images/kittyLuvv.jpg')}} alt="team">
                        </div>
                        <div class="team_content">
                            <ul class="social">
                                <li><a href="https://www.facebook.com/sheila.venturaaldecoa"><i
                                            class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram-original"></i></a></li>
                            </ul>
                            <h5 class="team_name"><i>Kitty Luvv</i></h5>
                            <p><i class="fa fa-female mx-2" aria-hidden="true"></i> Fitness Trainer</p>
                            <p><i class="fa fa-phone mx-2" aria-hidden="true"></i> 0977-095-9774
                                <hr>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="schedules" class="schedule_area pt-105 pb-120 bg_cover"
        style=" background-image: url('{{asset('assets/images/machine6.jpg')}}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section_title section_title_2 text-center pb-25">
                        <span class="line"></span>
                        <h3 class="title">CLASS SCHEDULES</h3>
                        <p>At Limitless Fitness Studio, we believe in providing a diverse range of classes to meet all
                            your fitness needs. Our expertly designed schedule offers something for everyone, whether
                            you're a beginner looking to start your fitness journey or an experienced athlete aiming to
                            push your limits.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">01.</span>
                        <span class="time">Mon, 7:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Strenght & Conditioning</a></h4>
                        <span class="time">Mon, 10:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Athletic Training</a></h4>
                        <span class="time">Mon, 3:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Cardio</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">02.</span>
                        <span class="time">Tue, 7.00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Zumba</a></h4>
                        <span class="time">Tue, 4:30 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Yoga Fitness Class</a></h4>
                        <span class="time">Tue, 8:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Weight Training</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">03.</span>
                        <span class="time">Wed, 8:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Body Building</a></h4>
                        <span class="time">Wed, 12:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Circuit Crossfit</a></h4>
                        <span class="time">Wed, 3:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Cardio</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">04.</span>
                        <span class="time">Thur, 8:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Boxing</a></h4>
                        <span class="time">Thur, 3:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Kick Boxing</a></h4>
                        <span class="time">Thur, 6:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Aeroboxing</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">05.</span>
                        <span class="time">Fri, 9:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Pilates</a></h4>
                        <span class="time">Fri, 2:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Taekwondo</a></h4>
                        <span class="time">Fri, 5:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Tai-Chi</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">06.</span>
                        <span class="time">Sat, 8:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">High-Intensity</a></h4>
                        <span class="time">Sat, 2:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Athletic Training</a></h4>
                        <span class="time">Sat, 5:00 PM</span>
                        <h4 class="title"><a href="javascript:void(0)">Body Building</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_schedule mt-30">
                        <span class="number">07.</span>
                        <span class="time">Sun, 8:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Zumba</a></h4>
                        <span class="time">Sun, 10:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Yoga Fitness Class</a></h4>
                        <span class="time">Sun, 5:00 AM</span>
                        <h4 class="title"><a href="javascript:void(0)">Weight Training</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="pricing" class="pricing_area pt-105 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section_title text-center pb-25">
                        <span class="line"></span>
                        <h3 class="title">GYM RATES</h3>
                        <p><i>At Limitless Fitness Studio, we're committed to making fitness accessible and affordable
                                for everyone. Our transparent and competitive pricing structure
                                ensures that you get the best value for your investment in health and wellness. Whether
                                you're looking for flexible membership options or convenient
                                pay-as-you-go rates, we have a plan that fits your lifestyle and budget.
                            </i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single_pricing mt-30">
                        <div class="pricing_wrapper">
                            <div class="pricing_header">
                                <h4 class="title">1 Month <i class="fa fa-ticket" aria-hidden="true"
                                        style="color: rgb(207, 156, 88);"></i></h4>
                                <span class="price"><span>₱800</span> /Month</span>
                            </div>
                            <div class="pricing_content">
                                <ul>
                                    <li>Access to Gym Equipment</li>
                                    <li>RFID</li>
                                    <li>FREE Water</li>
                                    <li>Member Events and Workshops</li>
                                    <li>Locker Rooms and Shower Facilities</li>
                                    <li>Unlimited Gym Access</li>
                                    <li>3 Personal Training Session</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single_pricing mt-30">
                        <div class="pricing_wrapper">
                            <div class="pricing_header">
                                <h4 class="title">3 Months <i class="fa fa-ticket" aria-hidden="true"
                                        style="color: silver;"></i></h4>
                                <span class="price"><span>₱2000</span> /Months</span>
                            </div>
                            <div class="pricing_content">
                                <ul>
                                    <li>Access to Gym Equipment</li>
                                    <li>RFID</li>
                                    <li>FREE Water</li>
                                    <li>Member Events and Workshops</li>
                                    <li>Locker Rooms and Shower Facilities</li>
                                    <li>Unlimited Gym Access</li>
                                    <li>9 Personal Training Session</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single_pricing mt-30">
                        <div class="pricing_wrapper">
                            <div class="pricing_header">
                                <h4 class="title">6 Months <i class="fa fa-ticket" aria-hidden="true"
                                        style="color: 	gold;"></i></h4>
                                <span class="price"><span>₱3500</span> /Months</span>
                            </div>
                            <div class="pricing_content">
                                <ul>
                                    <li>Access to Gym Equipment</li>
                                    <li>RFID</li>
                                    <li>FREE Water</li>
                                    <li>Member Events and Workshops</li>
                                    <li>Locker Rooms and Shower Facilities</li>
                                    <li>Unlimited Gym Access</li>
                                    <li>18 Personal Training Session</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="trainee" class="testimonial_area pt-120 pb-120 bg_cover"
        style=" background-image: url('{{asset('assets/images/machine2.jpg')}}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="testimonial_active">
                        <div class="single_testimonial text-center">
                            <img src={{asset('assets/images/art.jpg')}} alt="author">
                            <h5 class="author_name">Art Concerman</h5>
                            <span class="sub_title">Trainee</span>
                            <p>Limitless Fitness Studio has truly exceeded my expectations! The atmosphere is incredibly
                                welcoming, and the staff is always friendly and supportive. The equipment is top-notch,
                                and the variety of classes keeps me motivated. I've never felt more inspired to reach my
                                fitness goals. Highly recommend!
                            </p>
                        </div>
                        <div class="single_testimonial text-center">
                            <img src={{asset('assets/images/paler.jpg')}} alt="author">
                            <h5 class="author_name">Russel Paler</h5>
                            <span class="sub_title">Trainee</span>
                            <p> I've been a member of Limitless Fitness Studio for six months, and I've seen amazing
                                results.
                                The trainers are highly knowledgeable and create personalized workout plans that
                                really work.
                                The group classes are fun and challenging, and I always leave feeling accomplished. This
                                gym is a game-changer!
                            </p>
                        </div>
                        <div class="single_testimonial text-center">
                            <img src={{asset('assets/images/borja.jpg')}} alt="author">
                            <h5 class="author_name">Johnrafael Borja</h5>
                            <span class="sub_title">Trainee</span>
                            <p>Limitless Fitness Studio stands out for its cleanliness and sense of community. The
                                facilities are always spotless, and there's a great mix of people who are all
                                encouraging and friendly. Whether you're a beginner or an experienced athlete, this gym
                                has something for everyone. I'm so glad I joined!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="contact" class="contact_area ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact_form pt-105 pb-120">
                        <div class="section_title pb-25">
                            <span class="line"></span>
                            <h3 class="title">GIVE US FEEDBACK</h3>
                        </div>
                        <form action="{{route('feedback.submit')}}" method="POST">
                            @csrf
                            <div class="single_form">
                                <input type="text" name="name" placeholder="Name" required>
                            </div>
                            <div class="single_form">
                                <input type="text" name="email" placeholder="example@email.com" required>
                            </div>
                            <div class="single_form">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="single_form">
                                <textarea name="message" placeholder="Message" required></textarea>
                            </div>
                            <p class="form-message"></p>
                            <div class="single_form">
                                <button class="main-btn">SUBMIT</button>
                            </div>

                            @if(session('success'))
                                <div class="custom-alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    setTimeout(function () {
                                        const alert = document.querySelector('.custom-alert-success');
                                        if (alert) {
                                            alert.classList.add('fade-out');
                                        }
                                    }, 3000); // 3000ms = 3 seconds
                                });
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact_map">
            <div class="googlemap_limitless">
                <img src={{asset('assets/images/maps.png')}} alt="">
            </div>
        </div>
    </section>

    <section id="footer" class="footer_area">
        <div class="footer_widget pt-70 pb-120">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer_link mt-45">
                            <h4 class="footer_title">Course</h4>
                            <ul class="link">
                                <li><a href="javascript:void(0)">Strenght & Conditioning</a></li>
                                <li><a href="javascript:void(0)">Hight Intensity Training</a></li>
                                <li><a href="javascript:void(0)">Athletic Training</a></li>
                                <li><a href="javascript:void(0)">Circuit Crossfit</a></li>
                                <li><a href="javascript:void(0)">Weight Training</a></li>
                                <li><a href="javascript:void(0)">Body Building</a></li>
                                <li><a href="javascript:void(0)">Aeroboxing</a></li>
                                <li><a href="javascript:void(0)">Kick Boxing</a></li>
                                <li><a href="javascript:void(0)">Taekwondo</a></li>
                                <li><a href="javascript:void(0)">Boxing</a></li>
                                <li><a href="javascript:void(0)">Cardio</a></li>
                                <li><a href="javascript:void(0)">Weight Lifting</a></li>
                                <li><a href="javascript:void(0)">Zumba</a></li>
                                <li><a href="javascript:void(0)">Yoga</a></li>
                                <li><a href="javascript:void(0)">Pole Dancing</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer_link mt-45">
                            <h4 class="footer_title">Quick Link</h4>
                            <ul class="link">
                                <li><a href="#home">Home</a></li>
                                <li><a href="#courses">Courses</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="#team">Team</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="#schedules">Schedules</a></li>
                                <li><a href="#pricing">Pricing</a></li>
                                <li><a href="#trainee">Trainee</a></li>
                                <li><a href="#contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer_social mt-45">
                            <h4 class="footer_title">Follow Us On</h4>
                            <ul class="social">
                                <li><a href="https://www.facebook.com/LIMITLESSROCKSTARS"><i
                                            class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram-original"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer_info mt-45">
                            <h4 class="footer_title">Contact</h4>
                            <ul class="info">
                                <li><i class="fa fa-envelope"
                                        aria-hidden="true">&nbsp;limitlessfitnessstudioph@gmail.com
                                    </i>
                                </li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;0969-091-8489</li>
                                <li><i class="fa fa-map-marker" aria-hidden="true">&nbsp;Meralco Village, #6 Network
                                        Ave,
                                        Lias, Marilao, 3019 Bulacan
                                    </i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>





    <script src="{{asset('assets/js/email-decode.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets/js/modernizr-3.7.1.min.js')}}"></script>

    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.4.5.2.min.js')}}"></script>

    <script src="{{asset('assets/js/slick.min.js')}}"></script>

    <script src="{{asset('assets/js/ajax-contact.js')}}"></script>

    <script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/js/waypoints.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/js/scrolling-nav.js')}}"></script>

    <script src="{{asset('assets/js/main.js')}}"></script>
    <!-- <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/vedd3670a3b1c4e178fdfb0cc912d969e1713874337387"
        data-cf-beacon="{"
        rayid":"88768c664fe1775a","r":1,"version":"2024.4.1","token":"9a6015d415bb4773a0bff22543062d3b"}"=""
        crossorigin="anonymous">
    </script> -->


</body>

</html>