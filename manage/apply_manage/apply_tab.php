<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(27);

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

$row = $mysqldao-> findOneRec("select * from apply where id='$id'");

if($_REQUEST["op"]=="del"){	
	
	$findAllRec="DELETE FROM apply where id='$id'";
	$mysqldao->deleteRec($findAllRec);
	
	$returnInfo="已删除！";
	GoToPage("apply_list.php",$returnInfo);
	exit;
}

if($_REQUEST["op"]=="cn"){	
	
	$findAllRec="update apply set xm_pass=3 where id='$id'";
	$mysqldao->updateRec($findAllRec);
	
	$returnInfo="已提交！";
	GoToPage("apply_list.php",$returnInfo);
	exit;
}

if($_REQUEST["op"]=="gl"){	
echo $_POST["op"];
	$findAllRec="update apply set xm_pass=2 where id='$id'";
	$mysqldao->updateRec($findAllRec);
	
	$returnInfo="已提交！";
	GoToPage("apply_list.php",$returnInfo);
	exit;
}




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT	language="javascript" src="../../global/function.js"></script>
</HEAD>
<body >

<br />


<script src="../../js/function.js"></script>
<script>>
<!--
function subm(op){
	var op = op;
	var id = document.opinion_form.id.value;
	document.URL="apply_tab.php?op="+op+"&id="+id;
}

//-->
</script>
<table width="98%" border="0" align="center" cellpadding="0"
	cellspacing="1">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上申报管理</td>
	</tr>
	<tr>
		<td>
		<form name="opinion_form" action="" method="post"
			onsubmit="return check();">
		<table cellSpacing="1" cellPadding="0" width="99%" align="center"
			bgColor="#ebebeb" border="1" class="FormLabel">
			<tr width="100%" align="center">
				<td align="center"><B>姓名</B></td>
				<td align="left" class="TableTd">&nbsp;<?=$row["user_name"]?></td>
				<td align="center"><B>联系地址</B></td>
				<td align="left" class="TableTd">&nbsp;<?=$row["user_address"]?></td>
			</tr>
			<tr>
				<td width="15%" align="center"><B>手机</B></td>
				<td width="35%">&nbsp;<?=$row["user_selphone"]?></td>
				<td width="15%" align="center"><B>联系电话</B></td>
				<td width="35%">&nbsp;<?=$row["user_phone"]?></td>
			</tr>

			<tr>
				<td align="center"><B>邮编</B></td>
				<td>&nbsp;<?=$row["user_zip"]?></td>
				<td align="center">Email</td>
				<td>&nbsp;<?=$row["user_email"]?></td>
			</tr>

			<tr>
				<td align="center"><B>项目名称</B></td>
				<td colspan="3">&nbsp;<?=$row["xm_name"]?></td>
			</tr>


			<tr>
				<td align="center"><B>项目简介</B></td>
				<td colspan="3"><textarea cols="70" rows="5" readonly>&nbsp;<?=$row["xm_produce"]?></textarea>
				</td>
			</tr>

			<tr>
				<td align="center"><B>附件</B></td>
				<td colspan="3"><a
					href="http://localhost/e21jyzw/html/upload/<?=$row["xm_file"]?>"><?=$row["xm_file"]?></a>
				</td>
			</tr>
			<input type="hidden" name="id" value="<?=$id?>"/>
			<tr>
				<td align="center" colspan="50"><INPUT TYPE="button" value="已处理" onClick="javascript:self.location.href='apply_tab.php?op=cn&id=<?=$id?>'"> &nbsp;&nbsp; <INPUT TYPE="button"
					value="处理中" onClick="javascript:self.location.href='apply_tab.php?op=gl&id=<?=$id?>'"> &nbsp;&nbsp; <INPUT
					TYPE="button" value="取 消" onClick="window.history.back();"></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>