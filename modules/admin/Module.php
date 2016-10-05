<?php

namespace app\modules\admin;

use Yii;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = 'main';
    public $defaultRoute = 'site';

    public function init()
    {
        parent::init();

        $this->setLayoutPath($this->viewPath);
        Yii::$app->errorHandler->errorAction = 'admin/site/error';
        $this->setComponents([
            'adminUser' => [
                'class'=>'yii\web\user',
                'identityClass' => 'app\modules\admin\models\AdminUserIdentity',
                'enableAutoLogin' => true,
                'loginUrl'=>'/admin/site/login'
            ],
            
        ]);

    }
}
