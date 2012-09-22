<?
session_start();
include_once("database/mysqlDAO.php");

$sQueryWhere = " where 1=1";
if($_POST["key"]){
	$sQueryWhere .= " and mail_title like '%".$_POST["key"]."%'";
}
if($_POST["write_time"]){
	$sQueryWhere .= " and left(write_time,10)='".$_POST["write_time"]."'";
}
$sQueryWhere .= " and mail_open=1 and mail_open1=1 and back_type=2  order by back_time desc";	
$sQuery = "select * from mail";
$findAllRec = "select * from mail where mail_open=1 and mail_open1=1 and back_type=2  order by back_time desc ";

$sQueryCount="select count(mail_id) from mail ";
$sRsVarName="rstMail";
include ("util/cut_page.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
<script src="js/function.js"></script>
<script src="js/setday.js"></script>
<script type="text/javascript">
function doReset() {
     document.getElementById("mail_vocation").value='';
     document.getElementById("mail_age").value='';
     document.getElementById("mail_email").value='';
     document.getElementById("mail_phone").value='';
	 document.getElementById("mail_name").value='';
	 document.getElementById("mail_address").value='';
	 
     document.getElementById("mail_type").value='';
     document.getElementById("mail_content").value='';
     document.getElementById("mail_title").value='';
     document.getElementById("mail_field").value='';
     document.getElementById("mail_area").value='';
               
               
     document.getElementById("validate").value='';  
     document.getElementById("mail_open").checked='false';
}

function check(){
	var me=document.mailboxForm;
	
	if(IsSelected(me.mail_type,"","请选择信件类型！")) return false;
	if(IsSelected(me.mail_field,"","请选择涉及领域！")) return false;

	if(IsEmpty(me.mail_title,"请填写主题！")) return false;
	if(IsEmpty(me.mail_content,"请填写类容！")) return false;
	if(IsEmpty(me.validate,"请填写验证码！")) return false;
	if(IsEmpty(me.mail_phone,"请填写电话！")) return false;
	if(IsEmpty(me.mail_email,"请填写邮箱！")) return false;
	if(IsEmpty(me.mail_address,"请填写地址！")) return false;
	
	return confirm("您确定要提交吗？");
}
function check1(){
	var me=document.findAllRec_form;

	if(IsEmpty(me.findAllRec_code,"请填写查询码！")) return false;

}
</script>
</head>
<body>
  <div class="messsage"> <span> 我的信件办理情况查询： </span> </div>
  <div>
  <form method="post" action="mail_back.php"   name="findAllRec_form" onsubmit="return check1();">
  <td  bgcolor="#F2F2F2">
    查询码:<input type="text" name="query_code" class="input"/> &nbsp;验证码:<input type="text" name="validate" size="4" class="input"/>
                             <img src="util/gd_admin.php" border="0" align="absmiddle" width="35" height="19"> <input class="btn2" type="submit" name="submit" value="提交" />
   
  </td>
  </form>
  </div>

  <div class="messsage"> <span> 提交诉求 </span> </div>
<form method="post" action="mailbox_post.php"  name="mailboxForm" onsubmit="return check();">
<table width="100%" border="0">
 
  <tr>
    <td width="155"><span class="style6">信件类型：</span></td>
    <td width="974"><select   style=width:130  name="mail_type" id="mail_type" setfocusonerror="True">
      <option value=""></option>
      <option value="1" >建议</option>
      <option value="2" >求助</option>
      <option value="5" >咨询</option>
      <option value="3" >投诉</option>
      <option value="4" >批评</option>
      <option value="6" >其他</option>
    </select>      &nbsp;<FONT color=red>*</FONT></span>
	</td>
  </tr>
  
  <tr>
    <td><span class="style6">涉及领域：</span></td>
    <td>
      <select   style=width:130 name="mail_field" id="mail_field" setfocusonerror="True">
        <option value=""></option>
        <option value="水电气">水电气</option>
        <option value="教育">教育</option>
        <option value="社会治安"  >社会治安</option>
        <option value="环保"  >环保</option>
        <option value="民政"  >民政</option>
        <option value="三农"  >三农</option>
        <option value="移民"  >移民</option>
        <option value="交通"  >交通</option>
        <option value="市政"  >市政</option>
        <option value="征地、拆迁、物管"  >征地、拆迁、物管</option>
        <option value="劳资纠纷、社保、就业"  >劳资纠纷、社保、就业</option>
        <option value="安全生产"  >安全生产</option>
        <option value="卫生医疗"  >卫生医疗</option>
        <option value="人事"  >人事</option>
        <option value="通信"  >通信</option>
        <option value="城建"  >城建</option>
        <option value="物价"  >物价</option>
        <option value="质量监察"  >质量监察</option>
        <option value="工商"  >工商</option>
        <option value="税务"  >税务</option>
        <option value="其他"  >其他</option>
      </select>
&nbsp;<FONT color=red>*</FONT></td>
  </tr>
  
  <tr>
    <td><span class="style6">公开意愿：</span></td>
    <td>
      <input type="Radio" name="mail_open" id="appealOpen" value="1" checked="checked" class="input">
      <span class="f7">是</span>
      <input type="Radio" name="mail_open" id="appealOpen" value="2" class="input">
  		<span class="style7">否</span>&nbsp;<font color=red>*</font></td>
  </tr>
  
  <tr>
    <td><span class="style6">主题：</span></td>
    <td><input type="text"   name="mail_title" id="mail_title" size=20  setfocusonerror="True" value="" class="input">
    <FONT color=red>*</FONT></td>
  </tr>
  
  <tr>
    <td><span class="style6">内容：</span></td>
    <td><textarea class="inputTextArea" type="textarea"  name="mail_content" id="mail_content"  rows=8 cols=30/> </textarea>
	</td>
  </tr>
    
 <tr  bgcolor="#F2F2F2">
    <td><span class="style6">验证码：</span></td>
    <td>
      <INPUT type="text" maxLength=4 size=4  name="validate" id="validate" class="input"/>
&nbsp; <img src="util/gd_admin.php" border="0" align="absmiddle" width="35" height="19" style="vertical-align:middle"> &nbsp; <FONT color=red>*</FONT></td>
  </tr>
</table>

<table width="100%" border="0">
  <tr  bgcolor="#F2F2F2">
    <td width="33%"><span class="f7">姓名 <input  
                        size=8 name="mail_name" id="mail_name" value=""
                      setfocusonerror="True" class="input"/></span></td>
    <td width="29%"><SPAN class=f7>性别
                                              <SELECT  id=mail_sex 
                        name=mail_sex setfocusonerror="True">
                                                          <OPTION value=1 >男</OPTION>
                                                          <OPTION value=2 >女</OPTION>
                                                    </SELECT>
                                                    </SPAN></td>
    <td width="38%"><SPAN class=f7>电话</SPAN> 
                                               <INPUT 
                        size=10 name="mail_phone" id="mail_phone" value=""
                        setfocusonerror="True" class="input">
                                                      <FONT 
                        color=red>*</FONT></td>
  </tr >
  <tr  bgcolor="#F2F2F2">
    <td><SPAN class=f7>职业
                                         <INPUT  
                        size=8 name="mail_vocation" id="mail_vocation" value=""
                      setfocusonerror="True" class="input">
    </SPAN></td>
    <td><SPAN class=f7>年龄</SPAN>
    <INPUT   
                        size=4 setfocusonerror="True"  name="mail_age" id="mail_age"  maxlength="3"  value="" class="input"></td>
    <td><SPAN class=f7>邮箱
                                                      <INPUT  
                        size=10 name="mail_email" id="mail_email" value=""
setfocusonerror="True" class="input">
                                                    </SPAN><FONT 
                        color=red>*</FONT></td>
  </tr>
  <tr  bgcolor="#F2F2F2">
    <td colspan="3"><SPAN class=f7>地址</SPAN>
                                                      <input  
                        size=30 name="mail_address" id="mail_address" value="" class="input">
                                                      <FONT 
                        color=red>*</FONT></DIV></td>
    
  </tr>
  <tr>
    <td colspan="3" align="center"> <input type="submit"  class="btn2" value="提交" name="submit">&nbsp;<input onclick=javascript:doReset(); type=button  class="btn2" value=重写 name=button></td>

  </tr>
</table>                                  

</form>                       

                        
                      
                      
  <div class="messsage"> <span> 选登信件 </span> </div>            
                          
<TABLE id=DataGrid1 style="BORDER-COLLAPSE: collapse" 
                  cellSpacing=2 rules=all width="97%" align=center border=0>
<TBODY>
                                  
                                    <TR >
                                      <TD  width="60%" height="22" 
                      style="FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000; FONT-STYLE: normal; TEXT-DECORATION: none">                                    <div align="left">
                                          <? for($i=0;$i<count($rstMail);$i++){
                        	if ( ($i % 2) == 0){
								$tmpstr = "";
							} else {							
								$tmpstr = " style='background: #F3EFE6;' ";
							}	
							
							
						?>
                                          <table width="97%"  border="0" align="center" class='TableTd' <?=$tmpstr?>>
                                          <tr>
                                              <td width="9%" height="22"><div align="center" class="style4">来信</div></td>
                                              <td width="91%" height="22"><a target="_blank" href="mail_back.php?id=<?=$rstMail[$i]["mail_id"]?>"><?=$rstMail[$i]["mail_title"]?></a><span class="style5">（<?=$rstMail[$i]["write_time"]?>）</span> </td>
                                        </tr>
                                            <tr>
                                              <td height="22" valign="top"><div align="center" class="style4">回复</div></td>
                                              <td height="22" class="f7 style5">
                                    
                                    
                                    
                                           <span style="color:#7B847E"><span class="f7"><?=cutstr($rstMail[$i]["back_content"],100,0)?>
 ...<a target="_blank" href="mail_back.php?id=<?=$rstMail[$i]["mail_id"]?>">  >>></a></span> (<?=$rstMail[$i]["back_time"]?>)</span></td>
                                          </tr>
                                        </table>
                                          
                         <? }?>                 
                                                    

 <br>
                                          <span class="f7">
                                      </span></div></TD>
                                    </TR>
                                    
                </TBODY>
              </TABLE>
                   
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr width="100%" align="right" > 
			<td colspan="50" class="FormLabel">
				<?
				$cs="&".$sCutPage;
				$span_class="blue12";
				$link_class="blue12";
				include ("util/fenye_css.php");
				?>
			</td>
	  </tr>
  </table>
</body>
</html>
  

 


