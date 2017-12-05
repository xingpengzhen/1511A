<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Name;
use frontend\models\Content;
use app\models\Position;
use yii\data\Pagination;
use DfaFilter\SensitiveHelper;


class LoginController extends Controller{
	public function actionLogin(){
		$model = new name();
		return $this->render('login',['model'=>$model]);
	}
	public function actionIndex(){
		$model = new name();
		if($model->load(Yii::$app->request->post()) && $model->validate()){
			$list = $model->find()->asArray()->all();
            foreach($list as $v){
            	if($v['name'] == $model->name){
            		if($v['pwd'] == $model->pwd){       			
				        Yii::$app->session['name']= $model->name;
				        $name = Yii::$app->session['name'];
                        $this->redirect(array('/login/show','name'=>$name));
            		}
            		else{
			           return $this->render('login',['model'=>$model]);
		            }
            	}
            	else{
			        return $this->render('login',['model'=>$model]);
		        }
            }            
		}
	}


	public function actionAdd(){
		$content = new content();
		if($content->load(Yii::$app->request->post()) && $content->validate()){
		   //检测关键词
		   $list = Yii::$app->request->post();
		   $content->content = $list['Content']['content'];
		   $wordData = array(
						'察象蚂',
						'拆迁灭',
						'车牌隐',
						'成人电',
						'成人卡通'
						);
		   // $islegal = SensitiveHelper::init()->setTree($wordData)->islegal($con);
		   // // 获取内容中所有的敏感词
		   // $sensitiveWordGroup = SensitiveHelper::init()->setTree($wordData)->getBadWord($con);
		   // // 仅且获取一个敏感词
		   // $sensitiveWordGroup = SensitiveHelper::init()->setTree($wordData)->getBadWord($con, 1);
		   // 敏感词替换为***为例
		   $filterContent = SensitiveHelper::init()->setTree($wordData)->replace($content->content, '***');

		   $content->name = Yii::$app->session['name'];
		   $content->content = $filterContent;
		   $res = $content->insert();
		   if($res){
             $this->redirect(array('/login/show','name'=>$content->name));
		   }
		}
	}

	public function actionDel(){
		 $list = Yii::$app->request->get();
		 $res = Yii::$app->db->createCommand()->delete('content',['id'=>$list[1]['id']])->execute();
		 if($res){
		 	$name = Yii::$app->session['name'];
            $this->redirect(array('/login/show','name'=>$name));
		 }         		 
	}

	public function actionUp(){
		$list = Yii::$app->request->get();
		$content = new content();
		return $this->render('update',['content'=>$content,'list'=>$list[1]]);
	}

	public function actionUpdate(){
		$list = Yii::$app->request->post();
		$list = $list['Content'];
        $res = Yii::$app->db->createCommand()->update('content',array('content' => $list['content']), 'id=:id', array(':id' => $list['id']))->execute();
        if($res){
        	$name = Yii::$app->session['name'];
            $this->redirect(array('/login/show','name'=>$name));
        }	    
	}

	public function actionShow(){

		$data = Yii::$app->request->get();
		$name = $data['name'];
		$content = new content();
        $pagination=new pagination([
				            'defaultPageSize'=>6,
				            'totalCount'=>$content->find()->count()
				        ]);

        $list=$content->find()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        return $this->render('index',['content'=>$content,'name'=>$name,'list'=>$list,'pagination'=>$pagination]);
	}

}