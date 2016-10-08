<?php

namespace app\models;

use yii\base\Model;

class RoomForm extends Model
{
    public $title;
    public $password;
    public $player_1;
    public $player_2;
    public $modify_time;
    public $status;

    public function attributeLabels(){
        return [
            'title' => '房间名',
            'password' => '密码',
            'player_1' => '玩家1',
            'player_2' => '玩家2',
            'modify_time' => '变更时间',
            'status' => '状态',
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['player_1', 'player_2','status'], 'integer'],
            [[ 'password','modify_time'], 'safe'],
        ];
    }


}
