<?php
/**
 * picadd.php 图片添加
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年4月16日
 * @copyright GRL
 */
 
 //引入初始化文件
 require './lib/init.php';
 
 
 //检测是否有数据提交
 if(empty($_POST)){
 	//取出所有图片
 	$sql = "select * from pic";
	//取出所有行
	$pics = mGetAll($sql);//二维数组
 	//引入前台html页面
 	include PATH.'/view/admin/picadd.html';
	exit();
 }
 
//检测图片名称是否为空
 $data['pic_name'] = trim($_POST['pic_name']);
 if(empty($data['pic_name'])){
 	error('图片名称不能为空');
 }
 
 /*//检测图片id是否存在
 $data['pic_id'] = trim($_POST['pic_id']) ;
 $sql = "select count(*) from pic where pic_id='$data[pic_id]'";
 $count = mGetOne($sql);
 if($count<=0){
 	error('图片ID不存在');
 }*/
 
 //检测简介是否为空
 $data['pic_int'] = trim($_POST['pic_int']);
 if(empty($data['pic_int'])){
 	error('图片简介不能为空');
 }
 
 //图片发布时间
 $data['time'] = time();
 
//print_r($_FILES);exit();
 //检测是否有文件要上传
if(($_FILES['pic']['name'] != '') && ($_FILES['pic']['error'] == 0)){
 	$path = createDir().'/'.randStr().getExt($_FILES['pic']['name']);
	$realpath = PATH.$path;	
 	$res = move_uploaded_file($_FILES['pic']['tmp_name'], $realpath);
 	if($res){
 		$data['road'] = $path;
		$suodir = makeThumb($path);
		if($suodir){
			$data['suo'] = $suodir;
		}
 	}
 }

 //上传图片
  $sql = "insert into pic(pic_name,pic_int,time,road,suo) values('$data[pic_name]','$data[pic_int]','$data[time]','$data[road]','$data[suo]')";
  $res = mquery($sql);
 if(!$res){
 	error('图片上传失败');
 }else{
 	 succ('图片上传成功');
 	
 }
 

 
 
?>