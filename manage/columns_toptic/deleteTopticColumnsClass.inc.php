<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");

class deleteTopticColumnsClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteTopticColumnsClass($postObj,$getObj,$mysql)
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
		$id=0; //机构ID
		$cid=0; //栏目ID
		$deleteResult = 0;
		$small_img_id; //首页图片ID
		$big_img_id; //标题图片ID
		$slide_id; //幻灯片栏目ID
		$article_column_id;//最新消息栏目ID
		$html_column_id;//专题介绍栏目ID
		$imagetable_id;//图片新闻栏目ID
		
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		$this->toURL = "manageTopticColumns.php?id=$cid";
		if (($id==0) || ($cid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		
		//取其基本信息
		$sqlstr = "select small_img_id,big_img_id,slide_id,article_column_id,html_column_id,imagetable_id from columns_toptic where columns_toptic_id=$id and $cid in (select obj_id from my_object where menu_id=41 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的专题!";
			return;
		}
		
		$small_img_id = $sqlResult["small_img_id"];
		$big_img_id = $sqlResult["big_img_id"];
		$slide_id = $sqlResult["slide_id"];
		$article_column_id = $sqlResult["article_column_id"];
		$html_column_id = $sqlResult["html_column_id"];
		$imagetable_id = $sqlResult["imagetable_id"];
		//删除幻灯片栏目
		$deleteResult = deleteColumns_tphdplm($this->mysql,$slide_id);
		if ($deleteResult == 0) {			
			$this->errorMessage = "删除失败";
			
			return;
		}
		//删除最新消息栏目
		deleteColumns_wzlm($this->mysql,$article_column_id);
		//删除专题介绍栏目
		deleteColumns_zybjlm($this->mysql,$html_column_id);
		//删除图片新闻栏目
		deleteColumns_tpbglm($this->mysql,$imagetable_id);
		
		//设置图片为删除状态
		$sqlstr = "update upload_files set file_state=2 where is_sys=0 and file_id in ($small_img_id,$big_img_id)";
		$this->mysql->updateRec($sqlstr);
		//删除专题表记录
		$sqlstr = "delete from columns_toptic where columns_toptic_id=$id";
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows <=0){
			$this->errorMessage = "删除未成功!";			
		}
		
		//删除权限
		$slide_id; //幻灯片栏目ID
		$article_column_id;//最新消息栏目ID
		$html_column_id;//专题介绍栏目ID
		$imagetable_id;//图片新闻栏目ID
		$sqlstr = 'delete from my_object where user_id='.$_SESSION["sess_user_id"]." and menu_id in (40,34,36,39) and obj_id in ($slide_id,$article_column_id,$html_column_id,$imagetable_id)";
		$this->mysql->deleteRec($sqlstr);
		
	}
}
?>