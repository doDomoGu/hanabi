<?php

namespace app\controllers;

use app\models\Room;
use Yii;


class GameController extends BaseController
{

    public function actionIndex()
    {
        $id = Yii::$app->request->get('id',false);
        $room = Room::find()->where(['id'=>$id])->one();
        if($room){
            if(in_array($room->status,[1,2])){
                if($room->player_1==$this->user->id||$room->player_2==$this->user->id){
                    $params['room'] = $room;
                    return $this->render('index',$params);
                }
            }
        }
        return $this->goHome();

    }



}
