<?php

use function Cake\Core\env;

return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    'Security' => [
        'salt' => env('SECURITY_SALT', '5d1d93889c36a8e38b1a4d3059492381846b99e05d042d3b188fbd24468d0dc9'),
    ],

    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'seed_dev',
            'password' => '7333',
            'database' => 'seed_lab_db',
            'url' => null,
        ],

    ],

    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
