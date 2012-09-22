<?php
session_start();
include_once("../../util/commonFunctions.php"); 
canAcesssThisPage(16);

include_once("../../database/mysqlDAO.php");
include("checkArticleClass.inc.php");

$myPageClass = new checkArticleClass($_POST,$_GET,$mysqldao);
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
		<title>审批文章</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">		
		<script type="text/javascript">
			function checkData()
			{
				var tmpobj = document.getElementById(objID);				
				if (tmpobj.style.display == "none"){
					tmpobj.style.display="";
				} else {
					tmpobj.style.display="none";
				}
			}			
		</script>
	</HEAD>
	<body >	
	<br>
		<form id="editArticle" name="editArticle" onsubmit="return checkData();"  method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">审批文章</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='myCheckArticleList.php'>返回文章列表</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">栏目名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->columns_name?></TD>
							</TR>
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
							<tr>
								<td class="FormLabel" align="right">添加者</td>
								<td class="FormLabel"><?=$myPageClass->user_realname?></td>
							</tr>
							<TR>
								<TD class="FormLabel" align="right">文章状态:</TD>
								<TD class="FormLabel">
									<select name="article_state" id="article_state">
						     			<?php
						     			  for($i=0;$i<count($myPageClass->article_state_list);$i+=2)
						     			  {
						     			  	if ($myPageClass->article_state_list[$i] == $myPageClass->article_state){
						     			  		echo "<option value='".$myPageClass->article_state_list[$i]."' selected='selected'>".$myPageClass->article_state_list[$i+1]."</option>\n";
						     			  	} else {
						     			  		echo "<option value='".$myPageClass->article_state_list[$i]."'>".$myPageClass->article_state_list[$i+1]."</option>\n";     			  		
						     			  	}
						     			  } 
						     			?>
						     		</select>
						     		只有处于“发布”状态的文章才会在网站上显示
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">退回说明:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="200" name="back_text" id="back_text" style="width: 300px;" value="<?=$myPageClass->back_text?>"/>
								仅在退回文章时填写
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" colSpan="2"><?=$myPageClass->article_content?></td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="提交"/>									
									<input type="hidden" name="article_id" id="article_id" value="<?=$myPageClass->article_id?>"/>
									<input type="hidden" name="item_id" id="item_id" value="<?=$myPageClass->item_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
