<?php

namespace app\controllers;

use app\models\Card;
use app\models\Game;
use app\models\Room;
use app\models\RoomForm;
use app\models\GameCard;
use app\models\Record;
use Yii;


class GameController extends BaseController
{
    //单个游戏房间
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id',false);
        $game = Game::find()->where(['id'=>$id])->one();
        if($game && isset($game->room)){
            $room = $game->room;
            if($room->status == Room::STATUS_PLAYING){
                if($room->player_1==$this->user->id||$room->player_2==$this->user->id){
                    //是否为房主
                    if($room->player_1==$this->user->id){
                         $isMaster = true;
                    }else{
                        $isMaster = false;
                    }
                    //获取卡牌信息 （牌库、手牌、弃牌、桌面牌等）
                    $params['cardInfo'] = GameCard::getCardInfo($game->id);
                    //是否是你的回合
                    if($game->round_player==$this->user->id){
                        $isYourRound = true;
                    }else{
                        $isYourRound = false;
                    }
                    //游戏记录
                    $record_list = Record::find()->where(['game_id'=>$game->id])->orderBy('add_time asc')->all();

                    $params['game'] = $game;
                    $params['isYourRound'] = $isYourRound;
                    $params['record_list'] = $record_list;

                    $params['room'] = $room;
                    $params['isMaster'] = $isMaster;

                    return $this->render('one',$params);
                }
            }
        }
        return $this->goHome();

    }


    //游戏房间内 游戏中状态下 的数据通信
    public function actionAjaxGamePlayingSocket(){
        $room_id = Yii::$app->request->post('room_id',false);
        $arr = [
            /*'id1'=>0,
            'name1'=>'N/A',
            'head1'=>'/images/head_img_default.png',
            'id2'=>0,
            'name2'=>'N/A',
            'head2'=>'/images/head_img_default.png',
            'ord'=>0,
            'ready'=>0,*/
            'record'=>[],
            'end'=>false,
            'room_id'=>$room_id,
        ];
        $result = false;
        $id = Yii::$app->request->post('id',false);
        $record_offset = Yii::$app->request->post('record_offset',false);
        $uid = $this->user->id;
        $game = Game::find()->where(['id'=>$id])->one();
        if($game){
            $result = true;
            if(isset($game->room)){
                $room = $game->room;
                if(in_array($room->status,Room::$status_normal)){
                    if($room->status==Room::STATUS_PREPARING){
                        $arr['end'] = true;
                        $arr['room_id']=$room->id;
                    }
                    $record = [];
                    $record_list = Record::find()->where(['game_id'=>$game->id])->offset($record_offset)->orderBy('add_time asc')->all();
                    foreach($record_list as $l){
                        $record[] = '第'.$l->round.'回合：'.$l->content.' ('.$l->add_time.')';
                    }
                    $arr['record'] = $record;
                }
            }else{
                $arr['end'] = true;
            }
        }
        $arr['result'] = $result;
        echo  json_encode($arr);
        Yii::$app->end();
    }

    public function actionAjaxDoChangePlayerCardOrd(){
        $game_id = Yii::$app->request->post('id',false);
        $player = Yii::$app->request->post('player',false);//当前回合的玩家 1或2
        $ord1 = Yii::$app->request->post('ord1',false);
        $ord2 = Yii::$app->request->post('ord2',false);
        $game = Game::find()->where(['id'=>$game_id,'round_player'=>$player,'status'=>Game::STATUS_PLAYING])->one();
        $return = [];
        $result = false;
        if($game){
            $gc1 = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$player,'ord'=>$ord1,'status'=>1])->one();
            $gc2 = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$player,'ord'=>$ord2,'status'=>1])->one();
            if($gc1 && $gc2){
                $gc1->ord = $ord2;
                $gc1->save();
                $gc2->ord = $ord1;
                $gc2->save();
                Record::addWithChangePlayerCardOrd($game,$ord1,$ord2);
                $result = true;
            }
        }
        $return['result'] = $result;
        return json_encode($return);
    }

    public function actionAjaxEnd(){
        $game_id = Yii::$app->request->post('id',false);
        $game = Game::find()->where(['id'=>$game_id])->one();
        $return = [];
        $result = false;
        if($game && isset($game->room)){
            $room = $game->room;
            $room->game_id = 0;
            $room->status = Room::STATUS_PREPARING;
            $room->player_2_ready = 0;
            $room->save();
            GameCard::deleteAll(['game_id'=>$game_id]);
            $result = true;
            $return['room_id'] = $room->id;
        }
        $return['result'] = $result;
        return json_encode($return);
    }


    public function actionTest(){
        //游戏开始  创建牌库
        $game_id = 1;
        GameCard::drawCard($game_id,2);

        //GameCard::initLibrary($game_id);
echo 'success';exit;

    }

    public function actionTest2(){
        $game_id = 1;
        $gameCard = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_LIBRARY,'status'=>1])->orderBy('ord asc')->all();
        $colors = Card::$colors;
        $numbers = Card::$numbers;
        header("Content-Type: text/html; charset=UTF-8");
        echo '<ul>';

        foreach($gameCard as $gc){
            echo '<li style="display: block;float:left;width:100px;height:100px;border:1px solid #333;margin:10px 10px 0 0 ;">'.$colors[$gc['color']].'-'.$numbers[$gc['num']].'</li>';
        }
        echo '<ul>';
    }
}
