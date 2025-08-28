<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;

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
}