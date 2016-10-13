<?php
    use app\modules\admin\components\AdminFunc;
?>
<!-- left side start-->
<div class="left-side sticky-left-side">
    <!--logo and iconic logo start-->
    <div class="logo">
        <a href="<?=AdminFunc::adminUrl('/')?>"><img src="/adminAssets/adminEx/images/logo.png" alt=""></a>
    </div>

    <div class="logo-icon text-center">
        <a href="<?=AdminFunc::adminUrl('/')?>"><img src="/adminAssets/adminEx/images/logo_icon.png" alt=""></a>
    </div>
    <!--logo and iconic logo end-->

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <!--<div class="visible-xs hidden-sm hidden-md hidden-lg">
            111111
        </div>-->

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li <?=$this->context->id=='site'?'class="active"':''?>>
                <a href="<?=AdminFunc::adminUrl('/')?>">
                    <i class="fa fa-home"></i><span>仪表盘</span>
                </a>
            </li>

            <li <?=$this->context->id=='user'?'class="active"':''?>>
                <a href="<?=AdminFunc::adminUrl('user')?>">
                    <i class="fa fa-users"></i><span>玩家</span>
                </a>
            </li>
            <li <?=$this->context->id=='game'?'class="active"':''?>>
                <a href="<?=AdminFunc::adminUrl('game')?>">
                    <i class="fa fa-gamepad"></i><span>游戏</span>
                </a>
            </li>
            <li class="menu-list <?=$this->context->id=='manage'?'active':''?>">
                <a href="">
                    <i class="fa fa-laptop"></i> <span>网站管理</span>
                </a>
                <ul class="sub-menu-list">
                    <li class="<?=$this->context->id=='manage' && $this->context->action->id=='sms'?'active':''?>"><a href="<?=AdminFunc::adminUrl('manage/sms')?>">手机短信</a></li>
                    <li class="<?=$this->context->id=='manage' && $this->context->action->id=='verify-code'?'active':''?>"><a href="<?=AdminFunc::adminUrl('manage/verify-code')?>">验证码</a></li>
                    <!--<li><a href="boxed_view.html"> Boxed Page</a></li>
                    <li><a href="leftmenu_collapsed_view.html"> Sidebar Collapsed</a></li>
                    <li><a href="horizontal_menu.html"> Horizontal Menu</a></li>-->
                </ul>
            </li>
        </ul>
        <!--sidebar nav end-->

    </div>
</div>
<!-- left side end-->