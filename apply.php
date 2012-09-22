<?
session_start();
include_once("util/commonFunctions.php");
?>

<script>
function check(){
	if(document.reg_form.user_name.value=="" || document.reg_form.user_name.value.length<2 || document.reg_form.user_name.value.length>5)
		{
		
		window.alert("请填写正确的真实姓名！");
		document.reg_form.user_name.focus();
		return false;
	}

	
	if(document.reg_form.user_phone.value=="" || document.reg_form.user_phone.value.length<6 || document.reg_form.user_phone.value.length>15){
		window.alert("您填写的联系电话不符合规范请重新填写！");
		document.reg_form.user_phone.focus();
		return false;
	}


		if(document.reg_form.xm_name.value==""){
		window.alert("请填写您的项目名称！");
		document.reg_form.xm_name.focus();
		return false;
	}

		if(document.reg_form.xm_produce.value==""){
		window.alert("请填写项目简介！");
		document.reg_form.xm_produce.focus();
		return false;
	}

	//if(document.reg_form.srcfile.value==""){
	//	window.alert("请提交填写的申请表附件！");
	//	document.reg_form.srcfile.focus();
	//	return false;
	//}
		
	if(document.reg_form.u_sjm.value==""){
		window.alert("请填写随机码！");
		document.reg_form.u_sjm.focus();
		return false;


	}
	
}
</script>

<?
if($_POST["op"]=="ok"){
	if($_POST["u_sjm"]!=$_SESSION['sessRandomNumber']){
		GoToPage("work_consent.php?id=".$id,"随机码不正确！");
		exit;
	}
	
	$rs_sq=$mysqldao->findAllRec("select id from apply where user_name='$user_name' and  xm_name='$xm_name' ");
	
	if (count($rs_sq)>0){
		showMessage('请不要重复提交！');
	}else{
			
	 $accessory_add="insert into apply(user_name,user_address,user_selphone,user_phone,user_zip,user_email,xm_name,xm_produce,xm_file,time,xm_id,xm_pass) values('".$_POST["user_name"]."','".$_POST["user_address"]."','".$_POST["user_selphone"]."','".$_POST["user_phone"]."','".$_POST["user_zip"]."','".$_POST["user_email"]."','".$_POST["xm_name"]."','".$_POST["xm_produce"]."','".$_POST["file_name"]."',now(),'".$_POST["id"]."',1)";
	 $mysqldao->insertRec($accessory_add);
		GoToPage("work_consent.php?id=".$id,"提交成功，请等待工作人员审核！");
	}	
}

?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="13" align="left" bgcolor="#EFEFEF" background="images/m_13.gif"></td>
        </tr>
        <tr> 
          <td height="24" align="right" class="gray12"> 
            <table cellspacing=3 cellpadding=6 width="100%" align=center 
border=0>
              <tbody> 
              <tr valign=top bgcolor="#F1EEED"> 
                <td valign=center align=middle 
                width="20%" bgcolor=#F1EEED><b><img src="images/icon04.gif" width="18" height="12">网上申报</b></td>
                <td valign=top align=left width="80%"><font color=red>(*)</font>为必填选项</td>
              </tr>
              <tr valign=top bgcolor="#F1EEED"> 
                <td style="LINE-HEIGHT: 1.5" valign=center align=middle colspan="2" bgcolor=#F1EEED>
                  <table id=Table6 cellspacing=1 cellpadding=2 width="100%" 
                  bgcolor=#DBDBDB border=0>
                    <tbody> 
<form name=reg_form onsubmit="return check();" action="work_consent.php" method=post enctype=multipart/form-data>

                    <tr bgcolor=#ffffff> 
                      <td align=right width="161">姓名：</td>
                      <td style="WIDTH: 147px" width="172" align="left"> 
                        <input class=input id=txtAuthor style="WIDTH: 120px" name=user_name><font color=red>(*)</font> </td>
                      <td width="132" align=right>联系地址：</td>
                      <td width="296" align="left"><font color=red> 
                        <input class=input id=txtAddress name=user_address>
                        </font></td>
                    </tr>
                    <tr bgcolor=#ffffff> 
                      <td align=right>手机：</td>
                      <td style="WIDTH: 147px"  align="left"> 
                        <input class=input id=txtphone name=user_selphone>
                      </td>
                      <td align=right>联系电话：</td>
                      <td height=30  align="left"> 
                        <input class=input id=txttel name=user_phone>
                        <font color=red>(*)</font></td>
                    </tr>
                    <tr bgcolor=#ffffff> 
                      <td align=right>邮编：</td>
                      <td style="WIDTH: 147px" align="left"> 
                        <input class=input id=txtpostcard name=user_zip>
                      </td>
                      <td align=right>Email：</td>
                      <td align="left"> 
                        <input class=input id=txtEmail name=user_email>
                      </td>
                    </tr>
                    <tr bgcolor=#ffffff> 
                      <td align=right>项目名称：</td>
                      <td align=left colspan=3> <font color=red> 
                        <input class=input id=txtpostcard name=xm_name>
                        (*)</font></td>
                    </tr>
                    <tr bgcolor=#ffffff> 
                      <td align=right>项目简介：</td>
                      <td colspan=3 align="left"> 
                        <textarea class=formcss id=txtcontent style="WIDTH: 85%" name=xm_produce rows=8></textarea><font color=red>(*)</font>
                      </td>
                      </tr>
<!--                    
                    <tr bgcolor=#ffffff> 
                      <td align=right>项目附件：<font color=red>&nbsp;</font></td>
                      <td colspan=3 align="left">
						<INPUT name="srcfile" type=file>
						<input type="hidden" name="UploadAction" value=1><font color=red>只能上传doc/rar类型文件</FONT>
                       
                      </td>
                    </tr> -->
					 <tr bgcolor=#ffffff> 
                      <td align=right>随机码：<font color=red>&nbsp;</font></td>
                      <td colspan=3 align="left"><input 
                  class="input" maxlength=4 size=7 name=u_sjm>&nbsp;&nbsp;<img src="util/gd_admin.php" border="0" align="absmiddle" width="35" height="19" style="vertical-align:middle"></td>
                    </tr>
                    <tr bgcolor=#ffffff> 
                     
                      <td colspan=4 align="center"> 
                     
						<input type="hidden" name="op" value="ok">
						<input type="hidden" name="id" value="<?=$id?>">

                       <input type="submit" class="btn2"   value="提 交">
                      </td>
                    </tr>
					</form>
                   
                  </table>
                </td>
              </tr>
              </tbody> 
            </table>
          </td>
        </tr>
      </table>