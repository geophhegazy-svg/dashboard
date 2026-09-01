<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogResource;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', ActivityLog::class);

        $query = ActivityLog::with([
            'tenant',
            'user',
        ]);

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return ActivityLogResource::collection(
            $query
                ->latest()
                ->paginate(20)
        );
    }

    public function show(ActivityLog $activityLog): ActivityLogResource
    {
        $this->authorize('view', $activityLog);

        return new ActivityLogResource($activityLog);
    }
}
