<?php
namespace backend\controllers;

use app\models\Content;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;


/**
 * Site controller
 */
class ShowController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionLogin(){
        return $this->render('login.html');
    }
    public function actionLogin_do(){
        $data = $_POST;
        $username = $data["username"];
        $password = $data['password'];
        $arr = Yii::$app->db->createCommand('select * from login WHERE username ='."'$username'")->queryOne();
        if($arr){
            echo "<a href='?r=show/login'>用户名输入错误</a>";
           if($arr['password'] == $password){
               Yii::$app->response->redirect('?r=show/add&username='.$username, 301)->send();
           }else{
               echo "<a href='?r=show/login'>密码输入错误</a>";
           }
        }
    }
    public function actionAdd(){
        $username = $_GET['username'];
        $data = $_POST;
        if(!$_POST){

        }else{
            Yii::$app->db->createCommand()->insert('content',$data)->execute();
        }
        //实例化数据类
        $content = new Content();
        $pagination = new pagination([
            'defaultPageSize'=>5,
            'totalCount'=>$content->find()->count()
        ]);
//        var_dump($pagination);die;
        $articles = $content->find()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
//        print_r($pagination);die;
//        $good = Yii::$app->db->createCommand('select * from content')->queryAll();
        return $this->render('add.html',['good'=>$articles,'page'=>$pagination,'username'=>$username]);
    }
    public function actionDel(){
        $id = $_GET['id'];
        $username = $_GET['username'];
        $res = Yii::$app->db->createCommand()->delete('content',['id'=>$id])->execute();
        if($res){
            Yii::$app->response->redirect('?r=show/add&username='.$username, 301)->send();
        }
    }
    public function actionUpd(){
        $id = $_GET['id'];
        $username = $_GET['username'];
        $arr = Yii::$app->db->createCommand('select * from content where id ='.$id)->queryOne();
        return $this->render('upd.html',['arr'=>$arr,'username'=>$username]);
    }
    public function actionUpd_do(){
        $data = $_POST;
        $id = $_POST['id'];
        $username = $_GET['username'];
        $res = Yii::$app->db->createCommand()->update('content',$data,'id='.$id)->execute();
        if($res){
            Yii::$app->response->redirect('?r=show/add&username='.$username, 301)->send();
        }
    }
    public function actionShow(){
        $id = $_GET['id'];
        $username = $_GET['username'];
        $arr = Yii::$app->db->createCommand('select * from content where id ='.$id)->queryOne();
        return $this->render('show.html',['arr'=>$arr,'username'=>$username]);
    }
}