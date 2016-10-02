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
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(){
        $this->module->adminUser->logout();
        return $this->redirect('/admin');
    }
}