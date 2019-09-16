<?php
/**
 * index.php 首页
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月21日
 * @copyright GRL
 */
 //引入初始化文件
 require './lib/init.php';
 

 //检测是否有数据提交
 if(empty($_POST)){
 	//展示前台页面
 	require './view/admin/catadd.html';
	exit();
 }
 
 //检测栏目是否为空
$catname = trim($_POST['catname']);//trim去除字符两端的空格
if(empty($catname)){
	error('栏目不能为空');
	exit();
}

 //检测栏目是否已经存在
 //连接数据库
 /*$link = mysqli_connect('localhost','root','1234','blog');
 //var_dump($link);
 mysqli_query($link,'set names utf8');*/
 //执行查询语句
 $sql = "select count(*) from cat where catname = '$catname'";
 /*$res = mysqli_query($link,$sql);
 if(!$res){
 	echo mysqli_error($link);
 	exit();
 }
 $count = mysqli_fetch_row($res)[0];*/
 $count = mGetOne($sql);
 if($count>=1){
 	error('该栏目名已经存在，请重新输入');
 	exit();
 }
 
 //添加栏目
 $sql = "insert into cat(catname) values('$catname')";
 //$res = mysqli_query($link,$sql);
 $res = mquery($sql);
 if(!$res){
 	echo mysqli_error($link);
 }else{
 	 //echo'栏目添加成功';
 	 succ('栏目添加成功');
 	 //header('location:catlist.php');
 }

?>