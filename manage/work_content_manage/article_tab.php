<?
header("Content-Type: text/html; charset=UTF-8");
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(23);

include_once("../../database/mysqlDAO.php");
include ("../../lib/xajax/xajax.inc.php");

if(isset($xajax)){
	unset($xajax);
	$xajax = new xajax("article_tab.php");
}

function selectedUnit($id){
	global $mysqldao;	
	
	$sQuery="select part_id,part_name from corp_part where corp_id='$id'";
	$rst=$mysqldao->findAllRec($sQuery);


	$objResponse = new xajaxResponse("UTF-8");
	$arrayId = array();
	$arrayName = array();
	for($i=0;$i<count($rst);$i++){
		//$objResponse->addAlert($rst[$i]["part_name"]);
		array_push($arrayId,$rst[$i]["part_id"]);	
		array_push($arrayName,$rst[$i]["part_name"]);			
		
	}
	$objResponse->addScriptCall("changeDepartment",$arrayId,$arrayName);

	return $objResponse;
}
function selectedDepartment($id){
	global $mysqldao;	
	
	$sQuery="select user_realname,user_id from admins where user_part='$id'";
	$rst=$mysqldao->findAllRec($sQuery);

	$objResponse = new xajaxResponse("UTF-8");
	$arrayId = array();
	$arrayName = array();
	for($i=0;$i<count($rst);$i++){
		//$objResponse->addAlert($rst[$i]["part_name"]);
		array_push($arrayId,$rst[$i]["user_id"]);	
		array_push($arrayName,$rst[$i]["user_realname"]);			
		
	}
	$objResponse->addScriptCall("changePerson",$arrayId,$arrayName);

	return $objResponse;
}
$xajax->registerFunction("selectedUnit");
$xajax->registerFunction("selectedDepartment");
$xajax->processRequests();

//取得参数
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	if ( IsNumber($id) == 0){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}



$op = $_REQUEST["op"];

if($op=="mod"){
	//取得当前操作的文章
	$sfindAllRec = "select * from work where article_id='$id'";
	$rsThisArticle = $mysqldao->findOneRec($sfindAllRec);
	$sSelectedValue = $rsThisArticle["base_id"];
	$corpId = $rsThisArticle["unit"];
	$partId = $rsThisArticle["department"];
	$personId = $rsThisArticle["person"];
	//取得文章内容
	$sfindAllRec="select work_content from work_content where work_id='$id'";
	$sThisArticleContent=$mysqldao->findOneRec($sfindAllRec);
	$sThisArticleContent = $sThisArticleContent[0];

}

//生成主栏目下拉框((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((())))))))开始
$sfindAllRec="select * from work_columns where columns_pid=-1 order by columns_id ";
$rsAllItem=$mysqldao->findAllRec($sfindAllRec);
for($i=0;$i<count($rsAllItem);$i++){
	if($rsAllItem[$i]["columns_id"] == $rsThisArticle["columns_id"]){
		$selected="selected";
	}else{
		$selected="";
	}
	$sItemSelectedHtml.="<option value=\"".$rsAllItem[$i]["columns_id"]."\"".$selected.">".$rsAllItem[$i]["columns_name"]."</option>";
}

$sItemSelectedHtml="<SELECT NAME=\"columns\"><option value=\"\"></option>".$sItemSelectedHtml."</SELECT>";
//生成主栏目下拉框))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))结束

//生产基本设置下拉框
$sQuery="select * from work_columns where columns_pid!=-1 order by columns_pid,columns_id";
$rsAllItem = $mysqldao->findAllRec($sQuery);
$aAllItem = CreateArrayFromRs_2($rsAllItem,"columns_pid");

$arPid = array();
for($i=0;$i<count($rsAllItem);$i++)
{
	array_push($arPid,$rsAllItem[$i]["columns_pid"]);	
}

function CreateArrayFromRs_2($aRs,$sFieldKey){	
	$iRsCount=count($aRs);
	$aArray=array();
	for($i=0;$i<$iRsCount;$i++){		
		$aArray[$aRs[$i][$sFieldKey]][count($aArray[$aRs[$i][$sFieldKey]])]=$aRs[$i];
	}
	return $aArray;	
}

