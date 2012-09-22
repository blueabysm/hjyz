<?php
/**
 * 获取一个新栏目的顺序号和栏目类型句柄
 * @param $dbObj 数据库对象,需已打开
 * @param $columnsType 栏目类型的ID
 * @param $typeHandle 栏目类型句柄  引用调用 
 * @return 成功返回 序号 不成功返回0		
 */
function getNewColumns_handle($dbObj,$columnsType,&$typeHandle)
{
	$sqlstr = "";
	$sn = 0;		
	$sqlResult;
	$sqlstr = "update columns_type set next_number=next_number+1 where columns_type_id=$columnsType";		
	$dbObj->updateRec($sqlstr);
	if ($dbObj->a_rows <=0) return $sn;
	$sqlstr = "select next_number,type_handle from columns_type where columns_type_id=$columnsType";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	$sn = $sqlResult["next_number"] - 1;
	$typeHandle = trim($sqlResult["type_handle"]);
	return $sn;
}

/**
 * 以用户提供的栏目类型handle获取一个新栏目的顺序号
 * @param $dbObj 数据库对象,需已打开 
 * @param $typeHandle 栏目类型句柄
 * @return 成功返回 序号 不成功返回0		
 */
function getNewColumns_sn($dbObj,$typeHandle)
{
	$sqlstr = "";
	$sn = 0;		
	$sqlResult;
	
	//使原有记录+1
	$sqlstr = "update columns_type set next_number=next_number+1 where type_handle='$typeHandle'";		
	$dbObj->updateRec($sqlstr);
	if ($dbObj->a_rows <=0) return $sn;
	//取 next_number
	$sqlstr = "select next_number from columns_type where type_handle='$typeHandle'";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	$sn = $sqlResult["next_number"] - 1;	
	return $sn;
}

/**
 * 以用户提供的栏目id获取该栏目的所有子栏目id以及子栏目的子栏目的id
 * @param $dbObj 数据库对象,需已打开 
 * @param $cid 栏目id
 * @param $maxDepth 最大追踪深度（避免死循环)
 * @param $nowDepth 当前追踪深度（避免死循环)
 * @return 以逗号分隔的栏目id字符串		
 */
function getColumnsAllSubID($dbObj,$cid,$maxDepth,&$nowDepth)
{
	$nowDepth = $nowDepth + 1;
	if ($nowDepth > $maxDepth) {					
		return '';
	}	
	$sqlstr = "select sub_id from columns where columns_id=$cid";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return '';
	$str = trim($sqlResult["sub_id"]);
	if ($str == '') return '';
	
	
	$subIDs = explode(',',$str);
	$len = count($subIDs);
	
	for($i=0;$i<$len;$i++){
		$tempstr = getColumnsAllSubID($dbObj,$subIDs[$i],$maxDepth,$nowDepth);
		if ($tempstr != ''){
			$str = $str . ','. $tempstr;
		}
	}
	$nowDepth = $nowDepth - 1;
	return $str;
}

