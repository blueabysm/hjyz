<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(10); 

include_once("../../database/mysqlDAO.php");
include("editObjPartSetPurviewClass.inc.php");

$myPageClass = new editObjPartSetPurviewClass($_GET,$mysqldao);
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
<title>对象权限管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">该用户能管理以下单位的机构设置</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<TR>
				<TD class="FormLabel" align="left" colspan="2">
					<a href='addPartSetPurview.php?page=<?=$myPageClass->page?>&uid=<?=$myPageClass->uid?>&id=<?=$myPageClass->id?>'>增加单位管理权</a>
					<a href='editObjectPurview.php?page=<?=$myPageClass->page?>&uid=<?=$myPageClass->uid?>'>返回</a>								
				</TD>
			</TR>			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="20%" align="center">单位名称</td>
						<td class="TableTdCaption" width="65%" align="center">拥有权限</td>
						<td class="TableTdCaption" width="10%" align="center">操作</td>
					</tr>
					<?php
					if ($myPageClass->objList != -1)
					{
						for ($i=0;$i<count($myPageClass->objList);$i++)
						{
							if ( ($i % 2) == 0){
								$tmpstr = "";
							} else {							
								$tmpstr = " style='background: #F0F0F0;' ";
							}						
							echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
							echo ($i+1);
							echo "</td>\n<td class='TableTd' $tmpstr>";
							echo $myPageClass->objList[$i]["obj_name"];						
							echo "</td>\n<td class='TableTd' align='left' $tmpstr>";
							for($j=0;$j<count($myPageClass->purList);$j++)
					     	{
		     			  		$str2= ','.$myPageClass->purList[$j]["p_id"].',';
		     			  		$find = strpos($myPageClass->objList[$i]["pur_list"],$str2);
		     			  		if ($find === false){
		     			  			$chk = "";
		     			  		} else {
		     			  			$chk = 'checked="checked"';
		     			  		}
		     			  		
		     			  		echo '<input type="checkbox" '.$chk.' disabled="disabled" readonly="readonly" name="selPurList[]" id="selPurList_'.$myPageClass->purList[$j]["p_id"].'" value="'.$myPageClass->purList[$j]["p_id"] . '"/>';
		     			  		echo $myPageClass->purList[$j]["p_name"].' ';		  		
			     			}						
							echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
							echo "<a href='editPartSetPurview.php?rec_id=".$myPageClass->objList[$i]["rec_id"]."&uid=".$myPageClass->uid."&page=".$myPageClass->page."&id=$myPageClass->id'>修改</a> ";
							echo "<a onclick=\"return confirm('确定要删除对此单位的管理权？')\" href='delPartSetPurview.php?rec_id=".$myPageClass->objList[$i]["rec_id"]."&uid=".$myPageClass->uid."&page=".$myPageClass->page."&id=$myPageClass->id'>删除</a> ";
							echo "</td>\n</tr>";						
						}
					}					   
					?>					
				</TABLE>				
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</HTML>
