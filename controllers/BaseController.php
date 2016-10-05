<?php
namespace app\controllers;

use app\models\Game;
use app\models\Room;
use app\models\User;
use yii\bootstrap\Html;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public $user = false;
    public $isInRoom = false;
    public $roomId = false;
    public $navItems = [];
    public $layout = 'main';
    public function beforeAction($action){
        if (!parent::beforeAction($action)) {
            return false;
        }
        Yii::$app->setLayoutPath(Yii::$app->viewPath);
        if(!$this->checkLogin()){
            return false;
        }

        $this->isInRoom = $this->checkIsInRoom();

        $this->setNavItems();
//        $this->getMessageInfo();

        return true;
    }

    //检测是否登陆
    public function checkLogin(){
        $this->checkStatus();
        //除“首页”和“登陆页面”以外的页面，需要进行登陆判断
        if(!in_array($this->route,array('site/index','site/login','site/rule','site/register','site/captcha','site/error'))){
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

    //检测是否在房间
    public function checkIsInRoom(){
        if(!Yii::$app->user->isGuest) {
            $uid = Yii::$app->user->id;
            $roomExist = Room::find()
                ->where(['player_1' => $uid])
                ->orWhere(['player_2' => $uid])
                ->andWhere(['in','status',Room::$status_normal])
                ->one();
            if ($roomExist) {
                $this->roomId = $roomExist->id;
                return true;
            }
        }
        return false;
    }

    public function setNavItems(){
        $items[] = ['label' => '游戏规则', 'url' => ['/site/rule']];
        if(Yii::$app->user->isGuest){
            $items[] = ['label' => '登录', 'url' => ['/site/login']];
            $items[] = ['label' => '注册', 'url' => ['/site/register']];
        }else{
            $items[] = ['label' => '房间列表', 'url' => ['/room'] , 'active'=>($this->id=='room' && $this->action->id=='index')?true:false];
            if($this->roomId!=false && (!in_array($this->id,['room','game'])))
                $items[] = ['label' => '进入你的房间<span class="label label-warning">!</span>', 'url' => ['/room/'.$this->roomId],'encode'=>false];
            $items[] = ['label' => '个人中心(' . $this->user->nickname . ')', 'url'=> ['/user'], 'active' => ($this->id=='user')?true:false];
            $items[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    '登出',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>';
        }
        $this->navItems = $items;
    }

    /*public function isNavItemActive($url,$alias){
        $return = false;
        switch(true){
            case ($alias == 'room':
        }

        return $return;
    }*/

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