/**
 * 创建栏目的基本信息 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_type_id 栏目类型ID
 * @param $admin_id 栏目管理员ID
 * @param $create_type 栏目创建类型 0=系统栏目 1=用户创建栏目 2=程序创建栏目
 * @param $sites_id 栏目站点ID 0=主站 其它=子站ID
 * @param $columns_handle 新栏目句柄
 * @param $columns_name 新栏目名称
 * @param $sub_id 子栏目id
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_base_info($dbObj,$columns_type_id,$admin_id,$create_type,$sites_id,$columns_handle,$columns_name,$sub_id = '')
{
	$sqlstr = " insert into columns(columns_type_id,admin_id,create_type,sites_id,columns_handle,columns_name,columns_title,sub_id) values(";
	$sqlstr = $sqlstr . "$columns_type_id,";
	$sqlstr = $sqlstr . "$admin_id,";
	$sqlstr = $sqlstr . "$create_type,";
	$sqlstr = $sqlstr . "$sites_id,'";
	$sqlstr = $sqlstr . "$columns_handle','";
	$sqlstr = $sqlstr . "$columns_name','";
	$sqlstr = $sqlstr . "$columns_name',";
	$sqlstr = $sqlstr . "'$sub_id');";
	
	$dbObj->insertRec($sqlstr);
	
	if ($dbObj->a_rows >0) return 1;
	return 0;		
}

/**
 * 创建栏目的基本信息 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_type_id 栏目类型ID
 * @param $admin_id 栏目管理员ID
 * @param $create_type 栏目创建类型 0=系统栏目 1=用户创建栏目 2=程序创建栏目
 * @param $sites_id 栏目站点ID 0=主站 其它=子站ID
 * @param $columns_handle 新栏目句柄
 * @param $columns_name 新栏目名称
 * @param $level 栏目级别
 * @param $sub_id 子栏目id
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_base_info2($dbObj,$columns_type_id,$admin_id,$create_type,$sites_id,$columns_handle,$columns_name,$level,$sub_id)
{
	$sqlstr = " insert into columns(columns_type_id,admin_id,create_type,sites_id,columns_handle,columns_name,columns_title,level,sub_id) values(";
	$sqlstr = $sqlstr . "$columns_type_id,";
	$sqlstr = $sqlstr . "$admin_id,";
	$sqlstr = $sqlstr . "$create_type,";
	$sqlstr = $sqlstr . "$sites_id,'";
	$sqlstr = $sqlstr . "$columns_handle','";
	$sqlstr = $sqlstr . "$columns_name','";
	$sqlstr = $sqlstr . "$columns_name',";
	$sqlstr = $sqlstr . "$level,";
	$sqlstr = $sqlstr . "'$sub_id');";
	
	$dbObj->insertRec($sqlstr);
	
	if ($dbObj->a_rows >0) return $dbObj->getNewInsertID();
	return 0;		
}

/**
 * 创建一个自由编辑栏目 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_handle 栏目句柄
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_zybjlm($dbObj,$columns_handle)
{
	$sqlResult;
	$columns_id;
	$columns_name;
		
	$sqlstr = "select columns_id,columns_name from columns where columns_handle='$columns_handle'";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	$columns_id = $sqlResult["columns_id"];
	$columns_name = trim($sqlResult["columns_name"]);
	$sqlstr = " insert into columns_html(columns_id,columns_contents) values($columns_id,'$columns_name');";
	$dbObj->insertRec($sqlstr);	
	if ($dbObj->a_rows <= 0) return 0;	
	return 1;		
}

/**
 * 创建一个调查栏目 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_handle 栏目句柄
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_dclm($dbObj,$columns_handle)
{
	$sqlResult;
	$columns_id;
	$columns_name;
		
	$sqlstr = "select columns_id,columns_name from columns where columns_handle='$columns_handle'";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	$columns_id = $sqlResult["columns_id"];
	$columns_name = trim($sqlResult["columns_name"]);
	$sqlstr = " insert into survey(columns_id,survey_contents) values($columns_id,'$columns_name');";
	$dbObj->insertRec($sqlstr);	
	if ($dbObj->a_rows <= 0) return 0;	
	return 1;		
}

/**
 * 创建一个图片表格栏目 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_handle 栏目句柄
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_tpbglm($dbObj,$columns_handle)
{
	$sqlResult;
	$columns_id;	
		
	$sqlstr = "select columns_id from columns where columns_handle='$columns_handle'";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	$columns_id = $sqlResult["columns_id"];	
	$sqlstr = " insert into columns_imagetable(columns_id) values($columns_id);";
	$dbObj->insertRec($sqlstr);	
	if ($dbObj->a_rows <= 0) return 0;	
	return 1;		
}

/**
 * 以指定的sql语句创建一个图片表格栏目 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $sql 创建栏目内容的sql语句
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_tpbglm_by_sql($dbObj,$sql)
{
	$dbObj->insertRec($sql);	
	if ($dbObj->a_rows <= 0) return 0;	
	return 1;		
}

/**
 * 创建一个图片幻灯片栏目 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_handle 栏目句柄
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_tphdplm($dbObj,$columns_handle)
{
	$sqlResult;
	$columns_id;	
		
	$sqlstr = "select columns_id from columns where columns_handle='$columns_handle'";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	$columns_id = $sqlResult["columns_id"];	
	$sqlstr = " insert into columns_slideimage(columns_id) values($columns_id);";
	$dbObj->insertRec($sqlstr);	
	if ($dbObj->a_rows <= 0) return 0;	
	return 1;		
}

/**
 * 以指定的sql语句创建一个图片幻灯片栏目 (创建成功返回1 否则返回0)
 * @param $dbObj 数据库对象,需已打开
 * @param $sql 创建栏目内容的sql语句
 * @return 创建不成功返回0,创建成功返回1
 */
function createColumns_tphdplm_by_sql($dbObj,$sql)
{
	$dbObj->insertRec($sql);	
	if ($dbObj->a_rows <= 0) return 0;	
	return 1;		
}

