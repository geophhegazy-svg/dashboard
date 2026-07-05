<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class ArchitectureGenerator
{
    public function generate(): string
    {
        return implode(PHP_EOL, [

            '# Project Architecture',

            '',

            'app/',

            '├── Console',

            '├── Contracts',

            '├── Events',

            '├── Http',

            '├── Jobs',

            '├── Listeners',

            '├── Models',

            '├── Policies',

            '├── Providers',

            '├── Repositories',

            '├── Services',

            '│   ├── Billing',

            '│   ├── Customer',

            '│   ├── Dashboard',

            '│   ├── Documentation',

            '│   ├── Invoice',

            '│   ├── Network',

            '│   ├── Payment',

            '│   ├── Subscription',

            '│   └── Wallet',

        ]);
    }
}
