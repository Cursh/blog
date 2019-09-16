<?php
/**
 * comdel.php 评论删除页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月30日
 * @copyright GRL
 */
 
 require './lib/init.php';
 
 //获取评论id
 $id = $_GET['comment_id'];
 
 //查询评论表中id
 $sql = 'select art_id from comment where comment_id='.$id;
 $art_id = mGetOne($sql);
 
 //文章表的comm列，评论数量减1
 $sql = 'update art set comm=(comm-1) where art_id='.$art_id;
 $res = mQuery($sql);
 
 $sql = 'delete from comment where comment_id='.$id;
 $res = mQuery($sql);
 if(!$res){
 	error('评论删除失败');
 }
 
  
  header('location:comlist.php');
?>