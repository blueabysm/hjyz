<?php
include_once("../../util/commonFunctions.php");

class editSlideImageColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columns_name; //栏目名称
	public $columns_id;//栏目id
	public $columns_imagelist_id;//图片列表id
	public $text_height;//文字区域高度	
	public $img_width;//图片宽度
	public $img_heigth;//图片高度
	
	public $my_imagelist;
	

	
	function editSlideImageColumnsClass($postObj,$getObj,$mysql)
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
		$this->text_height = 35;		
		$this->img_width = 0;
		$this->img_heigth = 0;				
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
		
		//查找对应的栏目信息
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=40 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		//可用的文章栏目
		$sqlstr = "select columns_id,columns_name from columns where  columns_id in (select obj_id from my_object where menu_id=34 and user_id=".$_SESSION["sess_user_id"].")";		
 		$this->my_imagelist = $this->mysql->findAllRec($sqlstr);
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			$this->btnSave_Click();
			return;
		}		
		$sqlstr = "select * from columns_slideimage where columns_id=$this->columns_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);	
		$this->columns_imagelist_id = $sqlResult["columns_imagelist_id"];		
		$this->text_height = $sqlResult["text_height"];		
		$this->img_width = $sqlResult["img_width"];
		$this->img_heigth = $sqlResult["img_heigth"];
						
	}
	
	function btnSave_Click()
	{		
		
		$this->columns_imagelist_id = trim($this->postVars["columns_imagelist_id"]);		
		$this->text_height = trim($this->postVars["text_height"]);
		$this->img_width = trim($this->postVars["img_width"]);
		$this->img_heigth = trim($this->postVars["img_heigth"]);
		
		
		
		if (IsNumber($this->text_height) == 0){
 			$this->errorMessage = "标题文字区域高度必须是数字!";
 			return;
 		}
		if (intval($this->text_height) < 10){
 			$this->errorMessage = "标题文字区域高度必须大于等于10!";
 			return;
 		}		
		if (IsNumber($this->img_width) == 0){
 			$this->errorMessage = "单个图片宽度必须是数字!";
 			return;
 		}
		if (IsNumber($this->img_heigth) == 0){
 			$this->errorMessage = "单个图片高度必须是数字!";
 			return;
 		}
 		 		
 		
		//修改内容
		$this->columns_contents = htmlspecialchars($this->columns_contents); 
		$sqlstr = "update columns_slideimage set columns_imagelist_id=$this->columns_imagelist_id,text_height=$this->text_height,img_width=$this->img_width,img_heigth=$this->img_heigth where columns_id=$this->columns_id";		
		$this->mysql->updateRec($sqlstr); 		
 		if ($this->mysql->a_rows <= 0){
 			$this->errorMessage = "保存未成功";
 		}
 		
 		
		$this->toURL = $this->retURL;
	}
}
?>