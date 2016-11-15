<?php
use yii\widgets\LinkPager;
use yii\bootstrap\Html;
use app\assets\AppAsset;
use app\modules\admin\components\AdminFunc;
//AppAsset::addCssFile($this,'css/main/push-setting/index.css');
/*AppAsset::addJsFile($this,'js/main/system/global-config.js');*/


$this->title = '用户操作记录';
?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <?=$this->title?>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th style="width:50px;">#</th>
                <th style="width:50px;">用户ID</th>
                <th style="width:300px;">url</th>
                <th >控制器</th>
                <th >动作</th>
                <th >请求方式</th>
                <th >请求参数</th>
                <th >响应代码</th>
                <th >IP地址</th>
                <th >浏览器</th>
                <th style="width:160px;">操作时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)):?>
                <?php foreach($list as $l):?>
                    <tr>
                        <td><?=$l->id?></td>
                        <td><?=$l->user_id?></td>
                        <td><?=$l->url?></td>
                        <td><?=$l->controller?></td>
                        <td><?=$l->action?></td>
                        <td><?=$l->request_method?></td>
                        <td><?=$l->request?></td>
                        <td><?=$l->response?></td>
                        <td><?=$l->ip?></td>
                        <td><?=$l->user_agent?></td>
                        <td><?=$l->add_time?></td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>

        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>

</section>
