<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreScheduledReportRequest;
use App\Http\Requests\Reports\UpdateScheduledReportRequest;
use App\Http\Resources\ScheduledReportResource;
use App\Modules\Reports\Application\Actions\ActivateScheduledReportAction;
use App\Modules\Reports\Application\Actions\CreateScheduledReportAction;
use App\Modules\Reports\Application\Actions\DeactivateScheduledReportAction;
use App\Modules\Reports\Application\Actions\DeleteScheduledReportAction;
use App\Modules\Reports\Application\Actions\UpdateScheduledReportAction;
use App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport;
use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ScheduledReportController extends Controller
{
    public function __construct(
        private readonly ScheduledReportRepositoryInterface $repository,
        private readonly CreateScheduledReportAction $createAction,
        private readonly UpdateScheduledReportAction $updateAction,
        private readonly DeleteScheduledReportAction $deleteAction,
        private readonly ActivateScheduledReportAction $activateAction,
        private readonly DeactivateScheduledReportAction $deactivateAction,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('scheduled_reports.view');

        return ScheduledReportResource::collection(
            $this->repository->paginate()
        );
    }

    public function store(
        StoreScheduledReportRequest $request
    ): JsonResponse {
        $this->authorize('scheduled_reports.create');
        return (new ScheduledReportResource(
            $this->createAction->execute(
                $request->validated()
            )
        ))->response()->setStatusCode(
            Response::HTTP_CREATED
        );
    }

    public function show(
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {
        $this->authorize('scheduled_reports.view');
        return new ScheduledReportResource(
            $scheduledReport
        );
    }

    public function update(
        UpdateScheduledReportRequest $request,
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {
        $this->authorize('scheduled_reports.update');
        return new ScheduledReportResource(
            $this->updateAction->execute(
                $scheduledReport,
                $request->validated()
            )
        );
    }

    public function destroy(
        ScheduledReport $scheduledReport
    ): JsonResponse {
        $this->authorize('scheduled_reports.delete');
        $this->deleteAction->execute(
            $scheduledReport
        );

        return response()->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }

    public function activate(
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {
        $this->authorize('scheduled_reports.activate');
        return new ScheduledReportResource(
            $this->activateAction->execute(
                $scheduledReport
            )
        );
    }

    public function deactivate(
        ScheduledReport $scheduledReport
    ): ScheduledReportResource {
        $this->authorize('scheduled_reports.deactivate');
        return new ScheduledReportResource(
            $this->deactivateAction->execute(
                $scheduledReport
            )
        );
    }
}
