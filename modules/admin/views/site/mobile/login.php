<?php
use yii\helpers\Html;
use app\assets\AppAdminAsset;
use yii\bootstrap\ActiveForm;
AppAdminAsset::register($this);
AppAdminAsset::addCssFile($this,'css/mobile/site/login.css');
$this->title = Yii::$app->id.' 控制台登录';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?=$this->title?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="panel panel-default" style="width:80%;margin:10% auto 0;">
    <div class="panel-heading"><?=$this->title?></div>
    <div class="panel-body">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-3 col-lg-5\">{input} {label}</div>\n<div class=\"col-lg-4\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-9">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

