<?php
$No=$_GET['No'];
if(empty($No))
{
	$No=$_POST['No'];
}

if($No=='001')echo 'Error:'.$No.' 数据库帐号密码出错！';
if($No=='002')echo 'Error:'.$No.' 数据库不存在！';
?>