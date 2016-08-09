<?php
return [
    'bootstrap' => ['gii', 'podium'],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'podium' => [
            'class' => 'bizley\podium\Module',
        ],
    ],

    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => '',
            'encryption' => '',
        ],
    ],
];
