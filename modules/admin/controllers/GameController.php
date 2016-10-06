<?php

namespace app\modules\admin\controllers;


use app\models\Game;
use app\models\Room;
use Yii;

class GameController extends BaseController
{
    public function actionIndex()
    {
        $list = Room::find()->all();
        $params['list'] = $list;
        return $this->render('index',$params);
    }


}
