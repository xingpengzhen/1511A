<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?= Url::toRoute(['study/add'])?>"><?= Html::button('添加',['class'=>'button'])?></a>

<table border="1">
	<tr>
		<td>ID</td>
		<td>姓名</td>
		<td>年龄</td>
		<td>性别</td>
	</tr>
<?php foreach($list as $v):?>
	<tr>
		<?= Html::tag('td', Html::encode($v['id']),['class' => 'id']) ?>
		<?= Html::tag('td', Html::encode($v['name']), ['class' => 'username']) ?>
		<?= Html::tag('td', Html::encode($v['age']), ['class' => 'age']) ?>
		<?= Html::tag('td', Html::encode($v['sex']), ['class' => 'sex']) ?>
	</tr>
<?php endforeach;?>
</table>