<?php
    app\assets\AppAsset::addCssFile($this,'css/main/site/index.css');
?>
<div class="well page-head">
    <div class="head-left">
        <h2>这是一个可以在线玩卡牌游戏【花火】的网站</h2>
        <div class="btn-area">
            <span>不懂游戏规则？</span><a class="btn btn-primary" href="/site/rule" target="_blank">查看游戏规则</a>
        </div>
        <div class="btn-area">
            <span>有账号？立即</span><a class="btn btn-success" href="/site/login">登录</a>
        </div>
        <div class="btn-area">
            <span>没有账号？</span><a class="btn btn-danger" href="/site/register">免费注册</a>
        </div>

    </div>
    <div class="head-right">
        <img src="/images/p1.jpg" />
    </div>
</div>
