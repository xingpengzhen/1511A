<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\Widgets\ActiveForm;
use yii\widgets\LinkPager;
?>

<?php $form = ActiveForm::begin(['action' => ['login/add'],'method'=>'post',]); ?>
<?= $form->field($content,'content')->textarea(['rows'=>3])?>
<?= Html::submitButton('提交', ['class'=>'btn btn-primary']) ?>
<?php $form->end()?>

<?php foreach($list as $v):?>
  <table border="1">
  	<tr>
  		<?= Html::tag('td',Html::encode($v['name'])) ?>
  		<?= Html::tag('td',Html::encode($v['content'])) ?>
  		<td><a href="<?= Url::toRoute(['login/del',['id'=>$v['id'],'name'=>$v['name']]])?>">删除</a></td>
  		<td><a href="<?= Url::toRoute(['login/up',['id'=>$v['id'],'name'=>$v['name']]])?>">修改</a></td>
  	</tr>

  </table>
<?php endforeach;?>
<?= LinkPager::widget(['pagination' => $pagination]) ?>
