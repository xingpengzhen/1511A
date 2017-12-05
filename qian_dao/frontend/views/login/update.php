<?php
use yii\helpers\Html;
use yii\Widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['login/update','id'=>$list['id']],'method'=>'post',]); ?>
<?= $form->field($content, 'id')->hiddenInput(['value'=>$list['id']]) ?>
<?= $form->field($content,'content') ?>
<?= Html::submitButton('提交', ['class'=>'btn btn-primary']) ?>
<?php $form->end()?>