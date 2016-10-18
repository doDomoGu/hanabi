<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UserController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message='Hello World')
    {
        echo $message . "\n";
    }

    public function actionSearch($name=false){
	$search = [];
	if($name){
	$search['username'] = $name;
	
	}

	$list = User::search($search);
//var_dump($list);exit;
	foreach($list as $l){
	echo $l->id.':'.$l->username."\n";
}
}
}
