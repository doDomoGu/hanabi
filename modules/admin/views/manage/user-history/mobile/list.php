<?php
use yii\widgets\LinkPager;
use yii\bootstrap\Html;
use app\assets\AppAdminAsset;
use app\modules\admin\components\AdminFunc;
AppAdminAsset::addCssFile($this,'css/mobile/manage/user-history.css');
/*AppAsset::addJsFile($this,'js/main/system/global-config.js');*/


$this->title = '用户操作记录';
?>
<section>
    <ul class="list-unstyled" id="user-history-list">
        <?php if(!empty($list)):?>
        <?php foreach($list as $l):?>
        <li>
            <div><?=$l->id?></div>
            <div><?=$l->user_id?></div>
            <!--<div><?/*=$l->url*/?></div>
            <div><?/*=$l->controller*/?></div>
            <div><?/*=$l->action*/?></div>
            <div><?/*=$l->request_method*/?></div>
            <div><?/*=$l->request*/?></div>
            <div><?/*=$l->response*/?></div>-->
            <div><?=$l->ip?></div><!--
            <div><?/*=$l->user_agent*/?></div>-->
            <div><?=$l->add_time?></div>
        </li>
        <?php endforeach;?>
        <?php endif;?>
    </ul>
            <!--<th style="width:40px;">#</th>
            <th style="width:60px;">用户ID</th>
            <th style="width:200px;">url</th>
            <th style="width:60px;">控制器</th>
            <th style="width:60px;">动作</th>
            <th style="width:80px;">请求方式</th>
            <th style="width:80px;">请求参数</th>
            <th style="width:80px;">响应代码</th>
            <th style="width:125px;">IP地址</th>
            <th>浏览器</th>
            <th style="width:160px;">操作时间</th>-->


    <?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>

</section>
