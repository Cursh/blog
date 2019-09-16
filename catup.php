<?php
/**
 * catup.php 栏目编辑页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月21日
 * @copyright GRL
 */
 
 //获取地址栏上的参数
 $id = $_GET['cat_id'];
 //连接数据库
 $link = mysqli_connect('localhost','root','1234','blog');
 mysqli_query($link, 'set names utf8');
 
 //获取id 
 $cat_id = trim($_GET['cat_id']);
//判断id是否为空; 
if(empty($_GET['cat_id'])){
	 echo '栏目id不能为空'; exit(); 
}
//判断栏目id是否合法 
if(!is_numeric($cat_id)){
	 echo '栏目id不合法'; exit(); 
}
 
 
 //检测是否有数据提交
 if(empty($_POST)){
 	//取出该行数据，作为默认值放在前台html
 	$sql = "select * from cat where cat_id=$id";
	$res = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($res);//一维数组
 	//展示前台页面
 	require './view/admin/catup.html';
 }else{	
	//检测栏目是否为空
	$catname = trim($_POST['catname']);//trim去除字符两端的空格
	if(empty($catname)){
		echo '栏目名不能为空';
		exit();
	}

 //检测栏目是否已经存在
 //执行查询语句
 $sql = "select count(*) from cat where catname = '$catname'";
 $res = mysqli_query($link,$sql);
 if(!$res){
 	echo mysqli_error($link);
 	exit();
 }
 $count = mysqli_fetch_row($res)[0];
 if($count>=1){
 	echo '该栏目名已经存在，请重新输入';
 	exit();
 }
	
//执行修改操作
$sql = "update cat set catname='$catname' where cat_id=$id ";
$res = mysqli_query($link, $sql);
if(!$res){                 //判断结果是否执行成功
	echo mysqli_error($link);
}else{
	header('location:catlist.php');
 }
}
?>