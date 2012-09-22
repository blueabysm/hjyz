<?php
include_once("../../util/columnsFunctions.php");

class addColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columnsTypeList;
	public $nowColumnsType;
	public $columns_name;
	public $columns_title;
	public $sub_id;
	public $level;
	public $treeItemStr;
	private $maxColumnsDepth;
	private $nowDepth;	
	
	
	
	function addColumnsClass($postObj,$getObj,$mysql,$dep)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		
		$this->columns_name = "";
		$this->columns_title = "";
		$this->nowColumnsType = 1;		
		$this->level = 0;		
		$this->maxColumnsDepth = $dep;
		$this->retURL = "manageColumnsAdmin.php";		
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
			
		
		$sqlstr = "select columns_type_id,type_name from columns_type order by columns_type_id;";
		$this->columnsTypeList = $this->mysql->findAllRec($sqlstr);
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
			return;			
		}
				
		$this->nowDepth = 0;
		$sqlstr = "select columns_id,columns_name,sub_id from columns a where sites_id>=0 and level=0 and create_type<2 order by columns_id;";
		$this->treeItemStr = "[['所有根栏目','',".$this->getTreeStr($sqlstr).']]';
				
	}
	
	function btnAdd_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$type_handle;
		$columns_sn = 0;
		$create_type = 1; //0=系统栏目 1=用户创建栏目 2=程序创建栏目
		$sites_id = $_SESSION["sess_user_sub_id"]; //0=主站 其它=子站ID
		$createResult = 0;
		$admin_id = $_SESSION["sess_user_id"];
		
		
		$tmpstr= "";
		
		//填充form		
		$this->columns_name = trim($this->postVars["columns_name"]);
		$this->columns_title = trim($this->postVars["columns_title"]);
		$this->nowColumnsType = trim($this->postVars["nowColumnsType"]);
		$this->sub_id = $this->postVars["sub_id"];
		$this->level = 0;
		if (strlen($this->sub_id) > 0){
			$this->level = 1;
		}		
		
		//检查参数
		if (strlen($this->columns_name) <=0){
			$this->errorMessage = "请填写栏目名称";
			return;
		}
		if (strlen($this->columns_title) <=0){
			$this->errorMessage = "请填写栏目标题";
			return;
		}		
		
		//取得新栏目序号和句柄
		$columns_sn = getNewColumns_handle($this->mysql,$this->nowColumnsType,$type_handle);
		if ($columns_sn == 0){
			$this->errorMessage = "无法创建栏目，系统数据库数据不全";
			return;
		}		
		//创建栏目的基本信息
		$createResult = createColumns_base_info2(
									$this->mysql,
									$this->nowColumnsType,
									$admin_id,
									$create_type,
									$sites_id,
									$type_handle.$columns_sn,
									$this->columns_name,
									$this->level,
									'');
									
		if ($createResult == 0) {
			$this->errorMessage = "创建栏目失败";			
			return;
		}
		//更新栏目标题
		$sqlstr = "update columns set columns_title='$this->columns_title' where columns_id=$createResult";
		$this->mysql->updateRec($sqlstr);
		//将新栏目id加入到各父栏目的sub_id字段中
		$sqlstr = "update columns set sub_id=IF( (sub_id='') or (sub_id is null),'$createResult', concat(sub_id,',$createResult')) where columns_id in ($this->sub_id)";
		$this->mysql->updateRec($sqlstr);
		switch ($type_handle)
		{
			case 'zdlm' :
				//自动栏目
				break;
			case 'wzlm'	:
				//文章栏目				
				break;
			case 'xxgk'	:
				//信息公开				
				break;
			case 'tzlm' :
				//通知栏目
				break;
			case 'ljtlm':
				//链接条栏目				
				break;
			case 'ejljtlm':
				//二级链接条栏目			
				break;
			case 'zybjlm':
				//自由编辑栏目
				$createResult = createColumns_zybjlm($this->mysql,$type_handle.$columns_sn);
				break;
			case 'dclm':
				//调查栏目
				$createResult = createColumns_dclm($this->mysql,$type_handle.$columns_sn);
				break;
			case 'tplblm':
				//图片列表栏目
				break;
			case 'tpbglm':
				//图片表格栏目
				$createResult = createColumns_tpbglm($this->mysql,$type_handle.$columns_sn);
				break;
			case 'tphdplm':
				//图片幻灯片栏目
				$createResult = createColumns_tphdplm($this->mysql,$type_handle.$columns_sn);
				break;
			case 'ztlm':
				//专题栏目				
				break;
			case 'jgszlm':
				//机构设置栏目
				break;
			default:
				$this->errorMessage = "无法识别的栏目类型";				
				break;
		}
		
		if ($createResult == 0) {
			$this->errorMessage = "创建栏目失败";			
			return;
		}
		
		$this->toURL = $this->retURL;
	}		
	function getTreeStr($sqlstr)
	{
		$this->nowDepth = $this->nowDepth + 1;
		if ($this->nowDepth > $this->maxColumnsDepth) {
			$this->nowDepth = $this->nowDepth - 1;					
			return "['到达最大栏目深度','']";
		}
		$str = "['无','']"; 
		if ($sqlstr == '') {$this->nowDepth = $this->nowDepth - 1;return $str;}
		$columnsList = $this->mysql->findAllRec($sqlstr);
		$col_count = count($columnsList);
		if ($col_count <= 0) {$this->nowDepth = $this->nowDepth - 1;return $str;}
		
		$str = "";		
		for($i=0;$i<$col_count;$i++){
			$link = "javascript:addCol(\'".$columnsList[$i]['columns_name']."\',".$columnsList[$i]['columns_id'].')';			
			
			if (trim($columnsList[$i]['sub_id']) == '') {
				$str = $str."['".$columnsList[$i]['columns_name']."','$link'],";
			} else {
				$sql = 'select columns_id,columns_name,sub_id from columns a where columns_id in ('.$columnsList[$i]['sub_id'].')';
				$str = $str."['".$columnsList[$i]['columns_name']."','$link',";				
				$str = $str.$this->getTreeStr($sql).'],';
			}		
		}
		$this->nowDepth = $this->nowDepth - 1;
		return substr($str,0,strlen($str)-1);
	}
}
?>