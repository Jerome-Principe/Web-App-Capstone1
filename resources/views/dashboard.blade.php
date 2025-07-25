@extends('layouts.master')

@section('content')
    @php
        // Set default values to prevent undefined variable errors
        $activeMembers = $activeMembers ?? 0;
        $walkinClients = $walkinClients ?? 0;
        $inventoryItems = $inventoryItems ?? 0;
        $todayAppointments = $todayAppointments ?? 0;
        $staffCount = $staffCount ?? 0;
        $todayAttendance = $todayAttendance ?? 0;
        $totalRevenue = $totalRevenue ?? 0;
        $monthlyRevenue = $monthlyRevenue ?? 0;
        $pendingAppointments = $pendingAppointments ?? 0;
        $recentActivities = $recentActivities ?? [];
        $monthlyStats = $monthlyStats ?? [
            'memberships' => ['current' => 0, 'previous' => 0],
            'appointments' => ['current' => 0, 'previous' => 0],
            'walkins' => ['current' => 0, 'previous' => 0],
            'revenue' => ['current' => 0, 'previous' => 0]
        ];
        $topMetrics = $topMetrics ?? [
            'membershipTypes' => ['gold' => 0, 'silver' => 0, 'bronze' => 0],
            'attendanceRate' => 0,
            'satisfactionScore' => 0,
            'equipmentUtilization' => 0
        ];
        $quickActions = $quickActions ?? [
            'pendingMemberships' => 0,
            'pendingAppointments' => 0,
            'lowStockItems' => 0,
            'todayBirthdays' => 0,
            'expiringMemberships' => 0,
            'unreadFeedback' => 0
        ];
    @endphp
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card bg-gradient-primary text-white p-4 rounded-lg shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2 text-white fw-bold">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h2>
                            <p class="mb-0 text-white-75 fs-5">Here's what's happening with your gym today.</p>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <div class="current-time">
                                <h4 class="mb-1 text-white fw-semibold">{{ now()->format('l, F j, Y') }}</h4>
                                <p class="mb-0 text-white-75 fs-6">{{ now()->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Active Members</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($activeMembers) }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-arrow-up text-success"></i>
                                    {{ $monthlyStats['memberships']['current'] - $monthlyStats['memberships']['previous'] }}
                                    this month
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Today's Walk-ins</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($walkinClients) }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-calendar text-info"></i> {{ $monthlyStats['walkins']['current'] }} this
                                    month
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-user-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Today's Appointments</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($todayAppointments) }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-clock text-warning"></i> {{ $pendingAppointments }} pending
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Revenue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₱{{ number_format($totalRevenue) }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-chart-line text-success"></i> ₱{{ number_format($monthlyRevenue) }} this
                                    month
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Metrics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Staff/Instructors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($staffCount) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Today's Attendance</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($todayAttendance) }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-percentage text-info"></i> {{ $topMetrics['attendanceRate'] }}% rate
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-clipboard-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-purple shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">
                                    Inventory Items</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($inventoryItems) }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-exclamation-triangle text-warning"></i>
                                    {{ $quickActions['lowStockItems'] }} low stock
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-boxes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-teal shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-teal text-uppercase mb-1">
                                    Satisfaction Score</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $topMetrics['satisfactionScore'] }}/5
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    <i class="fa fa-star text-warning"></i> Based on feedback
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics Row -->
        <div class="row mb-4">
            <!-- Membership Distribution Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Membership Distribution</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Chart Options:</div>
                                <a class="dropdown-item" href="#">View Details</a>
                                <a class="dropdown-item" href="#">Export Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="membershipChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Performance -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Monthly Performance</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Memberships
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Appointments
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> Walk-ins
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Recent Activities -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                    </div>
                    <div class="card-body">
                        <div class="activity-feed">
                            @forelse($recentActivities as $activity)
                                <div class="activity-item d-flex align-items-start mb-3">
                                    <div class="activity-icon mr-3">
                                        <i class="fa {{ $activity['icon'] }} fa-lg text-{{ $activity['color'] }}"></i>
                                    </div>
                                    <div class="activity-content flex-grow-1">
                                        <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                        <p class="text-muted mb-1">{{ $activity['description'] }}</p>
                                        <small class="text-muted">{{ $activity['time'] }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fa fa-inbox fa-3x mb-3"></i>
                                    <p>No recent activities</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="{{ route('membership-pendings.index') }}"
                                    class="btn btn-outline-primary btn-block">
                                    <i class="fa fa-users mr-2"></i>
                                    Pending Memberships
                                    <span class="badge badge-primary ml-2">{{ $quickActions['pendingMemberships'] }}</span>
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('appointments.index') }}" class="btn btn-outline-info btn-block">
                                    <i class="fa fa-calendar mr-2"></i>
                                    Pending Appointments
                                    <span class="badge badge-info ml-2">{{ $quickActions['pendingAppointments'] }}</span>
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('stock-items.index') }}" class="btn btn-outline-warning btn-block">
                                    <i class="fa fa-exclamation-triangle mr-2"></i>
                                    Low Stock Items
                                    <span class="badge badge-warning ml-2">{{ $quickActions['lowStockItems'] }}</span>
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('feedback.index') }}" class="btn btn-outline-success btn-block">
                                    <i class="fa fa-comments mr-2"></i>
                                    Unread Feedback
                                    <span class="badge badge-success ml-2">{{ $quickActions['unreadFeedback'] }}</span>
                                </a>
                            </div>
                            @if($quickActions['expiringMemberships'] > 0)
                                <div class="col-6 mb-3">
                                    <a href="#" class="btn btn-outline-danger btn-block">
                                        <i class="fa fa-clock mr-2"></i>
                                        Expiring Memberships
                                        <span class="badge badge-danger ml-2">{{ $quickActions['expiringMemberships'] }}</span>
                                    </a>
                                </div>
                            @endif
                            @if($quickActions['todayBirthdays'] > 0)
                                <div class="col-6 mb-3">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        <i class="fa fa-birthday-cake mr-2"></i>
                                        Today's Birthdays
                                        <span class="badge badge-secondary ml-2">{{ $quickActions['todayBirthdays'] }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Performance Metrics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-3">
                                <div class="metric-card">
                                    <div class="metric-value text-primary">{{ $topMetrics['attendanceRate'] }}%</div>
                                    <div class="metric-label">Attendance Rate</div>
                                    <div class="metric-progress mt-2">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary"
                                                style="width: {{ $topMetrics['attendanceRate'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-3">
                                <div class="metric-card">
                                    <div class="metric-value text-success">{{ $topMetrics['equipmentUtilization'] }}%</div>
                                    <div class="metric-label">Equipment Utilization</div>
                                    <div class="metric-progress mt-2">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success"
                                                style="width: {{ $topMetrics['equipmentUtilization'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-3">
                                <div class="metric-card">
                                    <div class="metric-value text-info">{{ $topMetrics['membershipTypes']['gold'] }}</div>
                                    <div class="metric-label">Gold Members</div>
                                    <div class="metric-progress mt-2">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-warning"
                                                style="width: {{ $activeMembers > 0 ? ($topMetrics['membershipTypes']['gold'] / $activeMembers) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-3">
                                <div class="metric-card">
                                    <div class="metric-value text-warning">{{ $topMetrics['satisfactionScore'] }}/5</div>
                                    <div class="metric-label">Satisfaction Score</div>
                                    <div class="metric-progress mt-2">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-warning"
                                                style="width: {{ ($topMetrics['satisfactionScore'] / 5) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .border-left-secondary {
            border-left: 0.25rem solid #858796 !important;
        }

        .border-left-purple {
            border-left: 0.25rem solid #6f42c1 !important;
        }

        .border-left-teal {
            border-left: 0.25rem solid #20c9a6 !important;
        }

        .text-gray-300 {
            color: #6c757d !important;
        }

        .text-gray-800 {
            color: #343a40 !important;
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }

        .chart-area {
            position: relative;
            height: 20rem;
            width: 100%;
        }

        .chart-pie {
            position: relative;
            height: 15rem;
            width: 100%;
        }

        .activity-feed {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fc;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f8f9fc;
        }

        .metric-card {
            padding: 20px;
            border-radius: 8px;
            background: #f8f9fc;
            transition: transform 0.2s;
        }

        .metric-card:hover {
            transform: translateY(-2px);
        }

        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .metric-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .current-time h4 {
            font-size: 1.25rem;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .current-time p {
            font-size: 0.875rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.85) !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        .fs-5 {
            font-size: 1.125rem !important;
        }

        .fs-6 {
            font-size: 0.875rem !important;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .badge {
            font-size: 0.75rem;
        }

        /* Enhanced readability for metric cards */
        .text-primary {
            color: #4e73df !important;
        }

        .text-success {
            color: #1cc88a !important;
        }

        .text-info {
            color: #36b9cc !important;
        }

        .text-warning {
            color: #f6c23e !important;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        .text-secondary {
            color: #858796 !important;
        }

        .text-purple {
            color: #6f42c1 !important;
        }

        .text-teal {
            color: #20c9a6 !important;
        }

        /* Better contrast for small text */
        .text-muted {
            color: #495057 !important;
        }

        .text-xs {
            font-size: 0.75rem !important;
        }

        /* Enhanced card shadows for better depth */
        .shadow {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        /* Better button styling */
        .btn-outline-primary {
            color: #4e73df;
            border-color: #4e73df;
        }

        .btn-outline-primary:hover {
            color: #fff;
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-outline-success {
            color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-outline-success:hover {
            color: #fff;
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-outline-info {
            color: #36b9cc;
            border-color: #36b9cc;
        }

        .btn-outline-info:hover {
            color: #fff;
            background-color: #36b9cc;
            border-color: #36b9cc;
        }

        .btn-outline-warning {
            color: #f6c23e;
            border-color: #f6c23e;
        }

        .btn-outline-warning:hover {
            color: #fff;
            background-color: #f6c23e;
            border-color: #f6c23e;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Membership Distribution Chart
            const membershipCtx = document.getElementById('membershipChart').getContext('2d');
            const membershipChart = new Chart(membershipCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Gold', 'Silver', 'Bronze'],
                    datasets: [{
                        data: [
                                {{ $topMetrics['membershipTypes']['gold'] }},
                                {{ $topMetrics['membershipTypes']['silver'] }},
                            {{ $topMetrics['membershipTypes']['bronze'] }}
                        ],
                        backgroundColor: ['#f6c23e', '#858796', '#e83e8c'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Monthly Performance Chart
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Memberships', 'Appointments', 'Walk-ins'],
                    datasets: [{
                        data: [
                                {{ $monthlyStats['memberships']['current'] }},
                                {{ $monthlyStats['appointments']['current'] }},
                            {{ $monthlyStats['walkins']['current'] }}
                        ],
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection