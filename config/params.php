<?php

return [
    'aliyun_sms_config'=> [
        'accessKey'=> 'LTAIaNUr1BPK7bAa',
        'accessSecret' => 'EyZv4WFoxrVzNMPzlrYnQd2LaSsOhr',
        'sign' => '欣萌网络',
        'regionId' => 'cn-hangzhou',
        'template' => [
            'param' => ['product'=>'[花火在线桌游]'],
            'scenario' => [
                'user_register'=>[
                    'code' =>'SMS_25490100',
                    'text' =>'验证码${code}，您正在注册${product}，如非本人操作，请忽略。'
                ],
                'forget_password'=>[
                    'code' =>'SMS_25490XXX',
                    'text' =>'XXXX验证码${code}，您正在注册${product}，如非本人操作，请忽略。'
                ]
            ]
        ],
    ]
];
