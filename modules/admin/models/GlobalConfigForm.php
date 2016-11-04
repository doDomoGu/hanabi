<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\models\GlobalConfig;
/**
 * ContactForm is the model behind the contact form.
 */
class GlobalConfigForm extends Model
{
    public $name;
    public $value;
    public $title;


    /*public function scenarios()
    {
        $allAttr = self::attributes();
        return [
            GLobalConfig::SCENARIO_ADD => $allAttr,
            GlobalConfig::SCENARIO_EDIT => $allAttr,
        ];
    }*/

    public function rules()
    {
        return [
            [['name','value'], 'required','on'=>[Globalconfig::SCENARIO_ADD,Globalconfig::SCENARIO_EDIT]],
            ['name','unique','targetClass'=>'app\models\GlobalConfig','message'=>'这个名称已被占用','on'=>GlobalConfig::SCENARIO_ADD],
            [['title'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'value' => '值',
            'title' => '说明',
        ];
    }


}
