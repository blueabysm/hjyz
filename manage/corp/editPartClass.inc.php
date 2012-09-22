<?php
include_once("../../util/commonFunctions.php");

class editPartClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_name;
	public $corp_id;
	public $part_id;
	
	public $article_column_id;
	public $part_order;
	public $part_name;
	public $part_master;
	public $part_phone;
	public $part_monitor_phone;
	public $part_note;
	public $master_photo;
	public $part_addr;
	public $part_mail;
	
	public $file_url;
	public $colList;
	
	function editPartClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->corp_name = "";
		$this->part_id = 0;
		$this->corp_id = 0;
		
		$this->article_column_id = 0;
		$this->part_order = 100;
		$this->part_name = '';
		$this->part_master = '';
		$this->part_phone = '';
		$this->part_monitor_phone = '';
		$this->part_note = '';
		$this->master_photo = 0;
		$this->part_addr = '';
		$this->part_mail = '';
		
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
		if(isset($this->getVars["part_id"])){
			$this->part_id = trim($this->getVars["part_id"]);
		}
		if(isset($this->postVars["part_id"])){
			$this->part_id = trim($this->postVars["part_id"]);
		}
		if ( ($this->corp_id == 0) || (isNumber($this->corp_id) == 0) ){
				$this->errorMessage = "单位参数错误";
				$this->toURL = "partSet.php";
				return;			
		}
		if ( ($this->part_id == 0) || (isNumber($this->part_id) == 0) ){
				$this->errorMessage = "机构参数错误";
				$this->toURL = "managePart.php?id=".$this->corp_id;
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
		
		//加载栏目信息
		$sqlstr = 'select a.column_id,(select columns_name from columns b where a.column_id=b.columns_id) columns_name from corp_part_sub a where a.c_type=1 and a.item_id='.$this->part_id;
		$this->colList = $this->mysql->findAllRec($sqlstr);
		if ($this->colList == -1){
			$this->colList = NULL;
		}
						
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			
			$this->btnSave_Click();
			return;			
		}
		//加载机构信息
		$sqlstr = "select article_column_id,part_order,part_name,part_master,part_phone,part_monitor_phone,part_note,master_photo,part_addr,part_mail,(select file_name from upload_files u where c.master_photo=u.file_id) file_name from corp_part c where part_id=$this->part_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "managePart.php?id=".$this->corp_id;
			return ;
		}

		$this->article_column_id = $sqlResult["article_column_id"];
		$this->part_order = $sqlResult["part_order"];
		$this->part_name = trim($sqlResult["part_name"]);
		$this->part_master = trim($sqlResult["part_master"]);
		$this->part_phone = trim($sqlResult["part_phone"]);
		$this->part_monitor_phone = trim($sqlResult["part_monitor_phone"]);
		$this->part_note = trim($sqlResult["part_note"]);
		$this->master_photo = $sqlResult["master_photo"];
		$this->part_addr = trim($sqlResult["part_addr"]);
		$this->part_mail = trim($sqlResult["part_mail"]);
		
		$this->file_url = WEB_DIRECTORY_NAME.WEB_SITE_UPLOAD_URL.$sqlResult["file_name"];
		
		//修复图片状态 当用户进入编辑时删除了图片，又点击返回，会造成引用图片已被标记为已删除
		$sqlstr = "update upload_files set file_state=1 where file_state=2 and file_id=$this->master_photo";		
		$this->mysql->updateRec($sqlstr);
	}
	
	function btnSave_Click()
	{	
		
		//填充form
		$this->article_column_id = $this->postVars["article_column_id"];
		$this->part_order = $this->postVars["part_order"];
		$this->part_name = trim($this->postVars["part_name"]);
		$this->part_master = trim($this->postVars["part_master"]);
		$this->part_phone = trim($this->postVars["part_phone"]);
		$this->part_monitor_phone = trim($this->postVars["part_monitor_phone"]);
		$this->part_note = trim($this->postVars["part_note"]);
		$this->master_photo = $this->postVars["master_photo"];
		$this->part_addr = trim($this->postVars["part_addr"]);
		$this->part_mail = trim($this->postVars["part_mail"]);
		$this->file_url = trim($this->postVars["file_url"]);
		
		//检查参数
		if (strlen($this->part_name) <=0){
			$this->errorMessage = "请填写机构名称";
			return;
		}
		if (IsNumber($this->part_order) ==0){
			$this->errorMessage = "序号必须是一个数字";
			return;
		}		
		if (strlen($this->part_master) <=0){
			$this->errorMessage = "请填写负责人";
			return;
		}
		if (strlen($this->part_phone) <=0){
			$this->errorMessage = "请填写联系电话";
			return;
		}
		if (strlen($this->part_monitor_phone) <=0){
			$this->errorMessage = "请填监督电话";
			return;
		}
		if (strlen($this->part_note) <=0){
			$this->errorMessage = "请填机构职能";
			return;
		}				
		
		
		//修改基本信息
		$sqlstr = "update corp_part set article_column_id=$this->article_column_id,part_order=$this->part_order,part_name='$this->part_name',part_master='$this->part_master',part_phone='$this->part_phone',part_monitor_phone='$this->part_monitor_phone',part_note='$this->part_note',master_photo=$this->master_photo,part_addr='$this->part_addr',part_mail='$this->part_mail' where part_id=$this->part_id;";		
		
		$this->mysql->updateRec($sqlstr);
			
		$this->toURL = "managePart.php?id=".$this->corp_id;
	}
}
?>