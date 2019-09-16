<?php
/**
 * logup.php 注册页面
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
 	require PATH.'/view/admin/logup.html';
 }else{
 	//有数据提交
 	$data['name'] = trim($_POST['name']);
	if(empty($data['name'])){
		echo"<script language='javascript'>alert('用户名不能为空！');window:location.href='logup.php';</script>";
		exit();
	}else{
		$sql = "select count(*) from user where name = '".$data['name']."'";
		$cnt = mGetOne($sql);
 		if($cnt>=1){
 			echo"<script language='javascript'>alert('用户名已存在！！！'); history.back(-1);</script>";
			exit();
   		}
	}
	
	$data['password'] = trim($_POST['password']);
	if(empty($data['password'])){
		echo"<script language='javascript'>alert('密码不能为空！');window:location.href='logup.php';</script>";
		exit();
	}
	
	if(empty(trim($_POST['repassword']))){
		echo"<script language='javascript'>alert('确认密码不能为空！');window:location.href='logup.php';</script>";
		exit();
	}
	
	if(trim($_POST['password']) != trim($_POST['repassword'])){
    	echo "<script language='javascript'>alert('两次密码输入不一致！');window:location.href='logup.php';</script>";
    	exit();
	}
	
	$data['email'] = trim($_POST['email']);
	if(empty($data['email'])){
		echo"<script language='javascript'>alert('邮箱不能为空！');window:location.href='logup.php';</script>";
		exit();
	}

	$data['createtime'] = time();
 	//获取来访者的ip
 	$data['ip'] = sprintf('%u',ip2long(getIp()));
 
	//插入的用户返回结果
 	$res = mExec('insert','user', $data,$where=0);
	if($res){
		echo "<script>alert('注册成功');window:location.href='login.php';</script>";
	}else{
		echo "<script language='JavaScript' >alert('对不起，注册失败！');histroy.back(-1);</script>";
	} 
}
?>