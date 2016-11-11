<?php

namespace app\controllers;

use app\components\MyLog;
use app\components\SendSms;
use app\components\SendSmsFunc;
use app\models\User;
use app\models\VerifyCode;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use yii\log\Logger;
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
                //'class' => 'yii\captcha\CaptchaAction',
                'class' => 'app\components\RegCaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                //'fixedVerifyCode' => 'testme',
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 6, //最大显示个数
                'minLength' => 5,//最少显示个数
                'padding' => 4,//间距
                'height'=>34,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>8,        //设置字符偏移量 有效果
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
            $session = Yii::$app->session;
            if(isset($session['referrer_url_user']))
                return $this->redirect($session['referrer_url_user']);
            else
                return $this->redirect('/user');
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


        if (Yii::$app->request->isAjax){
            $act = Yii::$app->request->post('act',false);
            if(in_array($act,['send-sms','check-send-sms'])) {
                //result值  {'send-success','send-fail','valid-success','valid-fail'}
                $msg = '';
                $model->setScenario(RegisterForm::SCENARIO_SEND_SMS);
                $model->load(Yii::$app->request->post());
                $errors = ActiveForm::validate($model);
                if(empty($errors)){
                    if($act=='send-sms'){
                        //检测是否已经存在有效的验证码  存在则不创建
                        if(!VerifyCode::checkMobileVerifyCodeExist($model->mobile)){
                            if(VerifyCode::insertMobileVerifyCode($model->mobile,VerifyCode::SCENARIO_USER_REGISTER)){
                                $result = 'send-success';
                                $msg ='验证码发送成功,请注意查收,验证码15分钟内有效';
                            }else{
                                $result = 'send-fail';
                            }
                        }else{
                            $result = 'send-success';
                            $msg = '已经发送验证码到您手机,请注意查收,验证码15分钟内有效';
                        }
                    }else{
                        $result = 'valid-success';
                    }
                }else{
                    $result = 'valid-fail';
                }
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ['result'=>$result,'errors'=>$errors,'msg'=>$msg];
            }else{
                $model->load(Yii::$app->request->post());
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->attributes = $model->attributes;
            $user->password_true = $model->password;
            $user->password = md5($model->password);
            $user->reg_time = new Expression('now()');
            $user->status = User::STATUS_ENABLE;
            if($user->save()){
                //将验证码 改为已使用  使用最后一个参数  update
                VerifyCode::check($model->mobile,$model->mobileVerifyCode,true);

                //自动登录 跳转至个人中心
                $loginForm = new LoginForm();
                $loginForm->username = $model->username;
                $loginForm->password = $model->password;
                $loginForm->login();

                return $this->redirect('/user');
            }else{
                var_dump($user->errors);
            }
            Yii::$app->end();
        }/*else{

        }*/

        $params['model'] = $model;
        return $this->render('register',$params);
    }

    /*
     * 登出动作
     */
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSendTest(){
        MyLog::error('201611111 1111 1 1 1 1 1 ',MyLog::CATE_SMS);

        echo 'log';exit;
        $model = new \stdClass();
        $model->Model = '104407581146^1105976032668';
        $model->RequestId = 'A89D5D6D-7241-4A5D-AE01-EF51B8430FBB';

        var_dump(json_encode($model));
        var_dump(\GuzzleHttp\json_decode(json_encode($model)));
        exit;
        //stdClass Object ( [Model] => 104407581146^1105976032668 [RequestId] => A89D5D6D-7241-4A5D-AE01-EF51B8430FBB )




        $code = '13213';
        $product = '[大法师放]';
        $s = "{\"code\":\"$code\",\"product\":\"$product\"}";
        //var_dump(json_decode($s,true));exit;



        $param = ['code'=>$code,'product'=>$product];
       var_dump("{\"code\":\"$code\",\"product\":\"$product\"}");
        var_dump(json_encode($param, JSON_UNESCAPED_UNICODE));exit;

        $text = '验证码${code}，您正在注册${product}，如非本人操作，请忽略。';

        $reg = [];
        $n = [];
        foreach($param as $k => $v){
            $reg[] = '${'.$k.'}';
            $n[] = $v;
        }

        $text2 = str_replace($reg,$n,$text);
            var_dump($text2);exit;

        "{\"code\":\"$code\",\"product\":\"$product\"}";



Yii::$app->end();
        $p = Yii::$app->params['aliyun_sms_config'];
        $s = $p['template']['passs']['222'];
        var_dump(isset($s));exit;


        $sms = new SendSms();
        $sms->sendByRegVerifyCode('18017865582','125234');
    }
}
