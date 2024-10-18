<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Fitdroid - Admin and Dashboard Template</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin-dashboard/css/bootstrap.min.css')}}">
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin-dashboard/fonts/line-icons.css')}}">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{asset('assets/admin-dashboard/plugins/morris/morris.css')}}">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin-dashboard/css/main.css')}}">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin-dashboard/css/responsive.css')}}">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>
    <div class="app header-default side-nav-dark">
        <div class="layout">
            <!-- Header START -->
            <div class="header navbar">
                <div class="header-container">
                    <div class="nav-logo">
                        <a href="#">
                            <div class="logo-container">
                                <img src="{{ asset('assets/admin-dashboard/img/dumbell.png') }}" alt="Dumbell">
                                <img src="{{ asset('assets/admin-dashboard/img/FITDROID.png') }}" alt="FITDROID">
                            </div>
                        </a>
                    </div>

                    <ul class="nav-left">
                        <li>
                            <a class="sidenav-fold-toggler" href="javascript:void(0);">
                                <i class="lni-menu"></i>
                            </a>
                            <a class="sidenav-expand-toggler" href="javascript:void(0);">
                                <i class="lni-menu"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav-right">
                        <li class="search-box">
                            <input class="form-control" type="text" placeholder="Type to search...">
                            <i class="lni-search"></i>
                        </li>
                        <li class="massages dropdown dropdown-animated scale-left">
                            <span class="counter">3</span>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="lni-envelope"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-lg">
                                <li>
                                    <div class="dropdown-item align-self-center">
                                        <h5><span class="badge badge-primary badge-pro float-right">745</span>Messages
                                        </h5>
                                    </div>
                                </li>
                                <li>
                                    <ul class="list-media">
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <img src={{asset('assets/admin-dashboard/img/users/avatar-1.jpg')}}
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        Amanda Robertson
                                                    </span>
                                                    <span class="sub-title">Dummy text of the printing and typesetting
                                                        industry.</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <img src={{asset('assets/admin-dashboard/img/users/avatar-2.jpg')}}
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        Danny Donovan
                                                    </span>
                                                    <span class="sub-title">It is a long established fact that a reader
                                                        will</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <img src={{asset('assets/admin-dashboard/img/users/avatar-3.jpg')}}
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        Frank Handrics
                                                    </span>
                                                    <span class="sub-title">You have 87 unread messages</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="check-all text-center">
                                    <span>
                                        <a href="#" class="text-gray">View All</a>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        <li class="notifications dropdown dropdown-animated scale-left">
                            <span class="counter">2</span>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="lni-alarm"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-lg">
                                <li>
                                    <h5 class="n-title text-center">
                                        <i class="lni-alarm"></i>
                                        <span>Notifications</span>
                                    </h5>
                                </li>
                                <li>
                                    <ul class="list-media">
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <div class="icon-avatar bg-primary">
                                                        <i class="lni-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        5 new messages
                                                    </span>
                                                    <span class="sub-title">4 min ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <div class="icon-avatar bg-success">
                                                        <i class="lni-comments-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        4 new comments
                                                    </span>
                                                    <span class="sub-title">12 min ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <div class="icon-avatar bg-info">
                                                        <i class="lni-users"></i>
                                                    </div>
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        3 Friend Requests
                                                    </span>
                                                    <span class="sub-title">a day ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="list-item">
                                            <a href="#" class="media-hover">
                                                <div class="media-img">
                                                    <div class="icon-avatar bg-purple">
                                                        <i class="lni-comments-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        2 new messages
                                                    </span>
                                                    <span class="sub-title">12 min ago</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="check-all text-center">
                                    <span>
                                        <a href="#" class="text-gray">Check all notifications</a>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        <li class="user-profile dropdown dropdown-animated scale-left">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img class="profile-img img-fluid"
                                    src={{asset('assets/admin-dashboard/img/avatar/avatar.jpg')}} alt="">
                            </a>
                            <ul class="dropdown-menu dropdown-md">
                                <li>
                                    <ul class="list-media">
                                        <li class="list-item avatar-info">
                                            <div class="media-img">
                                                <img src={{asset('assets/admin-dashboard/img/avatar/avatar.jpg')}}
                                                    alt="">
                                            </div>
                                            <div class="info">
                                                <span class="title text-semibold">Jerome Principe</span>
                                                <span class="sub-title">Admin</span>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="/profile">
                                        <i class="lni-user"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="lni-envelope"></i>
                                        <span>Inbox</span>
                                        <span class="badge badge-pill badge-primary badge-pro pull-right">2</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="lni-cog"></i>
                                        <span>Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <i class="lni-lock"></i>
                                            <span>Logout</span>
                                        </a>

                                    </form>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Header END -->

            <!-- Side Nav START -->@include('components.admin-sidebar')<!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">
                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="container-fluid">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!-- Content Wrapper END -->

            </div>
            <!-- Page Container END -->
        </div>
    </div>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/admin-dashboard/js/jquery-min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/jquery.app.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/main.js')}}"></script>

    <!--Morris Chart-->
    <script src="{{asset('assets/admin-dashboard/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/plugins/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/dashborad1.js')}}"></script>

</body>

</html>