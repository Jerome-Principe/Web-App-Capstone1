<div class="side-nav expand-lg bg-gradient-to-b from-gray-900 to-gray-800 text-white"
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; overflow: hidden; min-width: 280px; width: 280px; border: none; box-shadow: none; border-right: none;">
    <div class="side-nav-inner px-4 pb-4 h-full overflow-y-auto"
        style="scrollbar-width: none; -ms-overflow-style: none; padding-top: 0;">
        <style>
            .side-nav-inner::-webkit-scrollbar {
                display: none;
            }

            .side-nav-inner::-webkit-scrollbar-track {
                display: none;
            }

            .side-nav-inner::-webkit-scrollbar-thumb {
                display: none;
            }

            .side-nav-inner::-webkit-scrollbar-corner {
                display: none;
            }

            .side-nav {
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
            }

            .side-nav::-webkit-scrollbar {
                display: none !important;
            }

            /* Hide scrollbar for the entire sidebar */
            .side-nav::-webkit-scrollbar,
            .side-nav-inner::-webkit-scrollbar {
                width: 0 !important;
                display: none !important;
            }

            /* Hide scrollbar for Firefox */
            .side-nav,
            .side-nav-inner {
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
            }

            /* Additional scrollbar hiding for all browsers */
            .side-nav *::-webkit-scrollbar {
                width: 0 !important;
                display: none !important;
            }

            /* Remove the white border line from sidebar */
            .side-nav .side-nav-inner .side-nav-menu {
                border-right: none !important;
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
            <li class="nav-item dropdown open">
                <a href="#"
                    class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-blue-600 hover:to-blue-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-tachometer text-blue-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Dashboard</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li class="active">
                        <a href="/dashboard"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Dashboard</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-purple-600 hover:to-purple-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-user text-purple-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Admin</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/admin-users"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Admin</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-orange-600 hover:to-orange-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-bullhorn text-orange-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Announcement</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/announcements"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm"
                            style="white-space: normal; word-wrap: break-word;">Create
                            Announcement</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-green-600 hover:to-green-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-calendar text-green-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Appointment</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/appointments"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm"
                            style="white-space: normal; word-wrap: break-word;">View
                            Appointment List</a>
                    </li>
                    <li>
                        <a href="/appointments/appointment-pending-list"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm"
                            style="white-space: normal; word-wrap: break-word;">Pending
                            Appointment</a>
                    </li>
                    <li>
                        <a href="/cancelled"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm"
                            style="white-space: normal; word-wrap: break-word;">Cancelled
                            Appointment</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-teal-600 hover:to-teal-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-clock-o text-teal-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Attendance</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/rfid"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Attendance</a>
                    </li>
                    <li>
                        <a href="/attendance-records"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Attendance
                            Record List</a>
                    </li>
                    <li>
                        <a href="/register-rfid"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Attendance
                            Register List</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-yellow-600 hover:to-yellow-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-trophy text-yellow-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Competition</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/competitions"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Competition</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-pink-600 hover:to-pink-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-money text-pink-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Expenses</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/expenses"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Expenses</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-indigo-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-comments-o text-indigo-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Feedback</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/feedback"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Feedback</a>
                    </li>
                    <li>
                        <a href="/mobile-feedback"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Mobile Feedback</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-emerald-600 hover:to-emerald-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-balance-scale text-emerald-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Goal</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/goals"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Goal</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-cyan-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-folder-open text-cyan-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Inventory</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/sales"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Sale
                            Items</a>
                    </li>
                    <li>
                        <a href="/stock-items"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Stock
                            Items</a>
                    </li>
                    <li>
                        <a href="/equipmentsAdd"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Add
                            Equipment</a>
                    </li>
                    <li>
                        <a href="/machines"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Add
                            Machine</a>
                    </li>
                    <li>
                        <a href="/equipments-defect"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Defect
                            Equipment</a>
                    </li>
                    <li>
                        <a href="/machine-defects"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Defect
                            Machine</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-violet-600 hover:to-violet-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-list text-violet-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Resources</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/exercise"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Exercise
                            Default</a>
                    </li>
                    <li>
                        <a href="/exercise-custom"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Exercise
                            Custom</a>
                    </li>
                    <li>
                        <a href="/meal-plan"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Meal
                            Plan Default</a>
                    </li>
                    <li>
                        <a href="/meal-plan-custom"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Meal
                            Plan Custom</a>
                    </li>
                    <li>
                        <a href="/workout-programs"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Workout
                            Default</a>
                    </li>
                    <li>
                        <a href="/workout-program-custom"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Workout
                            Custom</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-rose-600 hover:to-rose-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-user-plus text-rose-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Membership</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/membership-pendings/list"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Membership</a>
                    </li>
                    <li>
                        <a href="/membership-pendings"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Pending
                            Membership</a>
                    </li>
                    <li>
                        <a href="/membership-request-list"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Membership
                            Request</a>
                    </li>
                    <li>
                        <a href="/membership-emergency-medical"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Emergency
                            / Medical</a>
                    </li>
                    <li>
                        <a href="/membership-payment-list"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Payment</a>
                    </li>
                    <li>
                        <a href="/membership-renewal"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">Renewal
                            Membership</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-sky-600 hover:to-sky-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-users text-sky-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Our Team</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/instructors"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Instructor</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle flex items-center px-3 py-2.5 text-gray-200 hover:bg-gradient-to-r hover:from-lime-600 hover:to-lime-700 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md"
                    href="#">
                    <span class="icon-holder w-5 h-5 mr-3 flex items-center justify-center">
                        <i class="fa fa-user text-lime-400 group-hover:text-white transition-colors"></i>
                    </span>
                    <span class="title font-semibold text-sm"
                        style="font-family: inherit; text-rendering: optimizeLegibility;">Walkin Client</span>
                    <span class="arrow ml-auto transform group-hover:rotate-90 transition-transform duration-300">
                        <i class="lni-chevron-right text-gray-400 group-hover:text-white text-xs"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down ml-4 mt-1 space-y-1 pl-3">
                    <li>
                        <a href="/walkin/clients"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all duration-200 font-medium text-sm">View
                            Walkin Client</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>