<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(29);

include_once("../../database/mysqlDAO.php");
$sCheckedUser = $_GET["sCheckedUser"];
$sCheckedUser = substr($sCheckedUser,1,strlen($sCheckedUser)-2);

$aCheckedUser = explode(',',$sCheckedUser);


//取得参数
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}

$rows = $mysqldao-> findAllRec("select * from admins where (user_type<>5 and user_type<>9) order  by user_type desc");
$rowNum = count($rows);

?>

<html>
<head>
<title>请选择要发送的对象</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
td {  font-size: 9pt}
-->
</style>

<SCRIPT language=JavaScript> 
function all_select(x){	
	if(document.mesForm.all_select_chk.checked){
		for(i=0;i<x;i++){
			document.all.selectuser[i].checked=true;
		}
	}
	else{
		for(i=0;i<x;i++){
			document.all.selectuser[i].checked=false;
		}
	}
	
}


function mes_sub(){ 

	var obj = document.getElementsByName("mesReceive");
	var strMes='';
	for(var i=0;i<obj.length;i++){
	  if(obj[i].checked==true){
	   strMes = strMes+","+obj[i].value;
	  }
	}
	if(strMes != '') strMes = strMes+',';
	this.opener.mes_form.mes_recive.value=strMes;
	window.close();
}
</script>

</head>

<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border=0 cellpadding=1 cellspacing=1   width=700 vspace="10" bgcolor="#666666">
  <form method="post" name="mesForm" action="">
 
 <tr   valign=center bgcolor="#E1E1E1"> 
  <td height=24 colspan="2" align="center" ><b>选择要公开的对象</b></td>
 </tr>
 <tr   valign=center bgcolor="#CCCCCC"> 
  <td height=24 colspan="2" align="right" > 
   <INPUT TYPE="checkbox" NAME="all_select_chk" id="all_select_chk"  onclick="javascript:all_select('<?=$rowNum?>');" >选择全部&nbsp;
 </tr>
<?php 
   for($i=0;$i<ceil($rowNum/2);$i++){
   	$j=$i*2;
  ?>
    <tr align=left valign=center bgcolor="#CCCCCC"> 
      
       <td height=24 width=48% bgcolor="#CCCCCC">&nbsp;
         <input type="checkbox"   id="selectuser" name="mesReceive" value="<?=$rows[$j]["user_id"];?>"  <?php if(in_array($rows[$j]["user_id"],$aCheckedUser)){echo "checked";}?>>
         <?php echo $rows[$j]["user_realname"]?>
       </td>
	   <td   width=48% bgcolor="#CCCCCC">&nbsp;
	    <?php if( ($j+2) < $rowNum ){?>
         <input type="checkbox"  id="selectuser" name="mesReceive" value="<?=$rows[$j+1]["user_id"];?>"  <?php if(in_array($rows[$j+1]["user_id"],$aCheckedUser)){echo "checked";}?>>
         <?php echo $rows[$j+1]["user_realname"];
	    }?>
       </td>
  	</tr>
  	<?php
	 }?>
	 <tr align=center valign=center bgcolor="#CCCCCC"> 
      <td height=32 colspan="8"> 
        <input type="button" name="Submit"  value="提交" onclick="mes_sub();">
        &nbsp;&nbsp;&nbsp;&nbsp; <BUTTON onclick=window.close();>取消</BUTTON> </td>
  </tr>
   </form>
 </table>
 
</body>
  