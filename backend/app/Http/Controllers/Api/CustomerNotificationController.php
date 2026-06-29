<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerNotificationController extends Controller
{
    /**
     * قائمة إشعارات العميل
     */
    public function index(Request $request)
    {
        $customer = $request->user();

        $notifications = $customer
            ->notifications()
            ->latest()
            ->paginate(15);

        return response()->json($notifications);
    }

    /**
     * قراءة إشعار
     */
    public function markAsRead($id, Request $request)
    {
        $customer = $request->user();

        $notification = $customer
            ->notifications()
            ->findOrFail($id);

        $notification->update([
            'is_read' => true,
        ]);

        return response()->json([
            'message' => 'Notification marked as read.'
        ]);
    }

    /**
     * قراءة جميع الإشعارات
     */
    public function markAllAsRead(Request $request)
    {
        $customer = $request->user();

        $customer
            ->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'message' => 'All notifications marked as read.'
        ]);
    }
}