$sBaseSelectedHtml=createItemSelect($aAllItem,"0","&nbsp;&nbsp;&nbsp;&nbsp;",$sSelectedValue,$arPid);
$sBaseSelectedHtml="<SELECT NAME=\"base\"><option vlaue=\"\"></option>".$sBaseSelectedHtml."</SELECT>";

//有子栏目的，使其value为“”
function createItemSelect($aAllItem,$iPid,$sNbsp,$sSelectedValue,$arPid){
	$sHtml="";

	$aThis=$aAllItem[$iPid];
	$iThisCount=count($aThis);
	for($i=0;$i<$iThisCount;$i++){	 
		if($aThis[$i]["columns_id"]==$sSelectedValue){
			$sTempSelected=" selected ";
		}else{
			$sTempSelected="";
		}

		if(in_array($aThis[$i]["columns_id"],$arPid)){
			$val = "";
		}else{
			$val = $aThis[$i]["columns_id"];
		}
		$sHtml.="<option value=\"".$val."\" ".$sTempSelected." >".$sNbsp.$aThis[$i]["columns_name"]."</option>";
	
		$sHtml.=createItemSelect($aAllItem,$aThis[$i]["columns_id"],$sNbsp.$sNbsp,$sSelectedValue,$arPid);
	}

	return $sHtml;
}
//生产基本设置下拉框结束

//mid下拉框
//手动排序
$aGlobalMid[0]["key"]="500";
$aGlobalMid[0]["name"]="默认";
$aGlobalMid[1]["key"]="1000";
$aGlobalMid[1]["name"]="置顶";
$sMidHtml=CreateSelectHtml("article_order",$aGlobalMid,"key","name",$rsThisArticle["article_order"]);


//生成单位下拉框((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((())))))))开始
$sfindAllRec = "select c_id,corp_name from corp order by c_id ";
$rsAllItem = $mysqldao->findAllRec($sfindAllRec);
for($i=0; $i<count($rsAllItem); $i++){
	if($rsAllItem[$i]["c_id"] == $corpId){
		$selected = "selected";
	}else{
		$selected = "";
	}
	$selectUnit .= "<option value=\"".$rsAllItem[$i]["c_id"]."\" ".$selected.">".$rsAllItem[$i]["corp_name"]."</option>";	
}
$selectUnit = "<SELECT NAME=\"unit\" onchange=\"javascript:xajax_selectedUnit(this.value);\"><option value=\"\"></option>".$selectUnit."</SELECT>";

if($op == "mod"){//修改回显
	//责任部门下拉框
	$sfindAllRec="select part_id,part_name from corp_part where corp_id='$corpId' order by part_id ";
	$rsAllItem=$mysqldao->findAllRec($sfindAllRec);
	for($i=0;$i<count($rsAllItem);$i++){
		//echo $rsAllItem[$i]["part_id"];
		if($rsAllItem[$i]["part_id"] == $partId){
			$selected="selected";
		}else{
			$selected="";
		}
		$selectedDepartment .= "<option value=\"".$rsAllItem[$i]["part_id"]."\"".$selected.">".$rsAllItem[$i]["part_name"]."</option>";
	}
	
	
	//责任人下拉框
	$sfindAllRec = "select user_id,user_realname from admins where user_part='$partId' order by user_id ";
	$rsAllItem=$mysqldao->findAllRec($sfindAllRec);
	
	for($i=0; $i<count($rsAllItem); $i++){
		if($rsAllItem[$i]["user_id"] == $personId){
			$selected="selected";
		}else{
			$selected="";
		}
		$selectedPerson .= "<option value=\"".$rsAllItem[$i]["user_id"]."\"".$selected.">".$rsAllItem[$i]["user_realname"]."</option>";
	}
}
?>


