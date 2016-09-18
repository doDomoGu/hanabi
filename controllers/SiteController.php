<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;

class SiteController extends BaseController {
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'/*,'register'*/],
                'rules' => [
                    /*[
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],*/
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /*
     * 首页
     */
    public function actionIndex(){
        return $this->render('index');
    }

    /*
     * 游戏规则页面
     */
    public function actionRule(){
        return $this->render('rule');
    }

    /*
     * 玩家登录页面
     */
    public function actionLogin(){
        //如果是登录用户跳转至个人中心
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/user']);
        }
        //登录表单
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/user']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /*
     * 玩家注册页面
     */
    public function actionRegister(){
        //如果是登录用户跳转至个人中心
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/user']);
        }
        //注册表单
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->attributes = $model->attributes;
            $user->password = md5($user->password);
            $user->status = 1;
            $user->reg_time = date('Y-m-d H:i:s');
            if($user->save()){
                return $this->redirect('/site/login');
            }else{
                return $this->redirect('/site/register');
            }
        }else{
            //TODO 验证失败
            var_dump($model->errors);//exit;
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /*
     * 登出动作
     */
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
