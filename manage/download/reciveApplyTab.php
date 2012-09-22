<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(49);
include_once("../../database/mysqlDAO.php");

$sWritePath = "../../".WEB_SITE_UPLOAD_URL;
$user_id = $_SESSION["sess_user_id"];
$mes_title = $_POST["mes_title"];
$mesHandle = $_GET["mesHandle"];
$sid = $_REQUEST['sid'];
$id = $_GET["id"];
$r_id = $_REQUEST["r_id"];
$flag = $_REQUEST["flag"];

//取得参数
if (isset($_REQUEST["mes_id"]) || isset($_REQUEST["r_id"])){
	$id = $_REQUEST["mes_id"];
	$r_id = $_REQUEST["r_id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}

 if($flag == 'no'){//添加
 	$sReadOver = $mysqldao->findOneField(" select mes_readover from down_mes where mes_id = '".$id."'  ");
 	if($sReadOver == ''){//为空
 		$sMesReadOver = ','.$user_id.',';
 	}else{
 		$sMesReadOver .= $user_id.',';
 	}//修改为已读
 	$mysqldao->updateRec(" update down_mes set mes_readover = '$sMesReadOver' where mes_id = '".$id."'  ");
 	
	$sid=file_srand();
 	$strSql=" insert into down_remes (user_id,mes_id,mes_title ,file_sid,mes_time) 
 		values ($user_id,'$id','$mes_title','$sid',now()) ";
 	
 	$mysqldao->insertRec($strSql);
	
 	$returnInfo="已回复成功！";
	//GoToPage("reciveMesList.php",$returnInfo);
	//exit;
 }
 if($flag == 'ok'){//修改
 	$strSql = " update down_remes set 
 		mes_title = '$mes_title' where remes_id=$r_id ";
 	
 	$mysqldao->updateRec($strSql);
 	
 	$returnInfo="已修改成功！";
	//GoToPage("reciveMesList.php",$returnInfo);
	//exit;
 }

 
 if($flag <> "" ){	
	
		//上传文件
		include("../../util/upload_file_class.php");
		//不允许上传的文件
		$sConfigEstopUploadType="exe,php,php3,php4,asp,aspx,pl,cgi,shtml,asx,jsp,sh,msi,rpm,deb,pkg,asa";	
		//允许上传的文件类型
		$sConfigEnabledUploadFileType=UPLOAD_FILE_TYPE; 
		
		$src = $_FILES["src"];
		
		//文件上传
		if($src["name"] <> ""){
			$oUploadFile=new File_Class("src");	
			$oUploadFile->UploadTo($sWritePath,$sConfigEstopUploadType,$sConfigEnabledUploadFileType);
			if($oUploadFile->error_message){
				$sTempReturnInfo=$oUploadFile->error_message;
				GoToPage("reciveMesList.php",$sTempReturnInfo);
				exit;
			}else{	
				
				$sTempImagePath=$oUploadFile->file_target_path.$oUploadFile->file_target_name.".".$oUploadFile->file_exname;				
				//插入相对路径到数据库
				if($sid <> "" and $flag == 'ok' ){
					//删除覆盖文件
					$tmpFileName = $mysqldao -> findOneField("select file_path from down_files where file_sid = '$sid'");
					if(is_file($sWritePath.$tmpFileName)){
						unlink($sWritePath.$tmpFileName);
					}				
					$Query = "update down_files set file_path='$sTempImagePath' where file_sid = '$sid' ";
					$mysqldao->updateRec($sQuery);		
				}
			} 
			
			if( $flag == 'no' ){
				 $query = "insert into down_files (file_sid,is_admin, create_time,file_path,file_info) values ('$sid','2',now(),'$sTempImagePath','$s_file_infor')";
				 $mysqldao -> insertRec($query);
			}
			
			if( $flag == 'ok' ){
				$query = "update down_files set   file_path = '$sTempImagePath' ,file_info = '$s_file_infor' where file_sid = '".$sid."'";
				$mysqldao ->updateRec($query);
			}
		}

		
		GoToPage("reciveMesList.php",$returnInfo);
		exit;
}

$mes_row = $mysqldao-> findOneRec("select * from down_mes where mes_id='$id'");
if($r_id <> ""){
	$remes_row = $mysqldao-> findOneRec("select * from down_remes where remes_id='$r_id'");
	
	$sQuery="select file_path from down_files  where file_sid= '".$remes_row["file_sid"]."' ";
	$sFilePath = $mysqldao->findOneField($sQuery);
	$sFileName = substr(strrchr( $sFilePath, "/" ), 1 );	
	
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script	language="javascript" src="../../global/function.js"></script>
<script>
function errFocus(msg) {
	   alert(msg);
	   return false;
}

function strip_space(str){
	while (str !="" && str.charAt(0) == " ") 
		str = str.substring(1,str.length);  
	while (str !="" && str.charAt(str.length-1) == " ") 
		str = str.substring(0,str.length-1);  
	return str;
}

function mesCheck(){
	var handle = '<?=$mesHandle?>';
	var mes_title=strip_space(document.mes_form.mes_title.value);
	var src=strip_space(document.mes_form.src.value);
	if(mes_title=="") { return errFocus("回复说明不能为空.");}
	if(src=="" && handle=='no') { return errFocus("附件信息不能为空.");}
	return true;
}
</script>
</HEAD>
<body >
<script src="../../js/function.js"></script>
<table width="98%" border="0" align="center" cellpadding="0"	cellspacing="1">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">下载中心管理</td>
	</tr>
	<tr>
		<td>
		<table  width="100%" align="center"
			bgColor="5e9fcb"   class="FormLabel" border="0" cellspacing="1" cellpadding="0">
			<form name="mes_form" action="" method="post" enctype="multipart/form-data"   onsubmit="return mesCheck();">
			<tr width="100%" align="center" bgColor="#FFFFFF">
				<td width="10%" height="25" align="center"><B>信息名称</B></td>
				<td align="left" colspan="3" >&nbsp;<?=$mes_row["mes_title"]?></td>
			</tr>
			<tr bgcolor="#FFFFFF">
			<td height="25"   align="center">回复说明</td>
				<td colspan="3" >
				<input name="mes_title" type="text" maxlength="48" class="TableTd" value=<?=$remes_row["mes_title"]?>></td>
				</td>
			</tr>
			
			<tr  bgcolor="#FFFFFF" style="display:<? if($remes_row["mes_time"] == ''){?>none<? } ?>">
				<td height="25"  align="center"><B>发布时间</B></td>
				<td colspan="3" align="left">&nbsp;<?=substr($mes_row["mes_time"],0,10)?></td>
			</tr>
			<tr  bgcolor="#FFFFFF">
				<td height="25"  align="center"><B>附件</B></td>
				<td  width="18%">
					<a href="<?=$sWritePath.$sFilePath?>"><?=$sFileName?></a>
				</td>
				<td colspan="2">
					<input name="src" type="file" >&nbsp;(只能添加一个附件，新添加附件将替换原附件)
				</td>
			</tr>
			<tr  bgcolor="#FFFFFF">
				<td align="center" colspan="4" height="40">
				<input type="hidden" name="id" value="<?=$id?>"/>
				<input type="hidden" name="r_id" value="<?=$r_id?>"/>
				<input type="hidden" name="sid" value="<?=$remes_row["file_sid"]?>"/>
				<input type="hidden" name="flag" value="<?php echo $mesHandle;?>">
				<INPUT TYPE="submit" value="确 定"> &nbsp;&nbsp;
				 <INPUT	TYPE="button" value="取 消" onClick="window.history.back();">
			</td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>