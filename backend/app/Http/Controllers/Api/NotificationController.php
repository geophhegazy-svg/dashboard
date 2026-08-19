<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Application\Actions\DeleteNotificationAction;
use App\Modules\Notification\Application\Actions\MarkAllNotificationsAsReadAction;
use App\Modules\Notification\Application\Actions\MarkNotificationAsReadAction;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function __construct(
        private readonly MarkNotificationAsReadAction $markAsRead,
        private readonly MarkAllNotificationsAsReadAction $markAllAsRead,
        private readonly DeleteNotificationAction $delete,
    ) {}
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
        $this->markAsRead->execute(
            $notification,
        );

        return response()->json([
            'message' => 'Notification marked as read.'
        ]);
    }

    public function markAllAsRead()
    {
        $this->markAllAsRead->execute();

        return response()->json([
            'message' => 'All notifications marked as read.'
        ]);
    }

    public function destroy(Notification $notification)
    {
        $this->delete->execute(
            $notification,
        );

        return response()->json([
            'message' => 'Notification deleted.'
        ]);
    }
}
