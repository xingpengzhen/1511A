<?php
use yii\helpers\Html;
use yii\Widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['check/index'],'method'=>'post',]);?>

<?= $form->field($model,'name')?>
<?= $form->field($model,'pwd')?>
<div>
	<?= Html::submitButton('submit') ?>
</div>
<?php $form->end()?>