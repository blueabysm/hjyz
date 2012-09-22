<div id="top">
<?php 
showZybjlmById($mysqldao,1);
?>
</div>
<?php 
if(showmenuId($mysqldao,34)==false){showZybjlmById($mysqldao,216);}
?>
<div class="notice">
  <div class="notice_l f_l" style="position: relative"><img src="images/menu_bg3.gif" width="124" height="19" align="absmiddle" />
  
     <marquee   scrollamount="2" scrolldelay="6" direction="left" onmousemove="this.stop()" onmouseout="this.start()" style="width: 500px;position: absolute;top: 8px">
        <?php showWzlmByIDNoDate($mysqldao,40,'red',5,0); ?>
     </marquee>
  </div>
  
  <div class="search f_r" style="position: relative">站内搜索：
  <form id="form1" name="form1" method="post" action="search_post.php" style="top: 5px;left:60px;position: absolute;" target='_top'>
  
  <label><input name="keyword" type="text" class="input" id="keyword" style="width:200px;" /></label>
  <label>
  <input type="submit" name="button1" id="button1" value="搜索" class="btn" />
  </label>
  </form>
  </div>
</div>