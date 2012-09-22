<?php
session_start();
header('Content-Type:text/html;charset=UTF-8');
include_once("../../../util/commonFunctions.php");
include_once("../../../database/mysqlDAO.php");

if (canAcesssThisPageAjax(47)){
	exit;
}

if ( (isset($_POST['t_name']) == false) || (isset($_POST['id']) == false) || (isset($_POST['actionType']) == false) ) {
	echo '缺少参数';
	exit;
}

$t_id = $_POST['id'];
$t_name = trim($_POST['t_name']);
$actionType = $_POST['actionType'];

if ($actionType < 3){
	if (strlen($t_name)< 1){
		echo '类型名称不能为空';
		exit;
	}
}
switch($actionType){
	case 1:{
		$sqlstr = "insert into corp_type(t_name) values('$t_name')";
		$mysqldao->insertRec($sqlstr);
		exit;
	}
	case 2:{
		$sqlstr = "update corp_type set t_name='$t_name' where t_id=$t_id";
		$mysqldao->updateRec($sqlstr);
		exit;
	}
	case 3:{
		$sqlstr = "delete from corp_type where t_id=$t_id";
		$mysqldao->deleteRec($sqlstr);
		exit;
	}
	default : {
		echo '非法操作';
	}
}
?>