<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::query();

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // الإشعارات غير المقروءة
        if ($request->boolean('unread')) {
            $query->where('is_read', false);
        }

        // البحث
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        return NotificationResource::collection(
            $query->latest()->paginate(15)
        );
    }

    public function show(Notification $notification)
    {
        return new NotificationResource($notification);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update([
            'is_read' => true,
        ]);

        return response()->json([
            'message' => 'Notification marked as read.'
        ]);
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)
            ->update([
                'is_read' => true
            ]);

        return response()->json([
            'message' => 'All notifications marked as read.'
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted.'
        ]);
    }
}
