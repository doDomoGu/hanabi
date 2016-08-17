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
            return $this->redirect('/room/'.$room->id);
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


    //游戏房间内（room状态应为 准备中 preparing)
    public function actionOne()
    {
        $id = Yii::$app->request->get('id',false);
        $room = Room::find()->where(['id'=>$id])->one();
        if($room){
            if(in_array($room->status,Room::$status_normal)){
                if($room->player_1==$this->user->id||$room->player_2==$this->user->id){
                    //是否为房主
                    if($room->player_1==$this->user->id){
                        $isMaster = true;
                    }else{
                        $isMaster = false;
                    }

                    $params['room'] = $room;
                    $params['isMaster'] = $isMaster;

                    return $this->render('one',$params);
                }
            }
        }
        return $this->goHome();

    }

    //游戏房间内 游戏准备中状态下 的数据通信
    public function actionAjaxGamePreparingSocket(){
        $arr = [
            'id1'=>0,
            'name1'=>'N/A',
            'head1'=>'/images/head_img_default.png',
            'id2'=>0,
            'name2'=>'N/A',
            'head2'=>'/images/head_img_default.png',
            'ord'=>0,
            'ready'=>0,
            'start'=>false,
        ];
        $result = false;
        $id = Yii::$app->request->post('id',false);
        $uid = $this->user->id;
        $room = Room::find()->where(['id'=>$id])->one();
        if($room ){
            if(in_array($room->status,Room::$status_normal)){
                $result = true;
                if($room->status==Room::STATUS_PLAYING){
                    $arr['start'] = true;
                }

                if(isset($room->player1)){
                    $arr['id1'] = $room->player_1;
                    $arr['name1'] = $room->player1->nickname;
                    if($room->player1->head_img!='')
                        $arr['head1'] = $room->player1->head_img;
                }
                if(isset($room->player2)){
                    $arr['id2'] = $room->player_2;
                    $arr['name2'] = $room->player2->nickname;
                    if($room->player2->head_img!='')
                        $arr['head2'] = $room->player2->head_img;
                }
                $arr['ord'] = $room->player_1==$uid?1:($room->player_2==$uid?2:0);
                $arr['ready'] = $room->player_2_ready;
            }
        }
        $arr['result'] = $result;
        echo  json_encode($arr);
        Yii::$app->end();
    }
}
