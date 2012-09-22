<?php
class editSurveyItemClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $columns_id; //所属栏目ID
	public $columns_name; //栏目名称
	public $survey_item_id; //备选答案ID	
	public $item_type; //备选答案类型 1=单选 2=多选 3=自填
	public $display_order; //备选答案显示顺序
	public $item_contents;	//备选答案内容	
	public $isInput; //是否允许自填
	
	
	function editSurveyItemClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columns_id = 0;
		$this->columns_name = "";
		$this->survey_item_id = 0;
		$this->item_type = 0;
		$this->display_order = 100;
		$this->item_contents = "";
		$this->isInput = 0;
	}
	
	function Page_Load()
	{		
		
		//检查并设置参数		
		if(isset($this->getVars["id"])){
			$this->columns_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["columns_id"])){
			$this->columns_id = trim($this->postVars["columns_id"]);
		}
		if ( ($this->columns_id == 0) || (isNumber($this->columns_id) == 0) ){
				$this->errorMessage = "栏目参数错误";
				$this->toURL = "../columns/manageColumnsTree.php";
				return;			
		}		
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=37 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumnsTree.php";
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		
		//取调查类型
		$sqlstr = "select survey_type from survey where columns_id=$this->columns_id";		
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumnsTree.php";
			return;			
		}		
		$this->item_type = trim($sqlResult["survey_type"]);

		if(isset($this->getVars["i_id"])){
			$this->survey_item_id = trim($this->getVars["i_id"]);
		}
		if(isset($this->postVars["survey_item_id"])){
			$this->survey_item_id = trim($this->postVars["survey_item_id"]);
		}	
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			$this->btnSave_Click();
			return;
		}		
		
		//如果为0表示是添加备选答案
		if ($this->survey_item_id == 0) return;
		if (isNumber($this->survey_item_id) == 0){
			$this->errorMessage = "备选答案参数错误";
			$this->toURL = "manageSurvey.php?id=".$this->columns_id;
			
			return;			
		}
		//取备选答案信息
		$sqlstr = "select * from survey_item where survey_item_id=$this->survey_item_id";		
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageSurvey.php?id=".$this->columns_id;
			
			return;
		}
		
		$this->item_contents = trim($sqlResult["item_contents"]);
		if ($sqlResult["item_type"] == 3){
			$this->isInput = 1;
		}
		$this->display_order = $sqlResult["display_order"];
		
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";
		$result = 0;
		
		$this->item_contents = trim($this->postVars["item_contents"]);
		$this->display_order = trim($this->postVars["display_order"]);		
		if ($this->postVars["isInput"] == "ok"){
			$this->item_type = 3;
		} else {
			$this->item_type = $this->postVars["item_type"];
		}
		
		

		//检查参数
		if (IsNumber($this->display_order) == 0){
			$this->errorMessage = "序号必须是一个整数!";			
			return;
		}
		if (strlen($this->item_contents) < 1){
			$this->errorMessage = "必须填写备选答案内容!";			
			return;
		}
				
		//检查允许自填的调查备选答案数量，每个调查只能有一个
		if ( $this->item_type == 3)
		{
			$sqlstr = "select item_type from survey_item where item_type=3 and  columns_id=$this->columns_id";
			if ($this->survey_item_id>0){
				$sqlstr = $sqlstr . " and survey_item_id<>$this->survey_item_id";
			}
			$sqlResult = $this->mysql->findAllRec($sqlstr);
			if (($sqlResult > 0) && (count($sqlResult) >=1 )){
				$this->errorMessage = "一个调查只允许一条备选答案自填!";
				
				$this->isInput = 0;
				$this->item_type = $this->postVars["item_type"];
				return;
			}
		}
		
		if ($this->survey_item_id>0){
			$sqlstr = "update survey_item set item_type=$this->item_type,display_order=$this->display_order,item_contents='$this->item_contents' where survey_item_id=$this->survey_item_id;";			
			$this->mysql->updateRec($sqlstr);
			$result = $this->mysql->a_rows;
			$this->errorMessage = "保存未成功!";
		} else {
			$sqlstr = "insert into survey_item(columns_id,item_type,display_order,item_contents) values(" . 
					  "$this->columns_id,$this->item_type,$this->display_order,'$this->item_contents');";			
			$this->mysql->insertRec($sqlstr);			
			$result = $this->mysql->a_rows;
			$this->errorMessage = "添加未成功!";
		}
		$this->toURL = "manageSurvey.php?id=".$this->columns_id;
						
		if ($result > 0){			
			$this->errorMessage = "";
		}	
	}
}
?>