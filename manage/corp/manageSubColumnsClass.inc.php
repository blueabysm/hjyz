<?php
include_once("../../util/commonFunctions.php");

class manageSubColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	public $corpName;	
	public $corp_id;
	public $objName;
	public $objID;
	public $subColumnsList;
	public $s_type;
	public $page_name;
	
	
	function manageSubColumnsClass($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->corp_id = 0;
		$this->objID = 0;
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;		
		
		//检查并设置参数
 		if(isset($this->getVars["id"])){
			$this->objID = trim($this->getVars["id"]);
		}		
		if(isset($this->getVars["corp_id"])){
			$this->corp_id = trim($this->getVars["corp_id"]);
		}
 		if(isset($this->getVars["s_type"])){
			$this->s_type = trim($this->getVars["s_type"]);
		}		
		if ( ($this->corp_id == 0) || 
		     (isNumber($this->corp_id) == 0) || 
		     ($this->objID == 0) || 
		     (isNumber($this->objID) == 0) || 
		     (isNumber($this->s_type) == 0) ||
		     ($this->s_type < 1) ||
		     ($this->s_type >2)
		     )
		   {
			$this->errorMessage = "参数错误";
			$this->toURL = "partSet.php";
			return;			
		}

		$sqlstr = "select short_name from corp where c_id=$this->corp_id and $this->corp_id in (select obj_id from my_object where menu_id=20 and user_id=".$_SESSION["sess_user_id"].')';		 
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的单位!";
			$this->toURL = "partSet.php";
			return;
		}
		$this->corpName = trim($sqlResult["short_name"]);
		
 		//加载信息
 		if ($this->s_type == 1){
 			$field_name = 'part_name';
 			$sqlstr = "select $field_name from corp_part where part_id=$this->objID";
 			$this->page_name = 'managePart.php';
 		} else {
 			$field_name = 'head_name';
 			$sqlstr = "select $field_name from corp_head where head_id=$this->objID";
 			$this->page_name = 'manageHead.php';
 		}
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "partSet.php";
			return ;
		}
		$this->objName = trim($sqlResult[$field_name]);
		
		//取栏目列表
		$sqlstr = "select sub_id,(select columns_name from columns b where b.columns_id=a.column_id) columns_name from corp_part_sub a where c_type=$this->s_type and  item_id=$this->objID order by sub_order";
 		$this->subColumnsList = $this->mysql->findAllRec($sqlstr);
 		
 	}
 	
}
?>