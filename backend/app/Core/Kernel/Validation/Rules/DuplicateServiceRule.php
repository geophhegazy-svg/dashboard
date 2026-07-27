<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Rules;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\DuplicateResourceDetector;
use App\Core\Kernel\Validation\Extractors\ServiceExtractor;
use App\Core\Kernel\Validation\ValidationError;
use App\Core\Kernel\Validation\ValidationErrorCode;

final readonly class DuplicateServiceRule implements KernelValidationRuleInterface
{
    public function __construct(
        private DuplicateResourceDetector $detector,
        private ServiceExtractor $extractor,
    ) {}

    /**
     * @return list<ValidationError>
     */
    public function validate(
        ModuleRegistry $registry,
    ): array {

        return $this->detector->detect(
            $registry,
            $this->extractor,
            ValidationErrorCode::DuplicateService,
            'Service',
        );
    }
}
