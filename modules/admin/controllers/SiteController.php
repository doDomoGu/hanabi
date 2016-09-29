<?php

namespace app\modules\admin\controllers;



/**
 * Default controller for the `admin` module
 */
class SiteController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'main';
    public function actionIndex()
    {
        return $this->render('index');
    }
}
