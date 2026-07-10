<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduledReport\StoreScheduledReportRequest;
use App\Http\Requests\ScheduledReport\UpdateScheduledReportRequest;
use App\Http\Resources\ScheduledReportResource;
use App\Models\ScheduledReport;
use App\Services\Reports\ScheduledReportService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ScheduledReportController extends Controller
{
    public function __construct(
        private readonly ScheduledReportService $service,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ScheduledReportResource::collection(
            $this->service->paginate()
        );
    }

    public function store(
        StoreScheduledReportRequest $request
    ): JsonResponse {

        return (new ScheduledReportResource(
            $this->service->create(
                $request->validated()
            )
        ))->response()->setStatusCode(
            Response::HTTP_CREATED
        );
    }

    public function show(
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {

        return new ScheduledReportResource(
            $scheduledReport
        );
    }

    public function update(
        UpdateScheduledReportRequest $request,
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {

        return new ScheduledReportResource(
            $this->service->update(
                $scheduledReport,
                $request->validated()
            )
        );
    }

    public function destroy(
        ScheduledReport $scheduledReport
    ) {
        $this->service->delete(
            $scheduledReport
        );

        return response()->noContent();
    }

    public function activate(
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {

        return new ScheduledReportResource(
            $this->service->activate(
                $scheduledReport
            )
        );
    }

    public function deactivate(
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {

        return new ScheduledReportResource(
            $this->service->deactivate(
                $scheduledReport
            )
        );
    }
}
