<?php
class fromListClass{
	
	public $mysql;
	public $areaList;
	
	function fromListClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;

		
		$sqlstr = 'select count(*) num,article_from from article group by article_from order by num desc';
 		$this->areaList = $this->mysql->findAllRec($sqlstr);
	
 	}
}
?>