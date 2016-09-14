<?php
    use app\components\CommonFunc;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>个人中心</h3>
    </div>
    <div class="panel-body">
        <ul>
            <li><img  width="300" height="300" src="<?=$this->context->user->head_img?>" /></li>
            <li>用户名：<?=$this->context->user->username?></li>
            <li>昵称：<?=$this->context->user->nickname?></li>
            <li>性别：<?=CommonFunc::getGenderCn($this->context->user->gender)?></li>
            <li>注册时间：<?=date("Y年m月d日 H:i:s",strtotime($this->context->user->reg_time))?></li>
        </ul>
    </div>
</div>