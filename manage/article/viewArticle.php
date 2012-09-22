<?php
session_start();
include_once("../../util/commonFunctions.php"); 
canAcesssThisPage(0);

include_once("../../database/mysqlDAO.php");
include("viewArticleClass.inc.php");

$myPageClass = new viewArticleClass($_POST,$_GET,$mysqldao);
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
		<title>查看文章</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body >	
	<br>
		<form id="editArticle" name="editArticle" onsubmit="return checkData();"  method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">查看文章</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<tr>
								<td class="FormLabel" align="right">标题:</td>
								<td class="FormLabel"><?=$myPageClass->article_title?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">关键词:</td>
								<td class="FormLabel"><?=$myPageClass->article_key?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">作者:</td>
								<td class="FormLabel"><?=$myPageClass->article_ath?></td>
							</tr>
							<TR>
								<TD class="FormLabel" align="right">来源:</TD>
								<TD class="FormLabel"><?=$myPageClass->article_from?></TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">图片url:</td>
								<td class="FormLabel"><a target="_blank" href='<?=$myPageClass->img_url?>'><?=$myPageClass->img_url?></a></td>
							</tr>
							<TR>
								<TD class="FormLabel" align="right">文章状态:</TD>
								<TD class="FormLabel">
						     			<?php
						     			  for($i=0;$i<count($myPageClass->article_state_list);$i+=2)
						     			  {
						     			  	if ($myPageClass->article_state_list[$i] == $myPageClass->article_state){
						     			  		echo $myPageClass->article_state_list[$i+1];
						     			  	}
						     			  } 
						     			?>
								</TD>
							</TR>							
							<tr>
								<td class="FormLabel" colSpan="2"><?=$myPageClass->article_content?></td>
							</tr>							
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
