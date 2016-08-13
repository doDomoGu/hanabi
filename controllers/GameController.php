<?php

namespace app\controllers;

use app\models\Card;
use app\models\Game;
use app\models\GameCard;
use app\models\Record;
use Yii;


class GameController extends BaseController
{
    //游戏房间列表
    public function actionIndex()
    {
        $list = Game::find()->where('player_1 > 0 and status in (1,2)')->all();
        $params['list'] = $list;
        return $this->render('index',$params);
    }

    //创建游戏房间
    public function actionCreate(){
        $model = new GameForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $game = new Game();
            $game->attributes = $model->attributes;
            $game->password = $game->password!=''?md5($game->password):'';
            $game->player_1 = $this->user->id;
            $game->status = 1;
            $game->create_time = date('Y-m-d H:i:s');
            if($game->save()){
                return $this->redirect('/game/'.$game->id);
            }else{
                return $this->redirect('/game');
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
        $game = Game::find()->where(['id'=>$id])->one();
        if($game->status==1 && $game->player_2==0){
            $game->player_2 = $this->user->id;
            $game->save();
            return $this->redirect('/game/'.$game->id);
        }else{
            echo 'enter game roo33m fail';
            exit;
        }
    }

    //退出游戏房间
    public function actionExit(){
        $uid = $this->user->id;
        $game = Game::find()->where("(player_1 = $uid or player_2 = $uid) and status in (1,2)")->one();
        if($game){
            if($game->player_1==$uid){
                if($game->player_2==0){
                    $game->player_1 = 0;
                    $game->status=0;
                }else{
                    $game->player_1 = $game->player_2;
                    /*$game->player_2 = 0;
                    $game->player_2_ready = 0;*/
                }
            }else{
                /*$game->player_2 = 0;
                $game->player_2_ready = 0;*/
            }

            $game->player_2 = 0;
            $game->player_2_ready = 0;
            $game->save();
            return $this->redirect('/game');
        }else{
            echo 'exit game fail';
            exit;
        }
    }


    //单个游戏房间
    public function actionOne()
    {
        $id = Yii::$app->request->get('id',false);
        $game = Game::find()->where(['id'=>$id])->one();
        if($game){
            if(in_array($game->status,Game::$status_normal)){
                if($game->player_1==$this->user->id||$game->player_2==$this->user->id){
                    //是否为房主
                    if($game->player_1==$this->user->id){
                         $isMaster = true;
                    }else{
                        $isMaster = false;
                    }

                    //如果游戏为游戏中状态
                    if($game->status == Game::STATUS_PLAYING){
                        //获取卡牌信息 （牌库、手牌、弃牌、桌面牌等）
                        $params['cardInfo'] = GameCard::getCardInfo($game->id);
                        //是否是你的回合
                        if($game->round_player==$this->user->id){
                            $isYourRound = true;
                        }else{
                            $isYourRound = false;
                        }
                        $params['isYourRound'] = $isYourRound;
                        $record_list = Record::find()->where(['game_id'=>$game->id])->orderBy('add_time asc')->all();
                        $params['record_list'] = $record_list;
                    }

                    $params['game'] = $game;
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
        $game = Game::find()->where(['id'=>$id])->one();
        if($game){
            if(in_array($game->status,Game::$status_normal)){
                $result = true;
                if($game->status==Game::STATUS_PLAYING){
                    $arr['start'] = true;
                }

                if(isset($game->player1)){
                    $arr['id1'] = $game->player_1;
                    $arr['name1'] = $game->player1->nickname;
                    if($game->player1->head_img!='')
                        $arr['head1'] = $game->player1->head_img;
                }
                if(isset($game->player2)){
                    $arr['id2'] = $game->player_2;
                    $arr['name2'] = $game->player2->nickname;
                    if($game->player2->head_img!='')
                        $arr['head2'] = $game->player2->head_img;
                }
                $arr['ord'] = $game->player_1==$uid?1:($game->player_2==$uid?2:0);
                $arr['ready'] = $game->player_2_ready;
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
        $game = Game::find()->where(['id'=>$id,'status'=>Game::STATUS_PREPARING])->one();
        if($game && in_array($act,['do-ready','do-not-ready'])){
            if($game->player_2 == $uid){
                if($act=='do-ready'){
                    $game->player_2_ready = 1;
                }elseif($act=='do-not-ready'){
                    $game->player_2_ready = 0;
                }
                if($game->save()){
                    $result = true;
                }
            }
        }
        $arr['result'] = $result;
        echo  json_encode($arr);
        Yii::$app->end();
    }

    public function actionAjaxStart(){
        $game_id = Yii::$app->request->post('id',false);
        $game = Game::find()->where(['id'=>$game_id,'status'=>Game::STATUS_PREPARING])
            ->andWhere('player_1 > 0 and player_2 > 0 and player_2_ready = 1')
            ->one();
        $return = [];
        $result = false;
        if($game){
            $game->status = Game::STATUS_PLAYING;
            //随机选择一个玩家开始游戏，即谁第一个回合开始游戏
            $game->round = 1;
            $game->round_player = rand(1,2);
            $game->save();
            GameCard::initLibrary($game_id);
            for($i=0;$i<5;$i++){ //玩家 1 2 各模五张牌
                GameCard::drawCard($game_id,1);
                GameCard::drawCard($game_id,2);
            }
            $result = true;

        }
        $return['result'] = $result;
        return json_encode($return);
    }

    //游戏房间内 游戏准备中状态下 的数据通信
    public function actionAjaxGamePlayingSocket(){
        $arr = [
            /*'id1'=>0,
            'name1'=>'N/A',
            'head1'=>'/images/head_img_default.png',
            'id2'=>0,
            'name2'=>'N/A',
            'head2'=>'/images/head_img_default.png',
            'ord'=>0,
            'ready'=>0,*/
            'end'=>false,
        ];
        $result = false;
        $id = Yii::$app->request->post('id',false);
        $uid = $this->user->id;
        $game = Game::find()->where(['id'=>$id])->one();
        if($game){
            if(in_array($game->status,Game::$status_normal)){
                $result = true;
                if($game->status==Game::STATUS_PREPARING){
                    $arr['end'] = true;
                }
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
        $game = Game::find()->where(['id'=>$game_id,'status'=>Game::STATUS_PLAYING])->one();
        $return = [];
        $result = false;
        if($game){
            $game->status = Game::STATUS_PREPARING;
            $game->player_2_ready = 0;
            $game->round = 0;
            $game->round_player = 0;
            $game->save();
            GameCard::deleteAll(['game_id'=>$game_id]);
            $result = true;
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
