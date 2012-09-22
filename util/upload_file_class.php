<?php
/*
上传文件类
*/
class File_Class{

	var $file_type_array;

	var $file,$file_name,$file_exname,$file_type,$file_size;

	var $file_target_name,$file_target_path;

	var $error_message;

	//构造函数，sFile文件名(如果是本地上传的则应该是file框的name)
	function File_Class($sFile){
		$this->SetFileInfo($sFile);
	}

	
	//设置文件信息
	function SetFileInfo($sFile){
		
		$aUploadFile=$_FILES[$sFile];
		$this->file_name=$aUploadFile["name"];
		$this->file_exname=substr(strrchr($this->file_name,"."),1);
		//$this->file_type=$this->file_type_array[$aUploadFile["type"]];
		$this->file_size=$aUploadFile["size"];
		$this->file=$aUploadFile["tmp_name"];
		

		return true;
	}


	//上传到指定路径
	//如果目标文件名为空，则自动按时间生成随机文件名
	function UploadTo($sInitPath,$sEstopUploadFileType,$sEnabledUploadFileType="",$sTargetFilePath="",$sTargetFileName="",$iCheckFileSize=8000000){

		if($this->CheckFile($sEstopUploadFileType,$sEnabledUploadFileType,$iCheckFileSize)){
	
			$this->SetTargetFileName($sTargetFileName);
			$this->SetTargetFilePath($sInitPath,$sTargetFilePath);

			$tmpfile=$sInitPath.$this->file_target_path.$this->file_target_name.".".$this->file_exname;
			if (!move_uploaded_file($this->file,$tmpfile)){
				$message_error="上传失败：  ".$tmpfile;
				$this->SetErrorMessage($message_error);
			}
		}
		
		return true;

	}
	
	
	
	//检查文件是否符合条件,iCheckFileSize的单位为字节
	function CheckFile($sEstopUploadFileType,$sEnabledUploadFileType,$iCheckFileSize){
		
		if($this->file_size>$iCheckFileSize){
			$tmpsize=$iCheckFileSize/1000;
			$message_error="文件不能超过".$tmpsize."K！";
			$this->SetErrorMessage($message_error);
			return false;
		}
		
		//黑名单//白名单
		if(($sEstopUploadFileType && in_array(strtolower($this->file_exname),explode(",",$sEstopUploadFileType))) || ($sEnabledUploadFileType && !in_array(strtolower($this->file_exname),explode(",",$sEnabledUploadFileType)))){
			$message_error="不能上传".$this->file_exname."类型的文件！";
			$this->SetErrorMessage($message_error);
			return false;
		}
		
		
		return true;
	}



	//生成目标文件名（以时间为基础随机）
	function SetTargetFileName($sTargetFileName){
		
		if(!$sTargetFileName){
			srand((double)microtime()*1000000);
			$randval = rand();
			$sTargetFileName =date('YmdHis') ."_".$randval;
		}

		$this->file_target_name=$sTargetFileName;

	}



	//创建目录
	function BuildFolder($sCurrentPath){
		if (!file_exists($sCurrentPath)){ 
			if(!mkdir($sCurrentPath, 0777)){
				$message_error="不能创建目录，在：  ".$sCurrentPath;
				$this->SetErrorMessage($message_error);
				return false;
			}
		}
		return true;
	}

	//生成目标文件路径（按日期建目录）
	function SetTargetFilePath($sInitPath,$sTargetFilePath){

		$sCurrentPath="";


		if($sTargetFilePath){
			$sCurrentPath=$sTargetFilePath;
		}
		else{

			$sCurrentDateTime=date("YmdHis");
			
			//get year month day,create folder
			$sCurrentYear=substr($sCurrentDateTime,0,4);
			$sCurrentPath.=$sCurrentYear;
			$this->BuildFolder($sInitPath.$sCurrentPath);

			$sCurrentMonth=substr($sCurrentDateTime,4,2);
			$sCurrentPath.="/".$sCurrentMonth;
			$this->BuildFolder($sInitPath.$sCurrentPath);

			$sCurrentDay=substr($sCurrentDateTime,6,2);
			$sCurrentPath.="/".$sCurrentDay;
			$this->BuildFolder($sInitPath.$sCurrentPath);
		}
		

		$this->file_target_path=$sCurrentPath."/";
	}

	
	



	//错误信息
	function SetErrorMessage($message_error){
		$this->error_message.=" ".$message_error;
	}
}

?>