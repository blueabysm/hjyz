<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(10); 

include_once("../../database/mysqlDAO.php");
include("editBasePurviewClass.inc.php");

$myPageClass = new editBasePurviewClass($_POST,$_GET,$mysqldao);
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
		<title>修改基本权限</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">		
		<script type="text/javascript">			
			function selectPur(id,c)
			{
				var sel = document.getElementsByName("selPurviewList[]");				
				for(i=0;i<sel.length;i++)
				{
					if(sel[i].id == "main"+id)
					{
						sel[i].checked =c;
					}
				}
			}			
		</script>
	</HEAD>
	<body >
	<div id="divMainForm">
	<br>
		<form id="addSubSite" name="addSubSite" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">修改基本权限</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='managePurview.php?page=<?=$myPageClass->page?>'>返回</a>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">模块列表:</td>
								<td class="FormLabel" >
									 <TABLE cellSpacing="1" cellPadding="1" width="400" bgColor="#ffffff" border="0">
											<tr>
												<td class="TableTdCaption" width="40%" align="center">模块</td>
												<td class="TableTdCaption" width="60%" align="center">功能</td>
											</tr>
											<?php											 
							     			  for($i=0;$i<count($myPageClass->allPurviewList);$i++)
							     			  {
							     			  	if ($myPageClass->allPurviewList[$i]["pid"] == 0)
							     			  	{
								     			  	echo '<tr>';
								     			  	echo '<td class="TableTd">';
								     			  	echo '<input type="checkbox" onclick="selectPur('.$myPageClass->allPurviewList[$i]["menu_id"].',this.checked)"/>';
								     			  	echo $myPageClass->allPurviewList[$i]["menu_name"];
								     			  	echo '</td>';							     			  	
								     			  	echo '<td class="TableTd">';
								     			  								     			  
								     			  	for($j=0;$j<count($myPageClass->allPurviewList);$j++){
								     			  		if ($myPageClass->allPurviewList[$i]["menu_id"] == $myPageClass->allPurviewList[$j]["pid"]){
								     			  			$str= ','.$myPageClass->allPurviewList[$j]["menu_id"].',';
								     			  			$check = "";
								     			  			if (strlen($myPageClass->selPurviewList) > 0){
									     			  			$find = strpos($myPageClass->selPurviewList,$str);	     			  												     			  			
									     			  			if ($find === false){
									     			  				$check= '';
									     			  			} else {
									     			  				$check= 'checked="checked"';
									     			  			}
								     			  			}
								     			  			echo '<input type="checkbox" name="selPurviewList[]" id="main'.$myPageClass->allPurviewList[$i]["menu_id"].'" value="'.$myPageClass->allPurviewList[$j]["menu_id"].'" '.$check.'/>';
								     			  			echo $myPageClass->allPurviewList[$j]["menu_name"];
								     			  			echo '<br>';
								     			  			
								     			  		}
								     			  		
								     			  	}
								     			  	echo '</td>';							     			  	
								     			  	echo '</tr>';
							     			  	}
							     			  } 
					     					?>											
									 </TABLE>									
									 <font color="red">*</font>
								</td>
							</tr>
																		
								
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
									<input type="hidden" name="uid" id="uid" value="<?=$myPageClass->uid?>"/>
									<input type="hidden" name="page" id="page" value="<?=$myPageClass->page?>"/>									
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="divUploadForm" style="display: none;">
		<iframe name="uploadIframe" id="uploadIframe" src="" height="100%" width="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	</body>
</HTML>
