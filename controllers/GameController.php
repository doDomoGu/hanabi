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
                        $playerNo = 1;
                    }else{
                        $isMaster = false;
                        $playerNo = 2;
                    }
                    //获取卡牌信息 （牌库、手牌、弃牌、桌面牌等）
                    $params['cardInfo'] = GameCard::getCardInfo($game->id);
                    $params['cardsTopOnTable'] = GameCard::getCardsTopOnTable($game->id);

                    //是否是你的回合
                    if($isMaster){
                        if($game->round_player==1){
                            $isYourRound = true;
                        }else{
                            $isYourRound = false;
                        }
                    }else{
                        if($game->round_player==2){
                            $isYourRound = true;
                        }else{
                            $isYourRound = false;
                        }
                    }
                    //游戏记录
                    $record_list = Record::find()->where(['game_id'=>$game->id])->orderBy('add_time asc')->all();

                    $params['game'] = $game;
                    $params['isYourRound'] = $isYourRound;
                    $params['playerNo'] = $playerNo;
                    $params['record_list'] = $record_list;

                    $params['room'] = $room;
                    $params['isMaster'] = $isMaster;

                    return $this->render('index',$params);
                }
            }
        }
        return $this->goHome();
    }


    //游戏房间内 游戏中状态下 的数据通信
    public function actionAjaxGamePlayingSocket(){
        $room_id = Yii::$app->request->post('room_id',false);
        $arr = [
            'opposite_card'=>[],
            'record'=>[],
            'is_your_round'=>false,
            'cue_num'=>8,
            'cue_num_2'=>0,
            'chance_num'=>3,
            'chance_num_2'=>0,
            'card_num_in_library'=>40,
            'card_num_in_discard'=>0,
            'cards_top_on_table'=>[],
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
                    //判断是否要结束游戏
                    if($room->status==Room::STATUS_PREPARING){
                        $arr['end'] = true;
                        $arr['room_id']=$room->id;
                    }
                    //游戏记录
                    $record = [];
                    $record_list = Record::find()->where(['game_id'=>$game->id])->offset($record_offset)->orderBy('add_time asc')->all();
                    foreach($record_list as $l){
                        $record[] = '第'.$l->round.'回合：'.$l->content.' ('.$l->add_time.')';
                    }
                    $arr['record'] = $record;
                    //各种数字
                    $arr['cue_num'] = $game->cue;
                    $arr['cue_num_2'] = Game::DEFAULT_CUE - $game->cue;
                    $arr['chance_num'] = $game->chance;
                    $arr['chance_num_2'] = Game::DEFAULT_CHANCE - $game->chance;
                    $arr['card_num_in_library'] = GameCard::find()->where(['game_id'=>$game->id,'type'=>GameCard::TYPE_IN_LIBRARY,'status'=>1])->count();
                    $arr['card_num_in_discard'] = GameCard::find()->where(['game_id'=>$game->id,'type'=>GameCard::TYPE_IN_DISCARD,'status'=>1])->count();

                    //根据当前是谁的回合，判断是否要交换回合
                    if($room->player_1==$this->user->id){
                        $isMaster = true;
                        $opposite_player = 2;
                        if($game->round_player==1){
                            $arr['is_your_round'] = true;
                        }
                    }else{
                        $isMaster = false;
                        $opposite_player = 1;
                        if($game->round_player==2){
                            $arr['is_your_round'] = true;
                        }
                    }

                    $colors = Card::$colors;
                    $nums = Card::$numbers;

                    //对方手牌信息
                    $game_card = GameCard::find()->where(['game_id'=>$game->id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$opposite_player,'status'=>1])->orderBy('ord asc')->all();
                    foreach($game_card as $gc){
                        $opposite_card[$gc->ord] = ['color'=>$colors[$gc->color],'num'=>$nums[$gc->num]];
                    }
                    $arr['opposite_card'] = $opposite_card;

                    //在桌面上的卡牌（成功燃放的烟花）信息
                    $arr['cards_top_on_table'] = GameCard::getCardsTopOnTable($game->id);

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
        $game = Game::find()->where(['id'=>$game_id,'round_player'=>$player])->one();
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

    //弃牌
    public function actionAjaxDoDiscardPlayerCard(){
        $game_id = Yii::$app->request->post('id',false);
        $player = Yii::$app->request->post('player',false);//当前回合的玩家 1或2
        $sel = Yii::$app->request->post('sel',false);
        $game = Game::find()->where(['id'=>$game_id,'round_player'=>$player])->one();
        $return = [];
        $result = false;
        if($game){
            //弃牌
            $discardCard = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$player,'ord'=>$sel,'status'=>1])->one();
            $discardCard->type = GameCard::TYPE_IN_DISCARD;
            $discardCard->player = 0;
            $discardCard->ord = GameCard::getInsertDiscardOrd($game->id);
            $discardCard->save();

            //恢复一个线索
            Game::renewCue($game_id);

            //整理手牌排序
            GameCard::sortCardOrdInPlayer($game_id,$player);

            //摸一张牌
            GameCard::drawCard($game->id,$player);

            //添加游戏记录
            Record::addWithDiscardPlayerCard($game,$discardCard);

            //交换游戏回合
            Game::changeRound($game->id,$player);

            $result = true;

        }
        $return['result'] = $result;
        return json_encode($return);
    }

    //提供线索
    public function actionAjaxDoCue(){
        $game_id = Yii::$app->request->post('id',false);
        $player = Yii::$app->request->post('player',false);//当前回合的玩家 1或2
        $sel = Yii::$app->request->post('sel',false);
        $cue_type = Yii::$app->request->post('cue_type',false);
        $game = Game::find()->where(['id'=>$game_id,'round_player'=>$player])->one();
        $return = [];
        $result = false;
        if($game && in_array($cue_type,Game::$cue_types)){
            //使用一个线索
            $useCue = Game::useCue($game_id);
            if($useCue){
                //提示线索
                if($player==1){
                    $opposite=2;
                }else{
                    $opposite=1;
                }

                $cards = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$opposite,'status'=>1])->orderBy('ord asc')->all();

                $selCard = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$opposite,'ord'=>$sel,'status'=>1])->one();

                if(!empty($cards) && $selCard){
                    $cueCardsOrd = [];
                    if($cue_type=='color'){
                        $colors = Card::$colors;
                        $selVal = $colors[$selCard->color];
                        foreach($cards as $c){
                            if($colors[$c->color] == $selVal){
                                $cueCardsOrd[] = $c->ord+1;
                            }
                        }
                    }elseif($cue_type=='num'){
                        $numbers = Card::$numbers;
                        $selVal = $numbers[$selCard->num];
                        foreach($cards as $c){
                            if($numbers[$c->num] == $selVal){
                                $cueCardsOrd[] = $c->ord+1;
                            }
                        }
                    }




                    //添加游戏记录
                    Record::addWithCue($game,$cue_type,$selVal,$cueCardsOrd);

                    //交换游戏回合
                    Game::changeRound($game->id,$player);

                    $result = true;
                }
            }
        }
        $return['result'] = $result;
        return json_encode($return);
    }

    //打出一张牌
    public function actionAjaxDoPlay(){
        $game_id = Yii::$app->request->post('id',false);
        $player = Yii::$app->request->post('player',false);//当前回合的玩家 1或2
        $sel = Yii::$app->request->post('sel',false);
        $game = Game::find()->where(['id'=>$game_id,'round_player'=>$player])->one();
        $return = [];
        $result = false;
        if($game){
            //获取打出的牌
            $playCard = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$player,'ord'=>$sel,'status'=>1])->one();

            if($playCard){
                $cardsTopOnTable = GameCard::getCardsTopOnTable($game_id);

                if($cardsTopOnTable[$playCard->color] + 1 == Card::$numbers[$playCard->num]){
                    //打出(燃放)成功
                    $return['success'] = true;

                    //1.卡牌进入桌面牌库
                    $playCard->type = GameCard::TYPE_ON_TABLE;
                    $playCard->ord = 0;
                    $playCard->player = 0;
                    $playCard->save();
                    //整理手牌排序
                    GameCard::sortCardOrdInPlayer($game_id,$player);
                    //2.摸一张牌
                    GameCard::drawCard($game_id,$player);

                    //添加游戏记录 （燃放成功）
                    Record::addWithPlaySuccess($game,$playCard);

                    //交换游戏回合
                    Game::changeRound($game->id,$player);
                }else{
                    //打出(燃放)失败
                    $return['success'] = false;
                    //1.卡牌进入弃牌堆
                    $playCard->type = GameCard::TYPE_IN_DISCARD;
                    $playCard->ord = GameCard::getInsertDiscardOrd($game_id);
                    $playCard->player = 0;
                    $playCard->save();
                    //整理手牌排序
                    GameCard::sortCardOrdInPlayer($game_id,$player);

                    //2.机会失去一次
                    Game::loseChance($game_id);

                    //添加游戏记录 (燃放失败，失去一次机会）
                    Record::addWithLoseChance($game,$playCard);

                    //如果失去全部机会游戏结束
                    $game = Game::find()->where(['id'=>$game_id])->one();
                    if($game->chance==0){
                        //添加游戏记录， 游戏结束：因为燃放失败次数达到3次
                        Record::addWithGameEnd($game);

                        $game->room->status = Room::STATUS_PREPARING;
                        $game->room->game_id = 0;
                        $game->room->player_2_ready = 0;
                        $game->room->save();
                        $return['game_end'] = true;
                    }else{
                        //3.摸一张牌
                        GameCard::drawCard($game_id,$player);
                        //交换游戏回合
                        Game::changeRound($game->id,$player);
                    }
                }

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
