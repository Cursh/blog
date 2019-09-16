<?php
/**
 * picdel.php 图片删除页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年4月16日
 * @copyright GRL
 */
 
 //引入初始化文件
 require './lib/init.php';
 //获取地址栏上的参数
 $id = $_GET['pic_id'];
 
 //检测文章id是否合法
 if(!is_numeric($id)){
 	error('图片id不合法');
 }
 
 //检测图片id是否存在
 $sql = "select count(*) from pic where pic_id='$id'";
 $count = mGetOne($sql);
 if($count<=0){
 	error('图片id不存在');
 }
 
 //执行删除操作
 $sql = "delete from pic where pic_id='$id'";
 $res = mQuery($sql);
 if(!$res){
 	error('图片删除失败');	
 }else{
 	//图片删除成功，转跳到列表页面
 	header('location:piclist.php');
 }
?>