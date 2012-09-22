<script>
<!--
function xSearch_check(){

	if(document.sel_from.time.value==""){
		window.alert("请选择受理年度！");
		document.sel_from.time.focus();
		return false;
	}

	if(document.sel_from.xm_name.value=="" ){
		window.alert("请选择项目名称！");
		document.sel_from.xm_name.focus();
		return false;
	}

	if(document.sel_from.APPMANNAME.value=="" || document.sel_from.APPMANNAME.value.length<4 || document.sel_from.APPMANNAME.value.length>22){
		window.alert("您填写的申请人名称不符合规范！");
		document.sel_from.APPMANNAME.focus();
		return false;
	}
	
}
//-->
</script>


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
                width="20%" bgcolor=#F1EEED><b><img src="images/icon04.gif" width="18" height="12">结果查询</b></td>
                <td valign=top align=left width="80%"> 
                  <table cellspacing=0 cellpadding=0 width=500 align=left 
                  border=0>
                    <tbody> 
                    <tr> 
                      <td height=25><span 
                        class=grayred><strong>请准确填写受理年度、项目名称以及姓名进行查询</strong></span></td>
                    </tr>
                    <tr> 
                      <td align=left height=25> 
                        <form action="work_consent.php<?php //content_xk.php 有误？?>" method=post onsubmit="return xSearch_check();" name="sel_from">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
						
							<? $year = date("Y");?>
                          <tr> 
                            <td height="25">年　　度： </td>
                            <td height="25"> 
                              <select name="time" class="input">
                             
								<option selected value="">请选择</option>
                                <? for($i=5;$i>0;$i--){?>
								<option value="<?=$year-$i?>"><?=$year-$i?></option>
								<? }?>
							  </select>
                            </td>
                            <td height="50" rowspan="2" align="center" width="60"><input type="image" border="0" name="imageField" src="images/an_cx.gif" align="left" width="49" height="41"></td>
                          </tr>
                          <tr> 
                            <td height="25">项目名称：</td>
                            <td height="25"> 
                              <input type="text" name="xm_name" class="input">
                            </td>
                          </tr>
						   <tr> 
                            <td height="25">姓名： </td>
                            <td height="25"> 
                              <input type="text" name="user_name" class="input">
                            </td>
                          </tr>
						  <input type="hidden" name="id" value="<?=$id?>">
						  <input type="hidden" name="search" value="ok">
						 

                        </table>
                         </form>
                      </td>
                    </tr>
                    </tbody> 
                  </table>
                
            </td>
              </tr>
              <tr valign=top bgcolor="#F1EEED"> 
                <td style="LINE-HEIGHT: 1.5" valign=center align=middle colspan="2" bgcolor=#F1EEED> 
                  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#DBDBDB">
                <tr align="center" bgcolor="#E6E6E6"> 
                  <td height="24" width="350">项目名称</td>
                  <td width="80">姓名</td>
                  <td width="80" align="center">申报时间</td>
                  <td width="80" align="center">办结时间</td>
                  <td width="100" align="center">规定办理时限差额</td>
                </tr>
                <? if ($search=="ok"){
	$Temp_search=$mysqldao->findAllRec("select xm_name,user_name,time,APPMANDATE,FINISHDATE from apply where xm_pass1=1 and user_name='$user_name' and xm_name like '%%$xm_name%%'  and time like '%%$time%%'");

for  ($i=0;$i<count($Temp_search);$i++){
	
	$Date_1=$Temp_search[$i]["FINISHDATE"];
	$Date_2=$Temp_search[$i]["APPMANDATE"];
	if (($Date_1<>'')&&($Date_2<>'')){
	$Date_List_1=explode("-",$Date_1);
	$Date_List_2=explode("-",$Date_2);
	$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
	$d2=mktime(0,0,0,$Date_List_2[1],$Date_List_2[2],$Date_List_2[0]);
	$Days=round(($d1-$d2)/3600/24);}
	
	?>
                <tr bgcolor="#FFFFFF"> 
                  <td height="24"> 
                    <?=$Temp_search[$i]["xm_name"];?>
                  </td>
                  <td> 
                    <?=$Temp_search[$i]["user_name"];?>
                  </td>
                  <td align="center" class="black12"> 
                   <?=substr($Temp_search[$i]["time"],0,10);?></td>
                  <td align="center" class="gray12"><?=$Temp_search[$i]["FINISHDATE"];?></td>
                  <td align="center" class="gray12">&nbsp;<?echo 20-$Days;?>天</td>
                </tr>
                <?}}?>
              </table>
                </td>
              </tr>
              </tbody> 
            </table>
          </td>
        </tr>
      </table>