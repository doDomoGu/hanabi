<?php

namespace app\controllers;

use app\models\User;
use Yii;


class GameController extends BaseController
{



    public function actionIndex()
    {
        return $this->render('index');
    }



}
