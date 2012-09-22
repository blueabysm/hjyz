<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editSubSiteClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $template_dir_name;
	public $sub_sites_id;
	public $site_name;
	public $site_href;
	public $site_state;
	public $templateList;
	public $site_state_list;	
	

	
	function editSubSiteClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";		

		$this->template_dir_name = "";
		$this->sub_sites_id = 0;
		$this->site_name = "";
		$this->site_href = "";	
		$this->site_state = 2;	
		$this->site_state_list = array(1,"正常",2,"关停");	
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";
		
		if(isset($this->getVars["id"])){
			$this->sub_sites_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["sub_sites_id"])){
			$this->sub_sites_id = trim($this->postVars["sub_sites_id"]);
		}		
		if ( ($this->sub_sites_id == 0) || (isNumber($this->sub_sites_id) == 0) ){
				$this->errorMessage = "参数错误";
				$this->toURL = "manageSubSite.php";
				return;			
		}
						
		//取模板列表
					
		$sqlstr = "select * from site_template where template_type=2";
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
		//网站信息
		$sqlstr = "select site_state,template_dir_name,site_name,site_href from sub_sites where site_type=2 and sub_sites_id=$this->sub_sites_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageSubSite.php";
			return;
		}
			
		$this->template_dir_name = trim($sqlResult["template_dir_name"]);
		$this->site_href = trim($sqlResult["site_href"]);
		$this->site_state = trim($sqlResult["site_state"]);
		$this->site_name = trim($sqlResult["site_name"]);
		
				
	}
	
	function btnSave_Click()
	{
		
		//填充form
		$this->template_dir_name = trim($this->postVars["template_dir_name"]);
		$this->site_href = strtolower(trim($this->postVars["site_href"]));
		$this->site_state = trim($this->postVars["site_state"]);
		$this->site_name = trim($this->postVars["site_name"]);		
		
		//检查参数
		if (strlen($this->site_name) <= 0) {
			$this->errorMessage = "请填写网站名称";
			return;
		}
		
		//更新网站信息		
		$sqlstr = "update sub_sites set site_state=$this->site_state,template_dir_name='$this->template_dir_name',site_name='$this->site_name',site_href='$this->site_href' where sub_sites_id=$this->sub_sites_id";								
		$this->mysql->updateRec($sqlstr);
		
		$this->toURL = "manageSubSite.php";
	}}
?>