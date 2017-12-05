<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<style>
    *{ margin:0; padding:0;list-style: none;}
    #tab {overflow:hidden;zoom:1;background:#000;border:1px solid #000;}
    #tab li {float:left;color:#fff;height:30px;	cursor:pointer;	line-height:30px;padding:0 20px;}
    #tab li.current {color:#000;background:#ccc;}
    #content {border:1px solid #000;border-top-width:0;}
    #content div {line-height:25px;	margin:0 30px;padding:10px 0;display:none;}
</style>
<body>
    <ul id="tab">
        <li>商品基本信息</li>
        <li>商品描述</li>
        <li>商品图片</li>
    </ul>
    <div id="content">
        <div style="display:block;">123456</div>
        <div>77777</div>
        <div>88888</div>
    </div>
</body>
</html>
<script src="/DAY5/lianxi/Public/jquery.min.js"></script>
<script>
    $(function(){
        window.onload=function(){
            var $li = $("#tab li");
            var $con = $("#content div");
            $li.click(function(){
                var indexcount = $(this).index();
                $li.removeClass();
                $(this).addClass('current');
                $con.css('display','none');
                $con.eq(indexcount).css('display','block');
            })
        }
    })
</script>