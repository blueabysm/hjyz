<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(29);
include_once("../../database/mysqlDAO.php");

$sWritePath = "../../".WEB_SITE_UPLOAD_URL;
$is_admin = 1;
$mesHandle = $_GET["mesHandle"];
if($mesHandle == ''){
	$mesHandle = 'add';
}
$mes_recive = $_POST["mes_recive"];
$mes_title = $_POST["mes_title"];
$mes_note = $_POST["mes_note"];
$open_mes = $_POST['open_mes'];
$mes_pass = $_POST['mes_pass'];
$flag= $_POST['flag'];
$sid = $_POST['sid'];
$id = $_GET['id'];
$del_sid = $_GET['del_sid'];

//取得参数
if (isset($_REQUEST["mes_id"])){
	$id = $_REQUEST["mes_id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}

 if($flag == 'add'){//添加
 	if($open_mes == 1) $mes_recive = 0;//完全公开
	$sid=file_srand();
 	$strSql=" insert into down_mes (mes_recive,mes_title,mes_note,mes_pass,file_sid,mes_time) 
 		values ('$mes_recive','$mes_title','$mes_note','$mes_pass','$sid',now()) ";
 	$mysqldao->insertRec($strSql);
	
 	$returnInfo="已添加成功！";
	//GoToPage("downMesList.php",$returnInfo);
	//exit;
 }
 
 
 if($flag == 'edit'){//修改
 	if($open_mes == 1) $mes_recive = 0;//完全公开
 	$strSql = " update down_mes set mes_recive = '$mes_recive' ,
 		mes_title = '$mes_title',mes_note = '$mes_note',mes_pass='$mes_pass' where mes_id=$id ";
 	$mysqldao->updateRec($strSql);
 	
 	$returnInfo="已修改成功！";
	//GoToPage("downMesList.php",$returnInfo);
	//exit;
 }

if($mesHandle=="del"){//删除
	//删除管理员相关
	$findAllRec="DELETE FROM down_mes where mes_id='$id'";
	$mysqldao->deleteRec($findAllRec);
	$tmpFileName = $mysqldao -> findOneField("select file_path from down_files where file_sid = '$del_sid'");
	if(is_file($sWritePath.$tmpFileName)){
			unlink($sWritePath.$tmpFileName);
	}	
	$findAllRec="DELETE FROM down_files where file_sid='$del_sid'";
	$mysqldao->deleteRec($findAllRec);
	
	//删除回复者相关
	$findAllrec = " select  file_sid from  down_remes where mes_id='$id' ";
	$aRemesSid = $mysqldao->findAllRec($findAllrec);
	for($s=0;$s<count($aRemesSid);$s++){
		$tmpSid = $aRemesSid[$s]["file_sid"];
		$tmpFileName = $mysqldao -> findOneField("select file_path from down_files where file_sid = '$tmpSid'");
		if(is_file($sWritePath.$tmpFileName)){
				unlink($sWritePath.$tmpFileName);
		}	
		$findAllRec="DELETE FROM down_files where file_sid='$tmpSid'";
		$mysqldao->deleteRec($findAllRec);
		
	}
	$findAllRec=" DELETE  FROM  down_remes  where  mes_id='$id' ";
	$mysqldao->deleteRec($findAllRec);
	
	
	$returnInfo="已删除！";
	GoToPage("downMesList.php",$returnInfo);
	exit;
}

if($flag <> ""){	
	
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
				//GoToPage("downMesList.php",$sTempReturnInfo);
				exit;
			}else{	
				
				$sTempImagePath=$oUploadFile->file_target_path.$oUploadFile->file_target_name.".".$oUploadFile->file_exname;				
				//插入相对路径到数据库
				if($sid <> "" and $flag == 'edit' ){
					//删除覆盖文件
					$tmpFileName = $mysqldao -> findOneField("select file_path from down_files where file_sid = '$sid'");
					if(is_file($sWritePath.$tmpFileName)){
						unlink($sWritePath.$tmpFileName);
					}				
					$Query = "update down_files set file_path='$sTempImagePath' where file_sid = '$sid' ";
					$mysqldao->updateRec($sQuery);		
				}
			} 
			if( $flag == 'add' ){
			 $query = "insert into down_files (file_sid,is_admin, create_time,file_path,file_info) values ('$sid','$is_admin',now(),'$sTempImagePath','$s_file_infor')";
			 $mysqldao -> insertRec($query);
		
				
			}
			if( $flag == 'edit' ){
				$query = "update down_files set   file_path = '$sTempImagePath' ,file_info = '$s_file_infor' where file_sid = '".$sid."'";
				$mysqldao ->updateRec($query);
			}
		
		}

		GoToPage("downMesList.php",$returnInfo);
		exit;
	}


