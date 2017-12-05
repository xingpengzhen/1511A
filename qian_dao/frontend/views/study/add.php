<?php
use yii\helpers\Html;
use yii\Widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin();?>
<?= $form->field($model,'name')?>
<?php $form->end()?>