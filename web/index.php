<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$urlRules = require(__DIR__ . '/../config/url_rules.php');
$params = require(__DIR__ . '/../config/params.php');
$db = require(__DIR__ . '/../config/db.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
