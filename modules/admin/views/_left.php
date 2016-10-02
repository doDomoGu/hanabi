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
                    <i class="fa fa-home"></i><span>后台首页</span>
                </a>
            </li>
            <li class="menu-list">
                <a href="">
                    <i class="fa fa-laptop"></i> <span>Layouts</span>
                </a>
                <ul class="sub-menu-list">
                    <li><a href="blank_page.html"> Blank Page</a></li>
                    <li><a href="boxed_view.html"> Boxed Page</a></li>
                    <li><a href="leftmenu_collapsed_view.html"> Sidebar Collapsed</a></li>
                    <li><a href="horizontal_menu.html"> Horizontal Menu</a></li>
                </ul>
            </li>
            <li <?=$this->context->id=='user'?'class="active"':''?>>
                <a href="<?=AdminFunc::adminUrl('user')?>">
                    <i class="fa fa-users"></i><span>玩家</span>
                </a>
            </li>
        </ul>
        <!--sidebar nav end-->

    </div>
</div>
<!-- left side end-->