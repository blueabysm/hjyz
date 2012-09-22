<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(26);

include_once("../../database/mysqlDAO.php");


//取得参数
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}
$rowOpinion = $mysqldao-> findOneRec("select * from opinion where opinion_id='$id'");


if($_REQUEST["op"]=="del"){	
	
	$findAllRec="DELETE FROM opinion where opinion_id='$id'";
	$mysqldao->deleteRec($findAllRec);
	
	$returnInfo="已删除！";
	GoToPage("opinion_result_list.php",$returnInfo);
	exit;
}

if($_REQUEST["op"]=="cn"){	
	
	$findAllRec="update opinion set opinion_pass=3 where opinion_id='$id'";
	$mysqldao->updateRec($findAllRec);
	
	$returnInfo="已提交！";
	GoToPage("opinion_result_list.php",$returnInfo);
	exit;
}

if($_REQUEST["op"]=="gl"){	
echo $_POST["op"];
	$findAllRec="update opinion set opinion_pass=2 where opinion_id='$id'";
	$mysqldao->updateRec($findAllRec);
	
	$returnInfo="已提交！";
	GoToPage("opinion_result_list.php",$returnInfo);
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
function subm(op){
	var op = op;
	var id = document.opinion_form.id.value;
	
	self.document.href="opinion_result_tab.php?op="+op+"&id="+id;
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
			<td align="center"><B>标题</B></td>
			<td align="left" colspan="3" class="TableTd">&nbsp;<?=$rowOpinion["opinion_title"]?></td>
		</tr>

		<tr > 
            <td width="15%" align="center"> <B>发表人</B></td>
            <td width="35%">&nbsp;<?=$rowOpinion["opinion_name"]?></td>
            <td width="15%"  align="center" > <B>发表时间</B></td>
            <td width="35%">&nbsp;<?=$rowOpinion["opinion_time"]?></td>
        </tr>
        
		<tr > 
            <td  align="center" > <B>手机</B></td>
            <td>&nbsp;<?=$rowOpinion["opinion_mphone"]?></td>
            <td  align="center" > <B>电话</B></td>
            <td>&nbsp;<?=$rowOpinion["opinion_phone"]?></td>
        </tr>
		
        <tr > 
            <td  align="center" > <B>邮编</B></td>
            <td>&nbsp;<?=$rowOpinion["opinion_code"]?></td>
            <td  align="center" > <B>邮箱</B></td>
            <td>&nbsp;<?=$rowOpinion["opinion_email"]?></td>
        </tr>
        
        <tr > 
            <td  align="center" > <B>地址</B></td>
            <td colspan="3">&nbsp;<?=$rowOpinion["opinion_address"]?></td>
        </tr>
        
        <tr > 
            <td  align="center" > <B>内容</B></td>
            <td colspan="3"> 
				<textarea name="subject_content" cols="70" rows="5"  readonly>&nbsp;<?=$rowOpinion["opinion_content"]?></textarea>
             </td>
        </tr>
        <input type="hidden" name="id" value="<?=$id?>"/>
        <tr > 
                      <td  align="center" colspan="50"> 
						<INPUT TYPE="button" value="采 纳" onClick="javascript:self.location.href='opinion_result_tab.php?op=cn&id=<?=$id?>'">
						&nbsp;&nbsp;
                        <INPUT TYPE="button" value="处理中" onClick="javascript:self.location.href='opinion_result_tab.php?op=gl&id=<?=$id?>'">
						&nbsp;&nbsp;
						<INPUT TYPE="button" value="取 消" onClick="window.history.back();">






                      </td>
          </tr>
          </form>
		</table>
	</td>
</tr>
</table>

