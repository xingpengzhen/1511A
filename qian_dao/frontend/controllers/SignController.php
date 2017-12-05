<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Sign;
// use yii\data\Pagination;

class SignController extends Controller{
     public function actionIndex(){
     	$sign = new sign();
     	$data = $sign->find()->asArray()->all();
     	return $this->render('index',['data'=>$data]);
     	// $this->redirect(array('/sign/index','data'=>$data));
     }

     public function actionAdd(){
     	$sign = new sign();
     	return $this->render('add',['sign'=>$sign]);
     }

     public function actionAdds(){
     	$sign = new sign();
     	$data = Yii::$app->request->post();
     	// var_dump($data);die;
     	$sign->name = $data['Sign']['name'];
     	$sign->value = $data['Sign']['value'];
     	$sign->stype = $data['stype'];
     	$sign->tian = $data['tian'];
     	$sign->yan = $data['yan'];
     	$sign->leng = implode($data['leng'], '-');
     	$res = $sign->insert();
     	if($res){
     		$this->redirect(array('/sign/index'));
     	}
     }

     public function actionUp(){
     	$id = Yii::$app->request->get();
     	$sign = new sign();
     	$data = $sign->find()->where(['id'=>$id[1]['id']])->asArray()->all();
     	return $this->render('up',['data'=>$data[0]]);
     }

     public function actionUpdate(){
     	$data = Yii::$app->request->post();
     	$sign['name'] = $data['name'];
     	$sign['value'] = $data['value'];
     	$sign['stype'] = $data['stype'];
     	$sign['tian'] = $data['tian'];
     	$sign['yan']= $data['yan'];
     	$sign['leng']= implode($data['leng'], '-');

     	$res = Yii::$app->db->createCommand()->update('sign',$sign, 'id=:id', array(':id' => $data['id']))->execute();
        if($res){
            $this->redirect(array('/sign/index'));
        }
     }

      public function actionDel(){
     	$id = Yii::$app->request->get();
     	$sign = new sign();
     	$res = Yii::$app->db->createCommand()->delete('sign',['id'=>$id[1]['id']])->execute();
		 if($res){
            $this->redirect(array('/sign/index'));
		 }
     }
}