/**
 * 删除栏目的基本信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_base_info($dbObj,$columns_id)
{
	$sqlstr = "delete from columns where columns_id=$columns_id;";	
	$dbObj->deleteRec($sqlstr);	
	if ($dbObj->a_rows >0) return 1;
	return 0;		
}

/**
 * 删除文章栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_wzlm($dbObj,$columns_id)
{
	//删除文章评论
	$sqlstr = "delete from article_comments where item_id=$columns_id";
	$dbObj->deleteRec($sqlstr);
	//删除文章内容
	$sqlstr = "delete from article_content where article_id in (select article_id from article where item_id=$columns_id)";
	$dbObj->deleteRec($sqlstr);
	//删除文章
	$sqlstr = " delete from article where item_id=$columns_id;";	
	$dbObj->deleteRec($sqlstr);
	
	$result = deleteColumns_base_info($dbObj,$columns_id); 
	return $result;	
}

/**
 * 删除链接条栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_ljtlm($dbObj,$columns_id)
{	
	$sqlstr = "delete from columns_link where columns_id=$columns_id;";	
	$dbObj->deleteRec($sqlstr);	 
	return deleteColumns_base_info($dbObj,$columns_id);	
}

/**
 * 删除二级链接条栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_ejljtlm($dbObj,$columns_id)
{	
	//删除子栏目
	$sqlstr = " delete from columns where columns_id in (select sub_columns_id from columns_link2 where columns_id=$columns_id)";	
	$dbObj->deleteRec($sqlstr);
	//删除条目信息
	$sqlstr = " delete from columns_link2 where columns_id=$columns_id";	
	$dbObj->deleteRec($sqlstr);
	//删除基本信息
	return deleteColumns_base_info($dbObj,$columns_id);		
}

/**
 * 删除自由编辑栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_zybjlm($dbObj,$columns_id)
{	
	$sqlstr = " delete from columns_html where columns_id=$columns_id;";	
	$dbObj->deleteRec($sqlstr);
	return deleteColumns_base_info($dbObj,$columns_id);	
}

/**
 * 删除调查栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_dclm($dbObj,$columns_id)
{	
	//删除自定义调查答案表记录
	$sqlstr = "delete from survey_custom where survey_item_id in (select survey_item_id from survey_item where columns_id=$columns_id)";
	$dbObj->deleteRec($sqlstr);
	//删除调查答案表记录
	$sqlstr = "delete from survey_item where columns_id=$columns_id";
	$dbObj->deleteRec($sqlstr);
	//删除调查表记录
	$sqlstr = " delete from survey where columns_id=$columns_id;";	
	$dbObj->deleteRec($sqlstr);
	return deleteColumns_base_info($dbObj,$columns_id);			
}

/**
 * 删除图片列表栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_tplblm($dbObj,$columns_id)
{	
	//标记引用图片为已删除
	$sqlstr = "update upload_files set file_state=2 where is_sys=0 and file_id in (select file_id from columns_imagelist where columns_id=$columns_id)";
	$dbObj->updateRec($sqlstr);
	//删除图片列表栏目表记录
	$sqlstr = "delete from columns_imagelist where columns_id=$columns_id";
	$dbObj->deleteRec($sqlstr);	
	return deleteColumns_base_info($dbObj,$columns_id);		
}

/**
 * 删除图片表格栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_tpbglm($dbObj,$columns_id)
{		
	$sqlstr = "delete from columns_imagetable where columns_id=$columns_id";
	$dbObj->deleteRec($sqlstr);	
	return deleteColumns_base_info($dbObj,$columns_id);	
}

/**
 * 删除图片幻灯片栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_tphdplm($dbObj,$columns_id)
{		
	$sqlstr = "delete from columns_slideimage where columns_id=$columns_id";
	$dbObj->deleteRec($sqlstr);	
	return deleteColumns_base_info($dbObj,$columns_id);	
}

/**
 * 删除专题栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_ztlm($dbObj,$columns_id)
{		
	$sqlResult;
	$sqlstr = "select columns_toptic_id from columns_toptic where columns_id=$columns_id";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	//删除基本栏目信息	
	return deleteColumns_base_info($dbObj,$columns_id);		
}

/**
 * 删除机构设置栏目信息
 * @param $dbObj 数据库对象,需已打开
 * @param $columns_id 栏目ID
 * @return 删除不成功返回0,删除成功返回1
 */
function deleteColumns_jgszlm($dbObj,$columns_id)
{		
	$sqlResult;
	$sqlstr = "select columns_partlist_id from columns_partlist where columns_id=$columns_id";
	$sqlResult = $dbObj->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	//删除基本栏目信息	
	$result = deleteColumns_base_info($dbObj,$columns_id); 
	return $result;			
}
?>