<?php
class mainSiteInfoClass
{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $template_dir_name;
	
	public $templateList;
	
	
	
	function mainSiteInfoClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		$this->template_dir_name = "";		
	}
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		
		

		//取模板列表
					
		$sqlstr = "select * from site_template where template_type=1";
		$this->templateList = $this->mysql->findAllRec($sqlstr);
		if ($this->templateList == -1){
			$this->errorMessage = "模板信息丢失!";
			$this->toURL = "../logout.php";
			return;
		}
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
			return;
		}
		$sqlstr = "select * from sub_sites where site_type=1";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		
		$this->template_dir_name = trim($sqlResult["template_dir_name"]);
		$this->site_href = trim($sqlResult["site_href"]);		
		$this->site_name = trim($sqlResult["site_name"]);		
		
			
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";
		
		$this->template_dir_name = trim($this->postVars["template_dir_name"]);		
				
		
			
		$sqlstr = "update sub_sites set template_dir_name='$this->template_dir_name' where site_state=1 and  site_type=1";		
		$this->mysql->updateRec($sqlstr);
		if ($this->mysql->a_rows > 0){
			$this->errorMessage = "保存已成功";
		}
		
	}
}
?>