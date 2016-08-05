<?php

namespace app\controllers;

use app\models\RoomForm;
use app\models\Room;
use Yii;


class RoomController extends BaseController
{

    public function actionIndex()
    {
        $list = Room::find()->where('player_1 > 0 and status in (1,2)')->all();
        $params['list'] = $list;
        return $this->render('index',$params);
    }

    //创建房间
    public function actionCreate(){
        $model = new RoomForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $room = new Room();
            $room->attributes = $model->attributes;
            $room->password = $room->password!=''?md5($room->password):'';
            $room->player_1 = $this->user->id;
            $room->status = 1;
            $room->create_time = date('Y-m-d H:i:s');
            if($room->save()){
                return $this->redirect('/game/'.$room->id);
            }else{
                return $this->redirect('/room');
            }
        }/*else{
            var_dump($model->errors);exit;
        }*/
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //进入房间
    public function actionEnter(){
        $id = Yii::$app->request->get('id',false);
        $room = Room::find()->where(['id'=>$id])->one();
        if($room->status==1 && $room->player_2==0){
            $room->player_2 = $this->user->id;
            $room->save();
            return $this->redirect('/game/'.$room->id);
        }else{
            echo 'enter room fail';
            exit;
        }
    }

    //退出房间
    public function actionExit(){
        $uid = $this->user->id;
        $room = Room::find()->where("(player_1 = $uid or player_2 = $uid) and status in (1,2)")->one();
        if($room){
            if($room->player_1==$uid){
                if($room->player_2==0){
                    $room->player_1 = 0;
                    $room->status=0;
                }else{
                    $room->player_1 = $room->player_2;
                    /*$room->player_2 = 0;
                    $room->player_2_ready = 0;*/
                }
            }else{
                /*$room->player_2 = 0;
                $room->player_2_ready = 0;*/
            }

            $room->player_2 = 0;
            $room->player_2_ready = 0;
            $room->save();
            return $this->redirect('/room');
        }else{
            echo 'exit room fail';
            exit;
        }
    }

}
