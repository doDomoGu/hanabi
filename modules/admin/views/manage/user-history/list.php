<?php
use yii\widgets\LinkPager;
use yii\bootstrap\Html;
use app\assets\AppAsset;
use app\modules\admin\components\AdminFunc;
//AppAsset::addCssFile($this,'css/main/push-setting/index.css');
/*AppAsset::addJsFile($this,'js/main/system/global-config.js');*/


    app\assets\AppAdminAsset::addJsFile($this,'js/main/manage/user-history.js');

$this->title = '用户操作记录';
?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <?=$this->title?>
        共 <?=$pages->totalCount?> 条
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <form id="searchForm" method="post">
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>
                        <?=Html::dropDownList(
                            "search[controller]",
                            $search['controller'],
                            $searchItems['controller'],
                            ['prompt'=>'--']
                        )?>
                    </td>
                    <td><?=Html::dropDownList("search[action]",$search['action'],$searchItems['action'],['prompt'=>'--'])?></td>
                    <td><?=Html::dropDownList("search[request_method]",$search['request_method'],$searchItems['request_method'],['prompt'=>'--'])?></td>
                    <td>--</td>
                    <td><?=Html::dropDownList("search[response]",$search['response'],$searchItems['response'],['prompt'=>'--'])?></td>
                    <td>--</td>
                    <td>--</td>

                    <th><button type="button" id="searchBtn" >检索</button></th>
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                </form>
            </tr>
            </thead>
            <tr>
                <th style="width:60px;" class="text-right">#</th>
                <th style="width:60px;" class="text-right">用户ID</th>
                <th style="width:200px;">url</th>
                <th style="width:60px;">控制器</th>
                <th style="width:60px;">动作</th>
                <th style="width:80px;">请求方式</th>
                <th style="width:80px;">请求参数</th>
                <th style="width:80px;">响应代码</th>
                <th style="width:125px;">IP地址</th>
                <th>浏览器</th>
                <th style="width:160px;">操作时间</th>
            </tr>
            <tbody>
            <?php if(!empty($list)):?>
                <?php foreach($list as $l):?>
                    <tr>
                        <td class="text-right"><?=$l->id?></td>
                        <td class="text-right"><?=$l->user_id?></td>
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
            'maxButtonCount' => 8,
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
            'firstPageLabel' => 1,
            'lastPageLabel' => $pages->getPageCount()
        ]);
        ?>
    </div>

</section>
