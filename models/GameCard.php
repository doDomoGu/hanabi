<?php

namespace app\models;

use Yii;
class GameCard extends \yii\db\ActiveRecord
{
    const TYPE_IN_PLAYER = 1;
    const TYPE_IN_LIBRARY = 2;
    const TYPE_ON_TABLE = 3;
    const TYPE_IN_DISCARD = 4;

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
                $insertArr[] = [$game_id,self::TYPE_IN_LIBRARY,0,$c[0],$c[1],$ord,1];
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

    //摸一张牌
    public static function drawCard($game_id,$player){
        //统计牌的总数 应该为50张
        $count = self::find()->where(['game_id'=>$game_id,'status'=>1])->count();
        if($count==50){
            $card = self::find()->where(['game_id'=>$game_id,'type'=>self::TYPE_IN_LIBRARY,'status'=>1])->orderBy('ord asc')->one();
            if($card){
                //查找玩家手上排序最大的牌，确定新模的牌的序号 ord
                $playerCard = self::find()->where(['game_id'=>$game_id,'type'=>self::TYPE_IN_PLAYER,'player'=>$player,'status'=>1])->orderBy('ord desc')->one();
                if($playerCard){
                    $ord = $playerCard->ord+1;
                }else{
                    $ord = 0;
                }
                $card->type = self::TYPE_IN_PLAYER;
                $card->player = $player;
                $card->ord = $ord;
                $card->save();
            }else{
                echo 'no card to draw';
            }
        }else{
            echo 'game card num wrong';
        }
    }

    //交换手牌顺序
    public static function changePlayerCardOrd($game_id,$player,$cardId1,$cardId2){
        $card1 = self::find()->where(['game_id'=>$game_id,'type'=>self::TYPE_IN_PLAYER,'player'=>$player,'id'=>$cardId1,'status'=>1])->one();
        $card2 = self::find()->where(['game_id'=>$game_id,'type'=>self::TYPE_IN_PLAYER,'player'=>$player,'id'=>$cardId2,'status'=>1])->one();
        if($card1 && $card2){
            $card1->ord = $card2->ord;
            $card2->ord = $card1->ord;
            $card1->save();
            $card2->save();
        }else{
            echo 'card info wrong';
        }
    }


    //获取牌库/手牌 等信息
    public static function getCardInfo($game_id){
        $cardInfo = [
            'player_1'=>[],
            'player_2'=>[],
            'library'=>[],
            'table'=>[],
            'discard'=>[],
        ];
        $gameCard = self::find()->where(['game_id'=>$game_id,'status'=>1])->orderBy('ord asc')->all();
        if(count($gameCard)==50){
            foreach($gameCard as $gc){
                $temp = ['id'=>$gc->id,'color'=>$gc->color,'num'=>$gc->num];
                if($gc->type==self::TYPE_IN_PLAYER){
                    if($gc->player==1){
                        $cardInfo['player_1'][]=$temp;
                    }elseif($gc->player==2){
                        $cardInfo['player_2'][]=$temp;
                    }
                }elseif($gc->type==self::TYPE_IN_LIBRARY){
                    $cardInfo['library'][]=$temp;
                }elseif($gc->type==self::TYPE_ON_TABLE){
                    $cardInfo['table'][]=$temp;
                }elseif($gc->type==self::TYPE_IN_DISCARD){
                    $cardInfo['discard'][]=$temp;
                }
            }
        }
        return $cardInfo;
    }

    //获取当前应插入弃牌堆的ord数值，即当前弃牌堆最小排序的数值减1，没有则为49
    public static function getInsertDiscardOrd($game_id){
        $lastDiscardCard = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_DISCARD,'status'=>1])->orderBy('ord asc')->one();
        if($lastDiscardCard){
            $ord = $lastDiscardCard->ord - 1;
        }else{
            $ord = 49;
        }
        return $ord;
    }

    //整理手牌排序 （当弃牌或者打出手牌后，进行操作）
    public static function sortCardOrdInPlayer($game_id,$player){
        $cards = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_IN_PLAYER,'player'=>$player,'status'=>1])->orderBy('ord asc')->all();
        $i=0;
        foreach($cards as $c){
            $c->ord = $i;
            $c->save();
            $i++;
        }
    }

    //获取桌面上成功燃放的烟花 卡牌
    public static function getCardsTopOnTable($game_id){
        $cardsOnTable = [
            [0,0,0,0,0],
            [0,0,0,0,0],
            [0,0,0,0,0],
            [0,0,0,0,0],
            [0,0,0,0,0]
        ];
        $cards = GameCard::find()->where(['game_id'=>$game_id,'type'=>GameCard::TYPE_ON_TABLE,'status'=>1])->all();

        foreach($cards as $c){
            $k1=$c->color;
            $k2=Card::$numbers[$c->num] - 1;
            $cardsOnTable[$k1][$k2] = 1;
        }

        $verify = true;//验证卡牌 ，按数字顺序
        $cardsTop = [0,0,0,0,0]; //每种颜色的最大数值
        foreach($cardsOnTable as $k1 => $row){
            $count = 0;
            $top = 0;
            foreach($row as $k2=>$r){
                if($r==1){
                    $count++;
                    $top = $k2+1;
                }
            }
            if($count==$top){
                $cardsTop[$k1] = $top;
            }else{
                $verify=false;
            }
        }

        if($verify){
            return $cardsTop;
        }else{
            return false;
        }

    }
}