<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(28);

include_once("../../database/mysqlDAO.php");

//取得参数
$op=$_REQUEST["op"];
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:index.php");
		exit;
	}
}

if($op=="mod"){
	//取得当前操作的文章
	$findAllRec="select * from question where question_id='$id'";
	$row=$mysqldao->findOneRec($findAllRec);
}

$findAllRec="select article_title,article_id from work where columns_id in( select columns_id from work_columns where columns_handle='xzxk')";
$rst=$mysqldao->findAllRec($findAllRec);
$consent_select = "";//相关许可事项选择
$selected = "";
for($i=0;$i<count($rst);$i++){
	if($rst[$i]["article_id"]==$row["consent_id"]) $selected="selected";
	$consent_select .= "<option value=\"".$rst[$i]["article_id"]."\"".$selected.">".$rst[$i]["article_title"]."</option>";
}
$consent_select = "<select name=\"consent_id\"><option value=\"0\"></option>".$consent_select."</select>";



if($_REQUEST["op"]=="del"){	
	
	$findAllRec="DELETE FROM question where question_id='$id'";
	$mysqldao->deleteRec($findAllRec);
	
	$returnInfo="已删除！";
	GoToPage("question_list.php",$returnInfo);
	exit;
}

if($_POST["op"]=="add"){
	$consent_id = $_POST["consent_id"];
	$question_content = $_POST["question_content"];
	//取得当前操作的文章
	$findAllRec="insert into question (consent_id,question_state,question_time,question_content) values ('$consent_id',1,now(),'$question_content')";
	$mysqldao->insertRec($findAllRec);
	
	$returnInfo="添加完成！";
	
	GoToPage("question_list.php",$returnInfo);
	exit;
}
if($_POST["op"]=="mod"){	
	$consent_id = $_POST["consent_id"];
	$question_content = $_POST["question_content"];
	//取得当前操作的文章
	$findAllRec="update question set consent_id='$consent_id',question_content='$question_content' where question_id='$id'";
	$mysqldao->insertRec($findAllRec);
	
	$returnInfo="修改完成！";
	
	GoToPage("question_list.php",$returnInfo);
	exit;
}



?>




<script src="../../global/function.js"></script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >

<br/>


<script src="../../js/function.js"></script>
<script>>
<!--
function check(){
	var me=document.question_form;

	if(IsEmpty(me.question_content,"请填写问题内容！")) return false;
	//if(IsEmpty(me.article_key,"请填写文章关键字！")) return false;

	return confirm("您确定要提交吗？");
}

//-->
</script>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上答疑问题管理</td>
	</tr>
	<tr>
		<td >



	
		<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="1"  class="FormLabel"> 
		<form name="question_form" action="" method="post" onsubmit="return check();">
		

		<tr  width="100%" align="center" > 
			<td width="35%" ><B>相关行政许可事项</B></td>
			<td width="75%" align="left"><?=$consent_select?></td>
		</tr>

        
        <tr > 
            <td  align="center" > <B>提问时间</B></td>
            <td> 
				<?=$row["question_time"]?>（系统自动生成）
             </td>
        </tr>
       
		
        <tr > 
            <td  align="center" > <B>问题内容</B></td>
            <td> 
				<textarea name="question_content" cols="70" rows="5"><?=$row["question_content"]?></textarea>
			 <font color="#CC0000">(*)</font></td>
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

