<?php
namespace app\modules\admin\controllers;

/*use app\models\Game;
use app\models\Room;
use app\models\User;
use yii\bootstrap\Html;*/
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
   /* public $user = false;
    public $isInRoom = false;
    public $roomId = false;
    public $navItems = [];*/

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

        return true;
    }

    public function checkLogin(){
        //除“首页”和“登陆页面”以外的页面，需要进行登陆判断
        if(!in_array($this->route,array('admin/site/index','admin/site/login','admin/site/captcha'))){
            if($this->module->adminUser->isGuest){
                $this->redirect(Yii::$app->urlManager->createUrl($this->module->adminUser->loginUrl));
                return false;
            }
        }
        return true;
    }


}