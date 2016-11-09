<?php
    app\assets\AppAsset::addCssFile($this,'css/main/site/index.css');
?>
<div class="well well-sm page-head">
    <div class="col-lg-7 head-left">
        <h2>这是一个可以在线玩卡牌游戏【花火】的网站</h2>
        <div class="row btn-area">
            <div class="col-lg-4">
                <span>不懂游戏规则？</span>
            </div>
            <div class="col-lg-8">
                <a class="btn btn-primary" href="/site/rule" target="_blank">查看游戏规则</a>
            </div>
        </div>
        <div class="row btn-area">
            <div class="col-lg-4">
                <span>已有账号？</span>
            </div>
            <div class="col-lg-8">
                <a class="btn btn-success" href="/site/login">立即登录</a>
            </div>
        </div>
        <div class="row btn-area">
            <div class="col-lg-4">
                <span>没有账号？</span>
            </div>
            <div class="col-lg-8">
                <a class="btn btn-danger" href="/site/register">免费注册</a>
            </div>
        </div>

    </div>
    <div class="col-lg-5 head-right">
        <img width=100% src="/images/p1.jpg" />
    </div>
</div>
