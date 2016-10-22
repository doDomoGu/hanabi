<?php
namespace app\components;

use yii\captcha\CaptchaAction;
use Yii;
use yii\web\Response;
use yii\helpers\Url;

class RegCaptchaAction extends CaptchaAction {

    //重写 validate
    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey() . 'count';
        $session[$name] = $session[$name] + 1;
        if ($valid || $session[$name] > $this->testLimit && $this->testLimit > 0) {
            //$this->getVerifyCode(true);
            $this->getVerifyCode(); //不重新生成验证码
        }

        return $valid;
    }
}
