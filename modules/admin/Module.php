<?php

namespace app\modules\admin;

use Yii;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = 'main';
    public $defaultRoute = 'site';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setLayoutPath($this->viewPath);

        // custom initialization code goes here
    }
}
