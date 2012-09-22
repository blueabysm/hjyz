<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editLinkColumns2Class{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $columns_name;
	public $columns_id;
	public $sub_link_name; //子链接条名称
	public $sub_columns_id;
	public $item_title;
	public $item_link;
	public $item_order;

	
	function editLinkColumns2Class($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columns_name = "";
		$this->columns_id = 0;
		$this->sub_link_name = "";
		$this->sub_columns_id = 0;
		$this->item_order = 100;
		$this->item_title = "";
		$this->item_link = "";
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
				
		//检查并设置参数		
		if(isset($this->getVars["columns_id"])){
			$this->columns_id = trim($this->getVars["columns_id"]);
		}
		if(isset($this->postVars["columns_id"])){
			$this->columns_id = trim($this->postVars["columns_id"]);
		}
		if ( ($this->columns_id == 0) || (isNumber($this->columns_id) == 0) ){
				$this->errorMessage = "栏目参数错误";
				$this->toURL = "../columns/manageColumnsTree.php";
				return;			
		}						
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=42 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumnsTree.php";
			
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);		
		
		
		
		if(isset($this->getVars["sub_columns_id"])){
			$this->sub_columns_id = trim($this->getVars["sub_columns_id"]);
		}
		if(isset($this->postVars["sub_columns_id"])){
			$this->sub_columns_id = trim($this->postVars["sub_columns_id"]);
		}		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			
			$this->btnSave_Click();
			return;
		}		
		if (isNumber($this->sub_columns_id) == 0){
			$this->errorMessage = "链接条参数错误";
			$this->toURL = "manageLinkColumns2.php?id=".$this->columns_id;
					
			return;			
		}
		//如果为0表示是添加链接条
		if ($this->sub_columns_id == 0){
			
			return;
		}
		
		
		//加载链接条	基本信息	
		$sqlstr = "select * from columns_link2 where sub_columns_id=$this->sub_columns_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageLinkColumns2.php?id=".$this->columns_id;
			
			return 0;
		}
		
		$this->item_order = trim($sqlResult["item_order"]);
		$this->item_title = trim($sqlResult["item_title"]);
		$this->item_link = trim($sqlResult["item_link"]);
		//加载链接条名字
		$sqlstr = "select columns_name from columns where columns_id=$this->sub_columns_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "manageLinkColumns2.php?id=".$this->columns_id;
			
			return;
		}
		$this->sub_link_name = trim($sqlResult["columns_name"]);		
		
			
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
		$type_handle = 'ljtlm';
		$columns_type_id;
		$columns_sn = 0; //子链接条栏目序号
		$create_type = 2; //0=系统栏目 1=用户创建栏目 2=程序创建栏目
		$sites_id = $_SESSION["sess_user_sub_id"]; //0=主站 其它=子站ID
		$createResult = 0; //创建栏目结果
		$admin_id = $_SESSION["sess_user_id"];
		
		
		//填充form		
		$this->item_order = trim($this->postVars["item_order"]);
		$this->item_title = trim($this->postVars["item_title"]);
		$this->item_link = trim($this->postVars["item_link"]);
		$this->sub_link_name = trim($this->postVars["sub_link_name"]);		
		
		//检查参数
		if (strlen($this->sub_link_name) <=0){
			$this->errorMessage = "请填写子链接条名称";
			return;
		}
		if (strlen($this->item_title) <=0){
			$this->errorMessage = "请填写链接条的标题";
			return;
		}
		if (IsNumber($this->item_order) == 0){
			$this->errorMessage = "序号必须是一个整数!";			
			return;
		}
		
		
		
		//保存记录							
		if ($this->sub_columns_id>0){
			//修改名称
			$sqlstr = "update columns set columns_name='$this->sub_link_name' where columns_id=$this->sub_columns_id";		
			$this->mysql->updateRec($sqlstr);
			//修改基本信息
			$sqlstr = "update columns_link2 set item_order=$this->item_order,item_title='$this->item_title',item_link='$this->item_link' where sub_columns_id=$this->sub_columns_id;";		
			$this->mysql->updateRec($sqlstr);
			
			$result = $this->mysql->a_rows;
		} else {
			////创建子链接条栏目
			//取得新栏目序号和句柄
			$columns_sn = getNewColumns_sn($this->mysql,$type_handle);
			if ($columns_sn == 0){
				$this->errorMessage = "无法创建栏目，系统数据库数据不全";
				$this->toURL = "manageLinkColumns2.php?id=".$this->columns_id;
				
				return;
			}
			//取$columns_type_id
			$sqlstr = "select columns_type_id from columns_type where type_handle='$type_handle'";
			$sqlResult = $this->mysql->findOneRec($sqlstr);
			$columns_type_id = $sqlResult["columns_type_id"];			
			//创建子链接条栏目的基本信息
			$createResult = createColumns_base_info(
										$this->mysql,
										$columns_type_id,
										$admin_id,
										$create_type,
										$sites_id,
										$type_handle.$columns_sn,
										$this->sub_link_name);
										
			if ($createResult == 0) {
				$this->errorMessage = "创建栏目失败";
				$this->toURL = "manageLinkColumns2.php?id=".$this->columns_id;
				
				return;
			}
			//取新链接条链目ID 存入$this->sub_columns_id	
			$sqlstr = "select columns_id from columns where columns_handle='".$type_handle.$columns_sn."'";
			$sqlResult = $this->mysql->findOneRec($sqlstr);
			$this->sub_columns_id = $sqlResult["columns_id"];
			//添加基本信息
			$sqlstr = "insert into columns_link2(columns_id,sub_columns_id,item_order,item_title,item_link) values(" .
						"$this->columns_id,$this->sub_columns_id,$this->item_order,'$this->item_title','$this->item_link');";			
			$this->mysql->insertRec($sqlstr);			
			$result = $this->mysql->a_rows;
			
			//添加权限
			$sqlstr = 'select p_id from purview where menu_id=35';
 			$purs = $this->mysql->findAllRec($sqlstr);
 			if ($purs != -1){
	 			$tmpstr = ',';
	 			for($j=0;$j<count($purs);$j++){
	 				$tmpstr = $tmpstr.$purs[$j]['p_id'].',';
	 			}
	 			$sqlstr = "insert into my_object(user_id,menu_id,obj_id,pur_list) values(".
						$_SESSION["sess_user_id"].',35,'.$this->sub_columns_id.",'$tmpstr');";		
				$this->mysql->insertRec($sqlstr);
 			}
			
		}
		
		$this->toURL = "manageLinkColumns2.php?id=".$this->columns_id;
	}
}
?>