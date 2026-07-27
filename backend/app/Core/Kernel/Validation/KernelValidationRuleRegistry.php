<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

use App\Core\Contracts\ContainerInterface;
use App\Core\Kernel\Contracts\KernelValidationRuleInterface;

final readonly class KernelValidationRuleRegistry
{
    /**
     * @param list<class-string<KernelValidationRuleInterface>> $ruleClasses
     */
    public function __construct(
        private ContainerInterface $container,
        private array $ruleClasses,
    ) {}

    /**
     * @return iterable<KernelValidationRuleInterface>
     */
    public function rules(): iterable
    {
        foreach ($this->ruleClasses as $rule) {
            yield $this->container->make($rule);
        }
    }
}
