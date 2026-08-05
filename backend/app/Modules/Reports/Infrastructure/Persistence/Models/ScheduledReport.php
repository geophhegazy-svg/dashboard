<?php

namespace App\Modules\Reports\Infrastructure\Persistence\Models;

class ScheduledReport extends \App\Models\ScheduledReport
{
    protected static function newFactory()
    {
        return \Database\Factories\ScheduledReportFactory::new();
    }
}
