<?php

namespace app\modules\admin\controllers;


use app\models\Sms;
use app\models\User;
use Yii;

class ManageController extends BaseController
{
    public function actionSms()
    {
        $list = Sms::find()->all();
        $params['list'] = $list;
        return $this->render('sms/index',$params);
    }


}
