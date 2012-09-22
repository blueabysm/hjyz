<?php
class manageSurveyClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columns_id;
	public $columns_name;
	public $survey_type;
	public $display_type;
	public $text_display_mode;
	public $survey_contents;
	public $survey_type_list;
	public $text_display_mode_list;
	public $surveyItemList;
	
	
	function manageSurveyClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columns_id = 0;
		$this->columns_name = "";
		$this->survey_type = 1;
		$this->display_type = 1;
		$this->text_display_mode = 3;
		$this->survey_contents = "";
		$this->survey_type_list = array(1,"多选",2,"单选");
		$this->text_display_mode_list = array(1,"百分比",2,"票数",3,"百分比+票数");
		
		$this->retURL = "../columns/manageColumnsTree.php";
		
	}
	
	function Page_Load()
	{
		
		
		//检查并设置参数
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}

		
		if(isset($this->getVars["id"])){
			$this->columns_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["columns_id"])){
			$this->columns_id = trim($this->postVars["columns_id"]);
		}
		if ( ($this->columns_id == 0) || (isNumber($this->columns_id) == 0) ){
			$this->errorMessage = "栏目参数错误";
			$this->toURL = $this->retURL;
			return;			
		}
		
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=37 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		
		
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			return $this->btnSave_Click();
		}
		
		$sqlstr = "select * from survey_item where columns_id=$this->columns_id order by display_order";
		$this->surveyItemList = $this->mysql->findAllRec($sqlstr);
		
		//取当前记录
		$sqlstr = "select * from survey where columns_id=$this->columns_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = $this->retURL;
			
			return;
		}		
		$this->survey_type = trim($sqlResult["survey_type"]);
		$this->display_type = trim($sqlResult["display_type"]);
		$this->text_display_mode = trim($sqlResult["text_display_mode"]);
		$this->survey_contents = trim($sqlResult["survey_contents"]);
		
		return;
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		
		
		$this->survey_type = trim($this->postVars["survey_type"]);
		$this->display_type = trim($this->postVars["display_type"]);
		$this->text_display_mode = trim($this->postVars["text_display_mode"]);
		$this->survey_contents = trim($this->postVars["survey_contents"]);
		
		
		if (strlen($this->survey_contents) < 1 ){
			$this->errorMessage = "必须填写调查的内容!";
			return 0;
		}

		
		$sqlstr = "update survey set survey_type=$this->survey_type,display_type=$this->display_type,text_display_mode=$this->text_display_mode,survey_contents='$this->survey_contents' where columns_id=$this->columns_id";			
		$this->mysql->updateRec($sqlstr);		
		
				
		if ($this->mysql->a_rows <= 0){			
			$this->errorMessage = "保存未成功!";
		}
		$this->toURL = $this->retURL;
	}
}
?>