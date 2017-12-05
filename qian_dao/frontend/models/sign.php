<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Sign extends ActiveRecord{
	public function rules(){
		return [
			[['name','value','leng'],'required','message'=>'{attribute}不能为空!'],
		];		
	}

	public function attributeLabels(){
		return [
		   'name'=>'字段名',
		   'value'=>'请输入字段默认值',
		   'leng'=>'请选择填写长度范围',
		];
	} 
}