$row = $mysqldao-> findOneRec("select * from down_mes where mes_id='$id'");

$sQuery="select file_path from down_files  where file_sid= '".$row["file_sid"]."' ";
$sFilePath = $mysqldao->findOneField($sQuery);
$sFileName = substr(strrchr( $sFilePath, "/" ), 1 );
?>







<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT	language="javascript" src="../../global/function.js"></script>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script>>
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
	
	var mes_title=strip_space(document.mes_form.mes_title.value);
	var open_mes,handle='<?=$mesHandle?>';
	if(document.mes_form.open_mes[1].checked){
		open_mes=strip_space(document.mes_form.open_mes[1].value);
	}
	var mes_recive=strip_space(document.mes_form.mes_recive.value);
	var src=strip_space(document.mes_form.src.value);
	
	if(mes_title=="") { return errFocus("信息名称不能为空.");}
	if(open_mes=="2" && mes_recive == "") { return errFocus("部分公开时请选择公开范围.");}
	if(src=="" && handle=='add') { return errFocus("附件信息不能为空.");}
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
			<form name="mes_form" action="" method="post"  enctype="multipart/form-data"   onsubmit="return mesCheck();">
			<tr width="100%" align="center" bgColor="#FFFFFF">
				<td width="10%" height="25" align="center"><B>信息名称</B></td>
				<td align="left" colspan="3" >&nbsp;<input name="mes_title" type="text" maxlength="48" class="TableTd" value=<?=$row["mes_title"]?>></td>
			</tr>
			<tr bgcolor="#FFFFFF">
			<td height="25"   align="center">信息状态</td>
				<td colspan="3" >
					<? 
					$checked1="";
					$checked2="";
					if($row["mes_pass"]==1 || $row["mes_pass"]==''){
						$checked1="checked";					
					}else if($row["mes_pass"]==0){
						$checked2="checked";
					}
					?>
                <input  type="radio" name="mes_pass" value="1" <?=$checked1?>>有效
                <input  type="radio" name="mes_pass" value="0" <?=$checked2?>>无效
				</td>
			</tr>
			<tr  bgcolor="#FFFFFF">
			<td  height="25"   align="center">公开程度</td>
				<td colspan="3" >&nbsp;
					<? 
					$checked1="";
					$checked2="";
					if(strlen($row["mes_recive"])> 1  ){
						$checked2="checked";					
					}else {
						$checked1="checked";
					}
					?>
                <input type="radio" name="open_mes"  onClick="javascript:document.getElementById('open').style.display='none'"  value="1" <?=$checked1?>>完全公开
                <input type="radio" name="open_mes" onClick="javascript:document.getElementById('open').style.display='block'" value="2" <?=$checked2?>>部分公开
				</td>
			</tr>
			<tr  bgcolor="#FFFFFF" id="open" style="display:<? if(strlen($row["mes_recive"])<= 1){?>none<? } ?>">
				<td height="25"   align="center"><B>公开范围</B></td>
				<td  colspan="3" >&nbsp;<input  type="text" id="mes_recive" name="mes_recive" length="80" readonly 
					 class="TableTd" value=<?=$row["mes_recive"]?>>
					<a href="#" onClick="OpenWindow('userList.php?sCheckedUser=<?=$row["mes_recive"]?>','','left=200,top=50,width=412,height=221,scrollbars=yes,resizable=no')" 
					    class="red12">点击调整</a>
				</td>
			</tr>
			<tr  bgcolor="#FFFFFF" style="display:<? if($row["mes_time"] == ''){?>none<? } ?>">
				<td height="25"  align="center"><B>发布时间</B></td>
				<td colspan="3" align="left">&nbsp;<?=$row["mes_time"]?></td>
			</tr>
			<tr  bgcolor="#FFFFFF">
				<td   align="center"><B>信息简介</B></td>
				<td colspan="3"><textarea name="mes_note" cols="70" rows="4" ><?=$row["mes_note"]?></textarea>
				</td>
			</tr>

			<tr  bgcolor="#FFFFFF">
				<td height="25"  align="center"><B>附件</B></td>
				<td  width="18%">
					<a href="<?=$sWritePath.$sFilePath?>"><?=$sFileName?></a>
				</td>
				<td colspan="2">
					<input length="10" name="src" type="file" >&nbsp;(只能添加一个附件，新添加附件将替换原附件)
				</td>
			</tr>
			<tr  bgcolor="#FFFFFF">
				<td align="center" colspan="4" height="40">
				<input type="hidden" name="id" value="<?=$id?>"/>
				<input type="hidden" name="sid" value="<?=$row["file_sid"]?>"/>
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