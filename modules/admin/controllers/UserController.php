<?php

namespace app\modules\admin\controllers;


use Yii;

class UserController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


}
