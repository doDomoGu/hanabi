<?php

namespace app\controllers;

use app\models\User;
use Yii;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $this->view->title = '个人中心';
        return $this->render('index');
    }
}
