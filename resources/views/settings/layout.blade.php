@extends('layouts.master')

@section('content')
    <div class="settings-container">
        <!-- Settings Backdrop -->
        <div id="settings-backdrop" class="settings-backdrop"></div>

        <div class="settings-wrapper">
            <!-- Left Sidebar -->
            <div class="settings-sidebar">
                <div class="settings-logo">
                    <h3>FITDROID</h3>
                    <p>Fitness • Gym • Workout</p>
                </div>

                <nav class="settings-nav">
                    <ul>
                        <li class="{{ request()->routeIs('settings.terms') ? 'active' : '' }}">
                            <a href="{{ route('settings.terms') }}">Term & Condition</a>
                        </li>
                        <li class="{{ request()->routeIs('settings.guidelines') ? 'active' : '' }}">
                            <a href="{{ route('settings.guidelines') }}">Guidelines</a>
                        </li>
                        <li class="{{ request()->routeIs('settings.privacy') ? 'active' : '' }}">
                            <a href="{{ route('settings.privacy') }}">Privacy Policy</a>
                        </li>
                        <li class="{{ request()->routeIs('settings.community') ? 'active' : '' }}">
                            <a href="{{ route('settings.community') }}">Community Standards</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="settings-content">
                <div class="settings-header">
                    <div class="header-content">
                        <!-- Mobile Menu Toggle for Settings Sidebar -->
                        <button id="settings-menu-toggle" class="settings-menu-btn">
                            <i class="fa fa-bars"></i>
                        </button>

                        <div class="header-logo">
                            <h2>FITDROID</h2>
                            <p>Fitness • Gym • Workout</p>
                        </div>
                    </div>
                </div>

                <div class="content-area">
                    <h1 class="page-title">@yield('page-title')</h1>

                    <div class="content-body">
                        @yield('settings-content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .settings-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            margin: -20px;
        }

        .settings-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Left Sidebar */
        .settings-sidebar {
            width: 300px;
            background: #2c3e50;
            color: white;
            padding: 0;
            position: fixed;
            height: 100vh;
            left: 280px;
            /* Account for the main sidebar */
            top: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .settings-logo {
            text-align: center;
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }



        .settings-logo h3 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 5px 0;
            color: #ff6b35;
        }

        .settings-logo p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .settings-nav {
            padding: 20px 0;
        }

        .settings-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .settings-nav li {
            margin: 0;
        }

        .settings-nav li a {
            display: block;
            padding: 15px 30px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 16px;
            font-weight: 400;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .settings-nav li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #ff6b35;
        }

        .settings-nav li.active a {
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff6b35;
            border-left-color: #ff6b35;
            font-weight: 500;
        }

        /* Main Content Area */
        .settings-content {
            flex: 1;
            margin-left: 300px;
            /* Width of sidebar */
            background: white;
            min-height: 100vh;
            width: calc(100vw - 580px);
            /* Full viewport width minus main sidebar (280px) and settings sidebar (300px) */
        }

        .settings-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 40px;
            color: white;
            border-bottom: 1px solid #e9ecef;
            position: relative;
            z-index: 1;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .settings-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .settings-menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 2;
        }



        .header-logo h2 {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            color: white;
            display: block;
            visibility: visible;
            opacity: 1;
        }

        .header-logo p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .content-area {
            padding: 40px;
            width: 100%;
            box-sizing: border-box;
        }

        .page-title {
            font-size: 32px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 30px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .content-body {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            width: 100%;
            max-width: none;
            box-sizing: border-box;
        }

        .content-body h2 {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin: 30px 0 15px 0;
        }

        .content-body h3 {
            font-size: 20px;
            font-weight: 600;
            color: #34495e;
            margin: 25px 0 12px 0;
        }

        .content-body p {
            margin: 0 0 15px 0;
        }

        .content-body ul,
        .content-body ol {
            margin: 0 0 15px 20px;
        }

        .content-body li {
            margin: 8px 0;
        }

        .content-body strong {
            font-weight: 600;
            color: #2c3e50;
        }

        .content-body em {
            color: #7f8c8d;
        }

        /* Settings Backdrop */
        .settings-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .settings-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .settings-sidebar {
                left: 0;
                width: 280px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 101;
            }

            .settings-sidebar.show {
                transform: translateX(0);
            }

            .settings-content {
                margin-left: 0;
                width: 100vw;
            }

            .settings-menu-btn {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .content-area {
                padding: 20px;
            }

            .settings-header {
                padding: 20px;
            }

            .page-title {
                font-size: 28px;
            }

            .header-logo h2 {
                font-size: 24px;
            }

            .content-body {
                width: 100%;
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            const settingsMenuToggle = $('#settings-menu-toggle');
            const settingsSidebar = $('.settings-sidebar');
            const settingsBackdrop = $('#settings-backdrop');

            // Toggle settings sidebar when button is clicked
            settingsMenuToggle.on('click', function () {
                settingsSidebar.toggleClass('show');
                settingsBackdrop.toggleClass('show');
            });

            // Close sidebar when backdrop is clicked
            settingsBackdrop.on('click', function () {
                settingsSidebar.removeClass('show');
                settingsBackdrop.removeClass('show');
            });

            // Close sidebar when a menu item is clicked (for better mobile UX)
            $('.settings-sidebar a').on('click', function () {
                // Only close on mobile screens
                if ($(window).width() <= 1200) {
                    settingsSidebar.removeClass('show');
                    settingsBackdrop.removeClass('show');
                }
            });

            // Handle window resize - hide sidebar if screen becomes larger
            $(window).on('resize', function () {
                if ($(window).width() > 1200) {
                    settingsSidebar.removeClass('show');
                    settingsBackdrop.removeClass('show');
                }
            });
        });
    </script>
@endsection