<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAdminAsset;

AppAdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Hanabi 花火<?=$this->title!=''?' - '.Html::encode($this->title):'' ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
/*    NavBar::begin([
        'brandLabel' => 'Hanabi 花火',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['id'=>'header-nav','class' => 'navbar-nav navbar-right'],
        'items' =>$this->context->navItems,
    ]);
    NavBar::end();
    */?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container text-center">
        <p class=""><a href="http://xinmengweb.com" target="_blank">&copy; Xinmeng Web</a> <?= date('Y') ?></p>

        <!--<p class="pull-right"><?/*= Yii::powered() */?></p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
