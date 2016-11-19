<?php

namespace app\modules\admin\controllers;


use app\models\GlobalConfig;
use app\models\Sms;
use app\models\User;
use app\models\UserHistory;
use app\models\VerifyCode;
use app\modules\admin\components\AdminFunc;
use app\modules\admin\models\GlobalConfigForm;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

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


    //检测globalConfig配置项 保持数量一致
    public function actionGlobalConfigCheckUpdate(){
        $keyListTrue = GlobalConfig::keyList(); //模型中配置列表
        $keyListExist = [];//数据库中配置列表
        $list = GlobalConfig::find()->all();
        foreach($list as $l){
            $key = $l->name;
            //删除多余的配置项
            if(!in_array($key,array_keys($keyListTrue)))
                $l->delete();

            $keyListExist[] = $key;
        }
        //遍历keyListTrue
        foreach ($keyListTrue as $k=>$v){
            //如果数据库中配置不存在 就添加
            if(!in_array($k,$keyListExist)){
                $gc = new GlobalConfig();
                $gc->name = $k;
                $gc->value = $v[0];
                $gc->title = $v[1];
                $gc->save();
            }
        }

        return $this->redirect(AdminFunc::adminUrl('manage/global-config'));
    }

    public function actionUserHistory()
    {
        $searchItems = [
            'controller'=>UserHistory::getValues('controller'),
            'action'=>UserHistory::getValues('action'),
            'request_method'=>UserHistory::getValues('request_method'),
            'response'=>UserHistory::getValues('response'),
        ];


        $search = [
            'controller' => false,
            'action' => false,
            'request_method' => false,
            'response' => false
        ];
        $searchPost = Yii::$app->request->post('search',false);

        $query = UserHistory::find();
        if($searchPost){
            $search = ArrayHelper::merge($search,$searchPost);
        }
        foreach($search as $k=>$s){
            if(in_array($k,['23232'])){
                if($s!='')
                    $query->andWhere(['like',$k,$s]);
            }else if(in_array($k,['controller','action','request_method','response'])){
                if($s!='' && $s!==false)
                    $query->andWhere([$k=>$s]);
            }/*else if(in_array($k,['position_id'])){
                if($s!==''){
                    $arr = ArrayHelper::merge([$s],PositionFunc::getAllChildrenIds($s));
                    $list->andWhere(['in',$k,$arr]);
                }

            }*/
        }


        /*$count = $list->count();*/
        /*$pageSize = 20;
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' => $pageSize,'pageSizeParam'=>false]);*/


        //$query = UserHistory::find();



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
        $params['search'] = $search;
        $params['searchItems'] = $searchItems;

        $viewName = $this->isMobile?'user-history/mobile/list':'user-history/list';

        return $this->render($viewName,$params);
    }


}
