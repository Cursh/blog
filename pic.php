<?php
/**
 * pic.php 我的相册展示页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年4月16日
 * @copyright GRL
 */
 
 //引入初始化文件
 require './lib/init.php';
 
 //检测用户是否登录成功
 if(!checkCookie()){
 	header('location:login.php');
	exit();
 }
//检测地址栏上是否有pic_id参数
 if(!isset($_GET['pic_id'])){
 	$where = 1;
 }else{
 	$where = 'pic.pic_id = '.$_GET['pic_id'];
 }
 
 //检测地址栏上是否有page参数
 if(!isset($_GET['page'])){
 	$curr = 1;
 }else{
 	$curr = $_GET['page'];
 }
 
 $sql ='select count(*) from pic where '.$where;
 $num = mGetOne($sql);//获取图片数
 $cnt = 6;//每页显示10张图片
 $page = getPage($num, $curr,$cnt);
 
 
 // 取出多条,注意,用哪些字段,取哪些字段,不要用*, 
 //用where 1 拼接后面的条件,有条件继续往后 and 即可
  //加上limit 筛选分页应显示的文章数
 //取出所有文章
 $sql = 'select suo,pic_id,pic_name,pic_int,road from pic where '. $where .' order 
 by pic_id asc limit '.($curr-1)*$cnt.','.$cnt;
 
 $pics = mGetAll($sql);
/* //把数据从数据库取出
 $sql = 'select art_id,title,pubtime,catname,comm 
 from art left join cat 
 on art.cat_id=cat.cat_id';
 $arts = mGetAll($sql);//获取所有文章*/
 
//把数据展示在HTML页面上
 require PATH.'/view/front/pic.html';//只要引入了初始化文件，就应该使用绝对路径
?>