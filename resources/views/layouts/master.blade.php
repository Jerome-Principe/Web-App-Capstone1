<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <!-- Tailwind CSS -->
    @if($viteManifestExists)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Production fallback - use CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!-- Custom Notification Styles -->
    <style>
        .notification-unread {
            background-color: rgba(0, 123, 255, 0.05);
            border-left: 3px solid #007bff;
        }

        .notification-read {
            background-color: transparent;
            border-left: 3px solid transparent;
        }

        .notification-unread:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .notification-read:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .notification-unread .title {
            font-weight: 600;
        }

        .notification-read .title {
            font-weight: normal;
        }

        /* Modern Dropdown Styling */
        .dropdown-menu {
            @apply bg-white border border-gray-200 rounded-lg shadow-lg mt-2 py-2 min-w-[280px];
            border: none;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dropdown-lg {
            @apply min-w-[320px];
        }

        .dropdown-md {
            @apply min-w-[280px];
        }

        .dropdown-item {
            @apply px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150;
        }

        .list-media {
            @apply space-y-1;
        }

        .list-item {
            @apply px-4 py-3 hover:bg-gray-50 transition-colors duration-150;
        }

        .list-item a {
            @apply flex items-center space-x-3 text-decoration-none;
        }

        .media-img {
            @apply flex-shrink-0;
        }

        .media-img img {
            @apply w-10 h-10 rounded-full object-cover;
        }

        .info {
            @apply flex-1 min-w-0;
        }

        .info .title {
            @apply block text-sm font-medium text-gray-900 truncate;
        }

        .info .sub-title {
            @apply block text-sm text-gray-500 truncate;
        }

        .check-all {
            @apply border-t border-gray-100 pt-2 mt-2;
        }

        .check-all a {
            @apply text-sm text-blue-600 hover:text-blue-800 transition-colors duration-150;
        }

        /* Full Height Layout Structure */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .app {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar - Full Height */
        .side-nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            z-index: 1000;
            overflow-y: auto;
        }

        /* Main Content Area */
        .main-content-wrapper {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header - Same level as dashboard */
        .header-container {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Content Area */
        .content-container {
            flex: 1;
            padding: 20px;
            background-color: #f9fafb;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 992px) {
            .side-nav {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .side-nav.show {
                transform: translateX(0);
            }

            .main-content-wrapper {
                margin-left: 0;
            }
        }

        @media only screen and (max-width: 767px) {
            .content-container {
                padding: 15px;
            }
        }
    </style>

</head>

<body>
    <div class="app">
        <!-- Side Nav START -->
        @include('components.admin-sidebar')
        <!-- Side Nav END -->

        <!-- Main Content Wrapper START -->
        <div class="main-content-wrapper">
            <!-- Header START -->
            <div class="header-container">
                <div class="flex items-center justify-between px-6 py-4 h-16">
                    <!-- Left spacer -->
                    <div class="flex-1"></div>

                    <!-- Navigation Icons with Search -->
                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" placeholder="Type to search..."
                                class="w-64 pl-4 pr-10 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="lni-search text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        <!-- Messages -->
                        <div class="relative">
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-medium">3</span>
                            <a href="#"
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                data-toggle="dropdown">
                                <i class="lni-envelope text-gray-600 text-lg"></i>
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
                        </div>

                        <!-- Notifications -->
                        <div class="relative">
                            <span
                                class="absolute -top-1 -right-1 bg-green-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-medium"
                                id="notification-counter">0</span>
                            <a href="#"
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                data-toggle="dropdown">
                                <i class="lni-alarm text-gray-600 text-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-lg">
                                <li>
                                    <h5 class="n-title text-center">
                                        <i class="lni-alarm"></i>
                                        <span>Notifications</span>
                                        <small class="text-muted" id="notification-total">(0)</small>
                                    </h5>
                                </li>
                                <li>
                                    <ul class="list-media" id="notification-list">
                                        <li class="list-item text-center">
                                            <span class="text-gray">Loading notifications...</span>
                                        </li>
                                    </ul>
                                </li>
                                <li class="check-all text-center">
                                    <span>
                                        <a href="#" class="text-gray" id="mark-all-read">Mark all as read</a>
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <!-- User Profile -->
                        <div class="relative">
                            <a href="#"
                                class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-200 hover:border-blue-500 transition-colors duration-200"
                                data-toggle="dropdown">
                                <img src="{{ asset(auth()->user()->profile_picture ?? 'assets/admin-dashboard/img/avatar/avatar.jpg') }}"
                                    alt="Profile Picture" class="w-full h-full object-cover rounded-full">
                            </a>
                            <ul class="dropdown-menu dropdown-md">
                                <li>
                                    <ul class="list-media">
                                        <li class="list-item avatar-info">
                                            <div class="media-img">
                                                <img src="{{ asset(auth()->user()->profile_picture ?? 'assets/admin-dashboard/img/avatar/avatar.jpg') }}"
                                                    alt="Profile Picture" class="rounded-circle"
                                                    style="width: 50px; height: 50px;">
                                            </div>
                                            <div class="info">
                                                <span
                                                    class="title text-semibold">{{ auth()->user()->name ?? 'Jerome Principe' }}</span>
                                                <span class="sub-title">Admin</span>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('profile.edit') }}">
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header END -->

            <!-- Content Container START -->
            <div class="content-container">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- Content Container END -->

            <!-- Footer START -->
            <footer class="content-footer bg-white border-t border-gray-200 py-4">
                <div class="container-fluid">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <span>Copyright © 2018 <b class="text-dark">UIdeck</b>. All Right Reserved</span>
                        </div>
                        <div class="flex space-x-4">
                            <a href="" class="text-sm text-gray-600 hover:text-gray-800">Term &amp; Conditions</a>
                            <a href="" class="text-sm text-gray-600 hover:text-gray-800">Privacy &amp; Policy</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- Footer END -->
        </div>
        <!-- Main Content Wrapper END -->
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
    <script src="{{asset('assets/admin-dashboard/js/morris.min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/raphael-min.js')}}"></script>
    <script src="{{asset('assets/admin-dashboard/js/dashborad1.js')}}"></script>

    <!-- Notification System JavaScript -->
    <script>
        $(document).ready(function () {
            // Load notifications on page load
            loadNotifications();
            loadNotificationCount();

            // Refresh notifications every 30 seconds
            setInterval(function () {
                loadNotifications();
                loadNotificationCount();
            }, 30000);

            // Mark all as read functionality
            $('#mark-all-read').on('click', function (e) {
                e.preventDefault();
                markAllAsRead();
            });

            // Load notification count
            function loadNotificationCount() {
                $.ajax({
                    url: '{{ route("notifications.count") }}',
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            $('#notification-counter').text(response.count);

                            // Hide counter if no unread notifications
                            if (response.count === 0) {
                                $('#notification-counter').hide();
                            } else {
                                $('#notification-counter').show();
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading notification count:', error);
                    }
                });
            }

            // Load recent notifications
            function loadNotifications() {
                $.ajax({
                    url: '{{ route("notifications.recent") }}',
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            displayNotifications(response.data);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading notifications:', error);
                        $('#notification-list').html('<li class="list-item text-center"><span class="text-gray">Error loading notifications</span></li>');
                    }
                });
            }

            // Display notifications in the dropdown
            function displayNotifications(notifications) {
                const notificationList = $('#notification-list');

                // Update total count in header
                $('#notification-total').text(`(${notifications.length})`);

                if (notifications.length === 0) {
                    notificationList.html('<li class="list-item text-center"><span class="text-gray">No notifications</span></li>');
                    return;
                }

                let html = '';
                notifications.forEach(function (notification) {
                    const date = new Date(notification.date);
                    const timeAgo = getTimeAgo(date);
                    const isRead = notification.is_read;
                    const readClass = isRead ? 'notification-read' : 'notification-unread';
                    const iconClass = isRead ? 'lni-alarm' : 'lni-alarm';
                    const bgClass = isRead ? 'bg-secondary' : 'bg-primary';

                    html += `
                        <li class="list-item ${readClass}">
                            <a href="#" class="media-hover" data-notification-id="${notification.id}" data-is-read="${isRead}">
                                <div class="media-img">
                                    <div class="icon-avatar ${bgClass}">
                                        <i class="${iconClass}"></i>
                                    </div>
                                </div>
                                <div class="info">
                                    <span class="title ${isRead ? 'text-muted' : ''}">${notification.feature}</span>
                                    <span class="sub-title ${isRead ? 'text-muted' : ''}">${notification.description}</span>
                                    <small class="text-muted">${timeAgo}</small>
                                </div>
                            </a>
                        </li>
                    `;
                });

                notificationList.html(html);

                // Add click handler for individual notifications
                $('.media-hover[data-notification-id]').on('click', function (e) {
                    e.preventDefault();
                    const notificationId = $(this).data('notification-id');
                    const isRead = $(this).data('is-read');

                    if (!isRead) {
                        markAsRead(notificationId);
                    }
                });
            }

            // Mark single notification as read
            function markAsRead(notificationId) {
                $.ajax({
                    url: `/api/notifications/${notificationId}/mark-read`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            loadNotifications();
                            loadNotificationCount();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error marking notification as read:', error);
                    }
                });
            }

            // Mark all notifications as read
            function markAllAsRead() {
                $.ajax({
                    url: '{{ route("notifications.markAllAsRead") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            loadNotifications();
                            loadNotificationCount();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error marking all notifications as read:', error);
                    }
                });
            }

            // Helper function to get time ago
            function getTimeAgo(date) {
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                if (diffInSeconds < 60) {
                    return 'Just now';
                } else if (diffInSeconds < 3600) {
                    const minutes = Math.floor(diffInSeconds / 60);
                    return `${minutes} min ago`;
                } else if (diffInSeconds < 86400) {
                    const hours = Math.floor(diffInSeconds / 3600);
                    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    const days = Math.floor(diffInSeconds / 86400);
                    return `${days} day${days > 1 ? 's' : ''} ago`;
                }
            }
        });
    </script>

</body>

</html>