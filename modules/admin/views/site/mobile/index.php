<?php
    use app\models\User;
    use app\models\Room;
    use app\models\Game;
    use app\models\Record;

    $this->title = '仪表盘';

    $user_count = User::find()->where(['status'=>User::STATUS_ENABLE])->count();

    $room_count = Room::find()->where(['in','status',Room::$status_normal])->count();

    $game_count = Game::find()->count();

    $record_count = Record::find()->count();
?>

<div class="row">
    <div class="col-md-6">
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="well">
                <div class="value"><?=$user_count?></div>
                <div class="title">注册玩家</div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="well">
                <div class="value"><?=$room_count?></div>
                <div class="title">正在游玩的房间</div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="well">
                <div class="value"><?=$game_count?></div>
                <div class="title">历史游戏总局数</div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="well">
                <div class="value"><?=$record_count?></div>
                <div class="title">历史游戏操作数</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
    </div>
</div>