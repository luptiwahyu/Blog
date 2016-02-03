<?php 

return [
    'app' => [
        'url'  => 'http://localhost:8000',
        'hash' => [
            'algo' => PASSWORD_BCRYPT,
            'cost' => 10
        ]
    ],

    'db' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'blogslim',
        'username'  => 'kid',
        'password'  => 'sequel',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ],

    'auth' => [
        'session'  => 'user_id',
        'remember' => 'user_remember'
    ],

    'mail' => [
        'smtp_auth'   => true,
        'smtp_secure' => 'tls',
        'host'        => 'smtp.gmail.com',
        'username'    => 'lupinoftheheiseiera@gmail.com',
        'password'    => 'Kait0Kur0ba',
        'port'        => 587,
        'html'        => true,
    ],

    'twig' => [
        'debug' => true
    ],

    'csrf' => [
        'key' => 'csrf_token'
    ]
];