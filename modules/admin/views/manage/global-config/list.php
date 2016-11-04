<?php
use yii\widgets\LinkPager;
use yii\bootstrap\Html;
use app\assets\AppAsset;
use app\modules\admin\components\AdminFunc;
//AppAsset::addCssFile($this,'css/main/push-setting/index.css');
AppAsset::addJsFile($this,'js/main/system/global-config.js');


$this->title = '参数设置';
?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <?=$this->title?>
    </header>
    <div class="panel-body">
        <!--<p>
            <a id="editable-sample_new" class="btn btn-primary" href="/system/global-config-add-and-edit">
                添加 <span class="glyphicon glyphicon-plus"></span>
            </a>
        </p>-->
        <p>
            <a id="editable-sample_new" class="btn btn-primary" href="<?=AdminFunc::adminUrl('manage/global-config-check-update')?>">
                检测更新
            </a>
        </p>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th style="width:50px;">#</th>
                <th style="width:300px;">名称</th>
                <th style="width:300px;">值</th>
                <th >说明</th>
                <th style="width:100px;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)):?>
                <?php foreach($list as $l):?>
                    <tr>
                        <td><?=$l->id?></td>
                        <td><?=$l->name?></td>
                        <td><?=$l->value?></td>
                        <td><?=$l->title?></td>
                        <td>
                            <?=Html::a('编辑',[AdminFunc::adminUrl('manage/global-config-add-and-edit'),'id'=>$l->id])?>
                        </td>
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
