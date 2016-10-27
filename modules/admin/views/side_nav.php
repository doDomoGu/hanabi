<?php
    use app\modules\admin\components\AdminFunc;
    //手动引入bootstrap.js
    //**由于有可能没有调用任何bootstrap组件   **使用Asset依赖注册不会重复引入js文件
    yii\bootstrap\BootstrapPluginAsset::register($this);
?>

<div class="side-nav">
    <ul class="nav nav-pills nav-stacked">
        <li class="menu-single <?=$this->context->id=='site'?'active':''?>">
            <a href="<?=AdminFunc::adminUrl('/')?>">
                <span class="menu-icon glyphicon glyphicon-inbox"></span>
                仪表盘
            </a>
        </li>
        <!--<li class="menu-list <?/*=$this->context->id=='system2'?'nav-active':''*/?>">
            <a href="javascript:void(0);" class="<?/*=$this->context->id=='system2'?'':'collapsed'*/?>">
                <span class="menu-icon glyphicon glyphicon-cog"></span>
                系统设置
                <span class="sub-menu-collapsed glyphicon glyphicon-plus"></span>
                <span class="sub-menu-collapsed-in glyphicon glyphicon-minus"></span>
            </a>
            <ul class="sub-menu-list collapse <?/*=$this->context->id=='system2'?'in':''*/?>" id="system-collapse">
                <li class="<?/*=$this->context->id=='system2' && $this->context->action->id=='global-config'?'active':''*/?>">
                    <a href="/system2/global-config">
                        参数设置
                    </a>
                </li>
                <li class="<?/*=$this->context->id=='system2' && $this->context->action->id=='function2'?'active':''*/?>">
                    <a href="/system2/function2">
                        功能二(测试用)
                    </a>
                </li>
                <li class="<?/*=$this->context->id=='system2' && $this->context->action->id=='function3'?'active':''*/?>">
                    <a href="/system2/function3">
                        功能三(测试用)
                    </a>
                </li>
            </ul>
        </li>-->
        <li class="menu-single <?=$this->context->id=='user'?'active':''?>">
            <a href="<?=AdminFunc::adminUrl('user')?>">
                <span class="menu-icon glyphicon glyphicon-refresh"></span>
                玩家
            </a>
        </li>
        <li class="menu-single <?=$this->context->id=='game'?'active':''?>">
            <a href="<?=AdminFunc::adminUrl('game')?>">
                <span class="menu-icon glyphicon glyphicon-refresh"></span>
                游戏
            </a>
        </li>
        <li class="menu-list <?=$this->context->id=='manage'?'nav-active':''?>">
            <a href="javascript:void(0);" class="<?=$this->context->id=='manage'?'':'collapsed'?>">
                <span class="menu-icon glyphicon glyphicon-cog"></span>
                网站管理
                <span class="sub-menu-collapsed glyphicon glyphicon-plus"></span>
                <span class="sub-menu-collapsed-in glyphicon glyphicon-minus"></span>
            </a>
            <ul class="sub-menu-list collapse <?=$this->context->id=='manage'?'in':''?>" id="system-collapse">
                <li class="<?=$this->context->id=='manage' && substr($this->context->action->id,0,3)=='sms'?'active':''?>">
                    <a href="<?=AdminFunc::adminUrl('manage/sms')?>">
                        手机短信
                    </a>
                </li>
                <li class="<?=$this->context->id=='manage' && $this->context->action->id=='verify-code'?'active':''?>">
                    <a href="<?=AdminFunc::adminUrl('manage/verify-code')?>">
                        验证码
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-single">
            <a href="<?=AdminFunc::adminUrl('site/logout')?>">
                <span class="menu-icon glyphicon glyphicon-log-out"></span>
                退出
            </a>
        </li>
    </ul>
</div>
