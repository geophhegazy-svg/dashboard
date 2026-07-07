<?php

declare(strict_types=1);

namespace App\Automation\Contracts;

use App\Automation\DTOs\AutomationResult;

interface AutomationServiceInterface
{
    public function run(): AutomationResult;
}
