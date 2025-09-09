<?php


return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Définit le mailer par défaut pour l'envoi des emails.
    |
    */
    'default' => env('MAIL_MAILER', 'phpmailer'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Configuration des mailers disponibles. Seule la configuration PHPMailer est utilisée.
    |
    */
    'mailers' => [
        'phpmailer' => [
            'transport' => 'phpmailer',
        ],


         'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost:8000'), PHP_URL_HOST)),
        ],
        
        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'ses' => [
            'transport' => 'ses',
        ],
        'postmark' => [
            'transport' => 'postmark',
        ],
        'resend' => [
            'transport' => 'resend',
        ],
        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],
        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],
        'array' => [
            'transport' => 'array',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | Adresse et nom par défaut pour tous les emails envoyés.
    |
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'nanatchoffojunior@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'Afrix'),
    ],
];



