<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
            'is_deleted' => false
        ]);

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
     * Get notifications count for the notification bell
     */
    public function getCount(): JsonResponse
    {
        $count = Notification::active()->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Get recent notifications for the notification bell dropdown
     */
    public function getRecent(): JsonResponse
    {
        $notifications = Notification::active()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    /**
     * Mark notification as read (soft delete)
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        $notification->update(['is_deleted' => true]);

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
        Notification::active()->update(['is_deleted' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
}