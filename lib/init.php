<?php
/**
 * init.php 初始化文件
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月26日
 * @copyright GRL
 */
 
 //初始化文件
 define('PATH', dirname(__DIR__));//定义一个常量，指向目录blog
 require PATH.'/lib/mysql.php';
 require PATH.'/lib/func.php';
 
/* $_POST = _addslashes($_POST);
 $_GET = _addslashes($_GET);
 $_COOKIE = _addslashes($_COOKIE);
 $_SESSION = _addslashes($_SESSION);*/
 
?>