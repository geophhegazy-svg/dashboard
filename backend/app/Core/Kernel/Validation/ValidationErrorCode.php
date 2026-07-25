<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

enum ValidationErrorCode: string
{
    case DuplicateModuleName = 'duplicate_module_name';

    case DuplicateModuleClass = 'duplicate_module_class';

    case MissingDependency = 'missing_dependency';

    case CircularDependency = 'circular_dependency';

    case DuplicateService = 'duplicate_service';

    case DuplicateAction = 'duplicate_action';

    case DuplicateCommand = 'duplicate_command';

    case DuplicateQuery = 'duplicate_query';

    case DuplicatePolicy = 'duplicate_policy';

    case DuplicateListener = 'duplicate_listener';
}
