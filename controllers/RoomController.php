<?php

namespace app\controllers;

use app\models\Game;
use app\models\GameCard;
use app\models\Room;
use app\models\RoomForm;
//use app\models\Record;
use Yii;


class RoomController extends BaseController
{
    //游戏房间列表
    public function actionIndex(){
        $list = Room::find()
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
                return $this->redirect('/room/'.$room->id);
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
                //你是房主
                if($room->player_2==0){
                    //没有其他玩家 status 置为0
                    $room->player_1 = 0;
                    $room->status = 0;
                }else{
                    //有其他玩家 将其设为房主
                    $room->player_1 = $room->player_2;
                    $room->player_2 = 0;
                }
            }else{
                //不是房主
                $room->player_2 = 0;
            }
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
            if($room->status == Room::STATUS_PREPARING){
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
            }elseif($room->status == Room::STATUS_PLAYING){
                return $this->redirect('/game/'.$room->game_id);
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
            'game_id'=>0,
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
                    $arr['game_id'] = $room->game_id;
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

    //玩家2进行准备操作
    public function actionAjaxDoPlayerReady(){
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

    public function actionAjaxStart(){
        $room_id = Yii::$app->request->post('id',false);
        $room = Room::find()->where(['id'=>$room_id,'status'=>Room::STATUS_PREPARING])
            ->andWhere(['>','player_1',0])
            ->andWhere(['>','player_2',0])
            ->andWhere(['player_2_ready'=>1])
            ->one();
        $return = [];
        $result = false;
        if($room){
            //随机选择一个玩家开始游戏，即谁第一个回合开始游戏
            $game = new Game();
            $game->round = 1;
            $game->round_player = rand(1,2);
            $game->cue = Game::DEFAULT_CUE;
            $game->chance = Game::DEFAULT_CHANCE;
            $game->save();
            //修改房间信息
            $room->game_id = $game->id;
            $room->status = Room::STATUS_PLAYING;
            $room->save();
            //初始化牌库
            GameCard::initLibrary($game->id);
            for($i=0;$i<5;$i++){ //玩家 1 2 各模五张牌
                GameCard::drawCard($game->id,1);
                GameCard::drawCard($game->id,2);
            }
            $result = true;
            $return['game_id'] = $game->id;
        }
        $return['result'] = $result;
        return json_encode($return);
    }
}
