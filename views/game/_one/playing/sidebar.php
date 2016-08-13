游戏中


<a id="end_btn" class="btn btn-primary <?=$isMaster?'':'hidden'?>">结束游戏</a>

<div class="record_list">
    <?php if(!empty($record_list)):?>
    <ul>
        <?php foreach($record_list as $l):?>
        <li>
            第<?=$l->round?>回合：<?=$l->content?> (<?=$l->add_time?>)
        </li>
        <?php endforeach?>
    </ul>
    <?php endif;?>
</div>