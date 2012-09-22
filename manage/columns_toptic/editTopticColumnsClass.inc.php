<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editTopticColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $columns_toptic_id;
	public $columns_name;
	public $columns_id;	
	public $small_img_id;
	public $small_img_width;
	public $small_img_height;
	public $big_img_id;
	public $big_img_width;
	public $big_img_height;
	public $toptic_order;	
	public $slide_name;
	public $article_column_name;
	public $html_column_name;
	public $imagetable_name;
	public $toptic_name;
	public $toptic_href;
	public $toptic_note;
	public $small_img_url;
	public $big_img_url;
	public $to_index;
	public $slide_id;
	public $article_column_id;
	public $html_column_id;
	public $imagetable_id;
	
	public $to_index_list;
	
	

	
	function editTopticColumnsClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columns_toptic_id = 0;
		$this->columns_name = "";
		$this->columns_id = 0;	
		$this->small_img_id = 0;
		$this->small_img_width = 553;
		$this->small_img_height = 60;
		$this->big_img_id = 0;
		$this->big_img_width = 979;
		$this->big_img_height = 151;
		$this->toptic_order = 100;	
		$this->slide_name = "图片幻灯片";
		$this->article_column_name = "最新消息";
		$this->html_column_name = "专题简介";
		$this->imagetable_name = "图片";
		$this->toptic_name = "";
		$this->toptic_href = "";
		$this->toptic_note = "";
		$this->small_img_url = "";
		$this->big_img_url = "";
		$this->to_index = 0;
		
		$this->to_index_list = array(0,"否",1,"是");
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
				
		//检查并设置参数		
		if(isset($this->getVars["columns_id"])){
			$this->columns_id = trim($this->getVars["columns_id"]);
		}
		if(isset($this->postVars["columns_id"])){
			$this->columns_id = trim($this->postVars["columns_id"]);
		}
		if(isset($this->getVars["columns_toptic_id"])){
			$this->columns_toptic_id = trim($this->getVars["columns_toptic_id"]);
		}
		if(isset($this->postVars["columns_toptic_id"])){
			$this->columns_toptic_id = trim($this->postVars["columns_toptic_id"]);
		}
		if ( ($this->columns_id == 0) || (isNumber($this->columns_id) == 0) ){
				$this->errorMessage = "栏目参数错误";
				$this->toURL = "../columns/manageColumns.php";
				return;			
		}
		if ( ($this->columns_toptic_id == 0) || (isNumber($this->columns_toptic_id) == 0) ){
				$this->errorMessage = "专题参数错误";
				$this->toURL = "manageTopticColumns.php?id=".$this->columns_id;
				return;			
		}				
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=41 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumns.php";
			
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		//加载信息
		$sqlstr = "select small_img_id,small_img_width,small_img_height,big_img_id,big_img_width,big_img_height,toptic_order,to_index,toptic_name,toptic_href,toptic_note,slide_id,article_column_id,html_column_id,imagetable_id";
		$sqlstr = $sqlstr . ",(select file_name small_img_url from upload_files where small_img_id=file_id) small_img_url";
		$sqlstr = $sqlstr . ",(select file_name big_img_url from upload_files where big_img_id=file_id) big_img_url";
		$sqlstr = $sqlstr . ",(select columns_name from columns where columns_id=slide_id) slide_name";
		$sqlstr = $sqlstr . ",(select columns_name from columns where columns_id=article_column_id) article_column_name";
		$sqlstr = $sqlstr . ",(select columns_name from columns where columns_id=html_column_id) html_column_name";
		$sqlstr = $sqlstr . ",(select columns_name from columns where columns_id=imagetable_id) imagetable_name";
		$sqlstr = $sqlstr . " from  columns_toptic where columns_toptic_id=$this->columns_toptic_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageTopticColumns.php?id=".$this->columns_id;
			
			return;
		}
		$this->slide_id = $sqlResult["slide_id"];
		$this->article_column_id = $sqlResult["article_column_id"];
		$this->html_column_id = $sqlResult["html_column_id"];
		$this->imagetable_id = $sqlResult["imagetable_id"];
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
						
			$this->btnSave_Click();
			return;			
		}
		
		$this->small_img_id = $sqlResult["small_img_id"];
		$this->small_img_width = $sqlResult["small_img_width"];
		$this->small_img_height = $sqlResult["small_img_height"];
		$this->big_img_id = $sqlResult["big_img_id"];
		$this->big_img_width = $sqlResult["big_img_width"];
		$this->big_img_height = $sqlResult["big_img_height"];
		$this->toptic_order = $sqlResult["toptic_order"];		
		$this->slide_name = $sqlResult["slide_name"];
		$this->article_column_name = $sqlResult["article_column_name"];
		$this->html_column_name = $sqlResult["html_column_name"];
		$this->imagetable_name = $sqlResult["imagetable_name"];
		$this->toptic_name = trim($sqlResult["toptic_name"]);
		$this->toptic_href = trim($sqlResult["toptic_href"]);
		$this->toptic_note = trim($sqlResult["toptic_note"]);
		$this->small_img_url = WEB_DOMAIN_NAME.$sqlResult["small_img_url"];
		$this->big_img_url = WEB_DOMAIN_NAME.$sqlResult["big_img_url"];	
		$this->to_index = $sqlResult["to_index"];
		
		//修复图片状态 当用户进入编辑时删除了图片，又点击返回，会造成引用图片已被标记为已删除
		$sqlstr = "update upload_files set file_state=1 where file_state=2 and file_id in ($this->small_img_id,$this->big_img_id)";
		$this->mysql->updateRec($sqlstr);
		
		
		
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";		
		
		//填充form
		$this->small_img_id = trim($this->postVars["small_img_id"]);
		$this->small_img_width = trim($this->postVars["small_img_width"]);
		$this->small_img_height = trim($this->postVars["small_img_height"]);
		$this->big_img_id = trim($this->postVars["big_img_id"]);
		$this->big_img_width = trim($this->postVars["big_img_width"]);
		$this->big_img_height = trim($this->postVars["big_img_height"]);
		$this->toptic_order = trim($this->postVars["toptic_order"]);
		$this->slide_name = trim($this->postVars["slide_name"]);
		$this->article_column_name = trim($this->postVars["article_column_name"]);
		$this->html_column_name = trim($this->postVars["html_column_name"]);
		$this->imagetable_name = trim($this->postVars["imagetable_name"]);
		$this->toptic_name = trim($this->postVars["toptic_name"]);
		$this->toptic_href = trim($this->postVars["toptic_href"]);
		$this->toptic_note = trim($this->postVars["toptic_note"]);
		$this->small_img_url = trim($this->postVars["small_img_url"]);
		$this->big_img_url = trim($this->postVars["big_img_url"]);		
		$this->to_index = trim($this->postVars["to_index"]);
		
		//检查参数
		if (strlen($this->toptic_name) <=0){
			$this->errorMessage = "请专题名称";
			return;
		}		
		if (IsNumber($this->toptic_order) ==0){
			$this->errorMessage = "序号必须是一个数字";
			return;
		}
		if ((IsNumber($this->small_img_id) ==0) || (intval($this->small_img_id) == 0) ){
			$this->errorMessage = "必须上传首页图片";
			return;
		}
		if (IsNumber($this->small_img_height) ==0){
			$this->errorMessage = "首页图片高度必须是一个数字";
			return;
		}
		if (IsNumber($this->small_img_width) ==0){
			$this->errorMessage = "首页图片宽度必须是一个数字";
			return;
		}
		if ((IsNumber($this->big_img_id) ==0) || (intval($this->big_img_id) == 0) ){
			$this->errorMessage = "必须上传标题图片";
			return;
		}
		if (IsNumber($this->big_img_height) ==0){
			$this->errorMessage = "标题图片高度必须是一个数字";
			return;
		}
		if (IsNumber($this->big_img_width) ==0){
			$this->errorMessage = "标题图片宽度必须是一个数字";
			return;
		}
		if (strlen($this->slide_name) <=0){
			$this->errorMessage = "请填写幻灯片栏目名称";
			return;
		}
		if (strlen($this->article_column_name) <=0){
			$this->errorMessage = "请填写最新消息栏目名称";
			return;
		}
		if (strlen($this->html_column_name) <=0){
			$this->errorMessage = "请填写专题介绍栏目名称";
			return;
		}
		if (strlen($this->imagetable_name) <=0){
			$this->errorMessage = "请填写图片新闻栏目名称";
			return;
		}
		
				
		
		
		//更新栏目名称信息
		$sqlstr = "update columns set columns_name='$this->slide_name' where columns_id=$this->slide_id";		
		$this->mysql->updateRec($sqlstr);
		$sqlstr = "update columns set columns_name='$this->article_column_name' where columns_id=$this->article_column_id";		
		$this->mysql->updateRec($sqlstr);
		$sqlstr = "update columns set columns_name='$this->html_column_name' where columns_id=$this->html_column_id";		
		$this->mysql->updateRec($sqlstr);
		$sqlstr = "update columns set columns_name='$this->imagetable_name' where columns_id=$this->imagetable_id";		
		$this->mysql->updateRec($sqlstr);
		if (intval($this->to_index) == 1){
			$sqlstr = "update columns_toptic set to_index=0 where to_index=1 and columns_id=".$this->columns_id;		
			$this->mysql->updateRec($sqlstr);
		}
		//更新基本信息
		$sqlstr = "update columns_toptic set small_img_id=$this->small_img_id,small_img_width=$this->small_img_width,small_img_height=$this->small_img_height,big_img_id=$this->big_img_id,big_img_width=$this->big_img_width,big_img_height=$this->big_img_height,toptic_order=$this->toptic_order,to_index=$this->to_index,toptic_name='$this->toptic_name',toptic_href='$this->toptic_href',toptic_note='$this->toptic_note' where columns_toptic_id=$this->columns_toptic_id";
		$this->mysql->updateRec($sqlstr);
		$result = $this->mysql->a_rows;		
		
		if ($result <= 0){			
			$this->errorMessage = "保存未成功!";
		}
		$this->toURL = "manageTopticColumns.php?id=".$this->columns_id;
	}
}
?>