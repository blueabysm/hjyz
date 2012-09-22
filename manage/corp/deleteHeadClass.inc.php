<?php
include_once("../../util/commonFunctions.php");

class deleteHeadClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteHeadClass($postObj,$getObj,$mysql)
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
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		$this->toURL = "manageHead.php?id=$cid";
		if (($id==0) || ($cid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
				
		//取其基本信息
		$sqlstr = "select head_photo from corp_head where head_id=$id and corp_id=$cid and $cid in (select obj_id from my_object where menu_id=20 and user_id=".$_SESSION["sess_user_id"].')';		 
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的单位!";
			$this->toURL = "partSet.php";
			return;
		}
		$head_photo = $sqlResult["head_photo"];		
		
		//删除文章栏目引用
		$sqlstr = "delete from corp_part_sub where c_type=2 and item_id=$id";
		$this->mysql->deleteRec($sqlstr);
		
		//标记负责人相片为删除状态
		if ($master_photo>0){
			$sqlstr = "update upload_files set file_state=2 where file_id=$head_photo";
			$this->mysql->updateRec($sqlstr);
		}
		
		//删除子栏目表记录		
		$sqlstr = "delete from corp_part_sub where c_type=2 and item_id=$id";;
		$this->mysql->deleteRec($sqlstr);
 		//删除机构表记录
		$sqlstr = "delete from corp_head where head_id=$id";
		$this->mysql->deleteRec($sqlstr);		
	}
}
?>