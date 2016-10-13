<?php

namespace app\modules\admin\controllers;


use app\models\Sms;
use app\models\User;
use app\models\VerifyCode;
use Yii;

class ManageController extends BaseController
{
    public function actionSms()
    {
        $list = Sms::find()->all();
        $params['list'] = $list;
        return $this->render('sms/index',$params);
    }

    public function actionVerifyCode()
    {
        $list = VerifyCode::find()->all();
        $params['list'] = $list;
        return $this->render('verify-code/index',$params);
    }


}
