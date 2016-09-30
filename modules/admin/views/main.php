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
    <title>后台管理<?=$this->title!=''?' - '.Html::encode($this->title):'' ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">
        ...left
    </div>
    <!-- left side end-->

    <!-- main content start-->
    <div class="main-content" >
        <!-- header section start-->
        <div class="header-section">
            ...header section
        </div>
        <!-- header section end-->
        <!-- page heading start-->
        <div class="page-heading">
            ...head
        </div>
        <!-- page heading end-->
        <!--body wrapper start-->
        <div class="wrapper">
            <?=$content?>
        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <footer>
            ...footer
        </footer>
        <!--footer section end-->
    </div>
    <!-- main content end-->
</section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
