<?php

namespace App\Http\Controllers;

use App\Models\PendingMembership;
use App\Models\Walkin;
use App\Models\StockItem;
use App\Models\PendingAppointment;
use App\Models\Instructor;
use App\Models\AttendanceRecord;
use App\Models\RFID;
use App\Models\Feedback;
use App\Models\Announcement;
use App\Models\Goal;
use App\Models\Competition;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get current date and month
            $currentDate = Carbon::now();
            $currentMonth = $currentDate->format('Y-m');

            // Active Members (Approved memberships)
            $activeMembers = PendingMembership::where('status', 'Approved')->count();

            // Walk-in Clients (today)
            $walkinClients = Walkin::whereDate('date', $currentDate->toDateString())->count();

            // Inventory Items
            $inventoryItems = StockItem::count();

            // Today's Appointments
            $todayAppointments = PendingAppointment::whereDate('selected_date', $currentDate->toDateString())->count();

            // Staff/Instructors
            $staffCount = Instructor::count();

            // Today's Attendance
            $todayAttendance = AttendanceRecord::whereDate('date_logged', $currentDate->toDateString())->count();

            // Total Revenue (from approved memberships and renewals)
            // Count ALL approved memberships + ALL approved renewals

            // Revenue from ALL approved original memberships
            $originalRevenue = PendingMembership::where('status', 'Approved')
                ->get()
                ->sum(function ($membership) {
                    $membershipType = optional($membership->requestMembership)->membership_type ?? '';
                    return match (strtolower($membershipType)) {
                        'gold' => 3500,
                        'silver' => 2000,
                        'bronze' => 800,
                        default => 0,
                    };
                });

            // Revenue from approved membership renewals
            $renewalRevenue = \App\Models\MembershipRenewal::where('status', 'Approved')
                ->sum('amount');

            $totalRevenue = $originalRevenue + $renewalRevenue;

            // Monthly Revenue (similar logic as total revenue)
            // Revenue from original memberships created this month
            $monthlyOriginalRevenue = PendingMembership::where('status', 'Approved')
                ->whereYear('created_at', $currentDate->year)
                ->whereMonth('created_at', $currentDate->month)
                ->get()
                ->sum(function ($membership) {
                    $membershipType = optional($membership->requestMembership)->membership_type ?? '';
                    return match (strtolower($membershipType)) {
                        'gold' => 3500,
                        'silver' => 2000,
                        'bronze' => 800,
                        default => 0,
                    };
                });

            // Revenue from approved membership renewals this month
            $monthlyRenewalRevenue = \App\Models\MembershipRenewal::where('status', 'Approved')
                ->whereYear('created_at', $currentDate->year)
                ->whereMonth('created_at', $currentDate->month)
                ->sum('amount');

            $monthlyRevenue = $monthlyOriginalRevenue + $monthlyRenewalRevenue;

            // Pending Appointments
            $pendingAppointments = PendingAppointment::where('status', 'Pending')->count();

            // Recent Activities (last 7 days)
            $recentActivities = $this->getRecentActivities();

            // Monthly Statistics
            $monthlyStats = $this->getMonthlyStatistics();

            // Top Performing Metrics
            $topMetrics = $this->getTopMetrics();

            // Quick Actions Data
            $quickActions = $this->getQuickActionsData();

        } catch (\Exception $e) {
            // If there's an error, provide default values
            $activeMembers = 0;
            $walkinClients = 0;
            $inventoryItems = 0;
            $todayAppointments = 0;
            $staffCount = 0;
            $todayAttendance = 0;
            $totalRevenue = 0;
            $monthlyRevenue = 0;
            $pendingAppointments = 0;
            $recentActivities = [];
            $monthlyStats = [
                'memberships' => ['current' => 0, 'previous' => 0],
                'appointments' => ['current' => 0, 'previous' => 0],
                'walkins' => ['current' => 0, 'previous' => 0],
                'revenue' => ['current' => 0, 'previous' => 0]
            ];
            $topMetrics = [
                'membershipTypes' => ['gold' => 0, 'silver' => 0, 'bronze' => 0],
                'attendanceRate' => 0,
                'satisfactionScore' => 0,
                'equipmentUtilization' => 0
            ];
            $quickActions = [
                'pendingMemberships' => 0,
                'pendingAppointments' => 0,
                'lowStockItems' => 0,
                'todayBirthdays' => 0,
                'expiringMemberships' => 0,
                'unreadFeedback' => 0
            ];
        }

        return view('dashboard', compact(
            'activeMembers',
            'walkinClients',
            'inventoryItems',
            'todayAppointments',
            'staffCount',
            'todayAttendance',
            'totalRevenue',
            'monthlyRevenue',
            'pendingAppointments',
            'recentActivities',
            'monthlyStats',
            'topMetrics',
            'quickActions'
        ));
    }

    private function getRecentActivities()
    {
        $activities = [];

        try {
            // Recent memberships
            $recentMemberships = PendingMembership::where('status', 'Approved')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            foreach ($recentMemberships as $membership) {
                $membershipType = 'Unknown';
                try {
                    if ($membership->requestMembership) {
                        $membershipType = $membership->requestMembership->membership_type ?? 'Unknown';
                    }
                } catch (\Exception $e) {
                    $membershipType = 'Unknown';
                }

                $activities[] = [
                    'type' => 'membership',
                    'title' => 'New Member: ' . $membership->first_name . ' ' . $membership->last_name,
                    'description' => 'Joined with ' . $membershipType . ' membership',
                    'time' => $membership->created_at->diffForHumans(),
                    'icon' => 'fa-user-plus',
                    'color' => 'success'
                ];
            }

            // Recent appointments
            $recentAppointments = PendingAppointment::where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            foreach ($recentAppointments as $appointment) {
                $memberName = 'Unknown';
                try {
                    if ($appointment->pendingMembership) {
                        $memberName = ($appointment->pendingMembership->first_name ?? 'Unknown') . ' ' . ($appointment->pendingMembership->last_name ?? '');
                    }
                } catch (\Exception $e) {
                    $memberName = 'Unknown';
                }

                $activities[] = [
                    'type' => 'appointment',
                    'title' => 'Appointment: ' . $memberName,
                    'description' => 'Scheduled for ' . $appointment->selected_date . ' at ' . $appointment->selected_time,
                    'time' => $appointment->created_at->diffForHumans(),
                    'icon' => 'fa-calendar',
                    'color' => 'info'
                ];
            }

            // Recent walk-ins
            $recentWalkins = Walkin::where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            foreach ($recentWalkins as $walkin) {
                $activities[] = [
                    'type' => 'walkin',
                    'title' => 'Walk-in: ' . $walkin->firstname . ' ' . $walkin->lastname,
                    'description' => 'Paid ₱' . number_format($walkin->amount, 2),
                    'time' => $walkin->created_at->diffForHumans(),
                    'icon' => 'fa-user',
                    'color' => 'warning'
                ];
            }

        } catch (\Exception $e) {
            // If there's an error, return empty activities
            return [];
        }

        // Sort by creation time and return top 10
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 10);
    }

    private function getMonthlyStatistics()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        return [
            'memberships' => [
                'current' => PendingMembership::where('status', 'Approved')
                    ->whereYear('created_at', $currentMonth->year)
                    ->whereMonth('created_at', $currentMonth->month)
                    ->count(),
                'previous' => PendingMembership::where('status', 'Approved')
                    ->whereYear('created_at', $lastMonth->year)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->count()
            ],
            'appointments' => [
                'current' => PendingAppointment::whereYear('created_at', $currentMonth->year)
                    ->whereMonth('created_at', $currentMonth->month)
                    ->count(),
                'previous' => PendingAppointment::whereYear('created_at', $lastMonth->year)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->count()
            ],
            'walkins' => [
                'current' => Walkin::whereYear('created_at', $currentMonth->year)
                    ->whereMonth('created_at', $currentMonth->month)
                    ->count(),
                'previous' => Walkin::whereYear('created_at', $lastMonth->year)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->count()
            ],
            'revenue' => [
                'current' => $this->calculateMonthlyRevenue($currentMonth),
                'previous' => $this->calculateMonthlyRevenue($lastMonth)
            ]
        ];
    }

    private function calculateMonthlyRevenue($month)
    {
        try {
            // Get all renewed membership IDs to exclude from original calculations
            $allRenewedMembershipIds = \App\Models\MembershipRenewal::where('status', 'Approved')
                ->pluck('membership_id')
                ->unique();

            // Revenue from original memberships created this month (excluding renewed ones)
            $originalRevenue = PendingMembership::where('status', 'Approved')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->whereNotIn('id', $allRenewedMembershipIds)
                ->get()
                ->sum(function ($membership) {
                    $membershipType = optional($membership->requestMembership)->membership_type ?? '';
                    return match (strtolower($membershipType)) {
                        'gold' => 3500,
                        'silver' => 2000,
                        'bronze' => 800,
                        default => 0,
                    };
                });

            // Revenue from approved membership renewals this month
            $renewalRevenue = \App\Models\MembershipRenewal::where('status', 'Approved')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');

            return $originalRevenue + $renewalRevenue;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getTopMetrics()
    {
        try {
            return [
                'membershipTypes' => [
                    'gold' => PendingMembership::where('status', 'Approved')
                        ->whereHas('requestMembership', function ($query) {
                            $query->where('membership_type', 'gold');
                        })->count(),
                    'silver' => PendingMembership::where('status', 'Approved')
                        ->whereHas('requestMembership', function ($query) {
                            $query->where('membership_type', 'silver');
                        })->count(),
                    'bronze' => PendingMembership::where('status', 'Approved')
                        ->whereHas('requestMembership', function ($query) {
                            $query->where('membership_type', 'bronze');
                        })->count()
                ],
                'attendanceRate' => $this->calculateAttendanceRate(),
                'satisfactionScore' => $this->calculateSatisfactionScore(),
                'equipmentUtilization' => $this->calculateEquipmentUtilization()
            ];
        } catch (\Exception $e) {
            return [
                'membershipTypes' => [
                    'gold' => 0,
                    'silver' => 0,
                    'bronze' => 0
                ],
                'attendanceRate' => 0,
                'satisfactionScore' => 0,
                'equipmentUtilization' => 0
            ];
        }
    }

    private function getQuickActionsData()
    {
        try {
            return [
                'pendingMemberships' => PendingMembership::where('status', 'Pending')->count(),
                'pendingAppointments' => PendingAppointment::where('status', 'Pending')->count(),
                'lowStockItems' => StockItem::where('quantity', '<=', 10)->count(),
                'todayBirthdays' => $this->getTodayBirthdays(),
                'expiringMemberships' => $this->getExpiringMemberships(),
                'unreadFeedback' => Feedback::where('is_read', false)->count()
            ];
        } catch (\Exception $e) {
            return [
                'pendingMemberships' => 0,
                'pendingAppointments' => 0,
                'lowStockItems' => 0,
                'todayBirthdays' => 0,
                'expiringMemberships' => 0,
                'unreadFeedback' => 0
            ];
        }
    }

    private function calculateAttendanceRate()
    {
        try {
            $totalMembers = PendingMembership::where('status', 'Approved')->count();
            $todayAttendance = AttendanceRecord::whereDate('date_logged', Carbon::now()->toDateString())->count();

            if ($totalMembers > 0) {
                return round(($todayAttendance / $totalMembers) * 100, 1);
            }

            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function calculateSatisfactionScore()
    {
        try {
            $feedbacks = Feedback::whereNotNull('rating')->get();

            if ($feedbacks->count() > 0) {
                $averageRating = $feedbacks->avg('rating');
                return round($averageRating, 1);
            }

            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function calculateEquipmentUtilization()
    {
        try {
            // This is a placeholder - you can implement actual equipment utilization logic
            return rand(65, 95); // Random percentage for demo
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getTodayBirthdays()
    {
        try {
            // This would require a birth_date field in your memberships table
            // For now, returning 0 as placeholder
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getExpiringMemberships()
    {
        try {
            $thirtyDaysFromNow = Carbon::now()->addDays(30);

            return PendingMembership::where('status', 'Approved')
                ->where('expiry_date', '<=', $thirtyDaysFromNow)
                ->where('expiry_date', '>=', Carbon::now())
                ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}