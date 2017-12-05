<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::register($this);
//在body区加载js 调用frontend\assets\AppAsset里的方法
AppAsset::addScript($this,'@web/assets/js/jquery.js'); 
//在head区加载js 
// $this->registerJsFile('@web/assets/js/jquery.js',['depends'=>['frontend\assets\AppAsset']]);

$this->registerCssFile('@web/assets/css/index.css',['depends'=>['frontend\assets\AppAsset']]); 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- 账户主要表格 -->
    <div class="account-box">
        <h2 class="account-title">
            <span class="left c3">用户:</span>
            <span class="left c3" style="color: green"><?= $name?></span>
            <span class="left c3">积分：</span>
            <span class="left c3" style="color: red" id="fen"><?= $fen?></span>
            <a href="###" class="f-btn-fhby right">返回本月</a>
            <div class="clearfix right">
                <div class="f-btn-jian left">&lt;</div><div class="left f-riqi"><span class="f-year">2017</span>年<span class="f-month">1</span>月</div><div class="f-btn-jia left">&gt;</div><!-- 一定不能换行-->
            </div>
        </h2>
        <div class="f-rili-table">
            <div class="f-rili-head celarfix">
                <div class="f-rili-th">周日</div>
                <div class="f-rili-th">周一</div>
                <div class="f-rili-th">周二</div>
                <div class="f-rili-th">周三</div>
                <div class="f-rili-th">周四</div>
                <div class="f-rili-th">周五</div>
                <div class="f-rili-th">周六</div>
                <div class="clear"></div>
            </div>
            <div class="f-tbody clearfix">

            </div>
        </div>
    </div>
</body>
<script>
$(function(){
                //页面加载初始化年月
                var mydate = new Date();
                $(".f-year").html( mydate.getFullYear() );
                $(".f-month").html( mydate.getMonth()+1 );
                showDate(mydate.getFullYear(),mydate.getMonth()+1);
                //日历上一月
                $(".f-btn-jian ").click(function(){
                    var mm = parseInt($(".f-month").html());
                    var yy = parseInt($(".f-year").html());
                    if( mm == 1){//返回12月
                        $(".f-year").html(yy-1);
                        $(".f-month").html(12);
                        showDate(yy-1,12);
                    }else{//上一月
                        $(".f-month").html(mm-1);
                        showDate(yy,mm-1);
                    }
                })
                //日历下一月
                $(".f-btn-jia").click(function(){
                    var mm = parseInt($(".f-month").html());
                    var yy = parseInt($(".f-year").html());
                    if( mm == 12){//返回12月
                        $(".f-year").html(yy+1);
                        $(".f-month").html(1);
                        showDate(yy+1,1);
                    }else{//上一月
                        $(".f-month").html(mm+1);
                        showDate(yy,mm+1);
                    }
                })
                //返回本月
                $(".f-btn-fhby").click(function(){
                    $(".f-year").html( mydate.getFullYear() );
                    $(".f-month").html( mydate.getMonth()+1 );
                    showDate(mydate.getFullYear(),mydate.getMonth()+1);
                })
                
                //读取年月写入日历  重点算法!!!!!!!!!!!
                function showDate(yyyy,mm){
                    var dd = new Date(parseInt(yyyy),parseInt(mm), 0);   //Wed Mar 31 00:00:00 UTC+0800 2010  
                    var daysCount = dd.getDate();            //本月天数  
                    var mystr ="";//写入代码
                    var icon = "";//图标代码
                    var today = new Date().getDate(); //今天几号  21
                    var monthstart = new Date(parseInt(yyyy)+"/"+parseInt(mm)+"/1").getDay()//本月1日周几  
                    var lastMonth; //上一月天数
                    var nextMounth//下一月天数
                    if(  parseInt(mm) ==1 ){
                        lastMonth = new Date(parseInt(yyyy)-1,parseInt(12), 0).getDate();
                    }else{
                        lastMonth = new Date(parseInt(yyyy),parseInt(mm)-1, 0).getDate();
                    }
                    if( parseInt(mm) ==12 ){
                        nextMounth = new Date(parseInt(yyyy)+1,parseInt(1), 0).getDate();
                    }else{
                        nextMounth = new Date(parseInt(yyyy),parseInt(mm)+1, 0).getDate();
                    }
                    

                    $.ajax({
                        url:'http://www.china.com/month8/qian_dao/frontend/web/index.php?r=check/show1',
                        dataType:'json',
                        success:function(msg){
                            //计算上月空格数
                            for(j=monthstart;j>0;j--){
                                mystr += "<div class='f-td f-null f-lastMonth' style='color:#ccc;'>"+(lastMonth-j+1)+"</div>";
                            }
                            //本月单元格
                            for(i=0;i<daysCount;i++){
                                var a = i+1;
                                 //这里为一个单元格，添加内容在此
                                if($.inArray(a.toString(), msg) != -1){
                                    mystr += "<div class='f-td f-number'><span class='f-day'>"+(i+1)+"</span>"
                                        // +"<div class='f-yuan'></div>"
                                        +"<div class='f-yuan' id='aa'></div>"
                                        +"<div class='f-table-msg'><span>已签到+1</span></div>"//这里加判断
                                        +"</div>";
                                }
                                else{
                                    mystr += "<div class='f-td f-number'><span class='f-day'>"+(i+1)+"</span>"
                                        // +"<div class='f-yuan'></div>"
                                        +"<div class='' id='aa'></div>"
                                        +"<div class='f-table-msg'><span>已签到+1</span></div>"//这里加判断
                                        +"</div>";
                                }
                            }
                            //计算下月空格数
                            for(k=0; k<42-(daysCount+monthstart);k++ ){//表格保持等高6行42个单元格
                                mystr += "<div class='f-td f-null f-nextMounth' style='color:#ccc;'>"+(k+1)+"</div>";
                            }

                            //写入日历
                            $(".f-rili-table .f-tbody").html(mystr);
                        }
                    })                   
                    
                    
                    //给今日加class
                    if( mydate.getFullYear() == yyyy){
                        if( (mydate.getMonth()+1 ) == mm){
                            var today = mydate.getDate();
                            var lastNum = $(".f-lastMonth").length;
                            $(".f-rili-table .f-td").eq(today+lastNum-1).addClass("f-today");
                        }
                    }
                    //绑定选择方法
                    $(".f-rili-table .f-number").off("click");
                    $(".f-rili-table .f-number").on("click",function(){
                        $(".f-rili-table .f-number").removeClass("f-on");
                        $(this).addClass("f-on");
                    });
                    
                }
                
            })

