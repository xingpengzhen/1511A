<?php
namespace backend\controllers;

use app\models\Demo;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

class RegisterController extends Controller{

    public $enableCsrfValidation = false;
    public function actionAdd(){
        return $this->render('register.html');
    }
    public function actionAdd_do(){
        if(!$_POST){
            return $this->render('register_2.html');
        }else{
            $data = Yii::$app->request->post();
            return $this->render('register_2.html',['data'=>$data]);
        }

    }
    public function actionAdd_two(){
        $data = Yii::$app->request->post();
        $arr = Yii::$app->db->createCommand('select * from r_hobby')->queryAll();
        return $this->render('register_3.html',[
            'data'=>$data,
            'arr' =>$arr
        ]);
    }
    public function actionInsert(){
        $data = Yii::$app->request->post();
        $res = Yii::$app->db->createCommand()->insert('register',$data)->execute();
        if($res){
            echo "<a href='?r=register/add'>添加成功</a>";
        }else{
            echo "<a href='?r=register/add'>添加失败</a>";
        }
    }
}