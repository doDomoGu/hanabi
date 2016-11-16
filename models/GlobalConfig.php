<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "globalconfig".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $title
 * @property integer $configable
 */
class GlobalConfig extends \yii\db\ActiveRecord
{
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_ADD = 'add';
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'globalconfig';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','value'], 'required','on'=>[GlobalConfig::SCENARIO_ADD,GlobalConfig::SCENARIO_EDIT]],
            ['name','unique','targetClass'=>'app\models\GlobalConfig'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'title' => 'Title',
            'configable' => 'Configable',
        ];
    }

    public static function keyList(){
        return [
            'send_sms_flag'=> [0,'是否发送短信的开关,0:关闭,1:开启'],
            /*'test1' => ['sddds','测试配置1111'],
            'test2' => ['vxcvvxc','测试配置222'],*/
        ];

    }

    public static function getConfig($name){
        if($name){
            $gc = self::find()->where(['name'=>$name])->one();
            if($gc){
                return $gc->value;
            }
        }
        return false;
    }


}


/*CREATE TABLE `global_config` (
`id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `configable` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;*/