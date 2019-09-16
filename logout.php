<?php

/**
 * logout.php 退出登录页面
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年4月8日
 * @copyright GRL
 */
 
 setcookie('name','');
 header('location:login.php');
 
?>