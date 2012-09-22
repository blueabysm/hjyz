<?php 
function getTreeStr($db,$sqlstr)
	{		
		$str = "['无单位','']"; 
		if ($sqlstr == '') return $str;
		$corpList = $db->findAllRec($sqlstr);
		
		$col_count = count($corpList);
		if ($col_count <= 0) return $str;
		
		$str = "";		
		for($i=0;$i<$col_count;$i++){
			$str = $str."['".$corpList[$i]['short_name']."','',";
			$sql = 'select part_id,part_name from corp_part where corp_id='.$corpList[$i]['c_id'].' order by part_order'; 				
			$str = $str.getPartTreeStr($db,$corpList[$i]['c_id'],$corpList[$i]['short_name'],$sql).'],';
		}
		return substr($str,0,strlen($str)-1);
}
function getPartTreeStr($db,$corp_id,$corp_name,$sqlstr)
{		
	$str = "['无部门','']"; 
	if ($sqlstr == '') return $str;
	$partList = $db->findAllRec($sqlstr);		
	$col_count = count($partList);
	if ($col_count <= 0) return $str;
	
	$str = "";		
	for($i=0;$i<$col_count;$i++){
		$str = $str."['".$partList[$i]['part_name']."','',";
		$sql = 'select user_id,user_realname from admins where user_part='.$partList[$i]['part_id'].' and user_id not in (select admin_id from sub_sites where site_type=2)'; 				
		$str = $str.getUserTreeStr($db,$corp_id,$corp_name,$sql).'],';
	}
	return substr($str,0,strlen($str)-1);
}
function getUserTreeStr($db,$corp_id,$corp_name,$sqlstr)
{		
	$str = "['无人员','']"; 
	if ($sqlstr == '') return $str;
	$userList = $db->findAllRec($sqlstr);		
	$col_count = count($userList);
	if ($col_count <= 0) return $str;
	
	$str = "";		
	for($i=0;$i<$col_count;$i++){
		$link = "javascript:selCorp(".$corp_id.",\'".$corp_name."\',".$userList[$i]['user_id'].",\'".$userList[$i]['user_realname']."\')";	
		$str = $str."['".$userList[$i]['user_realname']."','$link'],";
	}
	return substr($str,0,strlen($str)-1);
}
?>