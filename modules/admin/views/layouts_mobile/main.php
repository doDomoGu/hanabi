<?php
use yii\helpers\Html;
use app\assets\AppAdminAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

AppAdminAsset::register($this);
AppAdminAsset::addCssFile($this,'css/mobile.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>后台管理22<?=$this->title!=''?' - '.Html::encode($this->title):'' ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<section>
    <?php
    NavBar::begin([
        'brandLabel' => '控制台',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
            'id' => 'head-nav'
        ],
    ]);
    echo Nav::widget([
        'options' => ['id'=>'header-nav','class' => 'navbar-nav navbar-right'],
        'items' =>$this->context->mobileNavItems,
    ]);
    NavBar::end();
    ?>
    <div class="main-content" >
        <?=$this->render('../page_head')?>
        <div class="wrapper">
            <?=$content?>
        </div>
    </div>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
