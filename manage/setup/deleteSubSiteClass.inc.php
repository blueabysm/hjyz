<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");

class deleteSubSiteClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteSubSiteClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; //子站点ID
		$user_id;//用户ID
		$deleteResult = 0;
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		
		$this->toURL = "manageSubSite.php";
		if (($id==0) || (IsNumber($id)==0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		
		//取管理员ID
		$sqlstr = "select user_id from admins where user_sub_id=$id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的管理员!";
			return;
		}
		$user_id = $sqlResult["user_id"];
		//删除所有栏目
		$this->deleteSubSiteColumns($user_id,$id);
		//删除站点表记录
		$sqlstr = "delete from sub_sites where sub_sites_id=$id";
		$this->mysql->deleteRec($sqlstr);
	}
	
	/**
 	* 删除子网站的栏目
 	* @param $admin_id 子网站管理员ID
 	* @param $sub_id 子网站ID  	
 	*/
	function deleteSubSiteColumns($admin_id,$sub_id)
	{
		$col_id_list = "";
		$sqlstr = "select columns_id from columns where admin_id=$admin_id and sites_id=$sub_id";
		$columnsList = $this->mysql->findAllRec($sqlstr);
		for($i=0;$i<count($columnsList);++$i)
		{
			$col_id_list = $col_id_list . $columnsList[$i]["columns_id"] . ',';		
		}
		$col_id_list = substr($col_id_list,0,strlen($col_id_list) - 1);
		
		// ===========  所上传的图片
		$sqlstr = "update upload_files set file_state=2 where is_sys=0 and file_admin_id=$admin_id and file_state=1";		
		$this->mysql->updateRec($sqlstr);
		
		// ===========  文章栏目相关
		//删除文章评论
		$sqlstr = "delete from article_comments where item_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除文章内容
		$sqlstr = "delete from article_content where article_id in (select article_id from article where item_id in ($col_id_list))";
		$this->mysql->deleteRec($sqlstr);
		//删除文章
		$sqlstr = "delete from article where item_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=34 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);

		// ===========  调查栏目相关
		//删除自填调查备选答案
		$sqlstr = "delete from survey_custom where survey_item_id in (select survey_item_id from survey_item where columns_id in ($col_id_list))";
		$this->mysql->deleteRec($sqlstr);
		//删除调查答案表记录
		$sqlstr = "delete from survey_item where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除调查表记录
		$sqlstr = "delete from survey where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=37 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		// ===========  二级链接条栏目相关
		$sqlstr = "delete from columns_link2 where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=42 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		// ===========  链接条栏目相关
		$sqlstr = "delete from columns_link where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=35 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		// ===========  图片列表栏目相关
		$sqlstr = "delete from columns_imagelist where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=38 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		// ===========  图片幻灯片栏目相关
		$sqlstr = "delete from columns_slideimage where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=40 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		// ===========  图片表格栏目相关
		$sqlstr = "delete from columns_imagetable where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=39 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		// ===========  自由编辑栏目相关
		$sqlstr = "delete from columns_html where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
		//删除相关权限
		$sqlstr = "delete from my_object where user_id=$admin_id and menu_id=36 and obj_id in ($col_id_list);";	
		$this->mysql->deleteRec($sqlstr);
		
		//栏目
		$sqlstr = "delete from columns where columns_id in ($col_id_list)";
		$this->mysql->deleteRec($sqlstr);
	}
}
?>