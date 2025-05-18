<?php

return [
    'paths' => [
        'models' => app_path('Models'),
        'controllers' => app_path('Http/Controllers'),
        'requests' => app_path('Http/Requests'),
        'views' => resource_path('views'),
        'migrations' => database_path('migrations'),
    ],
    
    'namespace' => [
        'models' => 'App\\Models',
        'controllers' => 'App\\Http\\Controllers',
        'requests' => 'App\\Http\\Requests',
    ],
    
    'stubs' => [
        'path' => resource_path('stubs/vendor/laravel-extras'),
    ],
];
