<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(16); 

include_once("../../database/mysqlDAO.php");
include("myCheckArticleListClass.inc.php");

$myPageClass = new myCheckArticleListClass($mysqldao);
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
<title>待审文章一览表</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<form name="Form1" method="post" action="manageArticle.php" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">待审文章一览表</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="40%" align="center">标题</td>
						<td class="TableTdCaption" width="15%" align="center">所属栏目</td>
						<td class="TableTdCaption" width="20%" align="center">发表时间</td>						
						<td class="TableTdCaption" width="15%" align="center">添加者</td>
						<td class="TableTdCaption" width="10%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->articleList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->articleList[$i]["article_title"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->articleList[$i]["columns_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->articleList[$i]["article_time"];
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->articleList[$i]["user_realname"];
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='checkArticle.php?id=".$myPageClass->articleList[$i]["article_id"].'&item_id='.$myPageClass->articleList[$i]["item_id"].'\'>查看</a>';
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
