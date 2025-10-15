<div class="side-nav expand-lg bg-gradient-to-b from-gray-900 to-gray-800 text-white"
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; overflow-y: auto; overflow-x: hidden; min-width: 280px; width: 280px; height: 100vh; border: none; box-shadow: none; border-right: none;">
    <div class="side-nav-inner px-4 pb-4" style="padding-top: 0; min-height: 100%;">
        <style>
            /* Enable scrolling for the sidebar */
            .side-nav {
                overflow-y: auto !important;
                overflow-x: hidden !important;
                scroll-behavior: smooth !important;
            }

            .side-nav-inner {
                overflow-y: auto !important;
                overflow-x: hidden !important;
                max-height: 100vh !important;
                scroll-behavior: smooth !important;
            }

            /* Custom scrollbar styling */
            .side-nav::-webkit-scrollbar,
            .side-nav-inner::-webkit-scrollbar {
                width: 6px !important;
            }

            .side-nav::-webkit-scrollbar-track,
            .side-nav-inner::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1) !important;
                border-radius: 3px !important;
            }

            .side-nav::-webkit-scrollbar-thumb,
            .side-nav-inner::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3) !important;
                border-radius: 3px !important;
                transition: background 0.3s ease !important;
            }

            .side-nav::-webkit-scrollbar-thumb:hover,
            .side-nav-inner::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5) !important;
            }

            /* Firefox scrollbar styling */
            .side-nav,
            .side-nav-inner {
                scrollbar-width: thin !important;
                scrollbar-color: rgba(255, 255, 255, 0.3) rgba(255, 255, 255, 0.1) !important;
            }

            /* Remove the white border line from sidebar */
            .side-nav .side-nav-inner .side-nav-menu {
                border-right: none !important;
            }

            /* Custom active state styling with #e22a6f color */
            .side-nav .nav-item.dropdown.open .dropdown-toggle {
                background: linear-gradient(to right, #e22a6f, #e22a6f) !important;
                color: white !important;
            }

            .side-nav .nav-item.dropdown.open .dropdown-toggle .icon-holder i,
            .side-nav .nav-item.dropdown.open .dropdown-toggle .arrow i {
                color: white !important;
            }

            /* Active sub-menu items styling */
            .side-nav .dropdown-menu li.active a,
            .side-nav .dropdown-menu li a.bg-pink-600,
            .side-nav .dropdown-menu li a[class*="bg-pink-600"] {
                background-color: #e22a6f !important;
                color: white !important;
            }

            /* Ensure all active sub-menu items get the correct color */
            .side-nav .nav-item.dropdown .dropdown-menu li.active a {
                background-color: #e22a6f !important;
                color: white !important;
            }

            /* Override any conflicting styles for sub-menu active states */
            .side-nav .side-nav-menu .dropdown-menu li.active a {
                background-color: #e22a6f !important;
                color: white !important;
            }

            /* Additional specificity for sub-menu active states */
            .side-nav .side-nav-inner .side-nav-menu .nav-item .dropdown-menu li.active a {
                background-color: #e22a6f !important;
                color: white !important;
            }

            /* Force the color for any element with active class in sub-menus */
            .side-nav .dropdown-menu .active a {
                background-color: #e22a6f !important;
                color: white !important;
            }

            /* Debug: Make sure all active sub-menu items are visible */
            .side-nav .dropdown-menu li.active {
                background-color: #e22a6f !important;
            }

            .side-nav .dropdown-menu li.active a {
                background-color: #e22a6f !important;
                color: white !important;
                font-weight: bold !important;
            }

            /* Additional override for any conflicting styles */
            .side-nav .side-nav-menu li.dropdown ul.dropdown-menu li.active a {
                background-color: #e22a6f !important;
                color: white !important;
            }
        </style>
        <!-- Enhanced Brand Header -->
        <div class="side-nav-header mb-4 pb-3 pt-4 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/admin-dashboard/img/dumbbell-logo-blue.png') }}" alt="Dumbbell Logo"
                        class="w-10 h-10 object-contain">
                    <div>
                        <h1 class="text-lg font-bold text-white tracking-wide"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">FITDROID</h1>
                        <p class="text-xs text-gray-300 font-medium"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Limitless Fitness Studio
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Navigation Menu -->
        <ul class="side-nav-menu space-y-1">
            <li class="nav-item dropdown {{ request()->routeIs('dashboard') ? 'open' : '' }}">
                <a href="#"
                    class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-blue-600 hover:to-blue-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i
                            class="fa fa-tachometer {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-400 group-hover:text-white' }} transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Dashboard</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i
                            class="lni-chevron-right {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard"
                            class="block px-3 py-2 {{ request()->routeIs('dashboard') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                            Dashboard</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ request()->routeIs('admin-users*') ? 'open' : '' }}">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('admin-users*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-purple-600 hover:to-purple-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i
                            class="fa fa-user {{ request()->routeIs('admin-users*') ? 'text-white' : 'text-purple-400 group-hover:text-white' }} transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Admin</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i
                            class="lni-chevron-right {{ request()->routeIs('admin-users*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li class="{{ request()->routeIs('admin-users*') ? 'active' : '' }}">
                        <a href="/admin-users"
                            class="block px-3 py-2 {{ request()->routeIs('admin-users*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                            Admin</a>
                    </li>
                </ul>
            </li>

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Cashier')
                <li class="nav-item dropdown {{ request()->routeIs('announcements*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('announcements*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-orange-600 hover:to-orange-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-bullhorn {{ request()->routeIs('announcements*') ? 'text-white' : 'text-orange-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Announcement</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('announcements*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('announcements*') ? 'active' : '' }}">
                            <a href="/announcements"
                                class="block px-3 py-2 {{ request()->routeIs('announcements*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm"
                                style="white-space: normal; word-wrap: break-word;">Create
                                Announcement</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Instructor')
                <li
                    class="nav-item dropdown {{ request()->routeIs('appointments*') || request()->routeIs('appointment-pending-list') || request()->routeIs('cancelled*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('appointments*') || request()->routeIs('appointment-pending-list') || request()->routeIs('cancelled*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-green-600 hover:to-green-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-calendar {{ request()->routeIs('appointments*') || request()->routeIs('appointment-pending-list') || request()->routeIs('cancelled*') ? 'text-white' : 'text-green-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Appointment</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('appointments*') || request()->routeIs('appointment-pending-list') || request()->routeIs('cancelled*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                            <a href="/appointments"
                                class="block px-3 py-2 {{ request()->routeIs('appointments.index') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm"
                                style="white-space: normal; word-wrap: break-word;">View
                                Appointment List</a>
                        </li>
                        <li class="{{ request()->routeIs('appointment-pending-list') ? 'active' : '' }}">
                            <a href="/appointments/appointment-pending-list"
                                class="block px-3 py-2 {{ request()->routeIs('appointment-pending-list') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm"
                                style="white-space: normal; word-wrap: break-word;">Pending
                                Appointment</a>
                        </li>
                        <li class="{{ request()->routeIs('appointments.cancelled*') ? 'active' : '' }}">
                            <a href="/cancelled"
                                class="block px-3 py-2 {{ request()->routeIs('appointments.cancelled*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm"
                                style="white-space: normal; word-wrap: break-word;">Cancelled
                                Appointment</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Cashier')
                <li
                    class="nav-item dropdown {{ request()->routeIs('rfid*') || request()->routeIs('attendance-records*') || request()->routeIs('register-rfid*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('rfid*') || request()->routeIs('attendance-records*') || request()->routeIs('register-rfid*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-teal-600 hover:to-teal-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-clock-o {{ request()->routeIs('rfid*') || request()->routeIs('attendance-records*') || request()->routeIs('register-rfid*') ? 'text-white' : 'text-teal-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Attendance</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('rfid*') || request()->routeIs('attendance-records*') || request()->routeIs('register-rfid*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('rfid*') ? 'active' : '' }}">
                            <a href="/rfid"
                                class="block px-3 py-2 {{ request()->routeIs('rfid*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                                Attendance</a>
                        </li>
                        <li class="{{ request()->routeIs('attendance-records*') ? 'active' : '' }}">
                            <a href="/attendance-records"
                                class="block px-3 py-2 {{ request()->routeIs('attendance-records*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Attendance
                                Record List</a>
                        </li>
                        <li class="{{ request()->routeIs('register-rfid*') ? 'active' : '' }}">
                            <a href="/register-rfid"
                                class="block px-3 py-2 {{ request()->routeIs('register-rfid*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Attendance
                                Register List</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Instructor')
                <li class="nav-item dropdown {{ request()->routeIs('competitions*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('competitions*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-yellow-600 hover:to-yellow-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-trophy {{ request()->routeIs('competitions*') ? 'text-white' : 'text-yellow-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Competition</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('competitions*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('competitions*') ? 'active' : '' }}">
                            <a href="/competitions"
                                class="block px-3 py-2 {{ request()->routeIs('competitions*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                                Competition</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Cashier')
                <li class="nav-item dropdown {{ request()->routeIs('expenses*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('expenses*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-pink-600 hover:to-pink-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-money {{ request()->routeIs('expenses*') ? 'text-white' : 'text-pink-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Expenses</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('expenses*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('expenses*') ? 'active' : '' }}">
                            <a href="/expenses"
                                class="block px-3 py-2 {{ request()->routeIs('expenses*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                                Expenses</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li
                class="nav-item dropdown {{ request()->routeIs('feedback*') || request()->routeIs('mobile-feedback*') ? 'open' : '' }}">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('feedback*') || request()->routeIs('mobile-feedback*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-indigo-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i
                            class="fa fa-comments-o {{ request()->routeIs('feedback*') || request()->routeIs('mobile-feedback*') ? 'text-white' : 'text-indigo-400 group-hover:text-white' }} transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Feedback</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i
                            class="lni-chevron-right {{ request()->routeIs('feedback*') || request()->routeIs('mobile-feedback*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li class="{{ request()->routeIs('feedback*') ? 'active' : '' }}">
                        <a href="/feedback"
                            class="block px-3 py-2 {{ request()->routeIs('feedback*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                            Feedback</a>
                    </li>
                    <li class="{{ request()->routeIs('mobile-feedback*') ? 'active' : '' }}">
                        <a href="/mobile-feedback"
                            class="block px-3 py-2 {{ request()->routeIs('mobile-feedback*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                            Mobile Feedback</a>
                    </li>
                </ul>
            </li>

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Instructor')
                <li class="nav-item dropdown {{ request()->routeIs('goals*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('goals*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-emerald-600 hover:to-emerald-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-balance-scale {{ request()->routeIs('goals*') ? 'text-white' : 'text-emerald-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Goal</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('goals*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('goals*') ? 'active' : '' }}">
                            <a href="/goals"
                                class="block px-3 py-2 {{ request()->routeIs('goals*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                                Goal</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Cashier')
                <li
                    class="nav-item dropdown {{ request()->routeIs('sales*') || request()->routeIs('stock-items*') || request()->routeIs('equipmentsAdd*') || request()->routeIs('machines*') || request()->routeIs('equipments-defect*') || request()->routeIs('machine-defects*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('sales*') || request()->routeIs('stock-items*') || request()->routeIs('equipmentsAdd*') || request()->routeIs('machines*') || request()->routeIs('equipments-defect*') || request()->routeIs('machine-defects*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-cyan-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-folder-open {{ request()->routeIs('sales*') || request()->routeIs('stock-items*') || request()->routeIs('equipmentsAdd*') || request()->routeIs('machines*') || request()->routeIs('equipments-defect*') || request()->routeIs('machine-defects*') ? 'text-white' : 'text-cyan-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Inventory</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('sales*') || request()->routeIs('stock-items*') || request()->routeIs('equipmentsAdd*') || request()->routeIs('machines*') || request()->routeIs('equipments-defect*') || request()->routeIs('machine-defects*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('sales*') ? 'active' : '' }}">
                            <a href="/sales"
                                class="block px-3 py-2 {{ request()->routeIs('sales*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Sale
                                Items</a>
                        </li>
                        <li class="{{ request()->routeIs('stock-items*') ? 'active' : '' }}">
                            <a href="/stock-items"
                                class="block px-3 py-2 {{ request()->routeIs('stock-items*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Stock
                                Items</a>
                        </li>
                        <li class="{{ request()->routeIs('equipmentsAdd*') ? 'active' : '' }}">
                            <a href="/equipmentsAdd"
                                class="block px-3 py-2 {{ request()->routeIs('equipmentsAdd*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Add
                                Equipment</a>
                        </li>
                        <li class="{{ request()->routeIs('machines*') ? 'active' : '' }}">
                            <a href="/machines"
                                class="block px-3 py-2 {{ request()->routeIs('machines*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Add
                                Machine</a>
                        </li>
                        <li class="{{ request()->routeIs('equipments-defect*') ? 'active' : '' }}">
                            <a href="/equipments-defect"
                                class="block px-3 py-2 {{ request()->routeIs('equipments-defect*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Defect
                                Equipment</a>
                        </li>
                        <li class="{{ request()->routeIs('machine-defects*') ? 'active' : '' }}">
                            <a href="/machine-defects"
                                class="block px-3 py-2 {{ request()->routeIs('machine-defects*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Defect
                                Machine</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Instructor')
                <li
                    class="nav-item dropdown {{ request()->routeIs('exercise*') || request()->routeIs('meal-plan*') || request()->routeIs('workout-program*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('exercise*') || request()->routeIs('meal-plan*') || request()->routeIs('workout-program*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-violet-600 hover:to-violet-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-list {{ request()->routeIs('exercise*') || request()->routeIs('meal-plan*') || request()->routeIs('workout-program*') ? 'text-white' : 'text-violet-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Resources</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('exercise*') || request()->routeIs('meal-plan*') || request()->routeIs('workout-program*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('exercise.index') ? 'active' : '' }}">
                            <a href="/exercise"
                                class="block px-3 py-2 {{ request()->routeIs('exercise.index') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Exercise
                                Default</a>
                        </li>
                        <li class="{{ request()->routeIs('exercise-custom*') ? 'active' : '' }}">
                            <a href="/exercise-custom"
                                class="block px-3 py-2 {{ request()->routeIs('exercise-custom*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Exercise
                                Custom</a>
                        </li>
                        <li class="{{ request()->routeIs('meal-plan.index') ? 'active' : '' }}">
                            <a href="/meal-plan"
                                class="block px-3 py-2 {{ request()->routeIs('meal-plan.index') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Meal
                                Plan Default</a>
                        </li>
                        <li class="{{ request()->routeIs('meal-plan-custom*') ? 'active' : '' }}">
                            <a href="/meal-plan-custom"
                                class="block px-3 py-2 {{ request()->routeIs('meal-plan-custom*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Meal
                                Plan Custom</a>
                        </li>
                        <li class="{{ request()->routeIs('workout-programs.index') ? 'active' : '' }}">
                            <a href="/workout-programs"
                                class="block px-3 py-2 {{ request()->routeIs('workout-programs.index') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Workout
                                Default</a>
                        </li>
                        <li class="{{ request()->routeIs('workout-program-custom*') ? 'active' : '' }}">
                            <a href="/workout-program-custom"
                                class="block px-3 py-2 {{ request()->routeIs('workout-program-custom*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Workout
                                Custom</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li
                class="nav-item dropdown {{ request()->routeIs('membership-pendings*') || request()->routeIs('membership.list*') || request()->is('membership-request-list*') || request()->is('membership-emergency-medical*') || request()->is('membership-payment-list*') || request()->routeIs('membership-renewal*') ? 'open' : '' }}">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('membership-pendings*') || request()->routeIs('membership.list*') || request()->is('membership-request-list*') || request()->is('membership-emergency-medical*') || request()->is('membership-payment-list*') || request()->routeIs('membership-renewal*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-rose-600 hover:to-rose-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i
                            class="fa fa-user-plus {{ request()->routeIs('membership-pendings*') || request()->routeIs('membership.list*') || request()->is('membership-request-list*') || request()->is('membership-emergency-medical*') || request()->is('membership-payment-list*') || request()->routeIs('membership-renewal*') ? 'text-white' : 'text-rose-400 group-hover:text-white' }} transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Membership</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i
                            class="lni-chevron-right {{ request()->routeIs('membership-pendings*') || request()->routeIs('membership.list*') || request()->is('membership-request-list*') || request()->is('membership-emergency-medical*') || request()->is('membership-payment-list*') || request()->routeIs('membership-renewal*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li class="{{ request()->routeIs('membership.list') ? 'active' : '' }}">
                        <a href="/membership-pendings/list"
                            class="block px-3 py-2 {{ request()->routeIs('membership.list') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                            Membership</a>
                    </li>
                    <li class="{{ request()->routeIs('membership-pendings.index') ? 'active' : '' }}">
                        <a href="/membership-pendings"
                            class="block px-3 py-2 {{ request()->routeIs('membership-pendings.index') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Pending
                            Membership</a>
                    </li>
                    <li class="{{ request()->is('membership-request-list*') ? 'active' : '' }}">
                        <a href="/membership-request-list"
                            class="block px-3 py-2 {{ request()->is('membership-request-list*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Membership
                            Request</a>
                    </li>
                    <li class="{{ request()->is('membership-emergency-medical*') ? 'active' : '' }}">
                        <a href="/membership-emergency-medical"
                            class="block px-3 py-2 {{ request()->is('membership-emergency-medical*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Emergency
                            / Medical</a>
                    </li>
                    <li class="{{ request()->is('membership-payment-list*') ? 'active' : '' }}">
                        <a href="/membership-payment-list"
                            class="block px-3 py-2 {{ request()->is('membership-payment-list*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Payment</a>
                    </li>
                    <li class="{{ request()->routeIs('membership-renewal*') ? 'active' : '' }}">
                        <a href="/membership-renewal"
                            class="block px-3 py-2 {{ request()->routeIs('membership-renewal*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">Renewal
                            Membership</a>
                    </li>
                </ul>
            </li>

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Instructor')
                <li class="nav-item dropdown {{ request()->routeIs('instructors*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('instructors*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-sky-600 hover:to-sky-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-users {{ request()->routeIs('instructors*') ? 'text-white' : 'text-sky-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Our Team</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('instructors*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('instructors*') ? 'active' : '' }}">
                            <a href="/instructors"
                                class="block px-3 py-2 {{ request()->routeIs('instructors*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                                Instructor</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()?->role === 'Admin' || auth()->user()?->role === 'Cashier')
                <li class="nav-item dropdown {{ request()->routeIs('walkin*') ? 'open' : '' }}">
                    <a class="dropdown-toggle flex items-center px-3 py-2.5 {{ request()->routeIs('walkin*') ? 'text-white bg-gradient-to-r from-pink-600 to-pink-700' : 'text-gray-200 hover:bg-gradient-to-r hover:from-lime-600 hover:to-lime-700 hover:text-white' }} rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                        href="#">
                        <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                            <i
                                class="fa fa-user {{ request()->routeIs('walkin*') ? 'text-white' : 'text-lime-400 group-hover:text-white' }} transition-colors"></i>
                        </span>
                        <span class="title font-semibold text-sm"
                            style="font-family: inherit; text-rendering: optimizeLegibility;">Walkin Client</span>
                        <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                            <i
                                class="lni-chevron-right {{ request()->routeIs('walkin*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} text-xs"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                        <li class="{{ request()->routeIs('walkin*') ? 'active' : '' }}">
                            <a href="/walkin/clients"
                                class="block px-3 py-2 {{ request()->routeIs('walkin*') ? 'text-white bg-pink-600' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded transition-all duration-200 font-medium text-sm">View
                                Walkin Client</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>