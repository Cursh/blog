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
 
 //取出所有栏目
 $sql = 'select * from cat';
 $cats = mGetAll($sql);
 
 //取出所有图片
  $sql = 'select * from pic';
 $pics = mGetAll($sql);
 
 //检测地址栏上是否有cat_id参数
 if(!isset($_GET['cat_id'])){
 	$where = 1;
 }else{
 	$where = 'art.cat_id = '.$_GET['cat_id'];
 }
 
 //检测地址栏上是否有page参数
 if(!isset($_GET['page'])){
 	$curr = 1;
 }else{
 	$curr = $_GET['page'];
 }
 
 //获取页码数
 $sql ='select count(*) from art where '.$where;
 $num = mGetOne($sql);//获取总文章数
 $cnt = 5;//每页显示5篇文章
 $page = getPage($num, $curr,$cnt);
 
 
 //取出所有文章
 $sql = 'select  suo,title,content,pubtime,catname,comm,art_id from art left join cat 
 on art.cat_id=cat.cat_id where '. $where . ' order 
 by art_id desc limit '.($curr-1)*$cnt.','.$cnt;
 $arts = mGetAll($sql);//二维数组


 
 //把数据展示在HTML页面上
 require PATH.'/view/front/index.html';//只要引入了初始化文件，就应该使用绝对路径
 
 
?>