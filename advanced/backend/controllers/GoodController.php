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
class GoodController extends Controller{

    public $enableCsrfValidation = false;
    public function index(){
        $this->render('index');
    }
    public function add(){
        $data = $_POST;
        $res = Yii::$app->db->createCommand()->insert('content',$data)->execute();
    }
}