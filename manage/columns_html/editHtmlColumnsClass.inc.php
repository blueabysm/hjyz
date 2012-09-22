<?php
include_once("../../util/commonFunctions.php");
class editHtmlColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columns_id;
	public $columns_name;
	public $columns_contents;
	
	function editHtmlColumnsClass($postObj,$getObj,$mysql){
		
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		$this->retURL = "../columns/manageColumnsTree.php";

		$this->columns_id = 0;
		$this->columns_name = "";
		$this->columns_contents = "";
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
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
		
		$tmpstr = $this->columns_id;		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=36 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;			
			return;
		}
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			$this->btnSave_Click();
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		$sqlstr = "select columns_contents from columns_html where columns_id=$this->columns_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$this->columns_contents = trim($sqlResult["columns_contents"]);
				
	}
	
	function btnSave_Click()
	{		
		
		$this->columns_contents = trim($this->postVars["columns_contents"]);		
		
		//内容预处理
		$ip = 'http://'.$_SERVER['SERVER_ADDR'];
		if ($_SERVER['SERVER_PORT'] != 80){
			$ip = $ip.':'.$_SERVER['SERVER_PORT'];
		}
		$ip = $ip.'/';
		$this->columns_contents = str_replace($ip,'/',$this->columns_contents);
		$this->columns_contents = str_replace(WEB_DOMAIN_NAME,'',$this->columns_contents);
		if(get_magic_quotes_gpc()){
			$this->columns_contents=stripslashes($this->columns_contents);
		}
		$this->columns_contents = htmlspecialchars($this->columns_contents); 
		$sqlstr = "update columns_html set columns_contents='%%s' where columns_id=$this->columns_id";
		
		$args= array($this->columns_contents);
		$this->mysql->updateRec($sqlstr,$args);
 		
		$this->toURL = $this->retURL;
	}
	
}
?>