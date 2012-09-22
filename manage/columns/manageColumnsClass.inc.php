<?php
class manageColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;	
	
	public $columnsTypeList;
	public $nowColumnsType;
	public $columnsList;
	public $showAll; //显示所有栏目
	
	public $to_page;
	public $page_num;
	public $first_page;
	public $last_page;
	public $next_page;
	public $up_page;
	
	function manageColumnsClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->nowColumnsType = 0;
		$this->showAll = 0;
		
		$this->to_page = 1;
		$this->page_num = 1;
		$this->first_page = 1;
		$this->last_page = 1;
		$this->up_page = 1;
		$this->next_page = 1;
	}
	
	function Page_Load()
	{
		$sqlstr = "";
		$sqlWhere;
		if(isset($this->getVars["page"])){
			$this->to_page = trim($this->getVars["page"]);
			if (isNumber($this->to_page) == 0){
				$this->to_page = 1;
			}
		}
		if(isset($this->postVars["to_page"])){
			$this->to_page = trim($this->postVars["to_page"]);
		}	
		//取类型列表
		if(isset($this->postVars["nowColumnsType"])){
			$this->nowColumnsType = trim($this->postVars["nowColumnsType"]);
		}		
		$sqlstr = "select columns_type_id,type_name from columns_type order by columns_type_id;";
		$this->columnsTypeList = $this->mysql->findAllRec($sqlstr);
		//取栏目列表
		if ($this->postVars["showAll"] == "ok"){
			$this->showAll = 1;
		} else {
			$this->showAll = 0;
		}
		$sqlstr = "select a.columns_id,a.columns_name,a.create_type,a.columns_handle,b.type_name,b.manage_url from columns a,columns_type b ";		
		$sqlWhere = " where (a.columns_type_id=b.columns_type_id) ";
		if ($this->showAll == 0) {
			$sqlWhere = $sqlWhere ." and (a.create_type<2) ";
		}
		if ($this->nowColumnsType != 0){
			$sqlWhere = $sqlWhere ." and (a.columns_type_id=$this->nowColumnsType) ";
		}		
		if ($_SESSION["sess_user_type"] < 5) {
			 $sqlWhere = $sqlWhere ." and (a.admin_id=".$_SESSION["sess_user_id"] . ") ";
		} else {
			$sqlWhere = $sqlWhere ." and (a.sites_id=0) ";
		}
		$sqlstr = $sqlstr . $sqlWhere ." order by a.columns_name";
		$this->columnsList = $this->mysql->findAllRecByPage($sqlstr,$this->to_page,15);
		$this->page_num = $this->mysql->page_amount;
		$this->last_page = $this->page_num;
		$p = $this->to_page - 1;
		if ($p  < 1){
			$this->up_page = 1;
		} else {
			$this->up_page = $p;
		}
		$p = $this->to_page + 1;
		if ($p > $this->page_num){
			$this->next_page = $this->page_num;
		} else {
			$this->next_page = $p;
		}
		
	}	
}
?>