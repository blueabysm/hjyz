<script>
<!--
function zSearch_check(){

	if(document.search_from.user_name.value=="" || document.search_from.user_name.value.length<2 || document.search_from.user_name.value.length>8){
		window.alert("请您填写正确的申请人名称！");
		document.search_from.user_name.focus();
		return false;
	}

	if(document.search_from.xm_name.value=="" || document.search_from.xm_name.value.length<2 || document.search_from.xm_name.value.length>22){
		window.alert("请您填写正确的项目名称！");
		document.search_from.xm_name.focus();
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
                width="20%" bgcolor=#F1EEED><b><img src="images/icon04.gif" width="18" height="12">状态查询</b></td>
                <td valign=top align=left width="80%"> 
                  <table cellspacing=0 cellpadding=0 width=500 align=left 
                  border=0>
                    <tbody> 
                    <tr> 
                      
                    <td height=25><span 
                        class=grayred>请准确填写姓名、项目名称进行查询</span></td>
                    </tr>
                    <tr> 
                      <td align=left height=25> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <form action="work_consent.php" method=post onsubmit="return zSearch_check();" name="search_from">
                          <tr> 
                            <td width="97" height="25">姓名：</td>
                            <td width="250" height="25"> <input type="text" name="user_name" class="input"> 
                            </td>
                            <td width="53" rowspan="2"><input type="image" border="0" name="imageField" src="images/an_cx.gif" align="left" width="49" height="41"></td>
                          </tr>
                          <tr> 
                            <td height="25">项目名称：</td>
                            <td height="25"> <input type="text" name="xm_name" class="input"> 
                            </td>
                          </tr>
                          <input type="hidden" name="id" value="<?=$id?>">
                          <input type="hidden" name="search_zt" value="ok">
                        </form>
                      </table>
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
                  <td height="24" width="250">项目名称</td>
                  <td width="70">姓名</td>
                  <td width="70" align="center">申报时间</td>
                  <td width="70" align="center">剩余时间</td>
                  <td width="60" align="center">当前状态</td>
                  <td width="70" align="center">已进流程<BR>所处环节</td>
                  <td width="70" align="center">转入时间</td>
                  <td width="100" align="center">转入源</td>
                </tr>
                <? if ($search_zt=="ok"){

	$ztTemp_search=$mysqldao->findAllRec("select xm_name,user_name,time,xm_pass,xm_pass1,APPMANDATE,FINISHDATE from apply where user_name='$user_name' and xm_name like '%%$xm_name%%'");

for  ($j=0;$j<count($ztTemp_search);$j++){
	$zt_Date_1=date("Y-m-d");
	$zt_Date_2=$ztTemp_search[$j]["time"];
	if (($Date_1<>'')&&($Date_2<>'')){
	$zt_Date_List_1=explode("-",$zt_Date_1);
	$zt_Date_List_2=explode("-",$zt_Date_2);
	$zt_d1=mktime(0,0,0,$zt_Date_List_1[1],$zt_Date_List_1[2],$zt_Date_List_1[0]);
	$zt_d2=mktime(0,0,0,$zt_Date_List_2[1],$zt_Date_List_2[2],$zt_Date_List_2[0]);
	$zt_Days=round(($zt_d1-$zt_d2)/3600/24);
	}
	?>
                <tr bgcolor="#FFFFFF"> 
                  <td height="24">&nbsp;<?=$ztTemp_search[$j]["xm_name"];?>
                  </td>
                  <td  align="center">&nbsp;<?=$ztTemp_search[$j]["user_name"];?>
                  </td>
                  <td align="center" class="black12"> 
                    <?=substr($ztTemp_search[$j]["time"],0,10);?>
                  </td>
                  <td align="center" class="gray12"><?if ($ztTemp_search[$j]["xm_pass"]==1){echo 20-$zt_Days."天";}?></td>
                  <td align="center" class="gray12">
				  <?
					if ($ztTemp_search[$j]["xm_pass"]==0){echo "待受理";}
					if (($ztTemp_search[$j]["xm_pass"]==1)&&($ztTemp_search[$j]["xm_pass1"]==0)){echo "办理中";}
					if ($ztTemp_search[$j]["xm_pass1"]==1){echo "已办结";}?>
				</td>
                  <td align="center" class="gray12">
				 <?
					if ($ztTemp_search[$j]["xm_pass"]==0){echo "待受理";}
					if (($ztTemp_search[$j]["xm_pass"]==1)&&($ztTemp_search[$j]["xm_pass1"]==0)){echo "办理中";}
					if ($ztTemp_search[$j]["xm_pass1"]==1){echo "已办结";}?>
				</td>
                  <td align="center" class="gray12"> 
                    <?=$ztTemp_search[$j]["APPMANDATE"];?>
                  </td>
				 
                  <td align="center" class="gray12">&nbsp;<?if (($id<5118)&&($id>5111)){echo "发展规划处";}
					if ($id==5118){echo "教师管理处";}
					if (($id<5124)&&($id>5118)){echo "对外合作与交流处";}?></td>
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