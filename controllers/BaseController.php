<?php
namespace app\controllers;

use app\models\Game;
use app\models\User;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public $user = false;
    public $isInGame = false;
    public $gameId = false;
//    public $navbarView = 'navbar2';
    //public $message = [];
    //public $messageNum = 0;
    //public $layout = 'main';
    public function beforeAction($action){
        if (!parent::beforeAction($action)) {
            return false;
        }

        //$this->titleSuffix = '_'.yii::$app->id;

        if(!$this->checkLogin()){
            return false;
        }



        $this->isInGame = $this->checkIsInGame();


//        $this->getMessageInfo();

        return true;
    }

    //检测是否登陆
    public function checkLogin(){
        $this->checkStatus();
        //除“首页”和“登陆页面”以外的页面，需要进行登陆判断
        if(!in_array($this->route,array('site/index','site/login','site/rule','site/register','site/captcha'))){
            if(Yii::$app->user->isGuest){
                $this->redirect(Yii::$app->urlManager->createUrl(Yii::$app->user->loginUrl));
                return false;
            }
        }

        return true;
    }

    //检测用户状态
    public function checkStatus(){
        if(!Yii::$app->user->isGuest){
            $this->user = User::find()->where(['id'=>Yii::$app->user->id])->one();
            if(!$this->user->status==1){
                Yii::$app->user->logout();
                return $this->goHome();
            }
        }
        return true;
    }

    //检测是否登陆
    public function checkIsInGame(){
        if(!Yii::$app->user->isGuest) {
            $uid = Yii::$app->user->id;
            $gameExist = Game::find()->where("(player_1 = $uid or player_2 = $uid) and status in (1,2)")->one();
            if ($gameExist) {
                $this->gameId = $gameExist->id;
                return true;
            } else {
                return false;
            }
        }
    }



    //获取登录用户的消息通知提醒
    /*public function getMessageInfo(){
        if(!Yii::$app->user->isGuest){
            $this->message = MessageUser::find()->where(['send_to_id'=>yii::$app->user->id,'read_status'=>0])->all();
            if(!empty($this->message)){
                $this->messageNum = count($this->message);
            }
        }
    }*/
}