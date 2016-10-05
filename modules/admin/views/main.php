<?php
use yii\helpers\Html;
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
    <title>后台管理<?=$this->title!=''?' - '.Html::encode($this->title):'' ?></title>
    <?php $this->head() ?>
</head>
    <body class="sticky-header left-side-collapsed11 ">
<?php $this->beginBody() ?>

<section>
    <?=$this->render('_left')?>
    <div class="main-content" >
        <?=$this->render('_header')?><!--
        <?/*=$this->render('_page_head')*/?>
        --><div class="wrapper">
            <?=$content?>
        </div><!--
        <?/*=$this->render('_footer')*/?>
    --></div>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
