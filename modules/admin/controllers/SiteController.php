<?php

namespace app\modules\admin\controllers;


use app\modules\admin\models\AdminLoginForm;
use Yii;
/**
 * Default controller for the `admin` module
 */
class SiteController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'main';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){

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
}
