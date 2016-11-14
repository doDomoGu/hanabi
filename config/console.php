<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$dbConsole = require(__DIR__ . '/db_console.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'sms'=>[
                    'class' => 'yii\log\DbTarget',  //使用数据库记录日志
                    'levels' => ['error', 'warning'],
                    'categories' => ['sms'],
                    'logTable'=> 'log_sms'


                ]
            ],
        ],
        'db' => $dbConsole,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
