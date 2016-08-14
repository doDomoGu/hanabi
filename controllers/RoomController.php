<?php

namespace app\controllers;

use app\models\Room;
use app\models\RoomForm;
//use app\models\Record;
use Yii;


class RoomController extends BaseController
{
    //游戏房间列表
    public function actionIndex(){
        $list = Room::find()
            ->where(['>','player_1', 0])
            ->andWhere(['in','status', Room::$status_normal])
            ->all();
        $params['list'] = $list;
        return $this->render('index',$params);
    }

    //创建游戏房间
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

    //进入游戏房间
    public function actionEnter(){
        $id = Yii::$app->request->get('id',false);
        $room = Room::find()->where(['id'=>$id])->one();
        if($room->status==1 && $room->player_2==0){
            $room->player_2 = $this->user->id;
            $room->save();
            return $this->redirect('/game/'.$room->id);
        }else{
            echo 'enter game roo33m fail';
            exit;
        }
    }

    //退出游戏房间
    public function actionExit(){
        $uid = $this->user->id;
        $room = Room::find()
            ->where("(player_1 = $uid or player_2 = $uid)")
            ->andWhere(['in','status',Room::$status_normal])
            ->one();
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
            echo 'exit game fail';
            exit;
        }
    }
}
