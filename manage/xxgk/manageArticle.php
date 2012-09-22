<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(34); 

include_once("../../database/mysqlDAO.php");
include("manageArticleClass.inc.php");

$myPageClass = new manageArticleClass($_POST,$_GET,$mysqldao);
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
<title>信息公开管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delArticle(id,cid)
	{
		if ( confirm("你确定要删除该文章吗？\n删除文章将同时删除对该文章的所有评论以及所有的引用(文章被推荐到某栏目称为被引用)") == false) return false;
		window.location="deleteArticle.php?id=" + id + "&cid=" + cid + "&page=<?=$myPageClass->to_page?>" + "&retURL=" + "<?=$myPageClass->retURL?>";
		return false;
	}
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" action="manageArticle.php" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->articleColumnsName?> 栏目信息</td>
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
				<a href='editArticle.php?item_id=<?=$myPageClass->columnsID?>&page=<?echo $myPageClass->to_page?>&retURL=<?=$myPageClass->retURL?>'>添加新的公开信息</a>				
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="45%" align="center">信息标题</td>
						<td class="TableTdCaption" width="25%" align="center">发表时间</td>						
						<td class="TableTdCaption" width="10%" align="center">状态</td>
						<td class="TableTdCaption" width="20%" align="center">操作</td>
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
						
						if ($myPageClass->articleList[$i]["s_id"] == 0){
							echo $myPageClass->articleList[$i]["article_title"];
						} else {
							echo '<em style="color:#9e0b0f">'.$myPageClass->articleList[$i]["article_title"].'</em';
						}
						
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->articleList[$i]["article_time"];
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						switch ($myPageClass->articleList[$i]["article_state"])
						{
							case 1: echo "<font color='green'>发布</font>";break;
							case 2: echo '归档';break;
							case 3: echo "<font color='orange'>待审</font>";break;
							case 4: echo "<font color='red'>退回</font>";break;
							case 5: echo "<font color='blue'>起草</font>";break;
							default :echo '未知';break;
						}
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						if ($myPageClass->articleList[$i]["s_id"] == 0){
							echo "<a href='editArticle.php?item_id=".$myPageClass->columnsID."&article_id=".$myPageClass->articleList[$i]["article_id"]."&page=".$myPageClass->to_page."&retURL=".$myPageClass->retURL."'>修改</a> ";
						} else {
							echo "<a href='editArticle.php?item_id=".$myPageClass->articleList[$i]["s_item_id"]."&article_id=".$myPageClass->articleList[$i]["s_id"]."&page=".$myPageClass->to_page."&retURL=".$myPageClass->retURL."'>修改</a> ";
						}
/* 						if (($myPageClass->articleList[$i]["article_state"] == 1) && ($myPageClass->articleList[$i]["s_id"]==0)){
							echo "<a href='shareArticle.php?item_id=".$myPageClass->columnsID."&id=".$myPageClass->articleList[$i]["article_id"]."&page=".$myPageClass->to_page."&retURL=".$myPageClass->retURL."'>推荐</a> ";
						} */
						echo "<a href='javascript:void(0)' onclick='return delArticle(".$myPageClass->articleList[$i]["article_id"].",".$myPageClass->columnsID.")'>删除</a>";
						
						echo "</td>\n</tr>";					
						
					}					   
					?>
					
				</TABLE>
				<div align="right">
				  <span class="blue12">
					共<?echo $myPageClass->page_num?>页
					第<?echo $myPageClass->to_page?>页
					<a href="manageArticle.php?id=<?=$myPageClass->columnsID?>&page=<?echo $myPageClass->first_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">首页</A>
					<a href="manageArticle.php?id=<?=$myPageClass->columnsID?>&page=<?echo $myPageClass->up_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">上页</A>
					<a href="manageArticle.php?id=<?=$myPageClass->columnsID?>&page=<?echo $myPageClass->next_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">下页</A>
					<a href="manageArticle.php?id=<?=$myPageClass->columnsID?>&page=<?echo $myPageClass->last_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">末页</A>
				  </span>
				</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
</body>
</HTML>
