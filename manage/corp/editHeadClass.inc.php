<?php
include_once("../../util/commonFunctions.php");

class editHeadClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_name;
	public $corp_id;
	
	public $head_id;
	public $article_column_id;
	public $head_order;
	public $head_name;
	public $head_photo;
	public $head_post;
	public $head_post2;
	public $head_note;
	public $head_mail;	
	
	public $file_url;
	public $colList;
	
	function editHeadClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->corp_name = "";
		$this->corp_id = 0;
		$this->head_id = 0;
		
		$this->article_column_id = 0;
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
		if(isset($this->getVars["head_id"])){
			$this->head_id = trim($this->getVars["head_id"]);
		}
		if(isset($this->postVars["head_id"])){
			$this->head_id = trim($this->postVars["head_id"]);
		}
		if ( ($this->corp_id == 0) || (isNumber($this->corp_id) == 0) ){
				$this->errorMessage = "单位参数错误";
				$this->toURL = "partSet.php";
				return;			
		}
		if ( ($this->head_id == 0) || (isNumber($this->head_id) == 0) ){
				$this->errorMessage = "领导信息参数错误";
				$this->toURL = "manageHead.php?id=".$this->corp_id;
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
		$sqlstr = 'select a.column_id,(select columns_name from columns b where a.column_id=b.columns_id) columns_name from corp_part_sub a where a.c_type=2 and a.item_id='.$this->head_id;
		$this->colList = $this->mysql->findAllRec($sqlstr);
		if ($this->colList == -1){
			$this->colList = NULL;
		}
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			$this->btnSave_Click();
			return;
		}		
		//加载领导信息
		$sqlstr = "select article_column_id,head_order,head_name,head_photo,head_post,head_post2,head_note,head_mail,(select file_name from upload_files u where c.head_photo=u.file_id) file_name from corp_head c where head_id=$this->head_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageHead.php?id=".$this->corp_id;
			return ;
		}
		
		$this->head_order = $sqlResult["head_order"];
		$this->head_name = trim($sqlResult["head_name"]);
		$this->head_photo = $sqlResult["head_photo"];
		$this->head_post = trim($sqlResult["head_post"]);
		$this->head_post2 = trim($sqlResult["head_post2"]);
		$this->head_note = trim($sqlResult["head_note"]);
		$this->head_mail = trim($sqlResult["head_mail"]);
		$this->article_column_id = $sqlResult["article_column_id"];
		
		$this->file_url = WEB_DIRECTORY_NAME.WEB_SITE_UPLOAD_URL.$sqlResult["file_name"];
		
		//修复图片状态 当用户进入编辑时删除了图片，又点击返回，会造成引用图片已被标记为已删除
		$sqlstr = "update upload_files set file_state=1 where file_state=2 and file_id=$this->head_id";		
		$this->mysql->updateRec($sqlstr);
	}
	
	function btnSave_Click()
	{	
		
		//填充form
		$this->article_column_id = $this->postVars["article_column_id"];
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
		$sqlstr = "update corp_head set
					 article_column_id=$this->article_column_id,
					head_order=$this->head_order,
					head_name='$this->head_name',
					head_photo=$this->head_photo,
					head_post='$this->head_post',
					head_post2='$this->head_post2',
					head_note='$this->head_note',
					head_mail='$this->head_mail' where head_id=$this->head_id";
		$this->mysql->updateRec($sqlstr);		
			
		$this->toURL = "manageHead.php?id=".$this->corp_id;
	}
}
?>