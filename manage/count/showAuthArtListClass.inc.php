<?php
class showAuthArtListClass{
	
	public $getVars;
	public $postVars;
	
	public $mysql;
	public $autherName;
	public $artList;
	
	function showAuthArtListClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		
 		//检查并设置参数
 		if(isset($this->getVars["n"])){
			$this->autherName = trim($this->getVars["n"]);
		}
		if(isset($this->postVars["n"])){
			$this->autherName = trim($this->postVars["n"]);
		}
 		if ($this->autherName == '') return;
 		$sqlstr = "";		
		$sqlResult;
		
		$this->autherName = urldecode($this->autherName);

		
		
		$sqlstr = "select article_id,article_title,article_time from article where article_ath='".$this->autherName."' or article_ath like binary '%".$this->autherName."%' order by article_time desc";
 		$this->artList = $this->mysql->findAllRec($sqlstr);
 	} 	
}
?>