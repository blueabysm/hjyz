<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(28);

include_once("../../database/mysqlDAO.php");


//取得参数
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:index.php");
		exit;
	}
}


//取得当前操作的
$findAllRec="select * from question where question_id='$id'";
$row=$mysqldao->findOneRec($findAllRec);
$findAllRec="select answer_content from answer where question_id='$id'";
$answer_content=$mysqldao->findOneRec($findAllRec);
$answer_content = $answer_content[0];
//取得相关行政许可事项
$article_id=$mysqldao->findOneRec("select consent_id from question where question_id='$id'");
$article_id = $article_id[0];
$question_type=$mysqldao->findOneRec("select article_title from work where  article_id='$article_id'");
$question_type = $question_type[0];

if($_POST["op"]=="add"){	
	$answer_content = $_POST["answer_content"];
	
	$findAllRec="select count(answer_id) from answer where question_id='$id'";
	$num=$mysqldao->findOneRec($findAllRec);
	$num = $num[0];
	if($num>0){
		$findAllRec="UPDATE answer set answer_content='$answer_content'";
		$mysqldao->updateRec($findAllRec);
		
		$returnInfo="已提交！";

	}else{
		$findAllRec="insert into answer (question_id,answer_time,answer_content) values ('$id',now(),'$answer_content')";
		$mysqldao->insertRec($findAllRec);
		$findAllRec="UPDATE question set question_state=2 where question_id='$id'";
		$mysqldao->updateRec($findAllRec);
		
		$returnInfo="已提交！";
	}	
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

	if(IsEmpty(me.answer_content,"请填写回答内容！")) return false;

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
			<td width="75%" align="left">&nbsp;<?=$question_type?></td>
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
				<textarea name="question_content" cols="70" rows="5" readonly><?=$row["question_content"]?></textarea></td>
        </tr>
         <tr > 
            <td  align="center" > <B>回答</B></td>
            <td> 
				<textarea name="answer_content" cols="70" rows="5" ><?=$answer_content?></textarea>
			 <font color="#CC0000">(*)</font></td>
        </tr>
        <tr > 
                      <td  align="center" colspan="50"> 
						<INPUT TYPE="submit" value="确 定">
						&nbsp;&nbsp;
						<INPUT TYPE="button" value="取 消" onClick="window.history.back();">

						<INPUT TYPE="hidden" NAME="op" value="add">
						





                      </td>
          </tr>
          </form>
		</table>
	</td>
</tr>
</table>

