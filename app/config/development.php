<?php 

return [
    
    'app' => [
        'url'  => 'http://localhost:8000',
        'name' => 'blog',
    ],

    'security' => [
        'password' => [
            'algo' => PASSWORD_BCRYPT,
            'cost' => 10,
        ],
        'hash' => [
            'algo' => 'sha256'
        ]
    ],

    'db' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'dbname',
        'username'  => 'roor',
        'password'  => '',
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
        'username'    => 'example@gmail.com',
        'password'    => 'SecretPassword',
        'port'        => 587,
        'html'        => true,
    ],

    'twig' => [
        'debug' => true
    ],

    'csrf' => [
        'key' => 'csrf_token'
    ],

];
