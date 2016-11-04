<?php

namespace app\modules\admin\controllers;


use app\models\GlobalConfig;
use app\models\Sms;
use app\models\User;
use app\models\VerifyCode;
use app\modules\admin\components\AdminFunc;
use app\modules\admin\models\GlobalConfigForm;
use Yii;
use yii\data\Pagination;

class ManageController extends BaseController
{
    public $pageSize = 10;
    public function actionSms()
    {
        $list = Sms::find()->all();
        $params['list'] = $list;
        return $this->render('sms/index',$params);
    }

    public function actionVerifyCode()
    {
        $list = VerifyCode::find()->all();
        $params['list'] = $list;
        return $this->render('verify-code/index',$params);
    }

    public function actionGlobalConfig()
    {
        $query = GlobalConfig::find();
        $countQuery = clone $query;
        $pages = new Pagination();
        $pages->totalCount = $countQuery->count();
        $pages->pageSize = $this->pageSize;
        $list = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $params['pages']= $pages;
        $params['list'] = $list;

        return $this->render('global-config/list',$params);
    }


    public function actionGlobalConfigAddAndEdit(){
        $model = new GlobalConfigForm();
        $model->setScenario(GlobalConfig::SCENARIO_ADD);
        $id = Yii::$app->request->get('id',false);
        if($id){
            $globalConfigEdit = GlobalConfig::find()->where(['id'=>$id])->one();
            if($globalConfigEdit){
                $model->setScenario(GlobalConfig::SCENARIO_EDIT);
                $globalConfigEdit->setScenario(GlobalConfig::SCENARIO_EDIT);
            }
        }

        if(Yii::$app->request->post()){ //有post 开始进行验证 和 保存
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if($model->getScenario()==GlobalConfig::SCENARIO_ADD) {
                    //新建
                    $globalConfig = new GlobalConfig();
                    $globalConfig->setScenario(GlobalConfig::SCENARIO_ADD);
                    $globalConfig->attributes = $model->attributes;
                    $globalConfig->configable = 1;
                }else{
                    //编辑
                    $globalConfig = $globalConfigEdit;
                    $globalConfig->attributes = $model->attributes;
                }
                if($globalConfig->save()){
                    return $this->redirect(AdminFunc::adminUrl('manage/global-config'));
                }
            }
        }else{
            //没有post 如果是编辑 给model赋值
            if($model->scenario==GlobalConfig::SCENARIO_EDIT) {
                $model->attributes = $globalConfigEdit->attributes;
            }
        }


        $params['model'] = $model;
        $params['titlePrefix'] = $model->scenario==GlobalConfig::SCENARIO_ADD?'添加':'编辑';
        return $this->render('global-config/add-and-edit', $params);
    }

    /*public function actionDeleteGlobalConfig(){
        $id = Yii::$app->request->get('id',false);
        $gc = GlobalConfig::find()->where(['id'=>$id])->one();
        if($gc){
            $gc->delete();
        }
        return $this->redirect('/system/global-config');
    }*/


    //检测globalConfig 增加配置 初始化添加
    public function actionGlobalConfigCheckUpdate(){
        $keyList = GlobalConfig::keyList(); //配置列表
        $list = GlobalConfig::find()->all(); //存在的配置列表
        $exists = [];
        foreach($list as $l){
            $exists[] = $l->name;
        }
        foreach($keyList as $k=>$v){
            //配置不存在 新增
            if(!in_array($k,$exists)){
                $gc = new GlobalConfig();
                $gc->name = $k;
                $gc->value = $v[0];
                $gc->title = $v[1];
                $gc->save();
            }
        }

        return $this->redirect(AdminFunc::adminUrl('manage/global-config'));
    }


}
