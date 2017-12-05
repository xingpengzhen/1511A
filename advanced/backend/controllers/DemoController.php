<?php
namespace backend\controllers;

use app\models\Demo;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

class DemoController extends Controller{

    public $enableCsrfValidation = false;
    public function actionAdd(){
        $arr = Yii::$app->db->createCommand('select * from d_type')->queryAll();
        $res = Yii::$app->db->createCommand('select * from d_verify')->queryAll();
       return $this->render('add.html',[
           'arr'=>$arr,
           'res'=>$res
       ]);
    }
    public function actionAdd_do(){
        $data = Yii::$app->request->post();
        $data['option'] = $data['option'][0].'-'.$data['option'][1];
        if($data['length'][0] == ""){
            $data['length'] = '无';
        }else{
            $data['length'] = $data['length'][0].'-'.$data['length'][1];
        }
        $res = Yii::$app->db->createCommand()->insert('demo',$data)->execute();
        if($res){
            Yii::$app->response->redirect('?r=demo/show', 301)->send();
        }else{
            Yii::$app->response->redirect('?r=demo/add', 301)->send();
        }
    }
    public function actionShow(){
        $arr = Yii::$app->db->createCommand(
            'select * from'.
            '(demo left join d_type on demo.t_id=d_type.d_id)'.
            'left join d_verify on demo.v_id=d_verify.d_id')->queryAll();
        return $this->render('index.html',[
            'arr'=>$arr
        ]);
    }
    public function actionDel(){
        $id = Yii::$app->request->get('id');
//        var_dump($id);die;
        $res = Yii::$app->db->createCommand()->delete('demo',['id'=>$id])->execute();
        if($res){
            Yii::$app->response->redirect('?r=demo/show', 301)->send();
        }else{
            Yii::$app->response->redirect('?r=demo/show', 301)->send();
        }
    }
    public function actionUpd(){
        $id = Yii::$app->request->get('id');
        $arr = Yii::$app->db->createCommand(
            'select * from'.
            '(demo inner join d_type on demo.t_id=d_type.d_id)'.
            'inner join d_verify on demo.v_id=d_verify.d_id where id ='.$id)->queryOne();
        $reg = Yii::$app->db->createCommand('select * from d_type')->queryAll();
        $res = Yii::$app->db->createCommand('select * from d_verify')->queryAll();
        $arr['option'] = explode('-',$arr['option']);
        $arr['length'] = explode('-',$arr['length']);
//        var_dump($arr['option']);die;
        return $this->render('upd.html',[
            'arr'=>$arr,
            'reg'=>$reg,
            'res'=>$res
        ]);
    }
    public function actionUpd_do(){
        $data = Yii::$app->request->post();
        $id = Yii::$app->request->post('id');
        $data['option'] = $data['option'][0].'-'.$data['option'][1];
        if($data['length'][0] == ""){
            $data['length'] = '无';
        }else{
            $data['length'] = $data['length'][0].'-'.$data['length'][1];
        }
        $res = Yii::$app->db->createCommand()->update('demo',$data,['id'=>$id])->execute();
        if($res){
            Yii::$app->response->redirect('?r=demo/show', 301)->send();
        }else{
            Yii::$app->response->redirect('?r=demo/show', 301)->send();
        }
    }
}