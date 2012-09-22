<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editColumnsAdminClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;	
	
	public $columns_name;
	public $columns_title;
	public $columns_id;	
	public $sub_id;
	public $level;	
	public $levelList;
	public $treeItemStr;
	private $maxColumnsDepth;
	private $nowDepth;
	public $haveSubColStr;
	public $retURL;		

	
	function editColumnsAdminClass($postObj,$getObj,$mysql,$dep)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";				
		
		$this->columns_name = "";
		$this->columns_id = 0;
		$this->level = 0;
		$this->levelList = array(0,"根栏目",1,"子栏目");
		$this->maxColumnsDepth = $dep;
		$this->retURL = "manageColumnsAdmin.php";

	}
	
	function Page_Load()
	{				
		$sqlstr = "";
		
		if(isset($this->getVars["id"])){
			$this->columns_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["columns_id"])){
			$this->columns_id = trim($this->postVars["columns_id"]);
		}
		
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}		
		if ( ($this->columns_id == 0) || (isNumber($this->columns_id) == 0) ){
				$this->errorMessage = "参数错误";
				$this->toURL = $this->retURL;
				return;			
		}					
	
		
		
		//加载用户信息
		$sqlstr = "select columns_id,admin_id,columns_name,columns_title,level,sub_id from columns where columns_id=$this->columns_id";		
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = $this->retURL;
			return;
		}		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			
			$this->btnSave_Click();	
			return;
		}
		
		$this->columns_name = trim($sqlResult["columns_name"]);
		$this->columns_title = trim($sqlResult["columns_title"]);		
		$this->level = $sqlResult["level"];
		$this->sub_id = trim($sqlResult["sub_id"]);
		$this->haveSubColStr = '0';
		if ($this->sub_id != ''){
			$sqlstr = "select columns_id,columns_name from columns where columns_id in ($this->sub_id)";
			$colList = $this->mysql->findAllRec($sqlstr);
			if ($colList != -1){
				$tmpstr = "";
				for($i=0;$i<count($colList);$i++){
					$tmpstr = $tmpstr."['".$colList[$i]['columns_name']."',".$colList[$i]['columns_id']."],";
				}
				$this->haveSubColStr = '['.substr($tmpstr,0,strlen($tmpstr) -1).']';
			}
		}		
		
		$this->nowDepth = 0;		
		$sqlstr = "select columns_id,columns_name,sub_id from columns a where sites_id>=0 and level=0 and create_type<2 order by columns_id;";
		$this->treeItemStr = "[['所有根栏目','',".$this->getTreeStr($sqlstr).']]';
		
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";
		
		//填充form			
		$this->level = $this->postVars["level"];		
		$this->sub_id = $this->postVars["sub_id"];			
		$this->columns_title = $this->postVars["columns_title"];
		$this->columns_name = $this->postVars["columns_name"];
		
		
		//保存信息
	    $sqlstr = "update columns set level=$this->level,sub_id='$this->sub_id',columns_name='$this->columns_name',columns_title='$this->columns_title' where columns_id=$this->columns_id";		
		$this->mysql->updateRec($sqlstr);
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