<?php
include_once("../../util/commonFunctions.php");

class deleteImageListColumnsClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	
	function deleteImageListColumnsClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		$this->retURL = "../columns/manageColumnsTree.php";
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; //链接条ID
		$cid=0; //栏目ID
		$fid=0;//引用的图片文件ID
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		if(isset($this->getVars["fid"])){
			$fid = trim($this->getVars["fid"]);			
		}
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}
		$this->toURL = "manageImageListColumns.php?id=$cid&retURL=$this->retURL";
		
		if (($id==0) || ($cid == 0) || ($fid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0) || (IsNumber($fid) == 0)){
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		//删除记录
		$sqlstr = "delete from columns_imagelist where columns_imagelist_id=$id and $cid in (select obj_id from my_object where menu_id=38 and user_id=".$_SESSION["sess_user_id"].")";
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows >0){
			//标记引用图片状态为已删除
			$sqlstr = "update upload_files set file_state=2 where is_sys=0 and  file_id=$fid";
			$this->mysql->updateRec($sqlstr);
		}
				
		
	}
}
?>