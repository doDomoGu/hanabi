<?php
    return [
        //['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
        'room/<id:\d+>' => 'room/one',
        'game/<id:\d+>' => 'game/index',
        //'<controller:(user|manage)>'=>'<controller>/index',
        //'<controller:\w+>/about22' => '<controller>/about',
    ];