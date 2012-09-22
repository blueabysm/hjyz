<?php include("database/mysqlDAO.php")?>
<?php include("functions.php")?>
<?php
 //取所有栏目名称
 $list=getAllColumnsName($mysqldao);
 $colmnusNames = CreateArrayFromDBList($list,'columns_id','columns_title'); 
 $sub_id = CreateArrayFromDBList($list,'columns_id','sub_id'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
</head>
<body>
<!-- 页头开始  -->
<?php include('top.php') ?>
<!-- 页头结束  -->

<!-- 中部开始  -->

<div class="content"> 

	<div class="contentLeft">
	    <?php showZtlmSmallImageToFirstPage($mysqldao,195);?>
	    <?php showTphdp($mysqldao,201,5); ?> 
    </div>
    
    <div class="box1">

        <?php showZtlmToFirstPage($mysqldao,70,5);?>
        <div class="contentCenter">
          <script> var newSlider = {name:'newSlider',index:0,time:0,time_h:0,activeCssClass:'on',cssClass:'noton',list:[{id:'s_whxw',cid:'s_whxw_c',url:'article_more.php?id=13'},{id:'s_jyxw',cid:'s_jyxw_c',url:'article_more.php?id=14'},{id:'s_xxxw',cid:'s_xxxw_c',url:'article_more.php?id=15'},{id:'s_jdzt',cid:'s_jdzt_c',url:'toptic.php?id=195'}]}; </script>
          <div class="xinxi">
            <div class="xinxibiaoti">
                <ul>
                    <li id="s_whxw" class="on" onmouseover="sliderOnMouseOver(newSlider,0)"><?=$colmnusNames[13]?></li>
                    <li id="s_jyxw" class="noton" onmouseover="sliderOnMouseOver(newSlider,1)"><?=$colmnusNames[14]?></li>
                    <li id="s_xxxw" class="noton" onmouseover="sliderOnMouseOver(newSlider,2)"><?=$colmnusNames[15]?></li>
                    <li id="s_jdzt" class="noton" onmouseover="sliderOnMouseOver(newSlider,3)"><?=$colmnusNames[195]?></li>
                </ul>
                <span class="more">>> <a href="javascript:void(0)" onclick="sliderMoreClick(newSlider)">更多</a></span>
            </div>
            <div class="xinxiList">
                <?php showWzlmByID($mysqldao,13,'text_list','id="s_whxw_c"','y-m-d',10,38); ?>
                <?php showWzlmByID($mysqldao,14,'text_list','id="s_jyxw_c" style="display: none;"','y-m-d',10,38); ?>
                <?php showWzlmByID($mysqldao,15,'text_list','id="s_xxxw_c" style="display: none;"','y-m-d',10,38); ?>
                <?php showZtlmListById($mysqldao,195,'class="text_list" id="s_jdzt_c" style="display: none;"',10,45); ?>
            </div> 
            <div class="xinxiline"></div> 
          </div>
        </div>
        
    	<div class="contentRight">
        	<div class="r_xinxi">
            	<div class="r_xinxibiaoti">
                  <span class="more2">>> <a href="article_more.php?id=21">更多</a></span>
                  <h2><?=$colmnusNames[21]?></h2>
                </div>
                <div class="r_xinxiList">
                    <?php showWzlmByID($mysqldao,21,'text_list2 f_l','','',10,22); ?>                	
                </div>
                <div class="r_xinxiline"></div>
            </div>
      </div>
    </div>
</div>
<div class="banner"><?php showZybjlmById($mysqldao,22); ?></div>
<div class="content">
	<div class="contentLeft">
    	<div class="l_xinxi">
        	<div class="l_xinxibiaoti"><h2><?=$colmnusNames[24]?></h2></div>
        	<script> var partSlider = {name:'partSlider',index:0,time:0,time_h:0,activeCssClass:'box4 current2',cssClass:'box4',list:[{id:'s_part1',cid:'s_part1_c',url:''},{id:'s_part2',cid:'s_part2_c',url:''},{id:'s_part3',cid:'s_part3_c',url:''},{id:'s_part4',cid:'s_part4_c',url:''}]}; </script>
            <div class="l_xinxiList">
            	<div id="s_part1" class="box4" onclick="sliderOnMouseOver(partSlider,0)"><a><?=$colmnusNames[41]?></a></div>
                <div class="box5" id="s_part1_c" style="display: none;">                    
                    <?php showHeadListById($mysqldao,326,'text_list3','more4',0); ?>
                </div>
                <div id="s_part2" class="box4 current2" onclick="sliderOnMouseOver(partSlider,1)"><a><?=$colmnusNames[42]?></a></div>
                <div class="box5" id="s_part2_c">	             
	              <?php showPartListById($mysqldao,326,'text_list3','more4'); ?>	              
                </div>
                <div id="s_part3" class="box4" onclick="sliderOnMouseOver(partSlider,2)"><a><?=$colmnusNames[208]?></a></div>
                <div class="box5" id="s_part3_c"  style="display: none;">
	                <?php showWzlmByID($mysqldao,208,'text_list3','','',0,22); ?>	               
                </div>
                <div id="s_part4" class="box4" onclick="sliderOnMouseOver(partSlider,3)"><a><?=$colmnusNames[193]?></a></div>
                <div class="box5" id="s_part4_c" style="display: none;">
					 <?php showWzlmByID($mysqldao,193,'text_list3','','',0,22); ?>
                </div>
            </div>
            <div class="l_xinxiline"></div>
        </div>
        <div class="clean"></div>
        <div class="l_xinxi">
        	<div class="l_xinxibiaoti">
                <h2><?=$colmnusNames[25]?></h2>
            </div>
            <div class="l_xinxiList">
            	<div class="tongji">
                   <h3><?=$colmnusNames[26]?></h3>
                   <?php showFwlph($mysqldao,'text_list4',4,26); ?>
                </div>
                <div class="tongji">
                   <h3><?=$colmnusNames[27]?></h3>
                   <?php showXxlph($mysqldao,'text_list4',4,10); ?>
                </div>
            </div>
            <div class="l_xinxiline"></div>
        </div>
    </div>
	<div class="box1">
    	<div class="contentCenter">
          <div class="xinxi">
			 <script> var zcSlider = {name:'zcSlider',index:0,time:0,time_h:0,activeCssClass:'on',cssClass:'noton',list:[{id:'s_jyyw',cid:'s_jyyw_c',url:'article_more.php?id=16'},{id:'s_zxzc',cid:'s_zxzc_c',url:'article_more.php?id=18'}]}; </script>          
            <div class="xinxibiaoti">
                <ul>
                    <li class="on" id="s_jyyw" onmouseover="sliderOnMouseOver(zcSlider,0)"><?=$colmnusNames[16]?></li>
                    <li class="noton" id="s_zxzc" onmouseover="sliderOnMouseOver(zcSlider,1)"><?=$colmnusNames[18]?></li>
                </ul>
                <span class="more">>> <a href="javascript:void(0)" onclick="sliderMoreClick(zcSlider)">更多</a></span>
            </div>
            <div class="xinxiList">
                <?php showWzlmByID($mysqldao,16,'text_list','id="s_jyyw_c"','y-m-d',10,38); ?>
                <?php showWzlmByID($mysqldao,18,'text_list','id="s_zxzc_c" style="display: none;"','y-m-d',10,38); ?>               
            </div> 
            <div class="xinxiline"></div> 
          </div>
        </div>
		<div class="contentRight">
        	<div class="r_xinxi">
            	<div class="r_xinxibiaoti">
                  <h2><?=$colmnusNames[23]?></h2>
                </div>
                <div class="r_xinxiList">                	
                     <?php showxxgk($colmnusNames,$sub_id[5]); ?>
                </div>
                <div class="r_xinxiline"></div>
            </div>
        </div>
    </div>
    <div class="school">
    <script> var schoolSlider = {name:'schoolSlider',index:0,time:0,time_h:0,activeCssClass:'schoolon',cssClass:'schoolnoton',list:[{id:'s_yly',cid:'s_yly_c',url:''},{id:'s_xx',cid:'s_xx_c',url:''},{id:'s_cz',cid:'s_cz_c',url:''},{id:'s_gz',cid:'s_gz_c',url:''},{id:'s_zj',cid:'s_zj_c',url:''},{id:'s_tj',cid:'s_tj_c',url:''}]}; </script>          
         
      <div class="schoolbiaoti">
            <ul>
              <li id="s_yly" class="schoolon" onmouseover="sliderOnMouseOver(schoolSlider,0)">学生风采</li>
              <li id="s_xx" class="schoolnoton" onmouseover="sliderOnMouseOver(schoolSlider,1)">学校风光</li>
              <li id="s_cz" class="schoolnoton" onmouseover="sliderOnMouseOver(schoolSlider,2)">教师风采</li>
              <li id="s_gz" class="schoolnoton" onmouseover="sliderOnMouseOver(schoolSlider,3)">高 中</li>
              <li id="s_zj" class="schoolnoton" onmouseover="sliderOnMouseOver(schoolSlider,4)">职 教</li>
              <li id="s_tj" class="schoolnoton" onmouseover="sliderOnMouseOver(schoolSlider,5)">特 教</li>
            </ul>
      </div>
        <div class="schoollist">
		 <div id="s_yly_c"><?php showTpbglmById($mysqldao,188,'style="float:left;width:680px;overflow:hidden;margin-top:20px"',''); ?></div>
		 <div id="s_xx_c" style="display: none;"><?php showTpbglmById($mysqldao,223,'style="float:left;width:680px;overflow:hidden;margin-top:20px"',''); ?></div>
		 <div id="s_cz_c" style="display: none;"><?php showTpbglmById($mysqldao,260,'style="float:left;width:680px;overflow:hidden;margin-top:20px"',''); ?></div>
		 <div id="s_gz_c" style="display: none;"><?php showTpbglmById($mysqldao,260,'style="float:left;width:680px;overflow:hidden;margin-top:20px"',''); ?></div>
		 <div id="s_zj_c" style="display: none;"><?php showTpbglmById($mysqldao,107,'style="float:left;width:680px;overflow:hidden;margin-top:20px"',''); ?></div>
		 <div id="s_tj_c" style="display: none;"><?php showTpbglmById($mysqldao,109,'style="float:left;width:680px;overflow:hidden;margin-top:20px"',''); ?></div>
        </div>
        <div class="schoolline"></div>
    </div> 
  <div class="fuwu">
    <h2><?=$colmnusNames[28]?></h2>
      
      <?php showZybjlmById($mysqldao,28); ?> 
    </div> 
</div>
<div class="canyu">
 <?php showZybjlmById($mysqldao,29); ?> 
  
</div>
<div class="content">
	<div class="contentLeft">
    	<div class="l_xinxi">
        	<div class="l_xinxibiaoti">
                <h2><?=$colmnusNames[30]?></h2>
            </div>        	
            <?php showZybjlmById($mysqldao,30); ?>            
            <div class="l_xinxiline"></div>
        </div>
  </div>

    	<div class="contentCenter">
          <div class="xinxi">
			 <script> var qSlider = {name:'qSlider',index:0,time:0,time_h:0,activeCssClass:'on',cssClass:'noton',list:[{id:'s_bszn',cid:'s_bszn_c',url:'article_more.php?id=19'},{id:'s_cjwt',cid:'s_cjwt_c',url:'question_all_index.php'}]}; </script>          
            <div class="xinxibiaoti">
                <ul>
                    <li class="on" id="s_bszn" onmouseover="sliderOnMouseOver(qSlider,0)"><?=$colmnusNames[19]?></li>
                    <li class="noton" id="s_cjwt" onmouseover="sliderOnMouseOver(qSlider,1)"><?=$colmnusNames[35]?></li>
                </ul>
                <span class="more">>> <a href="javascript:void(0)" onclick="sliderMoreClick(qSlider)">更多</a></span>
            </div>
            <div class="xinxiList">
                <?php showWzlmByID($mysqldao,19,'text_list','id="s_bszn_c"','y-m-d',5,45); ?>                
                <?php showQuestion($mysqldao,'class="text_list" id="s_cjwt_c" style="display: none;"',5,45); ?>               
            </div> 
            <div class="xinxiline"></div> 
          </div>
          <div class="gongkai">
            <h2><?=$colmnusNames[31]?></h2>
              <?php showZybjlmById($mysqldao,31); ?>
          </div> 
        </div>
  <div class="contentRight">
        	<div class="r_xinxi">
            	<div class="r_xinxibiaoti">
                  <h2><?=$colmnusNames[32]?></h2>
                </div>
                <div class="r_xinxiList">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="10" align="center"></td>
                      </tr>
                      <tr>
                        <td align="left" style="padding: 5px;">
                            <?php showDclmByID($mysqldao,32,''); ?>
                        </td>
                      </tr>
                      <tr>
                        <td height="5" align="center"></td>
                      </tr>
                    </table>
                </div>
                <div class="r_xinxiline"></div>
            </div>
  </div>
</div>
<!-- 中部结束  -->

<!-- 页尾开始  -->
<?php include('bottom.php') ?>
<!-- 页尾结束  -->
</body>