<?php
namespace app\modules\admin\controllers;

/*use app\models\Game;
use app\models\Room;
use app\models\User;
use yii\bootstrap\Html;*/
use Yii;
use yii\web\Controller;
use app\components\CommonFunc;

class BaseController extends Controller
{
   /* public $user = false;
    public $isInRoom = false;
    public $roomId = false;
    public $navItems = [];*/

    public $isMobile = false;   //表示是否为移动用户

    public function beforeAction($action){
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->checkLogin();
        /*if(!$this->checkLogin()){
            return false;
        }

        $this->isInRoom = $this->checkIsInRoom();

        $this->setNavItems();*/
//        $this->getMessageInfo();

        $this->isMobile = CommonFunc::isMobile(); //根据设备属性判断是否为移动用户

        if($this->isMobile)  //如果是移动设备 调用另一个布局文件
            Yii::$app->getModule('admin')->setLayoutPath(Yii::$app->getModule('admin')->viewPath.'/layouts_mobile');

        return true;
    }

    public function checkLogin(){
        //除“首页”和“登陆页面”以外的页面，需要进行登陆判断
        if(!in_array($this->route,array('admin/site/login','admin/site/captcha','admin/site/error','admin/site/logout'))){
            if($this->module->adminUser->isGuest){
                $session = Yii::$app->session;
                $session['referrer_url_admin'] = Yii::$app->request->getAbsoluteUrl();
                $this->redirect(Yii::$app->urlManager->createUrl($this->module->adminUser->loginUrl));
                Yii::$app->end();
            }
        }
        return true;
    }


}