//修改代码
//点击添加样式
$(document).on('click','.f-day',function(){
    //获取今天的日期
    var mydate = new Date();
    var date = Array();
    date[0] = mydate.getFullYear();
    date[1] = mydate.getMonth()+1;
    // date[1] = 1;
    if(date[1]<10){
      date[1] = '0'+date[1];
    }
    date[2] = mydate.getDate();
    // date[2] = 2;
    if(date[2]<10){
      date[2] = '0'+date[2];
    }
    var newday = parseInt(date.join(''));
    
    var day = Array();
    day[0] = $('.f-year').html();
    day[1] = $('.f-month').html();
    if(day[1]<10){
      day[1] = '0'+day[1];
    }
    day[2] = $(this).html();
    if(day[2]<10){
      day[2] = '0'+day[2];
    }
    var logday = parseInt(day.join(''));
    if(logday>newday){
        alert('时间未到');
    }
    else if(logday<newday){
        if($(this).parent().find("#aa").attr('class')!= ''){
            alert('已补签到');
        }
        else{
            var con = confirm('时间已过,确定要补签?');
            if(con == true){
                $.ajax({
                    url:'http://www.china.com/month8/qian_dao/frontend/web/index.php?r=check/bu',
                    data:{logday:logday},
                    type:'get',
                    dataType:'json',
                    success:function(msg){
                       if(msg != 'false'){
                         alert('补签成功');
                         $('#fen').html(msg);
                         $(this).parent().find("#aa").attr('class','f-yuan');
                       }
                       else{
                         alert('补签失败,积分不足');
                       }                       
                    }
                })              
            }
        }
    }
    else{
        if($(this).parent().find("#aa").attr('class')!= ''){
            alert('今天已签到');
        }
        else{
            $.ajax({
            url:'http://www.china.com/month8/qian_dao/frontend/web/index.php?r=check/fen',
            data:{newday:newday},
            type:'get',
            dataType:'json',
            success:function(msg){
                 if(msg){
                    alert('签到成功');
                    $('#fen').html(msg);
                 }
            }
            })        
            $(this).parent().find("#aa").attr('class','f-yuan');
        }
    }

        //绑定查看方法
        $(".f-yuan").off("mouseover");  //移除鼠标悬停事件
        $(".f-yuan").on("mouseover",function(){    //添加鼠标悬停事件
            $(this).parent().find(".f-table-msg").show();
        });
        $(".f-table-msg").off("mouseover");      
        $(".f-table-msg").on("mouseover",function(){
            $(this).show();
        });
        $(".f-yuan").off("mouseleave");  //移除鼠标离开事件
        $(".f-yuan").on("mouseleave",function(){    //添加鼠标悬停事件
            $(this).parent().find(".f-table-msg").hide();
        });
        $(".f-table-msg").off("mouseleave");
        $(".f-table-msg").on("mouseleave",function(){
            $(this).hide();
        });

    var mydate = new Date();
    var dd = new Date(parseInt(mydate.getFullYear()),parseInt(mydate.getMonth()+1), 0);
    var daysCount = dd.getDate();
    if(date[2]==daysCount){
        $.ajax({
            url:'http://www.china.com/month8/qian_dao/frontend/web/index.php?r=check/di',
            data:{daysCount:daysCount},
            type:'get',
            dataType:'json',
            success:function(){

            }
        })
    }
     
})
</script>
</html>