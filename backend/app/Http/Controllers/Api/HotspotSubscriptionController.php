<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Subscription\Application\Actions\ActivateHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\CreateHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\DeleteHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\SuspendHotspotSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Http\Request;

final class HotspotSubscriptionController extends Controller
{
    public function __construct(
        private readonly HotspotSubscriptionRepositoryInterface $repository,
        private readonly CreateHotspotSubscriptionAction $createAction,
        private readonly ActivateHotspotSubscriptionAction $activateAction,
        private readonly SuspendHotspotSubscriptionAction $suspendAction,
        private readonly DeleteHotspotSubscriptionAction $deleteAction,
    ) {}

    public function index(Request $request)
    {
        return $this->repository->paginate(
            $request->only([
                'status',
                'customer_id',
            ])
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required',
            'customer_id' => 'required',
            'package_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'monthly_price' => 'required|numeric',
            'mikrotik_profile' => 'nullable|string',
        ]);

        $subscription = $this->createAction->execute(
            $data
        );

        return response()->json(
            $subscription,
            201
        );
    }

    public function show(
        HotspotSubscription $hotspotSubscription
    ) {
        return $this->repository->findOrFail(
            $hotspotSubscription->id
        );
    }

    public function destroy(
        HotspotSubscription $hotspotSubscription
    ) {
        $this->deleteAction->execute(
            $hotspotSubscription
        );

        return response()->json([
            'message' => 'Deleted',
        ]);
    }

    public function suspend(
        HotspotSubscription $hotspotSubscription
    ) {
        $this->suspendAction->execute(
            $hotspotSubscription
        );

        return response()->json([
            'message' => 'Hotspot subscription suspended',
        ]);
    }

    public function activate(
        HotspotSubscription $hotspotSubscription
    ) {
        $this->activateAction->execute(
            $hotspotSubscription
        );

        return response()->json([
            'message' => 'Hotspot subscription activated',
        ]);
    }
}
