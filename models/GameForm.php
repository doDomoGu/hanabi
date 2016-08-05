<?php

namespace app\models;

use yii\base\Model;

class GameForm extends Model
{
    public $title;
    public $password;
    public $player_1;
    public $player_2;
    public $create_time;
    public $status;

    public function attributeLabels(){
        return [
            'title' => '房间名',
            'password' => '密码',
            'player_1' => '玩家1',
            'player_2' => '玩家2',
            'create_time' => '创建时间',
            'status' => '状态',
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['player_1', 'player_2','status'], 'integer'],
            [[ 'password','create_time'], 'safe'],
        ];
    }


}
