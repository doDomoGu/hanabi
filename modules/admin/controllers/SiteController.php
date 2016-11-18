<?php
namespace app\modules\admin\controllers;

use app\modules\admin\models\AdminLoginForm;
use Yii;

class SiteController extends BaseController{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){

        $this->layout =false;
        if (!$this->module->adminUser->isGuest) {
            return $this->redirect('/admin');
        }

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $session = Yii::$app->session;
            if(isset($session['referrer_url_admin']))
                return $this->redirect($session['referrer_url_admin']);
            else
                return $this->redirect('/admin');
        }

        if($this->isMobile)
            $viewName = 'mobile/login';
        else
            $viewName = 'login';
        return $this->render($viewName, [
            'model' => $model,
        ]);
    }

    public function actionLogout(){
        $this->module->adminUser->logout();
        return $this->redirect('/admin');
    }

    public function actionError(){
        return $this->render('error');
    }
}