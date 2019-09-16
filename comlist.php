<?php
/**
 * comlist.php 评论列表页
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月30日
 * @copyright GRL
 */
 
 require './lib/init.php';
 
 $sql = "select comment.*, title from comment left join art on comment.art_id=art.art_id";
 $comms = mGetAll($sql);
 

 require PATH.'/view/admin/comlist.html';
?>