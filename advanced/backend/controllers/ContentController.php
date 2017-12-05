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
class ContentController extends Controller
{
        public $enableCsrfValidation = false;
        public function index(){
            return $this->render('index');
        }
        public function add(){
            $data = $_POST;
            $res = Yii::$app->db->createCommand()->insert('content',$data)->execute();
            if($res){
                echo "<a href='?r=content/show'>进入展示</a>";
            }
        }
        public function show(){
            $arr = Yii::$app->db->createCommand('select * from content')->queryAll();
            return $this->render('show',[
                'arr'=>$arr
            ]);
        }
}