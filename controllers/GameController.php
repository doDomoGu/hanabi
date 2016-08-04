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
            if(in_array($room->status,Room::$status_normal)){
                if($room->player_1==$this->user->id||$room->player_2==$this->user->id){
                    $params['room'] = $room;

                    return $this->render('index',$params);
                }
            }
        }
        return $this->goHome();

    }

    public function actionAjaxGetPlayer(){
        $arr = [];
        $result = false;
        $id = Yii::$app->request->post('id',false);
        $uid = $this->user->id;
        $room = Room::find()->where(['id'=>$id])->one();
        if($room){
            if(in_array($room->status,Room::$status_normal)){
                $result = true;
                $arr['id1'] = $room->player_1;
                $arr['name1'] = isset($room->player1)?$room->player1->nickname:'N/A';
                $arr['id2'] = $room->player_2;
                $arr['name2'] = isset($room->player2)?$room->player2->nickname:'N/A';
                $arr['ord'] = $room->player_1==$uid?1:($room->player_2==$uid?2:0);
            }
        }
        $arr['result'] = $result;
        echo  json_encode($arr);
        Yii::$app->end();
    }

}
