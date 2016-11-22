<?php

/*
 * 主配置文件
 * 可以被 Yii::$app->{key} 调用
 */
$config = [
    'id' => 'Hanabi 花火',  // page-title 前缀
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '0qfJ1ySMdJI7GtQnVjnTmdHAhCZ0bwbN',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
            'idParam' => '__user',  //需要配置前缀 与后台用户的session区分
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        /*'view' => [
            'theme' => [
                //'basePath' => 'app\views\themes\mobile',
                'baseUrl' => '@web/themes/mobile',
                'pathMap' => [
                    '@app/views' => ['@app/views2','@app/views/themes/mobile'],
                ],
            ],
        ],*/

        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => $urlRules,
        ],
        'log' => [
            //'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['htest'],
                    'logFile' => '@app/runtime/logs/htest.log'
                ],
                'sms'=>[
                    'class' => 'yii\log\DbTarget',  //使用数据库记录日志
                    'levels' => ['error', 'warning'],
                    'categories' => ['sms'],
                    'logTable'=> 'log_sms'
                    //php yii migrate --migrationPath=@yii/log/migrations/
                ]
            ],
        ],
        'db' => $db ,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
