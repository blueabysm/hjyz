<?php
class manageColumnsTreeClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;	
	
	public $treeItemStr;
	private $maxColumnsDepth;
	private $nowDepth;
	
	function manageColumnsTreeClass($postObj,$getObj,$mysql,$dep)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->maxColumnsDepth = $dep;
	}
	
	function Page_Load()
	{		
		$sqlstr = "select a.columns_id,a.columns_name,a.sub_id,b.manage_url,b.type_handle from columns a,columns_type b ";		
		$sqlWhere = " where a.level=0 and (a.columns_type_id=b.columns_type_id) and a.create_type < 2 and a.columns_id in (select obj_id from my_object where menu_id>0 and obj_id>0 and user_id=".$_SESSION["sess_user_id"].')';
		$sqlstr = $sqlstr . $sqlWhere ." order by a.columns_id";
		$this->nowDepth = 0;
		$this->treeItemStr = "[['所有根栏目','',".$this->getTreeStr($sqlstr,'../blank.php').']]';
		
	}

	function getTreeStr($sqlstr,$retURL)
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
			$link = $columnsList[$i]['manage_url'].'?id='.$columnsList[$i]['columns_id']."&retURL=$retURL";
			
			if (trim($columnsList[$i]['sub_id']) == '') {
				$str = $str."['".$columnsList[$i]['columns_name']."','$link'],";
			} else {
				$sql = 'select a.columns_id,a.columns_name,a.sub_id,b.type_name,b.manage_url,b.type_handle from columns a,columns_type b where (a.columns_type_id=b.columns_type_id) and a.columns_id in ('.$columnsList[$i]['sub_id'].') and a.columns_id in (select obj_id from my_object where menu_id>0 and obj_id>0 and user_id='.$_SESSION["sess_user_id"].')';
				$str = $str."['".$columnsList[$i]['columns_name']."','$link',";				
				$str = $str.$this->getTreeStr($sql,$retURL).'],';
			}
		}
		$this->nowDepth = $this->nowDepth - 1;
		return substr($str,0,strlen($str)-1);
	}
}
?>