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
                width="20%" bgcolor=#F1EEED><b><img src="images/icon04.gif" width="18" height="12">常见问题</b></td>
               <!--  <td valign=top align=left width="80%" class="red12"><b><a href="#" class="red12">问题咨询</a></b></td> -->
              </tr>
              <tr valign=top bgcolor="#F1EEED"> 
                <td style="LINE-HEIGHT: 1.5" valign=center align=middle colspan="2" bgcolor=#F1EEED>
                  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#DBDBDB">

				  <?
							//网上答疑
							$findAllRec="select question_id,question_time,question_content from question where  consent_id='%%s' and  question_state='%%s' order by question_time DESC limit 0,10";	
							
							$args = array($id,2);
							$rst = $mysqldao->findAllRec($findAllRec,$args);							
						
							//答疑循环开始*****************************
							for($i=0;$i<count($rst);$i++){
								
								$question_content=cutstr($rst[$i]["question_content"],56,1);
								$dy_id=$rs[$i]["id"];
								if($question_content==""){
										$question_content=cutstr($rst[$i]["question_content"],56,1);
								}				
						?>

						  
                    <tr bgcolor="#FFFFFF"> 
                      <td height="24" align="left"><img src="images/icon02.gif" width="21" height="11" align="absmiddle"><?  echo "<a href=question.php?id=".$rst[$i]["question_id"]." target='_blank' title='".$rst[$i]["question_content"]."' class=black12>".$question_content?></td>
                       <td align="center" class="gray12" width="120">[<?=cutstr($rst[$i]["question_time"],5,0)?>]</td> 
                    </tr>
					<? } ?>
                    
                  </table>
                </td>
              </tr>
              </tbody> 
            </table>
          </td>
        </tr>
      </table>