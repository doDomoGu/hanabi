<?php

namespace app\modules\admin\controllers;


use app\models\User;
use Yii;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $list = User::find()->all();
        $params['list'] = $list;
        return $this->render('index',$params);
    }


}
