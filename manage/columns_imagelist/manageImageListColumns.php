<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(38); 

include_once("../../database/mysqlDAO.php");
include("manageImageListColumnsClass.inc.php");

$myPageClass = new manageImageListColumnsClass($_POST,$_GET,$mysqldao);
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
<title>图片列表栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delLink(id,cid,fid)
	{
		if ( confirm("你确定要删除该图片吗？") == false) return false;
		window.location="deleteImageListColumns.php?id=" + id + "&cid=" + cid + "&fid=" + fid+ "&retURL=" + "<?=$myPageClass->retURL?>";
		return false;
	}
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->imageListColumnsName?></td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="<?=$myPageClass->retURL?>">返回</a>
				</td>
			</tr>			
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='editImageListColumns.php?columns_id=<?=$myPageClass->columnsID?>&retURL=<?=$myPageClass->retURL?>'>添加图片</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"> </td>
						<td class="TableTdCaption" width="50%" align="center">标题/地址</td>
						<td class="TableTdCaption" width="30%" align="center">图片</td>
						<td class="TableTdCaption" width="15%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->imageList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo $i+1;
						echo "</td>\n<td class='TableTd' $tmpstr><b>";
						echo $myPageClass->imageList[$i]["item_title"];
						echo "</b><br/><font color='blue'>";
						echo $myPageClass->imageList[$i]["item_link"];
						echo "</font></td>\n<td class='TableTd' $tmpstr>";
						echo "<a href='".$myPageClass->imageList[$i]["file_name"]."' target='_blank'><img width='60' height='60' border='0' src='".$myPageClass->imageList[$i]["file_name"]."' /></a>";						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editImageListColumns.php?columns_id=".$myPageClass->columnsID."&columns_imagelist_id=".$myPageClass->imageList[$i]["columns_imagelist_id"]."&retURL=".$myPageClass->retURL."'>修改</a> ";
						echo "<a href='#' onclick='return delLink(".$myPageClass->imageList[$i]["columns_imagelist_id"].",".$myPageClass->columnsID.",".$myPageClass->imageList[$i]["file_id"].")'>删除</a>";						
						echo "</td>\n</tr>";						
					}					   
					?>
					
				</TABLE>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
</body>
</HTML>
