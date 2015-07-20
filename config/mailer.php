<?php return [
    'class' => 'yii\swiftmailer\Mailer',
    'htmlLayout' => 'layouts/html',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'mailtrap.io',
        'port' => 2525,
        'username' => '35895ef47fc7126f1',
        'password' => 'f799648da025ad',
        'encryption' => 'tls',
    ],
];