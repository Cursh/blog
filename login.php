<?php

/**
 * login.php 登录页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年4月8日
 * @copyright GRL
 */
 
 //引入初始化文件
 require './lib/init.php';
 
 
 //检测是否有数据提交
 if(empty($_POST)){
 	require PATH.'/view/admin/login.html';
 }else{
 	//有数据提交
 	$name = trim($_POST['name']);
	if(empty($name)){
		error('用户名不能为空');
	}
	
	$password = trim($_POST['password']);
	if(empty($password)){
		error('密码不能为空');
	}
	
	//对比数据库
	$sql = "select count(*) from user where name='$name' and password='$password'";
	$count = mGetOne($sql);
	if($count<=0){
		error('用户名或密码错误');
	}else{
		setcookie('name',$name);
		header('location:artlist.php');
	}
	
	/*//取出用户的相关信息
	$sql = "select * from user where name = '$name'";
	$user = mGetRow($sql);
	if(empty($user['name'])){
		var_dump($user['name']);
		error('用户名错误');
	}

	//拿用户名取出的密码，再把传递过来的密码与加密过后和数据库的密码进行对比
	if($user['password'] !== md5($password.$user['salt'])){
		error('密码错误');
	}
	setcookie('name',$user['name']);
	setcookie('ccode',ccode($user['name']));
	header('location:artlist.php');*/
 }
?>