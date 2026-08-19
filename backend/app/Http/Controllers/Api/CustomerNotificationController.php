<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Notification\Application\Actions\MarkNotificationAsReadAction;
use Illuminate\Http\Request;
use App\Modules\Notification\Application\Actions\MarkAllNotificationsAsReadAction;

class CustomerNotificationController extends Controller
{
    public function __construct(
        private readonly MarkNotificationAsReadAction $markAsRead,
        private readonly MarkAllNotificationsAsReadAction $markAllAsRead,
    ) {}
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

        $this->markAsRead->execute(
            $notification,
        );

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

        $this->markAllAsRead->execute(
            $customer->id,
        );

        return response()->json([
            'message' => 'All notifications marked as read.'
        ]);
    }
}
