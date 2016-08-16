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


    //单个游戏房间
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

                    //如果游戏为游戏中状态
                    if($room->status == Room::STATUS_PLAYING){
                        $game = Game::find()->where(['room_id'=>$room->id])->one();
                        //获取卡牌信息 （牌库、手牌、弃牌、桌面牌等）
                        $params['cardInfo'] = GameCard::getCardInfo($room->id);
                        //是否是你的回合
                        if($room->round_player==$this->user->id){
                            $isYourRound = true;
                        }else{
                            $isYourRound = false;
                        }
                        //游戏记录
                        $record_list = Record::find()->where(['game_id'=>$game->id])->orderBy('add_time asc')->all();

                        $params['game'] = $game;
                        $params['isYourRound'] = $isYourRound;
                        $params['record_list'] = $record_list;
                    }

                    $params['room'] = $room;
                    $params['isMaster'] = $isMaster;

                    return $this->render('one',$params);
                }
            }
        }
        return $this->goHome();

    }
}
