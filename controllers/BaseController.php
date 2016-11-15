<?php
namespace app\controllers;

use app\components\CommonFunc;
use app\components\MyLog;
use app\models\Game;
use app\models\Room;
use app\models\User;
use app\models\UserHistory;
use yii\bootstrap\Html;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public $user = false;       //用户对象
    public $isInRoom = false;   //是否在游戏房间中 true||false
    public $roomId = 0;         //如果isInRoom=true 则保存对应房间ID 否则为0
    public $navItems = [];      //导航栏
    public $layout = 'main';    //表示使用哪个布局
    public $isMobile = false;           //是否为移动用户


    public function beforeAction($action){
        $this->addUserHistory();  //用户访问记录

        if (!parent::beforeAction($action)) {
            return false;
        }else{
            $this->checkLogin();  //检测用户登录 和 状态是否正常

            $this->isMobile = CommonFunc::isMobile(); //根据设备属性判断是否为移动用户

            Yii::$app->setLayoutPath(Yii::$app->viewPath);  //修改读取布局文件的默认文件夹  原本为 views/layouts => views

            if($this->isMobile)  //如果是移动设备 调用另一个布局文件
                $this->layout = 'main_web';

            $this->isInRoom = $this->checkIsInRoom();

            $this->setNavItems(); //设置导航栏
//        $this->getMessageInfo();

            return true;
        }
    }

    //检测是否登陆
    public function checkLogin(){
        if(!Yii::$app->user->isGuest){
            //用户登录
            $this->user = User::find()->where(['id'=>Yii::$app->user->id])->one();
            //检测用户的状态是否正常 ，否则强制退出，跳转至登录页面
            if(!$this->user->status==User::STATUS_ENABLE){
                Yii::$app->user->logout();
                $this->toLogin();
            }
        }else{
            //用户未登录
            $except = [
                'site/index',
                'site/login',
                'site/rule',
                'site/register',
                'site/captcha',
                'site/register-send-sms',
                'site/error',
                'site/send-test'
            ];
            //除了上述访问路径外，需要用户登录，跳转至登录页面
            if(!in_array($this->route,$except)) {
                $this->toLogin();
            }
        }
        return true;
    }

    //跳转至登录页面
    private function toLogin(){
        //session记录当前页面的url  登录后返回
        $session = Yii::$app->session;
        $session['referrer_url_user'] = Yii::$app->request->getAbsoluteUrl();

        $this->redirect(Yii::$app->urlManager->createUrl(Yii::$app->user->loginUrl));
        Yii::$app->end();
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
            if($this->isInRoom && $this->roomId>0 && (!in_array($this->id,['room','game'])))
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

    public function addUserHistory(){
        $new = new UserHistory();
        $new->user_id = Yii::$app->user->isGuest?0:Yii::$app->user->id;
        $new->url = Yii::$app->request->getAbsoluteUrl();
        $new->controller = $this->id;
        $new->action = $this->action->id;
        $new->request = Yii::$app->request->queryString;
        $new->response = Yii::$app->response->statusCode;
        $new->ip = Yii::$app->request->getUserIP();
        $new->user_agent = Yii::$app->request->getUserAgent();
        $new->referer = Yii::$app->request->getReferrer();
        $new->add_time = date('Y-m-d H:i:s');
        $new->save();
    }
}