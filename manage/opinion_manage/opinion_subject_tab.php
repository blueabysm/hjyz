<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(25);

include_once("../../database/mysqlDAO.php");

//取得参数
$op=$_REQUEST["op"];
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}

if($op=="mod"){
	//取得当前操作的文章
	$findAllRec="select * from opinion_subject where subject_id='$id'";
	$rowOpinion=$mysqldao->findOneRec($findAllRec);
}
//mid下拉框
//手动排序
$aGlobalMid[0]["key"]="500";
$aGlobalMid[0]["name"]="默认";
$aGlobalMid[1]["key"]="1000";
$aGlobalMid[1]["name"]="置顶";
$sMidHtml=CreateSelectHtml("subject_order",$aGlobalMid,"key","name",$rowOpinion["subject_order"]);

if($_REQUEST["op"]=="del"){	
	
	$findAllRec="DELETE FROM opinion_subject where subject_id='$id'";
	$mysqldao->deleteRec($findAllRec);
	
	$returnInfo="已删除！";
	GoToPage("opinion_subject_list.php",$returnInfo);
	exit;
}

if($_POST["op"]=="add"){
	$subject_title = $_POST["subject_title"];
	$subject_order = $_POST["subject_order"];
	$subject_content = $_POST["subject_content"];
	$subject_from = $_POST["subject_from"];
	//取得当前操作的文章
	$findAllRec="insert into opinion_subject (subject_title,subject_order,subject_content,subject_time,subject_from) values ('$subject_title','$subject_order','$subject_content',now(),'$subject_from')";
	$mysqldao->insertRec($findAllRec);
	
	$returnInfo="添加完成！";
	
	GoToPage("opinion_subject_list.php",$returnInfo);
	exit;
}
if($_POST["op"]=="mod"){	
	$subject_title = $_POST["subject_title"];
	$subject_order = $_POST["subject_order"];
	$subject_content = $_POST["subject_content"];
	//取得当前操作的文章
	$findAllRec="update opinion_subject set subject_title='$subject_title',subject_order='$subject_order',subject_content='$subject_content',subject_from='$subject_from' where subject_id='$id'";
	$mysqldao->insertRec($findAllRec);
	
	$returnInfo="修改完成！";
	
	GoToPage("opinion_subject_list.php",$returnInfo);
	exit;
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../../global/function.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<body >

<br/>


<script src="../../js/function.js"></script>
<script>>
<!--
function check(){
	var me=document.opinion_form;

	
	if(IsEmpty(me.subject_title,"请填写文章标题！")) return false;
	if(IsEmpty(me.subject_from,"请填写信息来源！")) return false;
	//if(IsEmpty(me.article_key,"请填写文章关键字！")) return false;

	return confirm("您确定要提交吗？");
}

//-->
</script>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">民意征集管理</td>
	</tr>
	<tr>
		<td >



	
		<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="1"  class="FormLabel"> 
		<form name="opinion_form" action="" method="post" onsubmit="return check();">
		

		<tr  width="100%" align="center" > 
			<td width="35%" ><B>标题</B></td>
			<td width="75%" align="left"><INPUT TYPE="text" NAME="subject_title" size="70" value="<?=$rowOpinion["subject_title"]?>">
						<font color="#CC0000">(*)</font></td>
		</tr>

		<tr > 
            <td  align="center"> <B>信息来源</B></td>
            <td> 
				<INPUT TYPE="text" NAME="subject_from" size="30" value="<?=$rowOpinion["subject_from"]?>"><font color="#CC0000">&nbsp;(*)</font>
             </td>
        </tr>
        
        <tr > 
            <td  align="center" > <B>上传时间</B></td>
            <td> 
				<?=$rowOpinion["subject_time"]?>（系统自动生成）
             </td>
        </tr>
        
		<tr > 
            <td  align="center" > <B>手动排序</B></td>
            <td><?=$sMidHtml?></td>
        </tr>
		
        <tr > 
            <td  align="center" > <B>内容</B></td>
            <td> 
				<textarea name="subject_content" cols="70" rows="5"><?=$rowOpinion["subject_content"]?></textarea>
             </td>
        </tr>
        
        <tr > 
                      <td  align="center" colspan="50"> 
						<INPUT TYPE="submit" value="确 定">
						&nbsp;&nbsp;
						<INPUT TYPE="button" value="取 消" onClick="window.history.back();">

						<INPUT TYPE="hidden" NAME="op" value="<?=$op?>">





                      </td>
          </tr>
          </form>
		</table>
	</td>
</tr>
</table>

