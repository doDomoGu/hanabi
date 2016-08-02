<?php

namespace app\controllers;

use app\models\RoomForm;
use app\models\Room;
use Yii;


class RoomController extends BaseController
{

    public function actionIndex()
    {
        $list = Room::find()->where('player_1 > 0 and status in (1,2)')->all();
        $params['list'] = $list;
        return $this->render('index',$params);
    }

    public function actionCreate(){
        $model = new RoomForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $room = new Room();
            $room->attributes = $model->attributes;
            $room->password = $room->password!=''?md5($room->password):'';
            $room->player_1 = $this->user->id;
            $room->status = 1;
            $room->create_time = date('Y-m-d H:i:s');
            if($room->save()){
                echo 111;exit;
                return $this->redirect('/room');
            }else{
                return $this->redirect('/room');
            }
        }/*else{
            var_dump($model->errors);exit;
        }*/
        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
