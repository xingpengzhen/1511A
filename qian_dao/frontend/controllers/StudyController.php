<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Study;
use frontend\models\user;

class StudyController extends Controller{
	public function actionIndex(){
		$model = new Study();
		$model = new user();
		$list = $model->find()->asArray()->all();
		return $this->render('index',['list'=>$list]);
	}

	public function actionAdd(){
		$model = new Study();
		if($model->load(Yii::$app->request->post()) && $model->validate()){
			var_dump(Yii::$app->request->post());die;
		}
		else{
			return $this->render('add',['model'=>$model]);
		}
	}
}