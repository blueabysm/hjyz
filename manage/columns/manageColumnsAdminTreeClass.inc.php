<?php
class manageColumnsAdminTreeClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;

	public $treeItemStr;
	private $maxColumnsDepth;
	private $nowDepth;
	
	
	function manageColumnsAdminTreeClass($postObj,$getObj,$mysql,$dep)
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
		$sqlstr = "select columns_id,columns_name,sub_id,(select type_handle from columns_type b where b.columns_type_id=a.columns_type_id) type_handle from columns a";		
		$sqlWhere = " where (a.sites_id=0) and (a.create_type < 2) and level=0";
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
			$link = 'editColumnsAdmin.php?id='.$columnsList[$i]['columns_id']."&retURL=$retURL";

			//如果是机构设置栏目则调用专用函数
			if ($columnsList[$i]['type_handle']=='jgszlm'){
				$str = $str."['".$columnsList[$i]['columns_name']."','$link',";
				$str = $str.$this->getPartTreeStr($columnsList[$i]['columns_id'],$retURL).'],';
			} else {
				if (trim($columnsList[$i]['sub_id']) == '') {
					$str = $str."['".$columnsList[$i]['columns_name']."','$link'],";
				} else {
					$sql = 'select columns_id,columns_name,sub_id,(select type_handle from columns_type b where b.columns_type_id=a.columns_type_id) type_handle from columns a where columns_id in ('.$columnsList[$i]['sub_id'].')';
					$str = $str."['".$columnsList[$i]['columns_name']."','$link',";				
					$str = $str.$this->getTreeStr($sql,$retURL).'],';
				}
			}
		}
		$this->nowDepth = $this->nowDepth - 1;
		return substr($str,0,strlen($str)-1);
	}

	function getPartTreeStr($topID,$retURL)
	{
		$this->nowDepth = $this->nowDepth + 1;
		if ($this->nowDepth > $this->maxColumnsDepth) {					
			return "['到达最大栏目深度','']";
		}
		$str = "['无','']";
		$columnsList = $this->mysql->findAllRec("select columns_partlist_id,part_name from columns_partlist where columns_id=$topID order by part_order");		
		if ($columnsList == -1) return $str;
		
		$col_count = count($columnsList);
		$str = "";		
		for($i=0;$i<$col_count;$i++){
			$link = '';
			$sql = 'select columns_id,columns_name,sub_id,(select type_handle from columns_type b where b.columns_type_id=a.columns_type_id) type_handle from columns a where columns_id in (select column_id from columns_partlist_sub where columns_partlist_id='.$columnsList[$i]['columns_partlist_id'].')';
			$str = $str."['".$columnsList[$i]['part_name']."','$link',";
			$str = $str.$this->getTreeStr($sql,$retURL).'],';
		}
		$this->nowDepth = $this->nowDepth - 1;
		return substr($str,0,strlen($str)-1);
	}
}
?>