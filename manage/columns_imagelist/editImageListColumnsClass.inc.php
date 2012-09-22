<?php
include_once("../../util/commonFunctions.php");

class editImageListColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columns_name;
	public $columns_id;
	public $columns_imagelist_id;
	public $item_title;
	public $item_link;
	public $item_order;
	public $file_id;
	public $file_url;

	
	function editImageListColumnsClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		$this->retURL = "../columns/manageColumnsTree.php";
		
		$this->columns_name = "";
		$this->columns_id = 0;
		$this->columns_imagelist_id = 0;
		$this->item_order = 100;
		$this->item_title = "";
		$this->item_link = "";
		$this->file_id = 0;
		$this->file_url = "";		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
			
		//检查并设置参数
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}		
		if(isset($this->getVars["columns_id"])){
			$this->columns_id = trim($this->getVars["columns_id"]);
		}
		if(isset($this->postVars["columns_id"])){
			$this->columns_id = trim($this->postVars["columns_id"]);
		}
		if ( ($this->columns_id == 0) || (isNumber($this->columns_id) == 0) ){
				$this->errorMessage = "栏目参数错误";
				$this->toURL = $this->retURL;
				return;			
		}				
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=38 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);		
		
		
		
		if(isset($this->getVars["columns_imagelist_id"])){
			$this->columns_imagelist_id = trim($this->getVars["columns_imagelist_id"]);
		}
		if(isset($this->postVars["columns_imagelist_id"])){
			$this->columns_imagelist_id = trim($this->postVars["columns_imagelist_id"]);
		}		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			$this->btnSave_Click();
			return;
		}		
		if (isNumber($this->columns_imagelist_id) == 0){
			$this->errorMessage = "图片参数错误";
			$this->toURL = "manageImageListColumns.php?id=".$this->columns_id."&retURL=$this->retURL";
					
			return;			
		}
		//如果为0表示是添加链接条
		if ($this->columns_imagelist_id == 0){
			return;
		}		
		
		//加载链接条
		$sqlstr = "select item_order,file_id,(select file_name from upload_files u where c.file_id=u.file_id) file_name,item_title,item_link from columns_imagelist c where columns_imagelist_id=$this->columns_imagelist_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";			
			$this->toURL = "manageImageListColumns.php?id=".$this->columns_id."&retURL=$this->retURL";
			
			return 0;
		}
		
		$this->item_order = trim($sqlResult["item_order"]);
		$this->item_title = trim($sqlResult["item_title"]);
		$this->item_link = trim($sqlResult["item_link"]);
		$this->file_id = $sqlResult["file_id"];
		$this->file_url = $sqlResult["file_name"];
		
		//修复图片状态 当用户进入编辑时删除了图片，又点击返回，会造成引用图片已被标记为已删除
		$sqlstr = "update upload_files set file_state=1 where file_state=2 and file_id=$this->file_id";		
		$this->mysql->updateRec($sqlstr);
		
		
			
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
		//填充form		
		$this->item_order = trim($this->postVars["item_order"]);
		$this->item_title = trim($this->postVars["item_title"]);
		$this->item_link = trim($this->postVars["item_link"]);
		$this->file_id = intval($this->postVars["file_id"]);
		$this->file_url = trim($this->postVars["file_url"]);		
		
		//检查参数
		if (strlen($this->item_title) <=0){
			$this->errorMessage = "请填写图片的标题";
			return;
		}
		if (IsNumber($this->item_order) == 0){
			$this->errorMessage = "序号必须是一个整数!";			
			return;
		}
		if ($this->file_id == 0)
		{
			$this->errorMessage = "必须指定一个图片!";			
			return;
		}		
		
		//保存记录							
		if ($this->columns_imagelist_id>0){
			$sqlstr = "update columns_imagelist set file_id=$this->file_id,item_order=$this->item_order,item_title='$this->item_title',item_link='$this->item_link' where columns_imagelist_id=$this->columns_imagelist_id;";		
			$this->mysql->updateRec($sqlstr);
			
			$result = $this->mysql->a_rows;
		} else {
			$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$this->columns_id,$this->file_id,$this->item_order,'$this->item_title','$this->item_link');";			
			$this->mysql->insertRec($sqlstr);			
			$result = $this->mysql->a_rows;
		}
		
				
		if ($result <= 0){			
			$this->errorMessage = "保存未成功!";
		}		
		$this->toURL = "manageImageListColumns.php?id=".$this->columns_id."&retURL=$this->retURL";
	}
}
?>