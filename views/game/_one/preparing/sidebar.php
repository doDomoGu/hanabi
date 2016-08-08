<div id="btn_list">

    <a id="ready_btn" class="btn btn-primary <?=$isMaster?'hidden':''?>"><?=$game->player_2_ready==1?'取消准备':'准备'?></a>

    <a id="start_btn" class="btn btn-primary <?=$isMaster?'':'hidden'?> <?=$game->player_2_ready==1?'':'disabled'?>">开始</a>

    <a id="exit_btn" class="btn btn-warning pull-right">退出房间</a>
</div>