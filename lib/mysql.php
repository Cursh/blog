<?php
/**
 * mysql.php 封装mysql函数
 * 
 * @author 六元的小虎牙
 * @link www.wywang.com
 * @since 2018年3月26日
 * @copyright GRL
 */
 
 
 /**
  * 连接数据库
  * 
  * @retrun $link 连接好数据库的通道
  */
  function mConn(){
  	//静态变量使得mConn在同一个页面，数据库只连接一次
	static $link = null;  //声明$link为静态变量
	if($link == null){
	$cfg = require PATH.'/lib/config.php';
	$link = mysqli_connect($cfg['host'],$cfg['user'],$cfg['pwd'],$cfg['db']);
	mysqli_query($link, 'set names '.$cfg['charset']);
	}
	return $link;
  }
/**
 * 执行SQL语句
 * 
 * @param $sql 待执行的sql语句
 * @return $res mixed类型   执行添加/删除/修改的时，成功返回true，执行查询语句时，成功返回（结果）。
 * 失败统一返回false
 */
 function mQuery($sql){
 	//return $res = mysqli_query(mConn(), $sql);
 	$Link =mConn();
	$res = mysqli_query($Link, $sql);
	if(!$res){
		mLog($sql."\n".mysqli_error($Link));
		return false;
	}else{
		mLog($sql);
		return $res;
	}
 }

/**
 * 取出所有行（数据）
 * 
 * @param $sql  待执行的查询（sql）语句
 * @return $data array 二维数组，存储了某张表中所有的数据
 */
 function mGetAll($sql){
 	$res = mQuery($sql);
	if(!$res){
		return false;
	}else{
	$data = array();
	while($row = mysqli_fetch_assoc($res)){
		$data[]= $row;
	}
  }
	return $data;
}
 
 /**
  * 记录日志 
  * 
  * @param $sql 待记录的sql语句
  */
  function mLog($sql){
  	$filename = PATH.'/log/'.date('Ymd').'.txt';
	$data = '-------------------------'."\n".date('Y/m/d H:i:s')."\n".
	$sql."\n".'-------------------------'."\n\n";
  	file_put_contents($filename, $data,FILE_APPEND);
  }
  
/**
 * 取出一行数据
 * 
 * @param $sql 待执行的查询语句
 * @return mixed类型  $res 执行成功返回一维数组，失败返回false
 */
 function mGetRow($sql){
 	$res = mQuery($sql);
	/*if(!$res){
		return false;
	}
	return $row = mysqli_fetch_assoc($res);*/
	return $row = $res?mysqli_fetch_assoc($res):false;
 }
 
/**
 * 获取一行数据的第一个单元
 * 
 * @param $sql 待执行的sql语句
 * @return mixed类型  一行数据的第一个单元
 */
 function mGetOne($sql){
 	$res = mQuery($sql);
	return $row = $res?mysqli_fetch_row($res)[0]:false;
 }
 
/**
 * ?执行添加和修改操作
 * 
 * @param $act 添加或修改操作，默认是添加
 * @param $table 待操作的表名
 * @param $data array 字段名（列名）作为键存在，添加的值作为数组的值
 * @param $where 修改的限制条件，默认值为0
 * @return bool 成功返回true，失败返回false
 * 添加语句：insert into user(uid,name,age) values ('1','zs','23');
 * 修改语句：update user set uid='1',name='zs',age='23' where uid = '1';
 */
 function mExec($act ='insert',$table,$data,$where=0){
 	if($act == 'insert'){
 		$sql = 'insert into '.$table.'(';
		$sql .= implode(',', array_keys($data)).") values ('";//获取数组的键，作为值存在
 		$sql .= implode("','", array_values($data))."')";
		$res = mQuery($sql);
		return $res;
	}else if($act == 'update'){
 		$sql = 'update '.$table.' set ';
		foreach ($data as $k => $v){
			$sql .= $k."='".$v."',";
		}
		$sql = rtrim($sql,',').' where '.$where;//取出字符串末端的空白字符
		return $res = mQuery($sql);
 	}
 }
 
?>