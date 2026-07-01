<?php

return [

    'host' => env('MIKROTIK_HOST'),

    'user' => env('MIKROTIK_USER'),

    'password' => env('MIKROTIK_PASSWORD'),

    'port' => (int) env('MIKROTIK_PORT', 8728),

];
