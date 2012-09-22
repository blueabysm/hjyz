<?php

include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class deleteColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	function deleteColumnsClass($postObj,$getObj,$mysql)
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
		$columns_id = 0; //栏目ID		
		$type_handle; //栏目类型句柄
		$deleteResult = 0;
		
		$this->toURL = "manageColumnsAdmin.php";
		if(isset($this->getVars["id"])){
			$columns_id = trim($this->getVars["id"]);
		}		
		if (($columns_id == 0) || (IsNumber($columns_id) == 0) ){
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		$sqlstr = "select (select type_handle from columns_type t where  t.columns_type_id=c.columns_type_id) type_handle from columns c where create_type=1 and columns_id=$columns_id and admin_id=".$_SESSION["sess_user_id"];
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";			
			
			return;
		}
		$type_handle = $sqlResult["type_handle"];
		
		switch ($type_handle)
		{
			case 'zdlm' :
				//自动栏目
				$deleteResult = deleteColumns_base_info($this->mysql,$columns_id);
				break;
			case 'wzlm'	:
				//文章栏目
				//删除基本信息								
				$deleteResult = deleteColumns_wzlm($this->mysql,$columns_id);				
				break;
			case 'xxgk'	:
				//信息公开	
				//删除基本信息								
				$deleteResult = deleteColumns_wzlm($this->mysql,$columns_id);					
				break;
			case 'ljtlm':
				//链接条栏目								
				$deleteResult = deleteColumns_ljtlm($this->mysql,$columns_id);				
				break;
			case 'ejljtlm':
				//二级链接条栏目								
				$deleteResult = deleteColumns_ejljtlm($this->mysql,$columns_id);							
				break;
			case 'zybjlm':
				//自由编辑栏目								
				$deleteResult = deleteColumns_zybjlm($this->mysql,$columns_id);				
				break;
			case 'dclm':
				//调查栏目
				$deleteResult = deleteColumns_dclm($this->mysql,$columns_id);				
				break;
			case 'tplblm':
				//图片列表栏目				
				$deleteResult = deleteColumns_tplblm($this->mysql,$columns_id);
				break;
			case 'tpbglm':
				//图片表格栏目				
				$deleteResult = deleteColumns_tpbglm($this->mysql,$columns_id);				
				break;
			case 'tphdplm':
				//图片幻灯片栏目				
				$deleteResult = deleteColumns_tphdplm($this->mysql,$columns_id); 				
				break;
			case 'ztlm':
				//专题栏目								
				$deleteResult = deleteColumns_ztlm($this->mysql,$columns_id);
				if ($deleteResult == 0){
					$this->errorMessage = "该栏目仍然拥有子栏目，无法删除";
				}				
				break;
			case 'jgszlm':
				//机构设置栏目				
				$deleteResult = deleteColumns_jgszlm($this->mysql,$columns_id);
				if ($deleteResult == 0){
					$this->errorMessage = "该栏目仍然拥有子栏目，无法删除";
				}
				break;
			default:
				$this->errorMessage = "无法法识别的栏目类型";				
				break;
		}
		
		if ($deleteResult >0){
			if (strlen($this->errorMessage) == 0) {
				$this->errorMessage = "删除成功!";
			}			
		}
				
	}
}
?>