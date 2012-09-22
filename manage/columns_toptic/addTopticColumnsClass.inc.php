<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class addTopticColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
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
	
	

	
	function addTopticColumnsClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
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
		
	}
	
	function Page_Load()
	{			
				
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
						
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columns_id and $this->columns_id in (select obj_id from my_object where menu_id=41 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumns.php";
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		
				
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();			
		}		
	}
	
	function btnAdd_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		
		$type_handle_tphdplm = 'tphdplm';
		$type_handle_wzlm = 'wzlm';
		$type_handle_zybjlm = 'zybjlm';
		$type_handle_tpbglm = 'tpbglm';		
		$columns_type_id;
		$columns_sn_tphdplm = 0; //幻灯片栏目序号
		$columns_sn_wzlm = 0; //最新消息栏目序号
		$columns_sn_zybjlm = 0; //专题介绍栏目序号		
		$columns_sn_tpbglm = 0; //图片新闻栏目序号
		
		$tphdplm_columns_id = 0;//幻灯片栏目ID
		$wzlm_columns_id = 0;//最新消息栏目ID
		$zybjlm_columns_id = 0;//专题介绍栏目ID
		$tpbglm_columns_id = 0;//图片新闻栏目ID
		
		$create_type = 2; //0=系统栏目 1=用户创建栏目 2=程序创建栏目
		$sites_id = $_SESSION["sess_user_sub_id"]; //0=主站 其它=子站ID		
		$admin_id = $_SESSION["sess_user_id"];
		$createResult = 0; //创建栏目结果		
		
		
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
		
				
		
		////创建子栏目
		//--幻灯片栏目
		//取得新栏目序号和句柄
		$columns_sn_tphdplm = getNewColumns_sn($this->mysql,$type_handle_tphdplm);
		if ($columns_sn_tphdplm == 0){
			$this->errorMessage = "无法创建栏目，系统数据库数据不全";
			$this->toURL = "manageTopticColumns.php?id=".$this->columns_id;
			
			return;
		}
		//取$columns_type_id
		$sqlstr = "select columns_type_id from columns_type where type_handle='$type_handle_tphdplm'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$columns_type_id = $sqlResult["columns_type_id"];			
		//创建幻灯片栏目的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$columns_type_id,
									$admin_id,
									$create_type,
									$sites_id,
									$type_handle_tphdplm.$columns_sn_tphdplm,
									$this->slide_name);
									
		if ($createResult == 0) {
			$this->errorMessage = "创建栏目失败";
			$this->toURL = "manageTopticColumns.php?id=".$this->columns_id;
			
			return;
		}
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handle_tphdplm.$columns_sn_tphdplm."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$tphdplm_columns_id = $sqlResult["columns_id"];
		//创建幻灯片栏目的扩展信息
		$sqlstr = "insert into columns_slideimage(columns_id,text_height,img_width,img_heigth) values($tphdplm_columns_id,20,298,198);";
		$createResult = createColumns_tphdplm_by_sql($this->mysql,$sqlstr);
		//--最新消息栏目
		//取得新栏目序号和句柄
		$columns_sn_wzlm = getNewColumns_sn($this->mysql,$type_handle_wzlm);		
		//取$columns_type_id
		$sqlstr = "select columns_type_id from columns_type where type_handle='$type_handle_wzlm'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$columns_type_id = $sqlResult["columns_type_id"];			
		//创建最新消息栏目的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$columns_type_id,
									$admin_id,
									$create_type,
									$sites_id,
									$type_handle_wzlm.$columns_sn_wzlm,
									$this->article_column_name);									
		
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handle_wzlm.$columns_sn_wzlm."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$wzlm_columns_id = $sqlResult["columns_id"];
		//--专题介绍栏目
		//取得新栏目序号和句柄
		$columns_sn_zybjlm = getNewColumns_sn($this->mysql,$type_handle_zybjlm);		
		//取$columns_type_id
		$sqlstr = "select columns_type_id from columns_type where type_handle='$type_handle_zybjlm'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$columns_type_id = $sqlResult["columns_type_id"];			
		//创建专题介绍栏目的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$columns_type_id,
									$admin_id,
									$create_type,
									$sites_id,
									$type_handle_zybjlm.$columns_sn_zybjlm,
									$this->html_column_name);									
		
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handle_zybjlm.$columns_sn_zybjlm."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$zybjlm_columns_id = $sqlResult["columns_id"];
		//创建专题介绍栏目的扩展信息
		$createResult = createColumns_zybjlm($this->mysql,$type_handle_zybjlm.$columns_sn_zybjlm);		
		//--图片新闻栏目
		//取得新栏目序号和句柄
		$columns_sn_tpbglm = getNewColumns_sn($this->mysql,$type_handle_tpbglm);		
		//取$columns_type_id
		$sqlstr = "select columns_type_id from columns_type where type_handle='$type_handle_tpbglm'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$columns_type_id = $sqlResult["columns_type_id"];			
		//创建图片新闻栏目的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$columns_type_id,
									$admin_id,
									$create_type,
									$sites_id,
									$type_handle_tpbglm.$columns_sn_tpbglm,
									$this->imagetable_name);									
		
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handle_tpbglm.$columns_sn_tpbglm."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$tpbglm_columns_id = $sqlResult["columns_id"];
		//创建图片新闻栏目的扩展信息
		$sqlstr = " insert into columns_imagetable(columns_id,img_width,img_heigth,col_number) values($tpbglm_columns_id,90,60,3);";
		$createResult = createColumns_tpbglm_by_sql($this->mysql,$sqlstr);
		//添加基本信息
		$sqlstr = "insert into columns_toptic(columns_id,small_img_id,small_img_width,small_img_height,big_img_id,big_img_width,big_img_height,toptic_order,slide_id,article_column_id,html_column_id,imagetable_id,toptic_name,toptic_href,toptic_note	) values(" .
					"$this->columns_id,$this->small_img_id,$this->small_img_width,$this->small_img_height,$this->big_img_id,$this->big_img_width,$this->big_img_height,$this->toptic_order,$tphdplm_columns_id,$wzlm_columns_id,$zybjlm_columns_id,$tpbglm_columns_id,'$this->toptic_name','$this->toptic_href','$this->toptic_note');";			
		$this->mysql->insertRec($sqlstr);			
		$result = $this->mysql->a_rows;
		
			
		if ($result <= 0){			
			$this->errorMessage = "添加未成功!";
		}
		
		//添加权限
		$purList = array(40,34,36,39);
		$ids = array($tphdplm_columns_id,$wzlm_columns_id,$zybjlm_columns_id,$tpbglm_columns_id);
		for($i=0;$i<count($purList);$i++){
			$sqlstr = 'select p_id from purview where menu_id='.$purList[$i];
 			$purs = $this->mysql->findAllRec($sqlstr);
 			if ($purs == -1) continue;
 			$tmpstr = ',';
 			for($j=0;$j<count($purs);$j++){
 				$tmpstr = $tmpstr.$purs[$j]['p_id'].',';
 			}
 			$sqlstr = "insert into my_object(user_id,menu_id,obj_id,pur_list) values(".
					$_SESSION["sess_user_id"].','.$purList[$i].','.$ids[$i].",'$tmpstr');";		
			$this->mysql->insertRec($sqlstr);
		}
		
		$this->toURL = "manageTopticColumns.php?id=".$this->columns_id;
	}
}
?>