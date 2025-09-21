<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <title>@yield('title', 'Fitdroid - Admin and Dashboard Template')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin-dashboard/css/bootstrap.min.css')}}">
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin-dashboard/fonts/line-icons.css')}}">

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
            top: 64px;
            left: 0;
            height: calc(100vh - 64px);
            width: 280px;
            z-index: 1000;
            overflow: visible;
        }

        /* Main Content Area */
        .main-content-wrapper {
            flex: 1;
            margin-left: 280px;
            margin-top: 64px;
            min-height: calc(100vh - 64px);
            display: flex;
            flex-direction: column;
        }

        /* Header - Full width across sidebar and content */
        .header-container {
            background: linear-gradient(to right, #5C4B9E 0%, #9B7EDD 100%);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(92, 75, 158, 0.15);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            width: 100vw;
            min-height: 64px;
        }

        /* Header Icons and Elements */
        .header-container .lni-envelope,
        .header-container .lni-alarm,
        .header-container .lni-search {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .header-container a:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .header-container input[type="text"] {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header-container input[type="text"]:focus {
            background: white;
            ring-color: rgba(255, 255, 255, 0.5);
        }

        /* Content Area */
        .content-container {
            flex: 1;
            padding: 20px;
            background-color: #f9fafb;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            cursor: pointer;
            z-index: 1001;
        }

        /* Backdrop for mobile sidebar */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 992px) {
            .side-nav {
                top: 64px;
                height: calc(100vh - 64px);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
            }

            .side-nav.show {
                transform: translateX(0);
            }

            .main-content-wrapper {
                margin-left: 0;
                margin-top: 64px;
            }

            /* Adjust header padding on mobile */
            .header-container>div {
                padding-left: 24px !important;
            }

            /* Hide search bar on smaller screens to make room for hamburger */
            .header-container .relative {
                display: none;
            }
        }

        @media only screen and (max-width: 576px) {

            /* Show search bar again on very small screens, but smaller */
            .header-container .relative {
                display: block;
            }

            .header-container .relative input {
                width: 180px;
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
        <!-- Sidebar Backdrop -->
        <div id="sidebar-backdrop" class="sidebar-backdrop"></div>

        <!-- Side Nav START -->
        @include('components.admin-sidebar')
        <!-- Side Nav END -->

        <!-- Main Content Wrapper START -->
        <div class="main-content-wrapper">
            <!-- Header START -->
            <div class="header-container">
                <div class="flex items-center justify-between py-4 h-16"
                    style="padding-left: 296px; padding-right: 24px;">
                    <!-- Mobile Hamburger Menu Button -->
                    <div class="flex items-center">
                        <button id="mobile-menu-toggle"
                            class="mobile-menu-btn flex items-center justify-center w-10 h-10 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors duration-200 lg:hidden">
                            <i class="lni-menu text-white text-xl"></i>
                        </button>
                    </div>

                    <!-- Left spacer -->
                    <div class="flex-1"></div>

                    <!-- Navigation Icons with Search -->
                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="relative" id="search-container">
                            <input type="text" id="header-search" placeholder="Type to search..."
                                class="w-64 pl-4 pr-10 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="lni-search text-gray-400 text-sm"></i>
                            </div>

                            <!-- Search Results Dropdown -->
                            <div id="search-results"
                                class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden max-h-96 overflow-y-auto">
                                <div id="search-loading" class="p-4 text-center text-gray-500 hidden">
                                    <i class="fa fa-spinner fa-spin mr-2"></i>Searching...
                                </div>
                                <div id="search-suggestions" class="py-2">
                                    <!-- Search suggestions will be populated here -->
                                </div>
                                <div id="search-no-results" class="p-4 text-center text-gray-500 hidden">
                                    <i class="fa fa-search mr-2"></i>No results found
                                </div>
                            </div>
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
                                        <i class="fa fa-user"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.index') }}">
                                        <i class="fa fa-cog"></i>
                                        <span>Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <i class="fa fa-sign-out"></i>
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

    <!-- Notification System JavaScript -->
    <script>
        $(document).ready(function () {
            // Load notifications on page load
            loadNotifications();
            loadNotificationCount();

            // TEMPORARILY COMMENTED OUT TO STOP DATABASE POLLING
            /*
            setInterval(function () {
                loadNotifications();
                loadNotificationCount();
            }, 300000); // 5 minutes = 300,000ms (was 30,000ms = 30 seconds)
            */

            // Mark all as read functionality
            $('#mark-all-read').on('click', function (e) {
                e.preventDefault();
                markAllAsRead();
            });

            // Load notification count - gets the number of unread notifications
            function loadNotificationCount() {
                // Make AJAX call to get unread notification count from server
                $.ajax({
                    url: '{{ route("notifications.count") }}', // Calls /api/notifications/count endpoint
                    method: 'GET',
                    success: function (response) {
                        // If server responds successfully
                        if (response.success) {
                            // Update the notification counter badge with the count number
                            $('#notification-counter').text(response.count);

                            // Hide the red counter badge if there are no unread notifications
                            if (response.count === 0) {
                                $('#notification-counter').hide();
                            } else {
                                // Show the red counter badge if there are unread notifications
                                $('#notification-counter').show();
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        // Log any errors to browser console for debugging
                        console.error('Error loading notification count:', error);
                    }
                });
            }

            // Load recent notifications - gets the latest 10 notifications to display in dropdown
            function loadNotifications() {
                // Make AJAX call to get recent notifications from server
                $.ajax({
                    url: '{{ route("notifications.recent") }}', // Calls /api/notifications/recent endpoint
                    method: 'GET',
                    success: function (response) {
                        // If server responds successfully with notification data
                        if (response.success) {
                            // Call function to display the notifications in the dropdown menu
                            displayNotifications(response.data);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Log error and show user-friendly error message in notification dropdown
                        console.error('Error loading notifications:', error);
                        $('#notification-list').html('<li class="list-item text-center"><span class="text-gray">Error loading notifications</span></li>');
                    }
                });
            }

            // Display notifications in the dropdown - formats and shows notification list
            function displayNotifications(notifications) {
                // Get the HTML element where notifications will be displayed
                const notificationList = $('#notification-list');

                // Update the total count shown in the notification dropdown header
                $('#notification-total').text(`(${notifications.length})`);

                // If there are no notifications, show "No notifications" message
                if (notifications.length === 0) {
                    notificationList.html('<li class="list-item text-center"><span class="text-gray">No notifications</span></li>');
                    return; // Exit function early
                }

                // Build HTML string to display each notification
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

            // Mark single notification as read - updates notification status in database
            function markAsRead(notificationId) {
                // Send POST request to mark specific notification as read
                $.ajax({
                    url: `/api/notifications/${notificationId}/mark-read`, // Dynamic URL with notification ID
                    method: 'POST',
                    headers: {
                        // Include CSRF token for Laravel security
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // If notification was successfully marked as read
                        if (response.success) {
                            // Refresh both notification list and counter to reflect changes
                            loadNotifications();
                            loadNotificationCount();
                        }
                    },
                    error: function (xhr, status, error) {
                        // Log any errors for debugging
                        console.error('Error marking notification as read:', error);
                    }
                });
            }

            // Mark all notifications as read - bulk update all unread notifications
            function markAllAsRead() {
                // Send POST request to mark ALL unread notifications as read at once
                $.ajax({
                    url: '{{ route("notifications.markAllAsRead") }}', // Calls /api/notifications/mark-all-read endpoint
                    method: 'POST',
                    headers: {
                        // Include CSRF token for Laravel security
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // If all notifications were successfully marked as read
                        if (response.success) {
                            // Refresh both notification list and counter to show all as read
                            loadNotifications();
                            loadNotificationCount();
                        }
                    },
                    error: function (xhr, status, error) {
                        // Log any errors for debugging
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

        // Mobile Sidebar Toggle Functionality
        $(document).ready(function () {
            const mobileMenuToggle = $('#mobile-menu-toggle');
            const sidebar = $('.side-nav');
            const backdrop = $('#sidebar-backdrop');

            // Toggle sidebar when hamburger button is clicked
            mobileMenuToggle.on('click', function () {
                sidebar.toggleClass('show');
                backdrop.toggleClass('show');
            });

            // Close sidebar when backdrop is clicked
            backdrop.on('click', function () {
                sidebar.removeClass('show');
                backdrop.removeClass('show');
            });

            // Close sidebar when a menu item is clicked (for better mobile UX)
            $('.side-nav a').on('click', function () {
                // Only close on mobile screens
                if ($(window).width() <= 992) {
                    sidebar.removeClass('show');
                    backdrop.removeClass('show');
                }
            });

            // Handle window resize - hide sidebar if screen becomes larger
            $(window).on('resize', function () {
                if ($(window).width() > 992) {
                    sidebar.removeClass('show');
                    backdrop.removeClass('show');
                }
            });
        });

        // Header Search Functionality
        $(document).ready(function () {
            const searchInput = $('#header-search');
            const searchResults = $('#search-results');
            const searchSuggestions = $('#search-suggestions');
            const searchLoading = $('#search-loading');
            const searchNoResults = $('#search-no-results');
            const searchContainer = $('#search-container');

            let searchTimeout;
            let currentSearchIndex = -1;
            let searchItems = [];

            // Define searchable menu items
            const menuItems = [
                { title: 'Dashboard', url: '/dashboard', icon: 'fa-tachometer', category: 'Main' },
                { title: 'View Admin', url: '/admin-users', icon: 'fa-user', category: 'Admin' },
                { title: 'Create Announcement', url: '/announcements', icon: 'fa-bullhorn', category: 'Announcement' },
                { title: 'View Appointment List', url: '/appointments', icon: 'fa-calendar', category: 'Appointment' },
                { title: 'Pending Appointment', url: '/appointments/appointment-pending-list', icon: 'fa-calendar', category: 'Appointment' },
                { title: 'Cancelled Appointment', url: '/cancelled', icon: 'fa-calendar', category: 'Appointment' },
                { title: 'View Attendance', url: '/rfid', icon: 'fa-clock-o', category: 'Attendance' },
                { title: 'Attendance Record List', url: '/attendance-records', icon: 'fa-clock-o', category: 'Attendance' },
                { title: 'Attendance Register List', url: '/register-rfid', icon: 'fa-clock-o', category: 'Attendance' },
                { title: 'View Competition', url: '/competitions', icon: 'fa-trophy', category: 'Competition' },
                { title: 'View Expenses', url: '/expenses', icon: 'fa-money', category: 'Expenses' },
                { title: 'View Feedback', url: '/feedback', icon: 'fa-comments-o', category: 'Feedback' },
                { title: 'View Mobile Feedback', url: '/mobile-feedback', icon: 'fa-comments-o', category: 'Feedback' },
                { title: 'View Goal', url: '/goals', icon: 'fa-balance-scale', category: 'Goal' },
                { title: 'Sale Items', url: '/sales', icon: 'fa-folder-open', category: 'Inventory' },
                { title: 'Stock Items', url: '/stock-items', icon: 'fa-folder-open', category: 'Inventory' },
                { title: 'Add Equipment', url: '/equipmentsAdd', icon: 'fa-folder-open', category: 'Inventory' },
                { title: 'Add Machine', url: '/machines', icon: 'fa-folder-open', category: 'Inventory' },
                { title: 'Defect Equipment', url: '/equipments-defect', icon: 'fa-folder-open', category: 'Inventory' },
                { title: 'Defect Machine', url: '/machine-defects', icon: 'fa-folder-open', category: 'Inventory' },
                { title: 'Exercise Default', url: '/exercise', icon: 'fa-list', category: 'Resources' },
                { title: 'Exercise Custom', url: '/exercise-custom', icon: 'fa-list', category: 'Resources' },
                { title: 'Meal Plan Default', url: '/meal-plan', icon: 'fa-list', category: 'Resources' },
                { title: 'Meal Plan Custom', url: '/meal-plan-custom', icon: 'fa-list', category: 'Resources' },
                { title: 'Workout Default', url: '/workout-programs', icon: 'fa-list', category: 'Resources' },
                { title: 'Workout Custom', url: '/workout-program-custom', icon: 'fa-list', category: 'Resources' },
                { title: 'View Membership', url: '/membership-pendings/list', icon: 'fa-user-plus', category: 'Membership' },
                { title: 'Pending Membership', url: '/membership-pendings', icon: 'fa-user-plus', category: 'Membership' },
                { title: 'Membership Request', url: '/membership-request-list', icon: 'fa-user-plus', category: 'Membership' },
                { title: 'Emergency / Medical', url: '/membership-emergency-medical', icon: 'fa-user-plus', category: 'Membership' },
                { title: 'Payment', url: '/membership-payment-list', icon: 'fa-user-plus', category: 'Membership' },
                { title: 'Renewal Membership', url: '/membership-renewal', icon: 'fa-user-plus', category: 'Membership' },
                { title: 'View Instructor', url: '/instructors', icon: 'fa-users', category: 'Our Team' },
                { title: 'View Walkin Client', url: '/walkin/clients', icon: 'fa-user', category: 'Walkin Client' }
            ];

            // Search function
            function performSearch(query) {
                if (query.length < 2) {
                    hideSearchResults();
                    return;
                }

                showSearchLoading();

                // Simulate search delay for better UX
                setTimeout(() => {
                    const results = menuItems.filter(item =>
                        item.title.toLowerCase().includes(query.toLowerCase()) ||
                        item.category.toLowerCase().includes(query.toLowerCase())
                    );

                    displaySearchResults(results);
                }, 200);
            }

            // Display search results
            function displaySearchResults(results) {
                hideSearchLoading();
                searchItems = results;
                currentSearchIndex = -1;

                if (results.length === 0) {
                    showNoResults();
                    return;
                }

                let html = '';
                results.forEach((item, index) => {
                    html += `
                        <div class="search-item px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0" 
                             data-index="${index}" data-url="${item.url}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                    <i class="fa ${item.icon} text-gray-400 text-sm"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="text-sm font-medium text-gray-900">${item.title}</div>
                                    <div class="text-xs text-gray-500">${item.category}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                searchSuggestions.html(html);
                showSearchResults();
            }

            // Show/hide search results
            function showSearchResults() {
                searchResults.removeClass('hidden');
                searchNoResults.addClass('hidden');
            }

            function hideSearchResults() {
                searchResults.addClass('hidden');
            }

            function showSearchLoading() {
                searchLoading.removeClass('hidden');
                searchSuggestions.addClass('hidden');
                searchNoResults.addClass('hidden');
            }

            function hideSearchLoading() {
                searchLoading.addClass('hidden');
                searchSuggestions.removeClass('hidden');
            }

            function showNoResults() {
                searchNoResults.removeClass('hidden');
                searchSuggestions.addClass('hidden');
                showSearchResults();
            }

            // Highlight search item
            function highlightSearchItem(index) {
                $('.search-item').removeClass('bg-blue-50 border-l-4 border-blue-500');
                if (index >= 0 && index < searchItems.length) {
                    $(`.search-item[data-index="${index}"]`).addClass('bg-blue-50 border-l-4 border-blue-500');
                }
            }

            // Navigate to selected item
            function navigateToItem(index) {
                if (index >= 0 && index < searchItems.length) {
                    const item = searchItems[index];
                    window.location.href = item.url;
                }
            }

            // Event handlers
            searchInput.on('input', function () {
                const query = $(this).val();
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => performSearch(query), 300);
            });

            searchInput.on('focus', function () {
                if ($(this).val().length >= 2) {
                    showSearchResults();
                }
            });

            searchInput.on('keydown', function (e) {
                if (!searchResults.hasClass('hidden')) {
                    switch (e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            currentSearchIndex = Math.min(currentSearchIndex + 1, searchItems.length - 1);
                            highlightSearchItem(currentSearchIndex);
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            currentSearchIndex = Math.max(currentSearchIndex - 1, -1);
                            highlightSearchItem(currentSearchIndex);
                            break;
                        case 'Enter':
                            e.preventDefault();
                            if (currentSearchIndex >= 0) {
                                navigateToItem(currentSearchIndex);
                            }
                            break;
                        case 'Escape':
                            hideSearchResults();
                            searchInput.blur();
                            break;
                    }
                }
            });

            // Click on search item
            $(document).on('click', '.search-item', function () {
                const url = $(this).data('url');
                window.location.href = url;
            });

            // Click outside to close search results
            $(document).on('click', function (e) {
                if (!searchContainer.is(e.target) && searchContainer.has(e.target).length === 0) {
                    hideSearchResults();
                }
            });
        });
    </script>

</body>

</html>