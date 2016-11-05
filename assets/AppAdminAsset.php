<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAdminAsset extends AssetBundle
{
    //public $sourcePath = '@webroot/adminAssets';
    /*public $jsOptions = [
        'basePath'=>'@webroot/adminAssets',
    ];*/
    public $basePath = '@webroot/adminAssets';
    public $baseUrl = '@web/adminAssets';
    public $css = [
        'css/admin.css',
    ];
    public $js = [
        'js/side-nav.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //导入当前页的功能js文件，注意加载顺序，这个应该最后调用  文件路径相对@web即可
    public static function addJsFile($view, $jsfile) {
        $view->registerJsFile('@web/adminAssets/'.$jsfile, ['depends' => 'app\assets\AppAdminAsset']);
    }

    //导入当前页的功能js代码，注意加载顺序，这个应该最后调用  文件路径相对@web即可
    public static function addJs($view, $jsString) {
        $view->registerJs($jsString, ['depends' => 'app\assets\AppAdminAsset']);
    }

    //导入当前页的样式css文件，注意加载顺序，这个应该最后调用  文件路径相对@web即可
    public static function addCssFile($view, $cssfile) {
        $view->registerCssFile('@web/adminAssets/'.$cssfile, ['depends' => 'app\assets\AppAdminAsset']);
    }
}
