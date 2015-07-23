<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'shitcode',
    'name' => 'shitcode',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'userSettings'],
    'defaultRoute' => 'site/latest',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'AujS1-LIscWfBs88_4NwiPPL2yDheo4e',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Admin',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/login'],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                'vote/<vote:(up|down)>/<id:\d+>' => 'site/vote',
                '<action:\w+>/language/<language:\w+>/page/<page:\d+>' => 'site/<action>',
                '<action:\w+>/language/<language:\w+>' => 'site/<action>',
                '<id:\d+>' => 'site/paste',
                '<action:\w+>/page/<page:\d+>' => 'site/<action>',
                '<action:\w+>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/page/<page:\d+>' => '<controller>/<action>',
            ),
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => require(__DIR__ . '/mailer.php'),
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'happycode*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'userSettings' => [
            'class' => 'app\components\UserSettings',
            'defaultHighlightStyle' => 'zenburn',
            'defaultAceStyle' => 'monokai',
        ],
        'languages' => [
            'class' => 'app\components\SupportedLanguages',
            'languages' => require(__DIR__.'/languages.php'),
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
