<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 6, //最大显示个数
                'minLength' => 5,//最少显示个数
                'padding' => 5,//间距
                'height'=>34,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
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


    public function actionRegister(){
        //如果是登录用户跳转至个人中心
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/user']);
        }

        $model = new RegisterForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        //获取步骤状态
        /*$step = Yii::$app->request->get('step',1);

        if($step==2){
            $sc = RegisterForm::SC_REG_STEP_2;
        }else{
            $sc = RegisterForm::SC_REG_STEP_1;
        }*/



        //$model->setScenario($sc);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /*if($sc == RegisterForm::SC_REG_STEP_1){

            }else{
                echo 'step wrong';exit;
            }*/
echo 'right';exit;
        }else{

        }

        $params['model'] = $model;
        //$params['step'] = $step;
        return $this->render('register',$params);

    }

    //注册第一步 根据手机创建用户 并发送验证码
    public function actionAjaxRegMobile(){
        if(Yii::$app->request->isAjax){
            $model = new RegisterForm();
            $model->setScenario(RegisterForm::SC_REG_STEP_1);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user = new User();
                $user->mobile = $model->mobile;

            }
        }


    }


    /*
     * 玩家注册页面
     */
    public function actionRegisterBak(){
        //如果是登录用户跳转至个人中心
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/user']);
        }
        //注册表单
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->attributes = $model->attributes;
            $user->password_true = $user->password;
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
            //var_dump($model->errors);//exit;
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