<script src="../../js/function.js"></script>
<script src="../editor/WLEditor.js" type="text/javascript"></script>
<?php $xajax->printJavascript('../../lib/xajax/');?>
<script>
<!--
function GetData()
{  
	var tmpobj = document.getElementById("work_content");											
	tmpobj.value = editor.data();																					
	return true;
}	
function article_form_check(){
	GetData();
	
	var me=document.article_form;
	if(IsEmpty(me.article_title,"请填写文章标题！")) return false;
	if(IsSelected(me.columns,"","请选择所属栏目！")) return false;
	if(IsSelected(me.base,"","请选择基本设置！")) return false;
	if(IsEmpty(me.article_from,"请填写信息来源！")) return false;
	if(me.guide.value.length()>256){
		me.guide.focus();
		alert("办事指南最多256字！");
		return false;
	}
	//if(IsEmpty(me.article_key,"请填写文章关键字！")) return false;

	return confirm("您确定要提交吗？");
}
			
function changeDiv(objID)
{
	var tmpobj = document.getElementById(objID);				
	if (tmpobj.style.display == "none"){
		tmpobj.style.display="";
	} else {
		tmpobj.style.display="none";
	}
}
function localImageClick()
{
	var tmpobj = document.getElementById("uploadIframe");						
	tmpobj.src = "../upload.php?it=1&nt=2";				
	changeDiv("divMainForm");
	changeDiv("divUploadForm");	
}
function localFileClick()
{
	var tmpobj = document.getElementById("uploadIframe");
	tmpobj.src = "../upload.php?it=1&nt=1";
	changeDiv("divMainForm");
	changeDiv("divUploadForm");	
}
function onUploadEnd(ftype,fid,furl,fnote)
{
	changeDiv("divMainForm");
	changeDiv("divUploadForm");
	
	if (ftype == 1) 
	{
		WLinsertFile(furl,fnote); 
	}
	else
	{
		WLInsertImage(furl, 0, 0, 0);
	}
}
function changeDepartment(arrayId,arrayName){
	var me=document.article_form;
	var option = document.getElementById("department");
	var option1 = document.getElementById("person");
	var len = option.length-1;
	for(var i=len;i>=1;i--) { 			
		option.options.remove(i);    
	}
	var len1 = option1.length-1;
	for(var i=len1;i>=1;i--) { 			
		option1.options.remove(i);    
	}
	for(var i=0;i<arrayId.length;i++) { 
		var option1 = new Option(arrayName[i],arrayId[i]);
		option.options.add(option1);  		
	}
}
function changePerson(arrayId,arrayName){
	var me=document.article_form;
	var option = document.getElementById("person");
	
	var len = option.length-1;
	for(var i=len;i>=1;i--) { 			
		option.options.remove(i);    
	}

	for(var i=0;i<arrayId.length;i++) { 
		var option1 = new Option(arrayName[i],arrayId[i]);
		option.options.add(option1);  		
	}
}
//-->
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<body >

