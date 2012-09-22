<?php 
function getTypeIdByT($now_t,$db)
	{
		$type_handle = "";
		switch ($now_t)
		{
			case  0: return -1;
			case  1: $type_handle="wzlm";break;	//文章栏目		
			case  2: $type_handle='ljtlm';break;//链接条栏目
			case  3: $type_handle='zybjlm';break;//自由编辑栏目
			case  4: $type_handle='dclm';break;//调查栏目
			case  5: $type_handle='tplblm';break;//图片列表栏目
			case  6: $type_handle='tpbglm';break;//图片表格栏目
			case  7: $type_handle='tphdplm';break;//图片幻灯片栏目
			case  8: $type_handle='ztlm';break;//专题栏目
			case 10: $type_handle='ejljtlm';break;//二级链接条栏目
			case 12: $type_handle='tzlm';break;	//通知栏目
			case 13: $type_handle='xxgk';break;	// 信息公开
			default : return -1;
		}
		
		$sqlstr = "select columns_type_id from columns_type where type_handle='$type_handle'";
		$sqlResult = $db->findOneRec($sqlstr);
		if ($sqlResult == -1) return -1;
		return $sqlResult['columns_type_id'];
}

function getTreeStr($db,$sqlstr)
	{		
		$str = "['无单位','']"; 
		if ($sqlstr == '') return $str;
		$corpList = $db->findAllRec($sqlstr);
		
		$col_count = count($corpList);
		if ($col_count <= 0) return $str;
		
		$str = "";		
		for($i=0;$i<$col_count;$i++){
			$link = "javascript:selCorp(".$corpList[$i]['c_id'].",\'".$corpList[$i]['short_name']."\',0,\'\')";	
			$str = $str."['".$corpList[$i]['short_name']."','$link',";
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
		$link = "javascript:selCorp(".$corp_id.",\'".$corp_name."\',".$partList[$i]['part_id'].",\'".$partList[$i]['part_name']."\')";	
		$str = $str."['".$partList[$i]['part_name']."','$link'],";
	}
	return substr($str,0,strlen($str)-1);
}
?>