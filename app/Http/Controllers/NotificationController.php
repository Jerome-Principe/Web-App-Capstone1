<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PendingMembership;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications
     */
    public function index(): JsonResponse
    {
        $notifications = Notification::active()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    /**
     * Store a newly created notification
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'feature' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date'
        ]);

        $notification = Notification::create([
            'feature' => $request->feature,
            'description' => $request->description,
            'date' => $request->date,
            'is_deleted' => false,
            'is_read' => false
        ]);

        // Clear notification cache when new notification is created
        CacheService::clearSpecificCache('notification');

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully',
            'data' => $notification
        ], 201);
    }

    /**
     * Display the specified notification
     */
    public function show(Notification $notification): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $notification
        ]);
    }

    /**
     * Update the specified notification
     */
    public function update(Request $request, Notification $notification): JsonResponse
    {
        $request->validate([
            'feature' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date'
        ]);

        $notification->update([
            'feature' => $request->feature,
            'description' => $request->description,
            'date' => $request->date
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification updated successfully',
            'data' => $notification
        ]);
    }

    /**
     * Remove the specified notification (soft delete)
     */
    public function destroy(Notification $notification): JsonResponse
    {
        $notification->update(['is_deleted' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }

    /**
     * Get unread notifications count for the notification bell
     */
    public function getCount(): JsonResponse
    {
        $count = Notification::active()->unread()->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Get recent notifications for the notification bell dropdown (all notifications, both read and unread)
     */
    public function getRecent(): JsonResponse
    {
        $notifications = Notification::active()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        $notification->update(['is_read' => true]);

        // Clear notification cache when status changes
        CacheService::clearSpecificCache('notification');

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        Notification::active()->unread()->update(['is_read' => true]);

        // Clear notification cache when status changes
        CacheService::clearSpecificCache('notification');

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Send expiry notifications to users with memberships expiring in 20 days or less
     */
    public function sendExpiryNotifications(Request $request): JsonResponse
    {
        try {
            \Log::info('🔔 Starting sendExpiryNotifications process');
            \Log::info('📝 Request data: ' . json_encode($request->all()));

            $request->validate([
                'memberships' => 'required|array',
                'memberships.*.id' => 'required',
                'memberships.*.firstName' => 'required|string',
                'memberships.*.lastName' => 'required|string',
                'memberships.*.email' => 'required|email',
                'memberships.*.expiryDate' => 'required|string',
                'memberships.*.daysLeft' => 'nullable|string'
            ]);

            $memberships = $request->input('memberships');
            $notificationsSent = 0;

            \Log::info('👥 Processing ' . count($memberships) . ' memberships');

            foreach ($memberships as $membershipData) {
                \Log::info("🔍 Processing membership ID: " . $membershipData['id']);
                
                // Find the membership record
                $membership = PendingMembership::find($membershipData['id']);

                if (!$membership) {
                    \Log::warning("❌ Membership not found for ID: " . $membershipData['id']);
                    continue; // Skip if membership not found
                }

                $expiryDate = Carbon::parse($membership->expiry_date);
                $daysRemaining = $expiryDate->diffInDays(Carbon::now());

                \Log::info("📅 Membership for {$membership->email} expires in {$daysRemaining} days");

                // Only send notification if membership is expiring in 30 days or less
                if ($daysRemaining <= 30) {
                    // Check if notification already exists to prevent duplicates
                    $existingNotification = Notification::where('user_email', $membership->email)
                        ->where('membership_id', $membership->id)
                        ->where('notification_type', 'expiry_reminder')
                        ->where('date', Carbon::now()->format('Y-m-d'))
                        ->first();

                    if ($existingNotification) {
                        \Log::info("⏭️ Notification already exists for {$membership->email} today");
                        continue;
                    }

                    // Create notification record for mobile app
                    $notification = Notification::create([
                        'feature' => 'Membership Expiry Reminder',
                        'description' => $this->generateExpiryMessage($membership, $daysRemaining),
                        'date' => Carbon::now()->format('Y-m-d'),
                        'is_deleted' => false,
                        'is_read' => false,
                        'user_email' => $membership->email, // Store user email for mobile filtering
                        'membership_id' => $membership->id,
                        'notification_type' => 'expiry_reminder'
                    ]);

                    \Log::info("✅ Created notification for {$membership->email} (ID: {$notification->id})");
                    $notificationsSent++;
                } else {
                    \Log::info("⏭️ Skipping {$membership->email} - expires in {$daysRemaining} days (> 30)");
                }
            }

            // Clear notification cache
            CacheService::clearSpecificCache('notification');
            \Log::info("🧹 Cleared notification cache");

            \Log::info("🎉 Successfully sent {$notificationsSent} notifications");

            return response()->json([
                'success' => true,
                'message' => "Successfully sent {$notificationsSent} expiry notification(s)",
                'count' => $notificationsSent
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Validation error in sendExpiryNotifications: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('❌ Exception in sendExpiryNotifications: ' . $e->getMessage());
            \Log::error('📍 Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate expiry notification message
     */
    private function generateExpiryMessage($membership, $daysRemaining): string
    {
        $memberName = $membership->first_name . ' ' . $membership->last_name;
        $membershipType = optional($membership->requestMembership)->membership_type ?? 'membership';
        $expiryDate = Carbon::parse($membership->expiry_date)->format('M d, Y');

        if ($daysRemaining == 0) {
            return "⚠️ Hi {$memberName}, your {$membershipType} membership expires today ({$expiryDate}). Please renew to continue enjoying our services.";
        } elseif ($daysRemaining == 1) {
            return "⚠️ Hi {$memberName}, your {$membershipType} membership expires tomorrow ({$expiryDate}). Please renew to avoid service interruption.";
        } else {
            return "🔔 Hi {$memberName}, your {$membershipType} membership will expire in {$daysRemaining} days ({$expiryDate}). Please renew before it expires to continue using our services.";
        }
    }

    /**
     * Get notifications for a specific user (for mobile app)
     */
    public function getUserNotifications(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $notifications = Notification::where('user_email', $request->email)
            ->orWhereNull('user_email') // Include general notifications
            ->active()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => $notifications->count()
        ]);
    }
}