<div id="divMainForm">	
<br/>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上办事内容管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">



	
		<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">	 	
              <FORM METHOD=POST ACTION="article_post.php" encType="multipart/form-data" name="article_form" onsubmit="return article_form_check();">
				

					<tr  class='TableTd'> 
                      <td  width="20%" align="center"> 
                        <B>标题</B>
                      </td>
                      <td> 
						<INPUT TYPE="text" NAME="article_title" size="70" value="<?=$rsThisArticle["article_title"]?>" maxlength="100">
						<font class="red12">&nbsp;(*)</font>
                      </td>
                    </tr>


					<tr class='TableTd'> 
                      <td  width="20%" align="center"> 
                        <B>所属栏目</B>
                      </td>
                      <td> 
						<?=$sItemSelectedHtml?><font class="red12">&nbsp;(*)</font>
                      </td>
                    </tr>

					<tr class='TableTd'> 
                      <td  width="20%" align="center"> 
                        <B>基本设置</B>
                      </td>
                      <td> 
						<?=$sBaseSelectedHtml?><font class="red12">&nbsp;(*)</font>
                      </td>
                    </tr>
                    <!--
					<tr class='TableTd'> 
                      <td  width="20%" align="center"> 
                        <B>作者</B>
                      </td>
                      <td> 
						<INPUT TYPE="text" NAME="article_ath" size="30" value="<?=$rsThisArticle["article_ath"]?>"><font class="red12">&nbsp;(*)</font>
                      </td>
                    </tr>
										<tr class='TableTd'> 
                      <td  width="20%" align="center"> 
                        <B>链接地址</B>
                      </td>
                      <td> 
						<INPUT TYPE="text" NAME="article_http" size="30" value="<?=$rsThisArticle["article_http"]?>">
                        <font class="">&nbsp;必须以“http://”开头</font>
                      </td>
                    </tr>
					-->

					<tr class='TableTd'> 
                      <td  width="20%" align="center"> 
                        <B>信息来源</B>
                      </td>
                      <td> 
						<INPUT TYPE="text" NAME="article_from" size="30" value="<?=$rsThisArticle["article_from"]?>" maxlength="100"><font class="red12">&nbsp;(*)</font>
                      </td>
                    </tr>

                    <tr class='TableTd'> 
                      <td align="center"> 
                        <B>文章关键字</B>
                      </td>
                      <td> 
						<INPUT TYPE="text" NAME="article_key" size="70" value="<?=$rsThisArticle["article_key"]?>" maxlength="100">
                      </td>
                    </tr>
                    
                     <tr class='TableTd'> 
                      <td align="center"> 
                        <B>单位</B>
                      </td>
                      <td> 
						<?=$selectUnit?>
                      </td>
                    </tr>
                    
                     <tr class='TableTd'> 
                      <td align="center"> 
                        <B>责任部门</B>
                      </td>
                      <td> 
						<?//=$selectedDepartment?>
                        <select name="department" id="department"  onChange="javascript:xajax_selectedDepartment(this.value);">
                            <option value=""></option>
                            <?=$selectedDepartment?>
                          </select>
                      </td>
                    </tr>
                    
                    <tr class='TableTd'> 
                      <td align="center"> 
                        <B>责任人</B>
                      </td>
                      <td> 
						<?//=$selectedPerson?>
                        <select name="person" id="person">
                            <option value=""></option>
                            <?=$selectedPerson?>
                          </select>
                      </td>
                    </tr>
                    
                    <tr class='TableTd'> 
                      <td align="center"> 
                        <B>联系方式</B>
                      </td>
                      <td> 
						<INPUT TYPE="text" NAME="person_tel" size="30" value="<?=$rsThisArticle["person_tel"]?>" maxlength="100">
                      </td>
                    </tr>
                    
                    <tr class='TableTd'> 
                      <td align="center"> 
                        <B>办事指南</B>
                      </td>
                      <td> 
                      	<textarea name="guide" rows="3" cols="70"><?=$rsThisArticle["guide"]?></textarea>
						
                      </td>
                    </tr>
                    
					<tr class='TableTd'> 
                      <td align="center"> 
                        <B>上传时间</B>
                      </td>
                      <td> 
					  <?=$rsThisArticle["article_time"]?>（系统自动生成） </td>
                    </tr>

                    
					<tr class='TableTd'> 
                      <td align="center"> 
                        <B>手动排序</B>
                      </td>
                      <td> 
						<?=$sMidHtml?>
                      </td>
                    </tr>
					
                  	<tr>
								<td class="FormLabel" colSpan="2">
								<input name="work_content" id="work_content" type="hidden" value="<? echo $sThisArticleContent;?>" />
									<script type="text/javascript">
										var editor = new WLEditor("editor");
										editor.hiddenName = "work_content";
										editor.width = "100%";
										editor.height = "400px";
										editor.imagePath = '../editor/images/';
										editor.uploadFileFunction = 'localFileClick();';
										editor.uploadImageFunction = 'localImageClick();';										
										editor.show();
																												
									</script>
								</td>
					</tr>
					

					<table width="100%" border="0" cellspacing="1" cellpadding="1"  class='TableTd' >
					<tr> 
                      <td  align="center" colspan="50"> 
						<INPUT TYPE="submit" value="确 定">
						&nbsp;&nbsp;
						<INPUT TYPE="button" value="取 消" onClick="window.history.back();">

						<INPUT TYPE="hidden" NAME="op" value="<?=$op?>">
					
						<INPUT TYPE="hidden" NAME="id" value="<?=$id?>">




                      </td>
                    </tr>
                  </table>


     
              </FORM>
            </table>
			</td>
			</tr>
			</table>
     </div>      
    <div id="divUploadForm" style="display: none;">
		<iframe name="uploadIframe" id="uploadIframe" src="" height="100%" width="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>