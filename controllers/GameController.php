<?php

namespace app\controllers;

use app\models\Card;
use app\models\Game;
use app\models\GameCard;
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
                    $isMaster = false; //是否为房主
                    if($game->player_1==$this->user->id){
                         $isMaster = true;
                    }

                    //如果游戏为游戏中状态，获取游戏牌
                    if($game->status == Game::STATUS_PLAYING){
                        $params['cardInfo'] = GameCard::getCardInfo($game->id);
                    }

                    $params['game'] = $game;
                    $params['isMaster'] = $isMaster;

                    return $this->render('one',$params);
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
        $game = Game::find()->where(['id'=>$id])->one();
        if($game){
            if(in_array($game->status,Game::$status_normal)){
                $result = true;
                $arr['id1'] = $game->player_1;
                $arr['name1'] = isset($game->player1)?$game->player1->nickname:'N/A';
                $arr['id2'] = $game->player_2;
                $arr['name2'] = isset($game->player2)?$game->player2->nickname:'N/A';
                $arr['ord'] = $game->player_1==$uid?1:($game->player_2==$uid?2:0);
                $arr['player_ready'] = $game->player_2_ready;
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
            $game->save();
            GameCard::initLibrary($game_id);
            for($i=0;$i<5;$i++){ //玩家 1 2 各模五张牌
                GameCard::drawCard($game_id,1);
                GameCard::drawCard($game_id,2);
            }
            $gameCard1 = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>1,'status'=>1])->orderBy('ord asc')->all();
            $gameCard2 = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>2,'status'=>1])->orderBy('ord asc')->all();
            $gameCard1Arr = [];
            foreach($gameCard1 as $gc1){
                $gameCard1Arr[] = ['gcid'=>$gc1->id,'color'=>$gc1->color,'num'=>$gc1->num];
            }
            $gameCard2Arr = [];
            foreach($gameCard2 as $gc2){
                $gameCard2Arr[] = ['gcid'=>$gc2->id,'color'=>$gc2->color,'num'=>$gc2->num];
            }
            $return['gc1'] = $gameCard1Arr;
            $return['gc2'] = $gameCard2Arr;
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
