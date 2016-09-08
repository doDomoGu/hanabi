<?php

namespace app\controllers;

use app\models\User;
use Yii;

class UserController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
