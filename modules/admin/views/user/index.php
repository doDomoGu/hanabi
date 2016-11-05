<?php
    $this->title = '玩家列表';
    use app\components\CommonFunc;

    app\assets\AppAdminAsset::addJsFile($this,'js/main/user/index.js');

?>
<section class="panel">
    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <form id="searchForm" method="post">
                <td>--</td>
                <td>
                    <input id="s_username" name="search[username]" value="<?=$search['username']?>" size="14" />
                </td>
                <td>
                    <input id="s_nickname" name="search[nickname]" value="<?=$search['nickname']?>" size="14" />
                </td>
                <td>
                    <input id="s_gender" name="search[gender]" value="<?=$search['gender']?>" size="14" />
                </td>
                <td>--</td>
                <td><input id="s_status" name="search[status]" value="<?=$search['status']?>" size="14" /></td>
                <th><button type="button" id="searchBtn" >检索</button></th>
                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                </form>
            </tr>
            </thead>
            <tr>
                <th>#</th>
                <th>用户名</th>
                <th>昵称</th>
                <th>性别</th>
                <th>注册时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            <tbody>
            <?php foreach($list as $l):?>
            <tr>
                <td><?=$l->id?></td>
                <td><?=$l->username?></td>
                <td><?=$l->nickname?></td>
                <td><?=CommonFunc::getGenderCn($l->gender)?></td>
                <td><?=$l->reg_time?></td>
                <td><?=CommonFunc::getStatusCn($l->status)?></td>
                <td>--</td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

</section>