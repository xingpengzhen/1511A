<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Name;
use frontend\models\Fen;
use frontend\models\Day;
use frontend\models\Bu;
use Illuminate\Support\Facades\Session;


class CheckController extends Controller{
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
				        
                        $this->redirect(array('/check/show'));
            		}
            		else{
            		// echo '<script>alert("密码错误");location.href="'.'?check/login'.'";</script>';
            		   echo '<script>alert("密码错误")</script>';       		  
			           return $this->render('login',['model'=>$model]);
		            }
            	}
            	else{
            		echo '<script>alert("用户名不存在")</script>'; 
			        return $this->render('login',['model'=>$model]);
		        }
            }            
		}
	}

	public function actionShow(){
		 $name = Yii::$app->session['name']; 
         $fen  = new Fen();
         $data = $fen->find()->where(['user'=>$name])->asArray()->one();
      
         return $this->render('show',['name'=>$name,'fen'=>$data['fen']]);
	}

	public function actionShow1(){
		 $name = Yii::$app->session['name'];
         $day = new Day();
         $dataday  = $day->find()->where(['user'=>$name])->asArray()->all();
         foreach($dataday as $k=>$v){
         	if(substr($v['day'],-2,1) == '0'){
         		$aa[$k] = substr($v['day'],-1);
         	}
         	else{
         		$aa[$k] = substr($v['day'],-2,2);
         	}        	
         }
         $bu = new Bu();
         $databu  = $bu->find()->where(['user'=>$name])->asArray()->all();
         foreach($databu as $k=>$v){
         	if(substr($v['day'],-2,1) == '0'){
         		$aa[] = substr($v['day'],-1);
         	}
         	else{
         		$aa[] = substr($v['day'],-2,2);
         	}
         }
         // var_dump($aa);die;
         if(isset($aa)){
         	echo json_encode($aa);
         }else{
         	$aa = array();
         	echo json_encode($aa);
         }         
	}

	public function actionFen(){
		$name = Yii::$app->session['name'];
		$date = Yii::$app->request->get();		
        settype($date['newday'],'int');  //字符串转换成数字
        
        $day  = new Day();
        //时间存到day表		
		$day->user = $name;
		$day->day  = $date['newday'];
		// $int = '20171204';
		// settype($int,'int');
		// $day->day  = $int;

		$res = $day->insert();

        //查询day中所有
        $list = $day->find()->where(['user'=>$name])->asArray()->all();
        if(count($list) == 1){
        	$num = 1;            //第一次签到
        }
        else{
            $key = count($list);
            $last = $list[$key-1]['day'];  //今天
            // var_dump($list[$key-1]);die;
            if($last==$list[0]['day']+1 && $key==2){
           	  $num = 2;           //第二次签到
            }
            else if($last == $list[0]['day']+2 && $key==3){
           	  $num = 3;           //第三次签到
            }
            else if($last == $list[0]['day']+3 && $key==4){
           	  $num = 4;           //第四次签到
            }
            else if($last == $list[0]['day']+4 && $key==5){
           	  $num = 5;           //第五次签到
            }
            else{
              $num = 1;
            }
            if($key > 5){
            	if($list[$key-2]['day']!=$last-1){
            	    $num = 1;         //断开第一天
	            }
	            else if($list[$key-3]['day']!=$last-2){
	            	$num = 2;         //断开第二天
	            }
	            else if($list[$key-4]['day']!=$last-3){
	            	$num = 3;         //断开第三天
	            }
	            else if($list[$key-5]['day']!=$last-4){
	            	$num = 4;         //断开第四天
	            }
	            else if($list[$key-6]['day']!=$last-5){
	            	$num = 5;        //断开第五天
	            }
	            else{
	            	$num = 5;
	            }
            }          
        }       

        // var_dump($num);die;  //今日所获积分

        //时间表添加积分项
        Yii::$app->db->createCommand()->update('day',array('add' => $num),'user="'.$name.'" and day='.$date['newday'])->execute();
        //添加积分
        $fen = new Fen();
        $f = $fen->find()->where(['user'=>$name])->asArray()->one();
        $f = $f['fen']+$num;
        $fenadd = Yii::$app->db->createCommand()->update('fen',array('fen' => $f), 'user=:user', array(':user' =>$name))->execute();      

		if($res && $fenadd){
			 echo json_encode($f);
		}
	}

	public function actionBu(){
		$name = Yii::$app->session['name'];		
		$data = Yii::$app->request->get();
		//积分表减1
		$fen = new Fen();
        $f = $fen->find()->where(['user'=>$name])->asArray()->one();
        if($f['fen']>=1){
        	$f = $f['fen']-1;
	        $fenjian = Yii::$app->db->createCommand()->update('fen',array('fen' => $f), 'user=:user', array(':user' =>$name))->execute();
	        //bu表添加
	        $bu = new Bu();
	        $bu->user = $name;
	        $bu->day = $data['logday'];
	        $res = $bu->insert();
	        if($res && $fenjian){
	        	echo json_encode($f);
	        }
        }
        else{
        	echo json_encode('false');
        }
	}

	public function actionDi(){
		$name = Yii::$app->session['name'];
		$data = Yii::$app->request->get();
        $bu = new Bu();
        $f = $bu->find()->where(['user'=>$name])->asArray()->all();
        $day = new Day();
        $e = $day->find()->where(['user'=>$name])->asArray()->all();
        $count = count($f)+count($e);
        //奖励60分
        if($count == $data['daysCount']){
        	 $fen = new Fen();
             $f = $fen->find()->where(['user'=>$name])->asArray()->one();
             $f = $f['fen']+60;
             $fenadd = Yii::$app->db->createCommand()->update('fen',array('fen' => $f), 'user=:user', array(':user' =>$name))->execute();
        }
        //清空本月bu表和day表
        Yii::$app->db->createCommand()->delete('bu',['user'=>$name])->execute();
        Yii::$app->db->createCommand()->delete('day',['user'=>$name])->execute();
	}
}