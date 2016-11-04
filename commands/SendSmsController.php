<?php
namespace app\commands;

use app\models\Sms;
use yii\console\Controller;

class SendSmsController extends Controller
{
    public function actionIndex(){
        //查找未发送的
        $list = Sms::find()->where(['flag'=>0]);
        //增加限制只查找30分钟内的
        $list = $list->all();
        foreach($list as $l){

        }
    }
}
