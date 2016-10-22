<?php

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\captcha\Captcha;

    //$this->title = '['.$step.'] 注册游戏账号';
    app\assets\AppAsset::addJsFile($this,'js/main/site/register.js');
?>
<style>
    form .has-error .help-block {
        display: none;
    }
    form .help-block-error {
        display: none;
    }
    form .has-error .help-block-error {
        display: block;
    }
</style>
<div class="panel panel-primary">
    <div class="panel-heading">免费注册游戏账号</div>
    <div class="panel-body">

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => ['class' => 'form-horizontal'],
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-2 control-label\">{label}</div><div class=\"col-lg-4\">{input}\n{hint}{error}</div><div class=\"col-lg-6\"></div>",
            'labelOptions' => [],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->hint('用来登录使用的用户名') ?>

        <?= $form->field($model, 'mobile',['template' => "<div class=\"col-lg-2 control-label\">{label}</div><div class=\"col-lg-4\">{input}\n{hint}{error}</div><div class=\"col-lg-6\"><button type=\"button\" class=\"btn btn-primary\" id=\"sendSmsBtn\">获取短信验证码</button></div>"])->textInput()->hint('请填写手机号码') ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
        ])->hint('正确输入图片验证码后，点击获取短信验证码') ?>

        <?= $form->field($model, 'mobileVerifyCode')->textInput()->hint('请查收手机短信，并填写短信中的验证码') ?>

        <?= $form->field($model, 'password')->passwordInput()->hint('6~16个字符，区分大小写') ?>

        <?= $form->field($model, 'password2')->passwordInput()->hint('请再次填写密码') ?>

        <?= $form->field($model, 'nickname')->textInput()->hint('游戏中显示的昵称') ?>


        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
