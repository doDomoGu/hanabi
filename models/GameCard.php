<?php

namespace app\models;

use Yii;
class GameCard extends \yii\db\ActiveRecord
{
    /*const STATUS_DELETED = 0;
    const STATUS_PREPARING = 1;
    const STATUS_PLAYING = 2;

    public static $status_normal = [self::STATUS_PREPARING,self::STATUS_PLAYING];*/

    public function attributeLabels(){
        return [
            'game_id' => '游戏ID',
            'type' => '类型',   //1.牌在玩家手上,2.牌在牌库,3.牌在桌面(燃放成功),4.牌在弃牌堆
            'player' => '玩家序号', //只有type=1的时候用到，表示player_1或player_2手上
            'ord' => '牌的顺序',  //根据type值不同含义不同,1.从左至右的顺序，2.从上至下，表示数值越小越在排序上面，被先摸到，3.无,4.从下至上，表示数值越小是越早弃掉的牌
            'color' => '牌的颜色', //根据card模型中colors
            'num' => '牌的数字', //根据card模型中numbers
            'status'=> '状态'  //0：失效(开始新的一局，设置失效),1:有效
        ];
    }


    public function rules()
    {
        return [
            [['game_id','type','color','num'], 'required'],
            [['game_id','type', 'player','ord','status','color','num'], 'integer'],

        ];
    }

/*CREATE TABLE `game_card` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`game_id` int(11) unsigned NOT NULL,
`type` tinyint(1) NOT NULL DEFAULT '0',
`player` tinyint(1) NOT NULL DEFAULT '0',
`color` tinyint(1) NOT NULL DEFAULT '0',
`num` tinyint(1) NOT NULL DEFAULT '0',
`ord` tinyint(4) NOT NULL DEFAULT '0',
`status` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/



    //初始化牌库
    public static function initLibrary($game_id){
        $exit = self::find()->where(['game_id'=>$game_id,'status'=>1])->one();
        if(!$exit){
            $cardArr = [];
            foreach(Card::$colors as $k=>$v){
                foreach(Card::$numbers as $k2=>$v2){
                    $cardArr[] = [$k,$k2];
                }
            }
            shuffle($cardArr);

            $insertArr = [];
            $ord = 0;
            foreach($cardArr as $c){
                $insertArr[] = [$game_id,2,0,$c[0],$c[1],$ord,1];
                $ord++;
            }

            Yii::$app->db->createCommand()->batchInsert(
                self::tableName(),
                ['game_id','type','player','color','num','ord','status'],
                $insertArr
            )->execute();
        }else{
            echo 'game card exist';exit;
        }
    }
}