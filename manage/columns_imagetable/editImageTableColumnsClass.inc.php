<?php
include_once("../../util/commonFunctions.php");

class editImageTableColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columns_name; //栏目名称
	public $columns_id;//栏目id
	public $columns_imagelist_id;//图片列表id
	public $text_xy;//文字方位 1=下方2=左方3=右方4=上方	
	public $img_width;//图片宽度
	public $img_heigth;//图片高度
	public $display_type;//显示方式 1=不滚动2=向左滚动3=向右滚动4=向上滚动5=向下滚动	
	public $col_number;//一行内的列数
	public $text_xy_list;
	public $display_type_list;
	public $my_imagelist;
	

	
	function editImageTableColumnsClass($postObj,$getObj,$mysql)
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
		$this->text_xy = 1;
		$this->img_width = 0;
		$this->img_heigth = 0;
		$this->display_type = 1;	
		$this->col_number = 10;
		$this->text_xy_list = array(1,"图片下方",2,"图片左方",3,"图片右方",4,"图片上方");
		$this->display_type_list = array(1,"不滚动",2,"向左滚动",3,"向右滚动",4,"向上滚动",5,"向下滚动");		
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
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=39 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		//可用的图片列表
		$sqlstr = "select columns_id,columns_name from columns where create_type<2 and admin_id=".$_SESSION["sess_user_id"];
		$sqlstr = $sqlstr . " and columns_type_id in (select columns_type_id from columns_type where type_handle='tplblm')";
 		$this->my_imagelist = $this->mysql->findAllRec($sqlstr);
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			$this->btnSave_Click();
			return;
		}		
		$sqlstr = "select * from columns_imagetable where columns_id=$this->columns_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$this->columns_imagelist_id = $sqlResult["columns_imagelist_id"];
		$this->text_xy = $sqlResult["text_xy"];
		$this->img_width = $sqlResult["img_width"];
		$this->img_heigth = $sqlResult["img_heigth"];
		$this->display_type = $sqlResult["display_type"];	
		$this->col_number = $sqlResult["col_number"];
						
	}
	
	function btnSave_Click()
	{
		$this->columns_imagelist_id = trim($this->postVars["columns_imagelist_id"]);
		$this->text_xy = trim($this->postVars["text_xy"]);	
		$this->img_width = trim($this->postVars["img_width"]);
		$this->img_heigth = trim($this->postVars["img_heigth"]);
		$this->display_type = trim($this->postVars["display_type"]);	
		$this->col_number = trim($this->postVars["col_number"]);
		
		
		
		if (IsNumber($this->img_width) == 0){
 			$this->errorMessage = "单个图片宽度必须是数字!";
 			return;
 		}
		if (IsNumber($this->img_heigth) == 0){
 			$this->errorMessage = "单个图片高度必须是数字!";
 			return;
 		}
		if (IsNumber($this->col_number) == 0){
 			$this->errorMessage = "行内图片数必须是数字!";
 			return;
 		}
		if (intval($this->col_number) < 1){
 			$this->errorMessage = "标题文字区域高度必须大于等于1!";
 			return;
 		} 	 		
 		
		//修改内容		 
		$sqlstr = "update columns_imagetable set columns_imagelist_id=$this->columns_imagelist_id,text_xy=$this->text_xy,img_width=$this->img_width,img_heigth=$this->img_heigth,display_type=$this->display_type,col_number=$this->col_number where columns_id=$this->columns_id";
		$this->mysql->updateRec($sqlstr); 		
 		if ($this->mysql->a_rows <= 0){
 			$this->errorMessage = "保存未成功";
 		}
 		
 		
		$this->toURL = $this->retURL;
	}
}
?>