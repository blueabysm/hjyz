<?php
class autherListClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $autherList;
	
	public $startDate;
	public $endDate;
	
	function autherListClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->startDate = date("Y")."0101";
		$this->endDate = date("Y")."1231";
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;
		$notCreateView = true;
		
 		if(isset($this->postVars["btnSave"])){			
			$this->startDate = trim($this->postVars["startDate"]);
			$this->endDate = trim($this->postVars["endDate"]);
 		    if ( (strlen($this->startDate) !=8) || 
 		    	 (strlen($this->endDate) !=8) ||
 		    	 (IsNumber($this->startDate) ==0) ||
 		    	 (IsNumber($this->endDate) == 0)
 		       ){
				$this->errorMessage = "时间格式不正确";
				return;
			}
			if ($this->endDate == ""){
				$this->errorMessage = "结束时间不能为空";
				return;
			}
			if ($this->endDate<=$this->startDate) 		{
				$this->errorMessage = "结束时间不能大于或等于开始时间";
				return;
			}
			
			$sqlstr = "drop view view_art_ath_count";
			$this->mysql->updateRec($sqlstr);
			$sqlstr = "create view view_art_ath_count as select count(*) art_num,article_ath from article where article_time>='".
			substr($this->startDate,0,4).'-'.substr($this->startDate,4,2).'-'.substr($this->startDate,6)."' and article_time<='".
			substr($this->endDate,0,4).'-'.substr($this->endDate,4,2).'-'.substr($this->endDate,6)."'  group by article_ath order by art_num desc";
			
			$this->mysql->updateRec($sqlstr);
			$notCreateView = false;
		}

		if ($notCreateView) return;
		$sqlstr = 'select distinct article_ath from view_art_ath_count order by article_ath';
 		$tmpList = $this->mysql->findAllRec($sqlstr);
 		if ($tmpList == -1) return;
 		
 		
 		$allList = array();
 		for ($i=0;$i<count($tmpList);$i++){
 			$name = $tmpList[$i]['article_ath'];
 			if ($name == '') continue;
 			$name = str_replace('　',' ',$name);
 			if (strpos($name,' ') === false){
 				$allList[]= $name;
 			} else {
 				$nameList = explode(' ',$name);
 				for ($j=0;$j<count($nameList);$j++){
 				  if ($nameList[$j] == '') continue;
 				  $allList[]= $nameList[$j];
 				}
 			}
 		}
 		$nameList = array();
 		$nameList[] = $allList[0];
 		for ($i=1;$i<count($allList);$i++){
 			if ($this->findName($nameList,$allList[$i]) == false){
 				$nameList[]=$allList[$i];
 			}
 		}

 		$countList = array();
 		
 		$sqlstr = 'select art_num,article_ath from view_art_ath_count';
 		$dataList = $this->mysql->findAllRec($sqlstr);
 		$dataLen = count($dataList);
 		for ($i=0;$i<count($nameList);$i++){
 			$countList[$i] = 0;
 			for($j=0;$j<$dataLen;$j++){
 				if (strpos($dataList[$j]['article_ath'],$nameList[$i]) === false){
 					continue;
 				}
 				$countList[$i] += $dataList[$j]['art_num'];
 			}			
 		}
 		
 		$len = count($countList);
 		for($i=0;$i<$len;$i++){
 			for($j=$len-2;$j>=$i;$j--){
 				if ($countList[$j+1]>$countList[$j]){
 					$tmpCount = $countList[$j];
 					$tmpName = $nameList[$j];
 					$countList[$j] = $countList[$j+1];
 					$nameList[$j] = $nameList[$j+1];
 					$countList[$j+1]=$tmpCount;
 					$nameList[$j+1]=$tmpName;
 				}
 			}
 		}
 		for($i=0;$i<$len;$i++){
 			$this->autherList[$i][0] = $nameList[$i];
 			$this->autherList[$i][1] = $countList[$i]; 			
 		}
	
 	}
 	
 	function findName($list,$name){
 		$len = count($list); 			
 		if ($len <1) {
 			return false;
 		}
 		for($i=0;$i<$len;$i++){
 			if ($list[$i] == $name){
 				return true;
 			}
 		}
 		return false;
 	}
 	
	function btnSave_Click()
	{
		$sqlstr = "";
		
		$this->user_realname = trim($this->postVars["user_realname"]);
		$this->user_phone = trim($this->postVars["user_phone"]);
		$this->user_email = trim($this->postVars["user_email"]);
		$this->user_pwd = trim($this->postVars["user_pwd"]);
		$this->user_pwd2 = trim($this->postVars["user_pwd2"]);
		
		//参数检查
		if (strlen($this->user_realname) <= 0) {
			$this->errorMessage = "请填写姓名";
			return;
		}
		if (strlen($this->user_pwd) > 0) {
			if (strlen($this->user_pwd) < 5){
				$this->errorMessage = "密码必须在5-16位之间";
				return;
			}
			if ($this->user_pwd != $this->user_pwd2){
				$this->errorMessage = "两次输入的密码不一致";
				return;
			}
		}
		
			
		$sqlstr = "update admins set user_realname='$this->user_realname',user_phone='$this->user_phone',user_email='$this->user_email'";
		if (strlen($this->user_pwd) > 0) {
			$sqlstr = $sqlstr . ",user_pwd='".md5($this->user_pwd)."'";
		}
		$sqlstr = $sqlstr . " where user_id=".$_SESSION["sess_user_id"];
		$this->mysql->updateRec($sqlstr);
		if ($this->mysql->a_rows > 0){
			$this->errorMessage = "保存已成功";
		}
		
	}
}
?>