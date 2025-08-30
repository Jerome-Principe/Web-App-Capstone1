@extends('layouts.master')

@section('content')
    <div class="settings-container">
        <div class="settings-wrapper">
            <!-- Left Sidebar -->
            <div class="settings-sidebar">
                <div class="settings-logo">
                    <img src="{{ asset('assets/admin-dashboard/img/logo.png') }}" alt="FITDROID" class="logo-img">
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
                    <div class="header-logo">
                        <img src="{{ asset('assets/admin-dashboard/img/logo.png') }}" alt="FITDROID"
                            class="header-logo-img">
                        <h2>FITDROID</h2>
                        <p>Fitness • Gym • Workout</p>
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

        .settings-logo .logo-img {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
            border-radius: 50%;
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
        }

        .settings-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 40px;
            color: white;
            border-bottom: 1px solid #e9ecef;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-logo-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .header-logo h2 {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .header-logo p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .content-area {
            padding: 40px 60px 40px 40px;
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .settings-sidebar {
                left: 0;
                width: 280px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .settings-sidebar.show {
                transform: translateX(0);
            }

            .settings-content {
                margin-left: 0;
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
@endsection