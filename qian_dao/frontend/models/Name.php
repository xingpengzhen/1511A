<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Name extends ActiveRecord{
	public function rules(){
		return [
			[['name','pwd'],'required','message'=>'{attribute}不能为空!'],
		];		
	}

	public function attributeLabels(){
		return [
		   'name'=>'用户名',
		   'pwd'=>'密码',
		];
	} 
}