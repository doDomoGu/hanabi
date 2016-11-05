<?php

namespace app\modules\admin\controllers;


use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $search = [
            'username' => '',
            'nickname' => '',
            'gender' => '',
            'mobile' => '',
            'status' => 1,
        ];
        $searchPost = Yii::$app->request->post('search',false);

        $list = User::find();
        if($searchPost){
            $search = ArrayHelper::merge($search,$searchPost);
        }

        foreach($search as $k=>$s){
            if(in_array($k,['username','nickname','mobile'])){
                if($s!='')
                    $list->andWhere(['like',$k,$s]);
            }else if(in_array($k,['status','gender'])){
                if($s!=='')
                    $list->andWhere([$k=>$s]);
            }/*else if(in_array($k,['position_id'])){
                if($s!==''){
                    $arr = ArrayHelper::merge([$s],PositionFunc::getAllChildrenIds($s));
                    $list->andWhere(['in',$k,$arr]);
                }

            }*/
        }
        $count = $list->count();
        $pageSize = 20;
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' => $pageSize,'pageSizeParam'=>false]);


        $list = $list
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id asc')
            ->all();
        $params['list'] = $list;
        $params['search'] = $search;
        $params['pages'] = $pages;

        return $this->render('index',$params);
    }


}
