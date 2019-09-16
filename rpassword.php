<?php

/**
 * rpassword.php 修改密码页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年4月13日
 * @copyright GRL
 */
  //引入初始化文件
  require './lib/init.php';
  
    
  //检测是否有数据提交
  if(empty($_POST)){
 	require PATH.'/view/admin/rpassword.html';
  }else{
    //有数据提交
 	$data['name'] = trim($_POST['name']);
	if(empty($data['name'])){
		echo"<script language='javascript'>alert('用户名不能为空！');histroy.back(-1);</script>";
	}else{
		$sql = "select * from user where name = '$data[name]'";
		$user = mGetRow($sql);
		if(empty($user['name'])){
			var_dump($user['name']);
			echo"<script language='javascript'>alert('用户名不存在！！！');history.back(-1);</script>";
			exit();
		}
		if(empty($user['password'])){
			echo"<script language='javascript'>alert('密码错误！！！');history.back(-1);</script>";
			exit();
		}
	}
	$data['password'] = trim($_POST['password']);
	if(empty($data['password'])){
		echo"<script language='javascript'>alert('原始密码不能为空!');histroy.back(-1);</script>";
	}
	
	$data['newpassword'] = trim($_POST['newpassword']);
	if(empty($data['newpassword'])){
		echo"<script language='javascript'>alert('新密码不能为空!');histroy.back(-1);</script>";
	}
	
	if (trim($_POST['password']) == trim($_POST['newpassword'])){
		echo"<script language='javascript'>alert('原始密码与新密码不能一致!');histroy.back(-1);</script>";
  	}
	
    if (trim($_POST['newpassword']) != trim($_POST['repassword'])){

    	echo"<script language='javascript'>alert('两次密码不一致!');histroy.back(-1);</script>";
	}

	$data['password'] = trim($_POST['newpassword']);
	//执行修改操作
	$sql = "update user set password='".$data['password']."'where name='".$data['name']."'";
	$res = mQuery($sql);
	if(!$res){
		echo "<script language='JavaScript' >alert('对不起，修改密码失败！');histroy.back(-1);</script>";
	}else{
		echo "<script language='JavaScript' >alert('修改密码成功！');window:location.href='login.php';</script>";
	}
}	
?>