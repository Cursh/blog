<?php

/**
 * artup.php 文章编辑界面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月21日
 * @copyright GRL
 */
 
 //引入初始化文件
 require './lib/init.php';
 //获取地址栏上的id
 $id = $_GET['art_id'];
 
 //检测文章id是否合法
 if(!is_numeric($id)){
 	error('文章id不合法');
 }
 
 //检测文章id是否存在
 $sql = "select count(*) from art where art_id='$id'";
 $count = mGetOne($sql);
 if($count == 0){
 	error('文章id不存在');
 }
 
 // 判断是点击编辑页面，还是有文章的修改
 if(empty($_POST)){
 	//取出该行
 	$sql = "select * from art where art_id = $id";
	$art = mGetRow($sql);//一维数组
	
	$sql = "select * from cat";
	$cats = mGetAll($sql);
 	require PATH.'/view/admin/artup.html';
 }else{
  //检测标题是否为空
 $data['title'] = trim($_POST['title']);
 if(empty($data['title'])){
 	error('文章标题不能为空');
 }
 
 //检测栏目id是否存在
 $data['cat_id'] = trim($_POST['cat_id']) ;
 $sql = "select count(*) from cat where cat_id='$data[cat_id]'";
 $count = mGetOne($sql);
 if($count<=0){
 	error('栏目ID不存在');
 }
 
 //检测内容是否为空
 $data['content'] = trim($_POST['content']);
 if(empty($data['content'])){
 	error('文章内容不能为空');
 }
 
 //上次修改时间
 $data['lastup'] = time();
 
 //print_r($data);exit();
 //检测是否有文件要上传
if(!empty($_FILES) && $_FILES['pic']['error'] == 0){
 	$path = createDir().'/'.randStr().getExt($_FILES['pic']['name']);
	$realpath = PATH.$path;	
 	$res = move_uploaded_file($_FILES['pic']['tmp_name'], $realpath);
 	if($res){
 		$data['pic'] = $path;
		$suodir = makeThumb($path);
		if($suodir){
			$data['suo'] = $suodir;
		}
 	}
 }
 

 //执行修改操作
 $res = mExec('update','art',$data,'art_id='.$id);
 if(!$res){
 	error('文章修改失败');
 }else{
 	succ('文章修改成功');
	}
 }
 //每增加一篇文章,cat表的 num字段+1
if($res){
	$sql = "update cat c,art a set c.num=c.num+1 where c.cat_id=a.cat_id";
	mQuery($sql);
} 
 
?>