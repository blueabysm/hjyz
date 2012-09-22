<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(18); 

include_once("../../database/mysqlDAO.php");
include("addCorpClass.inc.php");

$myPageClass = new addCorpClass($_POST,$_GET,$mysqldao);
$myPageClass->Page_Load();
if(strlen($myPageClass->errorMessage)>=1){
	echo "<script>";
  	echo "window.alert('".$myPageClass->errorMessage."');";  	
  	echo "</script>";
}
if(strlen($myPageClass->toURL)>=1){
	echo "<script>";
  	echo "window.location='$myPageClass->toURL';";
  	echo "</script>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>添加单位</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body >
	<br>
		<form id="addSubSite" name="addSubSite" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加单位</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageCorp.php'>返回</a>								
								</TD>
							</TR>			
							<tr>
								<td class="FormLabel" align="right">单位类型:</td>
								<td class="FormLabel">
									<select name="c_type" id="c_type">
					     			<?php
					     			  for($i=0;$i<count($myPageClass->corp_type_list);$i++)
					     			  {
					     			  	echo "<option value='".$myPageClass->corp_type_list[$i]['t_id']."' >".$myPageClass->corp_type_list[$i]['t_name'].'</option>\n';
					     			  	
					     			  } 
					     			?>
					     		</select>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">单位名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="corp_name" id="corp_name" style="width: 200px;" value="<?=$myPageClass->corp_name?>"/>
								<font color="red">*</font>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">简称:</td>
								<td class="FormLabel">								
								<input type="text" maxlength="100" name="short_name" id="short_name" style="width: 200px;" value="<?=$myPageClass->short_name?>"/>
								<font color="red">*</font>	
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">联系电话:</td>
								<td class="FormLabel">								
								<input type="text" maxlength="100" name="phone" id="phone" style="width: 200px;" value="<?=$myPageClass->phone?>"/>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">地址:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="addr" id="addr" style="width: 200px;" value="<?=$myPageClass->user_phone?>"/>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnAdd" id="btnAdd" value="添加"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
