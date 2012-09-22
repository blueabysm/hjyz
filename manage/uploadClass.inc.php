<?php
class uploadClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $uploadFileType;
	public $processOnSuccess;
	public $myUploadFile;
	public $file_note;
	
	public $nowIncludeType;//当前调用类型 1=被editor(在线网页编辑器)调用 2=被其它页面调用 默认为1
	public $needFileType; //期望上传的文件类型  1=所有允许的类型 2=图片
	public $ImageFileType;
	public $jsFileType; //JS验证的所允许的文件类型
	
	function uploadClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->uploadFileType = "";
		$this->processOnSuccess = "";
		$this->file_note = "";
		
		$this->nowIncludeType = 1;
		$this->needFileType = 1;
		$this->ImageFileType = ','.UPLOAD_IMAGE_TYPE.',';
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;

		$this->processOnSuccess =  "<script>btnCancel();</script>";
		$this->errorMessage = "参数错误";
		
		if(isset($this->getVars["it"])){
			$this->nowIncludeType = trim($this->getVars["it"]);
		}
		if(isset($this->postVars["nowIncludeType"])){
			$this->nowIncludeType = trim($this->postVars["nowIncludeType"]);
		}
		if(isset($this->getVars["nt"])){
			$this->needFileType = trim($this->getVars["nt"]);
		}
		if(isset($this->postVars["needFileType"])){
			$this->needFileType = trim($this->postVars["needFileType"]);
		}
		if ((isNumber($this->nowIncludeType) == 0 ) || (isNumber($this->needFileType) == 0 )) return;
		$this->nowIncludeType = intval($this->nowIncludeType);
		$this->needFileType = intval($this->needFileType);
		if (($this->nowIncludeType>2) || ($this->nowIncludeType < 1)) return;
		if (($this->needFileType>2) || ($this->needFileType < 1)) return;
		$this->processOnSuccess =  "";
		$this->errorMessage = "";		
		
		$this->uploadFileType = ','.UPLOAD_FILE_TYPE.',';
		
		$this->jsFileType = $this->uploadFileType;
		if ($this->needFileType == 2) $this->jsFileType = $this->ImageFileType;
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
			return;
		}		
		
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$oldFileName; //原始文件名
		$oldExtFileName;//原始文件扩展名
		$uploadPath; //目标目录
		$newFileName; //新文件名
		$newFilePath; //新文件的物理路径
		$fileSize; //文件大小
		$admin_ip = $_SERVER["REMOTE_ADDR"];//操作员IP
		$tmpstr;
		$path_parts; 		
		$nowpath = dirname(__FILE__); //当前路径		
		$imageFileExaNames = ",gif,jpg,png,";
		$strIndex;
		$file_id;
		$sqlResult;
		
		//填充form		
		$this->file_note = trim($this->postVars["file_note"]);
		$this->myUploadFile = trim($this->postVars["myUploadFile"]);
		
		
		//检查参数
		if (strlen($this->file_note) <=0){
			$this->errorMessage = "请填写文件说明";
			return;
		}		
		if ($this->myUploadFile == "null"){
			$this->errorMessage = "请选择文件!";			
			return;
		}
		$oldFileName = $_FILES['myUploadFile']['tmp_name'];
		$fileSize = $_FILES['myUploadFile']['size'];
		
		$tmpstr = strtolower($_FILES['myUploadFile']['name']);
		$path_parts = pathinfo($tmpstr); 
		$oldExtFileName = $path_parts['extension'];
		$tmpstr = ",".$oldExtFileName.",";
		
		//检查文件类型
		if ($this->needFileType == 2){
			$strIndex = strpos($this->ImageFileType,$tmpstr);
			$this->errorMessage = "你只能上传图片文件";
		} else {
			$strIndex =	strpos($this->uploadFileType,$tmpstr);
			$this->errorMessage = "不允许上传此类型的文件,请重新选择文件";
		}			
		if ($strIndex === false){						
			return;
		} else {
			$this->errorMessage = "";
		}		
		
		//生成目标目录绝对路径
		date_default_timezone_set('Asia/Shanghai');
		$dateYear = date("Y");
		$dateMon = date("m");
		$dateDay = date("d");
		$dateDir = $dateYear.DIRECTORY_SEPARATOR.$dateMon.DIRECTORY_SEPARATOR.$dateDay.DIRECTORY_SEPARATOR;
		$dateUrl = $dateYear.'/'.$dateMon.'/'.$dateDay.'/';
		$nowpath = substr($nowpath,0,stripos($nowpath,"manage"));
		$uploadPath = $nowpath . WEB_SITE_UPLOAD_DIR;
		
		////创建目录
		//顶级
		if (file_exists($uploadPath) == false){
			if (mkdir($uploadPath) == false){
				$this->errorMessage = '无法创建目录，请联系管理员!';			
				return;
			}
		}
		//年
		$uploadPath = $uploadPath.$dateYear.DIRECTORY_SEPARATOR;
		if (file_exists($uploadPath) == false){
			if (mkdir($uploadPath) == false){
				$this->errorMessage = '无法创建目录，请联系管理员!';			
				return;
			}
		}
		//月
		$uploadPath = $uploadPath.$dateMon.DIRECTORY_SEPARATOR;
		if (file_exists($uploadPath) == false){
			if (mkdir($uploadPath) == false){
				$this->errorMessage = '无法创建目录，请联系管理员!';			
				return;
			}
		}		
		//日
		$uploadPath = $uploadPath.$dateDay.DIRECTORY_SEPARATOR;
		if (file_exists($uploadPath) == false){
			if (mkdir($uploadPath) == false){
				$this->errorMessage = '无法创建目录，请联系管理员!';			
				return;
			}
		}
		chmod($uploadPath, 0777); 
		//生成新文件名
		$nowTime = explode(' ', microtime());
		$fileSN = round($nowTime[0]*1000+$nowTime[1]);
		$newFileName = "file".$fileSN;
		
		for($i=1;$i<10000;$i++){
			if (file_exists($uploadPath.$newFileName.".".$oldExtFileName) == false)
			{
				$newFileName = $newFileName.".".$oldExtFileName;
				$tmpstr = '0';
				break;
			}
			$newFileName = "file".($fileSN+$i);
			$tmpstr = '1';			
		}
		if ($tmpstr == '1'){
			$this->errorMessage = "磁盘空间满!";			
			return;
		}
		
		//保存文件
		if (move_uploaded_file($oldFileName,$uploadPath.$newFileName) == false){
			$this->errorMessage = "文件写入错误,请联系系统管理员!";			
			return;
		}
		
		//写数据库记录
		$file_url = WEB_DIRECTORY_NAME.WEB_SITE_UPLOAD_URL.$dateUrl.$newFileName;
		
		//处理$uploadPath中的 \
		$uploadPath = str_replace("\\","\\\\",$uploadPath);
		$sqlstr = "insert into upload_files(file_size,file_admin_id,create_time,file_type,file_name,file_admin,file_note,admin_ip) values(" .
						"$fileSize,".$_SESSION["sess_user_id"].",now(),'$oldExtFileName','$file_url',".
						"'".$_SESSION["sess_user_realname"]."','$this->file_note','$admin_ip');";			
		$this->mysql->insertRec($sqlstr);
		$file_id = $this->mysql->getNewInsertID();
		
		
		//上传成功后的操作
		$tmpstr =  "<script> if (window.parent != window.self) { ";
	  	$tmpstr = $tmpstr . " window.parent.";		
		$tmpstr = $tmpstr . "onUploadEnd($this->needFileType,$file_id,'" . $file_url . "','$this->file_note'); ";		
		$tmpstr = $tmpstr . "}</script>";		
		$this->processOnSuccess = $tmpstr;		
	}
}
?>