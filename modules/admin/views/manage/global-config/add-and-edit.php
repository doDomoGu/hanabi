<?php
    use yii\bootstrap\Html;
    use yii\bootstrap\ActiveForm;
    use app\modules\admin\components\AdminFunc;

    $this->title = $titlePrefix.'参数设置';

?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <?=$this->title?>
    </header>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'id' => 'global-config-add-form',
            'options' => ['class' => 'form-horizontal'],
            //'enableAjaxValidation'=>true,
            'fieldConfig' => [
                /*'template' => "{label}\n<div class=\"col-lg-10 \">{input}{hint}\n{error}</div>",*/
                'template' => "{label}\n<div class=\"col-lg-10 \"><div class='col-lg-6'>{input}</div><div class='col-lg-6'>{hint}</div><div class='col-lg-12'>{error}</div></div>",
                'labelOptions' => ['class' => 'col-lg-2 col-sm-2 control-label'],
                //'inputOptions' => ['class' => 'col-lg-6'],
                //'hintOptions' => ['class' => 'col-lg-6']
            ],
        ]); ?>
        <?php if($model->scenario==\app\models\GlobalConfig::SCENARIO_ADD):?>
            <?=$form->field($model, 'name')->textInput()?>
        <?php else:?>
            <?=$form->field($model, 'name',['template'=>"{label}\n<div class=\"col-lg-10 \"><div class='col-lg-12'>{hint}</div><div class='col-lg-12'>{error}</div>{input}</div>"])->input('hidden')->hint($model->name)?>
        <?php endif;?>

        <?=$form->field($model, 'value')->textArea(['rows'=>2])?>

        <?=$form->field($model, 'title')->textArea(['rows'=>2])?>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <div class="col-lg-6">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
                <?= Html::a('返回',AdminFunc::adminUrl('manage/global-config'),['class' => 'btn btn-default', 'name' => 'return-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</section>