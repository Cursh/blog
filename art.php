<?php
/**
 * art.php 文章前台展示页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月30日
 * @copyright GRL
 */
 
 require './lib/init.php';
 
 //接收地址栏上的参数
 $id = $_GET['art_id'];

 //取出所有栏目
 $sql = 'select * from cat';
 $cats = mGetAll($sql);
 
  
 //取出该篇文章
 $sql = "select art.*,suo,catname from art left join cat 
 on art.cat_id=cat.cat_id where art_id='$id'";
 $art = mGetRow($sql);//一维数组)
 
 //取出所有评论
 $sql = "select * from comment where art_id='$id'";
 $comment = mGetAll($sql);

 
 //如果地址栏输入一个没有的文章号 专跳到首页
 if(empty($art)){
 	header('Location:index.php'); exit;
 }
 
 
 //检测是否有评论提交
 if(!empty($_POST)){
 	//检测nick是否为空
 	$data['nick'] = trim($_POST['nick']);
	if(empty($data['nick'])){
		error('昵称不能为空');
	}
	//检测email是否为空
	$data['email'] = trim($_POST['email']);
	if(empty($data['email'])){
		error('邮箱不能为空');
	}
	//检测content是否为空
	$data['content'] = trim($_POST['content']);
	if(empty($data['content'])){
		error('内容不能为空');
	}
	
	$data['art_id'] = $id;
	$data['pubtime'] = time();
	
	//获取来访者的ip
	$data['ip'] = sprintf('%u',ip2long(getIp()));
	
	
	//echo sprintf('%u',ip2long('192.168.0.123')); exit();
	
    //插入的评论返回结果，如果返回false则发布评论失败
 	$res = mExec('insert','comment', $data,$where=0);
	
	//每增加一条评论,art表的 comm字段+1
	if($res){
		$sql = "update art set comm=comm+1 where art_id='$id'";
		mQuery($sql);
	}
   
    //转跳到上一页
 	if($res){
  		$ref = $_SERVER['HTTP_REFERER'];
		header("location:$ref");//用双引号，单引号无法识别变量 
  	}
 }
 

 
 //引入前台页面
 require PATH.'/view/front/art.html';
 
 //
?>