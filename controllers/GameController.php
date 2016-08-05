<?php

namespace app\controllers;

use app\models\Card;
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
                    if($room->player_1==$this->user->id){
                        $params['isMaster'] = true;
                    }else{
                        $params['isMaster'] = false;
                    }
                    return $this->render('index',$params);
                }
            }
        }
        return $this->goHome();

    }
    //获取游戏房间内玩家信息
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
                $arr['player_ready'] = $room->player_2_ready;
            }
        }
        $arr['result'] = $result;
        echo  json_encode($arr);
        Yii::$app->end();
    }

    //玩家2进行准备操作
    public function actionAjaxGetPlayerReady(){
        $arr = [];
        $result = false;
        $uid = $this->user->id;
        $id = Yii::$app->request->post('id',false);
        $act = Yii::$app->request->post('act',false);
        $room = Room::find()->where(['id'=>$id,'status'=>Room::STATUS_PREPARING])->one();
        if($room && in_array($act,['do-ready','do-not-ready'])){
            if($room->player_2 == $uid){
                if($act=='do-ready'){
                    $room->player_2_ready = 1;
                }elseif($act=='do-not-ready'){
                    $room->player_2_ready = 0;
                }
                if($room->save()){
                    $result = true;
                }
            }
        }
        $arr['result'] = $result;
        echo  json_encode($arr);
        Yii::$app->end();
    }


    public function actionTest(){
        $card = new Card();
        $f = $card->face;
        var_dump($f);
    }
}
