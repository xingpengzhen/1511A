<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class ChinaController extends Controller
{
        public function actionShow(){
            return $this->render('index.html');
        }
        public $enableCsrfValidation = false;
        public function actionAdd(){
            $data = $_POST;
            $arr = Yii::$app->db->createCommand()->insert('tel_b',$data)->execute();
            if($arr){
                Yii::$app->response->redirect('?r=china/html', 301)->send();
            }
        }
        public function actionSel(){
            $arr = Yii::$app->db->createCommand('select * from tel_b')->queryAll();
            return $this->render('sel.html',['arr'=>$arr]);
        }
}