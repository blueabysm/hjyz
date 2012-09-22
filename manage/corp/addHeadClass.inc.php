<?php
include_once("../../util/commonFunctions.php");

class addHeadClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_name;
	public $corp_id;
	
	public $head_order;
	public $head_name;
	public $head_photo;
	public $head_post;
	public $head_post2;
	public $head_note;
	public $head_mail;	
	
	public $file_url;
	
	function addHeadClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->corp_name = "";
		$this->corp_id = 0;
		
		$this->head_order = 100;
		$this->head_name = '';
		$this->head_photo = 0;
		$this->head_post = '';
		$this->head_post2 = '';
		$this->head_note = '';
		$this->head_mail = '';
		
		$this->file_url = '';
		
	}
	
	function Page_Load()
	{
						
		//检查并设置参数		
		if(isset($this->getVars["corp_id"])){
			$this->corp_id = trim($this->getVars["corp_id"]);
		}
		if(isset($this->postVars["corp_id"])){
			$this->corp_id = trim($this->postVars["corp_id"]);
		}
		if ( ($this->corp_id == 0) || (isNumber($this->corp_id) == 0) ){
				$this->errorMessage = "单位参数错误";
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
		$this->corp_name = trim($sqlResult["short_name"]);						
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			$this->btnSave_Click();
		}		
	}
	
	function btnSave_Click()
	{	
		
		//填充form
		
		$this->head_order = $this->postVars["head_order"];
		$this->head_name = trim($this->postVars["head_name"]);
		$this->head_photo = $this->postVars["head_photo"];
		$this->head_post = trim($this->postVars["head_post"]);
		$this->head_post2 = trim($this->postVars["head_post2"]);
		$this->head_note = trim($this->postVars["head_note"]);
		$this->head_mail = trim($this->postVars["head_mail"]);
		$this->file_url = trim($this->postVars["file_url"]);
		
		//检查参数
		if (strlen($this->head_name) <=0){
			$this->errorMessage = "请填写领导姓名";
			return;
		}
		if (IsNumber($this->head_order) ==0){
			$this->errorMessage = "序号必须是一个数字";
			return;
		}		
		if (strlen($this->head_post) <=0){
			$this->errorMessage = "请填写职务";
			return;
		}		
		
		//修改基本信息
		$sqlstr = 'insert into corp_head(
					corp_id,
					article_column_id,
					head_order,
					head_name,
					head_photo,
					head_post,
					head_post2,
					head_note,
					head_mail) values('.
					"$this->corp_id,
					0,
					$this->head_order,
					'$this->head_name',
					$this->head_photo,
					'$this->head_post',
					'$this->head_post2',
					'$this->head_note',
					'$this->head_mail')";
		$this->mysql->insertRec($sqlstr);
			
		$this->toURL = "manageHead.php?id=".$this->corp_id;
	}
}
?>