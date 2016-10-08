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
        <!--statistics start-->
        <div class="row state-overview">
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="panel purple">
                    <div class="symbol">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="state-value">
                        <div class="value"><?=$user_count?></div>
                        <div class="title">注册玩家</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="panel red">
                    <div class="symbol">
                        <i class="fa fa-gamepad"></i>
                    </div>
                    <div class="state-value">
                        <div class="value"><?=$room_count?></div>
                        <div class="title">正在游玩的房间</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row state-overview">
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="panel blue">
                    <div class="symbol">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="state-value">
                        <div class="value"><?=$game_count?></div>
                        <div class="title">历史游戏总局数</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="panel green">
                    <div class="symbol">
                        <i class="fa fa-eye"></i>
                    </div>
                    <div class="state-value">
                        <div class="value"><?=$record_count?></div>
                        <div class="title">历史游戏操作数</div>
                    </div>
                </div>
            </div>
        </div>
        <!--statistics end-->
    </div>
    <div class="col-md-6">
        <!--more statistics box start-->
        <!--<div class="panel deep-purple-box">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7 col-sm-7 col-xs-7">
                        <div id="graph-donut" class="revenue-graph"><svg height="220" version="1.1" width="443" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; top: -0.5px;"><desc>Created with Raphaël 2.1.2</desc><defs/><path style="opacity: 1;" fill="none" stroke="#4acacb" d="M221.5,176.66666666666669A66.66666666666667,66.66666666666667,0,0,0,263.07879551323236,57.88811835950217" stroke-width="2" opacity="1"/><path style="" fill="#4acacb" stroke="none" d="M221.5,179.66666666666669A69.66666666666667,69.66666666666667,0,0,0,264.9498413113278,55.54308368567977L283.8681932698485,31.832177539253266A100,100,0,0,1,221.5,210Z" stroke-width="3"/><path style="opacity: 0;" fill="none" stroke="#6a8bc0" d="M263.07879551323236,57.88811835950217A66.66666666666667,66.66666666666667,0,0,0,159.45101113025743,85.6203481426209" stroke-width="2" opacity="0"/><path style="" fill="#6a8bc0" stroke="none" d="M264.9498413113278,55.54308368567977A69.66666666666667,69.66666666666667,0,0,0,156.65880663111903,84.52326380903884L133.08019086061685,75.25899610323478A95,95,0,0,1,280.7497836063561,35.7405686622906Z" stroke-width="3"/><path style="opacity: 0;" fill="none" stroke="#5ab6df" d="M159.45101113025743,85.6203481426209A66.66666666666667,66.66666666666667,0,0,0,179.91301928453285,162.10534981569367" stroke-width="2" opacity="0"/><path style="" fill="#5ab6df" stroke="none" d="M156.65880663111903,84.52326380903884A69.66666666666667,69.66666666666667,0,0,0,178.0416051523368,164.45009055739988L162.2385524804593,184.25012348736345A95,95,0,0,1,133.08019086061685,75.25899610323478Z" stroke-width="3"/><path style="opacity: 0;" fill="none" stroke="#fe8676" d="M179.91301928453285,162.10534981569367A66.66666666666667,66.66666666666667,0,0,0,221.47905604932066,176.66666337679857" stroke-width="2" opacity="0"/><path style="" fill="#fe8676" stroke="none" d="M178.0416051523368,164.45009055739988A69.66666666666667,69.66666666666667,0,0,0,221.4781135715401,179.6666632287545L221.47015487028193,204.99999531193794A95,95,0,0,1,162.2385524804593,184.25012348736345Z" stroke-width="3"/><text style="text-anchor: middle; font: 800 15px &quot;Arial&quot;;" x="221.5" y="100" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" font-size="15px" font-weight="800" transform="matrix(1.4458,0,0,1.4458,-98.9639,-48.5904)" stroke-width="0.6916666666666665"><tspan dy="5">New Visit</tspan></text><text style="text-anchor: middle; font: 14px &quot;Arial&quot;;" x="221.5" y="120" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" font-size="14px" transform="matrix(1.3889,0,0,1.3889,-86.3333,-43.5556)" stroke-width="0.7199999999999999"><tspan dy="5">at least 70%</tspan></text></svg></div>

                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <ul class="bar-legend">
                            <li><span class="blue"></span> Open rate</li>
                            <li><span class="green"></span> Click rate</li>
                            <li><span class="purple"></span> Share rate</li>
                            <li><span class="red"></span> Unsubscribed rate</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>-->
        <!--more statistics box end-->
    </div>
</div>