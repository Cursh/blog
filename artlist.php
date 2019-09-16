<?php
/**
 * artlist.php 文章展示页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月21日
 * @copyright GRL
 */
 
 //引入初始化文件
 require './lib/init.php';
 
 //检测用户是否登录成功
 if(!checkCookie()){
 	header('location:login.php');
	exit();
 }
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
 
 $sql ='select count(*) from art where '.$where;
 $num = mGetOne($sql);//获取总文章数
 $cnt = 10;//每页显示5篇文章
 $page = getPage($num, $curr,$cnt);
 
 
 // 取出多条,注意,用哪些字段,取哪些字段,不要用*, 
 //用where 1 拼接后面的条件,有条件继续往后 and 即可
  //加上limit 筛选分页应显示的文章数
 //取出所有文章
 $sql = 'select art_id,title,pubtime,catname,comm from art left join cat 
 on art.cat_id=cat.cat_id where '. $where .' order 
 by art_id asc limit '.($curr-1)*$cnt.','.$cnt;
 
 $arts = mGetAll($sql);
/* //把数据从数据库取出
 $sql = 'select art_id,title,pubtime,catname,comm 
 from art left join cat 
 on art.cat_id=cat.cat_id';
 $arts = mGetAll($sql);//获取所有文章*/
 //把数据放在html模板上
 require PATH .'/view/admin/artlist.html';
?>