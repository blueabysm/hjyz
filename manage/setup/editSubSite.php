<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(7); 

include_once("../../database/mysqlDAO.php");
include("editSubSiteClass.inc.php");

$myPageClass = new editSubSiteClass($_POST,$_GET,$mysqldao);
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
		<title>修改子网站信息</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body >
	<br>
		<form id="addSubSite" name="addSubSite" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">修改子网站信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageSubSite.php'>返回</a>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right" width="15%">网站名称:</td>
								<td class="FormLabel"  width="85%">
								<input type="text" maxlength="30" name="site_name" id="site_name" style="width: 200px;" value="<?=$myPageClass->site_name?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">网站状态:</td>
								<td class="FormLabel">
								<select name="site_state" id="site_state">					
									<?php
					     			  for($i=0;$i<count($myPageClass->site_state_list);$i+=2)
					     			  {
					     			  	if ($myPageClass->site_state_list[$i] == $myPageClass->site_state){
								     		$tmpstr = "selected='selected'";										     		
								     	} else {
								     		$tmpstr = "";										     		     			  		
								     	}										
										echo "<option value='".$myPageClass->site_state_list[$i]."' $tmpstr>".$myPageClass->site_state_list[$i+1]."</option>\n";
					     			  } 
					     			?>
								</select>						
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">网站链接</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="site_href" id="site_href" style="width: 200px;" value="<?=$myPageClass->site_href?>"/>								
								(不推荐,当需要子网站被访问时转向另一个网址时填写)
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">网站模板:</td>
								<td class="FormLabel">
									<select name="template_dir_name" id="template_dir_name">										
										<?php 										
											 for($i=0;$i<count($myPageClass->templateList);$i++)
											 {
											     if ($myPageClass->templateList[$i]["template_dir_name"] == $myPageClass->template_dir_name){
											     	echo "<option value='".$myPageClass->templateList[$i]["template_dir_name"]."' selected='selected'>".$myPageClass->templateList[$i]["template_name"]."</option>\n";
											     } else {
											     	echo "<option value='".$myPageClass->templateList[$i]["template_dir_name"]."'>".$myPageClass->templateList[$i]["template_name"]."</option>\n";     			  		
											     }
											 } 
										?>
									</select>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
									<input type="hidden" name="sub_sites_id" id="sub_sites_id" value="<?=$myPageClass->sub_sites_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
