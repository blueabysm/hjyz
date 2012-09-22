<div class="contentLeft">
    	<?php showZtlmSmallImageToFirstPage($mysqldao,3);?>
	    <?php showTphdp($mysqldao,20,5); ?> 
        <div class="l_xinxi">
        	<div class="l_xinxibiaoti"><h2><?=$colmnusNames[24]?></h2></div>
        	<script> var partSlider = {name:'partSlider',index:0,time:0,time_h:0,activeCssClass:'box4 current2',cssClass:'box4',list:[{id:'s_part1',cid:'s_part1_c',url:''},{id:'s_part2',cid:'s_part2_c',url:''},{id:'s_part3',cid:'s_part3_c',url:''},{id:'s_part4',cid:'s_part4_c',url:''}]}; </script>
            <div class="l_xinxiList">
            	<div id="s_part1" class="box4" onclick="sliderOnMouseOver(partSlider,0)"><a><?=$colmnusNames[41]?></a></div>
                <div class="box5" id="s_part1_c" style="display: none;">                    
                    <?php showHeadListById($mysqldao,324,'text_list3','more4',0); ?>
                </div>
                <div id="s_part2" class="box4 current2" onclick="sliderOnMouseOver(partSlider,1)"><a><?=$colmnusNames[42]?></a></div>
                <div class="box5" id="s_part2_c">	             
	              <?php showPartListById($mysqldao,324,'text_list3','more4'); ?>	              
                </div>
                <div id="s_part3" class="box4" onclick="sliderOnMouseOver(partSlider,2)"><a><?=$colmnusNames[192]?></a></div>
                <div class="box5" id="s_part3_c"  style="display: none;">
	                <?php showWzlmByID($mysqldao,192,'text_list3','','',0,22); ?>	               
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