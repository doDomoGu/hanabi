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
        /*if(!$this->checkLogin()){
            return false;
        }

        $this->isInRoom = $this->checkIsInRoom();

        $this->setNavItems();*/
//        $this->getMessageInfo();

        return true;
    }


}