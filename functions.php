<?php

/**
 * 前台页面数据调取及显示函数库
 * 作者：王雷  wl2010tw@gmail.com
 * 创建日期：2009-9-10
 * 版本:2.0
 * 修改日期:2011-6-01 10:38
 */

/**
 * 以栏目的ID显示信息公开
 * @param $cID 栏目ID
 */
function showxxgk($colmnusNames,$cID)
{
	$arr=explode(",",$cID);
	echo '<table border="0" cellspacing="0" cellpadding="0" width="100%"><tbody>
			<tr>
			<td height="5" colSpan=3></td></tr>';
	for ($i=1;$i<=count($arr);$i++)
	  {
	    $j=$i-1;
		if($i%2==1){
			echo '<tr>
			<td align="middle">
			<table border="0" cellspacing="0" cellpadding="0" width="215">
			<tbody>
			<tr>
			<td width="102">
			<table border="0" cellspacing="1" cellpadding="0" width="102" bgcolor="#e4dac3">
			<tbody>
			<tr>
			<td bgcolor="#ffffff" height="24" align="middle"><img src="/images/icon02.gif" width="14" height="7"><a href="xxgk_more.php?id='.$arr[$j].'">'.$colmnusNames[$arr[$j]].'</a></td></tr></tbody></table></td>
			<td width="11">&nbsp;</td>';
		}else{
			echo '<td>
			<table border="0" cellspacing="1" cellpadding="0" width="102" bgcolor="#e4dac3">
			<tbody>
			<tr>
			<td bgcolor="#ffffff" height="24" align="middle"><img src="/images/icon02.gif" width="14" height="7"><a href="xxgk_more.php?id='.$arr[$j].'">'.$colmnusNames[$arr[$j]].'</a></td></tr></tbody></table></td></tr>
			<tr>
			<td height="2" colSpan=3></td></tr>
			</tbody></table></td></tr>';
		}
        if(count($arr)==$i and $i%2==1){
				echo '</tr>
			<tr>
			<td height="2" colSpan=3></td></tr>
			</tbody></table></td></tr>';
		}
	  }
	echo '</tbody></table>';
}
 
 
/**
 * 以栏目的ID显示栏目的名称
 * @param $mysql 数据库对象
 * @param $cID 栏目ID
 */
function showColumnsNameByID($mysql,$cID)
{
	
	$tmpstr = "select columns_title from columns where columns_id='%%s'";
	$args[]= $cID;
	$baseInfo = $mysql->findOneRec($tmpstr,$args);
	if ($baseInfo == -1) {
		echo "";
		return;
	}
	echo $baseInfo["columns_title"];
}


/**
 * 以栏目的ID显示自由编辑栏目的内容
 * @param $mysql 数据库对象
 * @param $c_id 栏目ID
 */
function showmenuId($mysql,$c_id)
{
	$args[]= $c_id;	
	$tmpstr = "select sub_columns_id,item_title,item_link from columns_link2 where columns_id =%%s ORDER BY item_order";
	$menulist =  $mysql->findAllRec($tmpstr,$args);
	if ( ($menulist == -1) || (count($menulist) <= 0) ) {
		return false;
	}
	for ($i=1;$i<=count($menulist);$i++)
	{
	 if($i%8==1)echo "<div id=menu><ul>";
	 echo "<li OnMouseOver=\"showMenu('sub_".$menulist[$i-1]['sub_columns_id']."',this);\"><a href=\"".$menulist[$i-1]['item_link']."\">".$menulist[$i-1]['item_title']."</a>\n"; 
	 if($i%8==0 or (count($menulist)==$i and $i%8!=0))echo "</li></ul></div>";	 
	}
	$tmpstr = "select columns_id,item_title,item_link from columns_link where columns_id in(select sub_columns_id from columns_link2 where columns_id=%%s) ORDER BY columns_id,item_order";
	$submenulist = $mysql->findAllRec($tmpstr,$args);
	for ($i=0;$i<count($submenulist);$i++)
	{
	  if($i==0){
		$ls=$submenulist[$i]['columns_id'];
		echo "<ul class=subMenu id=sub_".$submenulist[$i]['columns_id']." style=\"display: none\">\n";
	  }
	  if($submenulist[$i]['columns_id']!=$ls){
		$ls=$submenulist[$i]['columns_id'];
	    echo "</li></ul>";
		echo "<ul class=subMenu id=sub_".$submenulist[$i]['columns_id']." style=\"display: none\">\n";
	  }
	  echo "<li onmouseover=delayMenu()><a href=\"".$submenulist[$i]['item_link']."\">".$submenulist[$i]['item_title']."</a>\n"; 
      if(count($submenulist)==$i+1)echo "</li></ul>";	  
	}
	return true;
}

/**
 * 以栏目的ID显示自由编辑栏目的内容
 * @param $mysql 数据库对象
 * @param $c_id 栏目ID
 */
function showZybjlmById($mysql,$c_id)
{

	$tmpstr = "select columns_contents from columns_html where columns_id=$c_id";
	$baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1) {
		echo "";
		return;
	}
	$content = trim($baseInfo["columns_contents"]);
	echo htmlspecialchars_decode($content); 
}

/**
 * 以栏目ID显示文章栏目
 * @param $mysql 数据库对象
 * @param $cID 栏目ID
 * @param $cssClassName css样式类名
 * @param #html <>中的html可包含id style等
 * @param $dateFormat 日期格式字符
 * @param $recCount 要取的文章条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showWzlmByID($mysql,$cID,$cssClassName,$html,$dateFormat,$recCount,$titleCount)
{
	$tmpstr = "select article_id,article_title,article_time,article_order,s_id from article where  article_state=1 and item_id=%%s order by article_order desc,article_time desc";	
	$args[]= $cID;	
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$articleList = $mysql->findAllRec($tmpstr,$args);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		echo "<ul class='$cssClassName' $html><li>暂无新闻</li></ul>\n";
		return;
	}
	echo "<ul class='$cssClassName' $html>\n";
	for($i=0;$i<count($articleList);++$i)
	{		
		echo "<li>";
		if (strlen($dateFormat) > 1)
		{
			$tmpstr = $articleList[$i]["article_time"];
			$tmpstr = date($dateFormat,mktime(0,0,0,substr($tmpstr,5,2),substr($tmpstr,8,2),substr($tmpstr,0,4)));
			echo '<span class="date">'.$tmpstr.'</span>';
		}
		$article_id = $articleList[$i]["s_id"];
		if ($article_id == 0) $article_id = $articleList[$i]["article_id"];
		echo "<a target='_blank' href='article.php?id=" .$article_id."' title='".$articleList[$i]["article_title"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $articleList[$i]["article_title"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $articleList[$i]["article_title"];
		}
		echo "</a>";
		echo "</li>";	
	}
	echo "</ul>\n";
}


/**
 * 以栏目ID显示文章栏目
 * @param $mysql 数据库对象
 * @param $cID 栏目ID
 * @param $cssClassName css样式类名
 * @param #html <>中的html可包含id style等
 * @param $dateFormat 日期格式字符
 * @param $recCount 要取的文章条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showxxgkByID($mysql,$cID,$cssClassName,$html,$dateFormat,$recCount,$titleCount)
{
	$tmpstr = "select article_id,article_title,article_time,article_order,s_id from article where  article_state=1 and item_id=%%s order by article_order desc,article_time desc";	
	$args[]= $cID;	
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$articleList = $mysql->findAllRec($tmpstr,$args);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		echo "<ul class='$cssClassName' $html><li>暂无新闻</li></ul>\n";
		return;
	}
	echo "<ul class='$cssClassName' $html>\n";
	for($i=0;$i<count($articleList);++$i)
	{		
		echo "<li>";
		if (strlen($dateFormat) > 1)
		{
			$tmpstr = $articleList[$i]["article_time"];
			$tmpstr = date($dateFormat,mktime(0,0,0,substr($tmpstr,5,2),substr($tmpstr,8,2),substr($tmpstr,0,4)));
			echo '<span class="date">'.$tmpstr.'</span>';
		}
		$article_id = $articleList[$i]["s_id"];
		if ($article_id == 0) $article_id = $articleList[$i]["article_id"];
		echo "<a target='_blank' href='xxgk.php?id=" .$article_id."' title='".$articleList[$i]["article_title"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $articleList[$i]["article_title"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $articleList[$i]["article_title"];
		}
		echo "</a>";
		echo "</li>";	
	}
	echo "</ul>\n";
}
/**
 * 以栏目ID显示文章栏目
 * @param $mysql 数据库对象
 * @param $cID 栏目ID
 * @param $cssClassName css样式类名
 * @param $recCount 要取的文章条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showWzlmByIDNoDate($mysql,$cID,$cssClassName,$recCount,$titleCount)
{
	$tmpstr = "select article_id,article_title,article_time,article_order,s_id from article where  article_state=1 and item_id=%%s order by article_order desc,article_time desc";	
	$args[]= $cID;	
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$articleList = $mysql->findAllRec($tmpstr,$args);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		echo "暂无";
		return;
	}
	for($i=0;$i<count($articleList);++$i)
	{		
		
		$article_title = substr($articleList[$i]["article_title"],0,25);
		$article_id = $articleList[$i]["s_id"];
		if ($article_id == 0) $article_id = $articleList[$i]["article_id"];
		echo "&nbsp;&nbsp; . <a target='_blank' class='$cssClassName' href='article.php?id=" .$article_id."' title='".$articleList[$i]["article_title"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $articleList[$i]["article_title"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $articleList[$i]["article_title"];
		}
		echo "</a>";
	}
}

/**
 * 以栏目ID显示调查栏目
 * @param $mysql 数据库对象
 * @param $c_id 栏目id
 * @param $cssName css样式类名
 */
function showDclmByID($mysql,$c_id,$cssName)
{
	$tmpstr = "select * from survey where columns_id=$c_id";
	$baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1) {
		echo "暂无网上调查";
		return;
	}
	$tmpstr = "select survey_item_id,item_type,display_order,item_contents from survey_item where columns_id=" . $c_id . " order by display_order";
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<p>".$baseInfo["survey_contents"]."</p><br>\n";
	echo "<form id='dcForm".$c_id."' name='dcForm".$c_id."' method='post' action='contentment_result.php?t=1&id=".$c_id."'>\n";
	$ztItem = NULL;
	echo "<ul class='$cssName'>\n";
	for($i=0; $i<count($itemList); $i++) 
	{
		if ($itemList[$i]["item_type"] == 3)
		{
			$ztItem = $itemList[$i];
			continue;
		}
		echo "<li><label><input type='";
		if ($itemList[$i]["item_type"] == 2)
		{
			echo "radio' name='dcItem'";
		}
		else
		{
			echo "checkbox' name='dcItem[]'";
		}
		echo "value='".$itemList[$i]["survey_item_id"]."'/></label>".$itemList[$i]["item_contents"]."</li>\n";
	}
	if ($ztItem != NULL)
	{
		echo "<li><label><input type='";
		if ($baseInfo["survey_type"] == 2)
		{
			echo "radio' name='dcItem'";
		}
		else
		{
			echo "checkbox' name='dcItem[]'";
		}
		echo " value='".$ztItem["survey_item_id"]."'/></label>".$ztItem["item_contents"]."<br>";
		echo "<input maxlength='210' type='text' name='dcItemzt'/><input type='hidden' name='dcItemztID' value='".$ztItem["survey_item_id"]."'/></label></li>\n";
	}
	echo "<br/><li><input type='image' src='images/an-tj.gif' class='img_icn' name='tj' value='1'/>&nbsp;<a target='_blank' href='contentment_result.php?id=".$c_id."' ><img border='0' src='images/an-ck.gif' class='img_icn'/></a></li>\n";
	echo "</ul>\n";
	echo "</form>\n";
}

/**
 * 显示访问量排行
 * @param $mysql
 * @param $cssName
 * @param $recCount
 * @param $titleCount
 * @return unknown_type
 */
function showFwlph($mysql,$cssName,$recCount,$titleCount)
{
	$tmpstr = "select  article_title,article_id,click_count  from article where item_id in (select columns_id from columns where sites_id=0 and columns_type_id<>13) group by item_id order by click_count desc";
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<ul class='$cssName'>\n";
	for($i=0;$i<count($itemList);++$i)
	{
		echo "<li>";
		echo "<span class='f_r'>".$itemList[$i]["click_count"]."</span>";
		echo "<a href='article.php?id=" .$itemList[$i]["article_id"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $itemList[$i]["article_title"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $itemList[$i]["article_title"];
		}
		echo "</a>";
		echo "</li>\n";	
	}
	echo "</ul>\n";
}

/**
 * 信息量排行
 * @param $mysql
 * @param $cssName
 * @param $recCount
 * @param $titleCount
 * @return unknown_type
 */
function showXxlph($mysql,$cssName,$recCount,$titleCount)
{
	$tmpstr = "select item_id,count(*) article_count,(select columns_name from columns where columns_id=item_id) c_name from article where item_id in (select columns_id from columns where sites_id=0 and columns_type_id<>13) group by item_id order by article_count desc";
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<ul class='$cssName'>\n";
	for($i=0;$i<count($itemList);++$i)
	{
		echo "<li>";
		echo "<span class='f_r'>".$itemList[$i]["article_count"]."</span>";
		echo "<a href='article_more.php?id=" .$itemList[$i]["item_id"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $itemList[$i]["c_name"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $itemList[$i]["c_name"];
		}
		echo "</a>";
		echo "</li>\n";	
	}
	echo "</ul>\n";
}

/**
 * 显示网上答疑
 * @param $mysql 数据库对象
 * @param $html <>内的html
 * @param $recCount 要取的条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showQuestion($mysql,$html,$recCount,$titleCount)
{
	$tmpstr = "select question_id,question_content,question_time from question order by question_time desc";
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<ul $html>\n";
	for($i=0;$i<count($itemList);++$i)
	{
		echo "<li>";
		echo "<a target='_blank' href='question.php?id=" .$itemList[$i]["question_id"]."' title='".$itemList[$i]["question_content"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $itemList[$i]["question_content"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $itemList[$i]["question_content"];
		}
		echo "</a>";
		echo "</li>";	
	}
	echo "</ul>\n";
}

/**
 * 以栏目ID显示专题栏目
 * @param $mysql 数据库对象
 * @param $zt_id 栏目ID
 * @param $html <>内的html
 * @param $recCount 要取的条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showZtlmListById($mysql,$zt_id,$html,$recCount,$titleCount)
{
	$tmpstr = "select columns_toptic_id,toptic_name,toptic_order from columns_toptic where  columns_id=$zt_id order by toptic_order desc, columns_toptic_id desc";
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<ul $html>\n";
	for($i=0;$i<count($itemList);++$i)
	{
		echo "<li>";
		echo "<a target='_blank' href='viewToptic.php?id=" .$itemList[$i]["columns_toptic_id"]."' title='".$itemList[$i]["toptic_name"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $itemList[$i]["toptic_name"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $itemList[$i]["toptic_name"];
		}
		echo "</a>";
		echo "</li>";	
	}
	echo "</ul>\n";
}

/**
 * 显示图片幻灯片
 * @param $mysql 数据库操作对象
 * @param $c_id 栏目ID
 * @param $recCount
 * @return unknown_type
 */
function showTphdp($mysql,$c_id,$recCount)
{
	$tmpstr = "select * from columns_slideimage where columns_id=$c_id";
	$baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1) {
		echo "";
		return;
	}
	if ($baseInfo["columns_imagelist_id"] == 0)
	{
		echo "";
		return;
	}
	
	$tmpstr = "select article_id,article_title,img_url,s_id from article c where item_id=" . $baseInfo["columns_imagelist_id"] . 
	          " and article_state=1 and img_url<>'' order by article_order desc,article_time desc limit $recCount";
	$imageList = $mysql->findAllRec($tmpstr);
	$imgCount = count($imageList);
	if ( ($imageList == -1) || ($imgCount <= 0) ) {
		echo "";
		return;
	}
	echo '<div class="box3" style="position: relative;width: '.$baseInfo["img_width"].'px;height: '.($baseInfo["text_height"]+$baseInfo["img_heigth"]).'px;">'; 
	echo '	<div id="pics'.$c_id.'" style="left:0px;position:absolute;z-index: 1">'; 
	echo '		<ul>';
	$article_id = $imageList[0]["s_id"];
	if ($article_id == 0) $article_id = $imageList[0]["article_id"];
	echo '   <li id="img_li'.$c_id.'_0"><a id="img_li'.$c_id.'_0_a" href="article.php?id='.$article_id.'"><img id="img_li'.$c_id.'_0_i" src="'.$imageList[0]["img_url"].'" width="'.$baseInfo["img_width"].'" height="'.$baseInfo["img_heigth"].'" alt="'.$imageList[0]["article_title"].'"/></a></li>'; 
	for($i=1;$i<$imgCount;$i++) {
		$article_id = $imageList[$i]["s_id"];
		if ($article_id == 0) $article_id = $imageList[$i]["article_id"];
		echo '   <li id="img_li'.$c_id.'_'.$i.'" style="display: none"><a id="img_li'.$c_id.'_'.$i.'_a" href="article.php?id='.$article_id.'"><img id="img_li'.$c_id.'_'.$i.'_i" src="'.$imageList[$i]["img_url"].'" width="'.$baseInfo["img_width"].'" height="'.$baseInfo["img_heigth"].'" alt="'.$imageList[$i]["article_title"].'"/></a></li>';
	} 
	echo '		</ul>'; 
	echo '	</div>'; 
	echo '	<div id="pic_order'.$c_id.'"  style="position:absolute;z-index: 2;right:5px;bottom: 55px;">';
	echo '	  <div id="pic_order'.$c_id.'_0" class="slideNumOn" onclick="imgSlideClick(myImgSlide'.$c_id.',0)"></div>'; 
	for($i=1;$i<$imgCount;$i++) {
		echo '	  <div id="pic_order'.$c_id.'_'.$i.'" class="slideNum" onclick="imgSlideClick(myImgSlide'.$c_id.','.$i.')"></div>';
	} 
	echo '	</div>'; 
	echo '	<div id="pic_order_text'.$c_id.'"  style="position:absolute;z-index: 3;right:5px;bottom: 55px;">'; 
	for($i=0;$i<$imgCount;$i++) {
		echo '	  <div class="slideText" onclick="imgSlideClick(myImgSlide'.$c_id.','.$i.')">'.($i+1).'</div>';
	} 
	echo '	</div>'; 
	echo '	<div  style="left:0px;position:absolute;z-index: 2;text-align:center;width: '.$baseInfo["img_width"].'px;bottom: 10px">'; 
	echo '	  <a id="pic_title'.$c_id.'" href="javascript:void(0)" style="line-height:12pt;text-decoration: none;font-size: 12pt;font-weight: bold;"></a>'; 
	echo '	</div>'; 			
	echo '</div>'; 
	echo '<script>';  
	echo '  var myImgSlide'.$c_id.' = {name:"myImgSlide'.$c_id.'",time_h:0,count:'.$imgCount.',index:0,li_id:"img_li'.$c_id.'",txt_id:"pic_title'.$c_id.'",num:"pic_order'.$c_id.'"};'; 
	echo '  imgSlide(myImgSlide'.$c_id.',0);'; 
	echo '</script>';    
}

/**
 * 从指定的专题栏目取显示在首页的一条小图片显示在首页上
 * @param $mysql 数据库操作对象
 * @param $c_id 栏目id
 * @return unknown_type
 */
function showZtlmSmallImageToFirstPage($mysql,$c_id){
	$tmpstr = "select (select file_name from upload_files u where u.file_id=small_img_id) s_file_name,small_img_width,small_img_height,columns_toptic_id from columns_toptic where to_index=1 and columns_id=$c_id";
	$baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1)
	{
		echo "";
		return;
	}
	echo '<div class="box2"><a href="viewToptic.php?id='.$baseInfo["columns_toptic_id"].'"><img src="'.$baseInfo["s_file_name"].'" width="'.$baseInfo["small_img_width"].'" height="'.$baseInfo["small_img_height"].'" /></a></div>';
}

/**
 * 从指定的专题栏目取显示在首页的一条显示在首页上
 * @param $mysql 数据库操作对象
 * @param $c_id 专题栏目id
 * @param $recCount 取文章数量
 * @return unknown_type
 */
function showZtlmToFirstPage($mysql,$c_id,$recCount){
	$tmpstr = "select toptic_name,article_column_id,columns_toptic_id from columns_toptic where to_index=1 and columns_id=$c_id";
	$baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1)
	{
		echo "";
		return;
	}
	$tmpstr = "select article_id,article_title,s_id from article where  article_state=1 and item_id=%%s order by article_order desc";	
	$args[]= $baseInfo["article_column_id"];	
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$articleList = $mysql->findAllRec($tmpstr,$args);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		return;
	}
	echo '<div class="toutiao">';
	$art_id = $articleList[0]['s_id'];
    if ($art_id == 0) {$art_id=$articleList[0]['article_id'];}
    echo '<h2><a href="article.php?id='.$art_id.'">'.$articleList[0]['article_title'].'</a></h2>';
    for($i=1;$i<count($articleList);$i++){
    	$art_id = $articleList[$i]['s_id'];
    	if ($art_id == 0) {$art_id=$articleList[$i]['article_id'];}
    	echo '[ <a href="article.php?id='.$art_id.'">'.$articleList[$i]['article_title'].'</a> ]'; 
    }
    echo '</div>';
}

/**
 * 以ID显示领导列表
 * @param $mysql 数据库对象
 * @param $zt_id 单位ID
 * @param $cssName ul css样式类名
 * @param $cssName2 span css样式类名
 * @param $recCount 要取的条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showHeadListById($mysql,$zt_id,$cssName,$cssName2,$recCount)
{
   $tmpstr = "select c_id from corp where to_index=1 limit 0,1";
   $baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1) {
		echo "";
		return;
	}
	$zt_id= $baseInfo["c_id"];
	$tmpstr = "select head_id,head_name,head_post,head_post2 from corp_head where  corp_id=$zt_id order by head_order";
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo '<ul class="'.$cssName.'">';
	for($i=0;$i<count($itemList);++$i)
	{
		echo '<li><a href="viewHead.php?id=' .$itemList[$i]["head_id"].'"><span class="'.$cssName2.'">[详情]</span></a><span style="width:55px;display:-moz-inline-box;display:inline-block;">'.$itemList[$i]["head_name"].'</span> '.$itemList[$i]["head_post"].'</li>';		
	}
	echo "</ul>\n";
}


/**
 * 以栏目ID显示机构列表
 * @param $mysql 数据库对象
 * @param $id 栏目ID
 * @param $cssName css样式类名
 * @param $cssName2 span cssClass
 */
function showPartListById($mysql,$id,$cssName,$cssName2)
{
   $tmpstr = "select c_id from corp where to_index=1 limit 0,1";
   $baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1) {
		echo "";
		return;
	}
	$args[]= $baseInfo["c_id"];
	$tmpstr = "select part_id,part_name from corp_part where corp_id=%%s order by part_order";
	$itemList = $mysql->findAllRec($tmpstr,$args);	
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<ul class='$cssName'>\n";
	for($i=0; $i<count($itemList); $i++) 
	{
		echo '<li><a href="viewPart.php?id='.$itemList[$i]["part_id"].'"><span class="'.$cssName2.'">[详情]</span></a>'.$itemList[$i]["part_name"].'</li>';
	}
	echo "</ul>\n";
}

/**
 * 以单位类型ID显示单位列表
 * @param $mysql 数据库对象
 * @param $type_id 单位类型ID
 * @param $cssName css样式类名
 * @param $cssName2 span cssClass
 * @param $recCount 要取的条数
 */
function showCorpListByTypeId($mysql,$type_id,$cssName,$cssName2,$recCount)
{
	$tmpstr = "select c_id,corp_name,(select part_id from corp_part where corp_id=a.c_id  limit 0,1) part_id from corp a where  c_type=$type_id";
	if ($recCount != 0)
	{
		$tmpstr = $tmpstr . " limit 0,$recCount";
	}
	$itemList = $mysql->findAllRec($tmpstr);
	if ( ($itemList == -1) || (count($itemList) <= 0) ) {
		echo "";
		return;
	}
	echo "<ul class='$cssName'>\n";
	for($i=0; $i<count($itemList); $i++) 
	{
		echo '<li><a href="viewPart.php?id='.$itemList[$i]["part_id"].'"><span class="'.$cssName2.'">[详情]</span></a>'.$itemList[$i]["corp_name"].'</li>';
	}
	echo "</ul>\n";
}

/**
 * 以栏目ID显示文章栏目（分页显示）
 * @param $mysql 数据库对象
 * @param $cID 栏目ID
 * @param $cssName css样式类名
 * @param $dateFormat 日期格式字符
 * @param $recCount 要取的文章条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 * @param $to_page 要到达的目的页数
 */
function showWzlmByIDToPage($mysql,$cID,$cssName,$dateFormat,$recCount,$titleCount,$to_page)
{
	$page_num = 1;
	$first_page = 1;
	$last_page = 1;
	$up_page = 1;
	$next_page = 1;
		
	$tmpstr = "select article_id,article_title,article_time,article_order,s_id from article where  article_state=1 and item_id=$cID order by article_order desc,article_time desc";	
	$articleList = $mysql->findAllRecByPage($tmpstr,$to_page,$recCount);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		echo "";
		return;
	}
	$page_num = $mysql->page_amount;
	$last_page = $page_num;
	$p = $to_page - 1;
	if ($p  < 1){
		$up_page = 1;
	} else {
		$up_page = $p;
	}
	$p = $to_page + 1;
	if ($p > $page_num){
		$next_page = $page_num;
	} else {
		$next_page = $p;
	}
	echo "<ul class='$cssName'>\n";
	for($i=0;$i<count($articleList);++$i)
	{		
		echo "<li>";		
		if (strlen($dateFormat) > 1)
		{
			$tmpstr = $articleList[$i]["article_time"];
			$tmpstr = date($dateFormat,mktime(0,0,0,substr($tmpstr,5,2),substr($tmpstr,8,2),substr($tmpstr,0,4)));
			echo '<span class="date">'.$tmpstr.'</span>';
		}
		
		$article_id = $articleList[$i]["s_id"];
		if ($article_id == 0) $article_id = $articleList[$i]["article_id"];
		
		echo "<a target='_blank' href='article.php?id=" .$article_id."' title='".$articleList[$i]["article_title"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $articleList[$i]["article_title"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $articleList[$i]["article_title"];
		}
		echo "</a>";
		echo "</li>";	
	}	
		
	echo "</ul>\n";
	$pageStr =  "共 $page_num 页 ";
	$pageStr =$pageStr.   "第 $to_page 页 ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$first_page' class='blue12'>首页</A> ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$up_page' class='blue12'>上页</A> ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$next_page' class='blue12'>下页</A> ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$last_page' class='blue12'>末页</A> ";
	return $pageStr;
}


/**
 * 以栏目ID显示文章栏目（分页显示）
 * @param $mysql 数据库对象
 * @param $cID 栏目ID
 * @param $cssName css样式类名
 * @param $dateFormat 日期格式字符
 * @param $recCount 要取的文章条数
 * @param $titleCount 标题字符数 多余的字符将以...代替
 * @param $to_page 要到达的目的页数
 */
function showxxgkByIDToPage($mysql,$cID,$cssName,$dateFormat,$recCount,$titleCount,$to_page)
{
	$page_num = 1;
	$first_page = 1;
	$last_page = 1;
	$up_page = 1;
	$next_page = 1;
		
	$tmpstr = "select article_id,article_title,article_time,article_order,s_id from article where  article_state=1 and item_id=$cID order by article_order desc,article_time desc";	
	$articleList = $mysql->findAllRecByPage($tmpstr,$to_page,$recCount);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		echo "";
		return;
	}
	$page_num = $mysql->page_amount;
	$last_page = $page_num;
	$p = $to_page - 1;
	if ($p  < 1){
		$up_page = 1;
	} else {
		$up_page = $p;
	}
	$p = $to_page + 1;
	if ($p > $page_num){
		$next_page = $page_num;
	} else {
		$next_page = $p;
	}
	echo "<ul class='$cssName'>\n";
	for($i=0;$i<count($articleList);++$i)
	{		
		echo "<li>";		
		if (strlen($dateFormat) > 1)
		{
			$tmpstr = $articleList[$i]["article_time"];
			$tmpstr = date($dateFormat,mktime(0,0,0,substr($tmpstr,5,2),substr($tmpstr,8,2),substr($tmpstr,0,4)));
			echo '<span class="date">'.$tmpstr.'</span>';
		}
		
		$article_id = $articleList[$i]["s_id"];
		if ($article_id == 0) $article_id = $articleList[$i]["article_id"];
		
		echo "<a target='_blank' href='xxgk.php?id=" .$article_id."' title='".$articleList[$i]["article_title"]."'>";
		if ($titleCount != 0)
		{
			$tmpstr = $articleList[$i]["article_title"];
			echo cutstr($tmpstr,$titleCount,1);
		}
		else
		{
			echo $articleList[$i]["article_title"];
		}
		echo "</a>";
		echo "</li>";	
	}	
		
	echo "</ul>\n";
	$pageStr =  "共 $page_num 页 ";
	$pageStr =$pageStr.   "第 $to_page 页 ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$first_page' class='blue12'>首页</A> ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$up_page' class='blue12'>上页</A> ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$next_page' class='blue12'>下页</A> ";
	$pageStr =$pageStr.   "<a href='article_more.php?id=$cID&page=$last_page' class='blue12'>末页</A> ";
	return $pageStr;
}
/**
 * 以栏目的ID显示图片表格栏目
 * @param $mysql 数据库对象
 * @param $c_id 栏目ID
 * @param $html <>内的html
 * @param $marquee_css marquee的css
 */
function showTpbglmById($mysql,$c_id,$html,$marquee_css = '')
{
	$tmpstr = "select * from columns_imagetable where columns_id=$c_id";
	$baseInfo = $mysql->findOneRec($tmpstr);
	if ($baseInfo == -1) {
		echo "";
		return;
	}
	if ($baseInfo["columns_imagelist_id"] == 0)
	{
		echo "";
		return;
	}
	$tmpstr = "select (select file_name from upload_files u where u.file_id=c.file_id) file_name,item_title,item_link from columns_imagelist c where columns_id=" . $baseInfo["columns_imagelist_id"] . " order by item_order";
	$imageList = $mysql->findAllRec($tmpstr);
	if ( ($imageList == -1) || (count($imageList) <= 0) ) {
		echo "";
		return;
	}
	$rowNumber = floor(count($imageList) / $baseInfo["col_number"]);
	if ( (count($imageList) % $baseInfo["col_number"]) != 0) $rowNumber ++;
	$i = 0;
	$context = "";
	$rollUpTd = '';
	$rollDownTd = '';
	for ($j=0;$j<$rowNumber;$j++)
	{
		$context = $context . "<div id='imgList1_$c_id' $html>\n";
		for($s = 0; $s < $baseInfo["col_number"]; ++$s)
		{
			if ($i >= count($imageList)) break;
			$imgstr = '<img src="'.WEB_DOMAIN_NAME.$imageList[$i]["file_name"].'"';
			if ($baseInfo["img_width"] != 0)
			{
				$imgstr = $imgstr . " width='".$baseInfo["img_width"]."' ";
			}
			if ($baseInfo["img_heigth"] != 0)
			{
				$imgstr = $imgstr . " height='".$baseInfo["img_heigth"]."' ";
			}
			$imgstr = $imgstr . "/>";
			$linkstr = "<a target='_top' href='".$imageList[$i]["item_link"]."'>".$imageList[$i]["item_title"]."</a>";
			switch ($baseInfo["text_xy"])
			{
				case 1:
					{   $rollUpTd .= '<td>'.$imgstr.'</td><td>&nbsp;</td>';
					    $rollDownTd .= '<td>'.$linkstr.'</td><td>&nbsp;</td>';
						$context = $context . '<div style="float:left"><div>'.$imgstr ."</div><div style='text-align: center;'>". $linkstr.'</div></div><div style="float:left">&nbsp;</div>';
						break;						
					}
				case 2 :
					{
						$context = $context . $linkstr . $imgstr;
						break;
					}
				case 3 :
					{
						$context = $context . $imgstr . $linkstr;
						break;
					}
				case 4 :
					{
						$context = $context . $linkstr ."<br/>". $imgstr;
						break;
					}	
			}
		 $i++;
		}
		$context = $context . "</div>";
	}
	switch ($baseInfo["display_type"])
	{
		case 1:
			{
				echo $context;
				break;						
			}
		case 2 :
			{
				echo "<div id='imgList_$c_id'  $html>";
               	echo '<table cellpadding="0" cellspacing="0" border="0">';
                echo "<tr><td id='imgList1_$c_id' valign='top' align='center'>";
                echo '<table cellpadding="2" cellspacing="0" border="0">';
                echo '<tr align="center">';
                echo $rollUpTd;
                echo '</tr><tr align="center">';
                echo $rollDownTd;
                echo '</tr></table>';
                echo "</td><td id='imgList2_$c_id' valign='top'></td></tr></table>";
				echo "<script> ";
				echo "var imgList_$c_id"."speed=20; ";
				echo "var imgListTab_$c_id=document.getElementById('imgList_$c_id'); ";
				echo "var imgListTab1_$c_id=document.getElementById('imgList1_$c_id'); ";
				echo "var imgListTab2_$c_id=document.getElementById('imgList2_$c_id'); ";
				echo "imgListTab2_$c_id.innerHTML=imgListTab1_$c_id.innerHTML; ";
				echo "function Marquee$c_id(){ ";
				echo "if(imgListTab2_$c_id.offsetWidth-imgListTab_$c_id.scrollLeft<=0) {";
				echo "imgListTab_$c_id.scrollLeft-=imgListTab1_$c_id.offsetWidth;";
				echo "} else { ";
				echo "imgListTab_$c_id.scrollLeft++; ";
				echo "} ";
				echo "} ";
				echo "var imgListMar_$c_id=setInterval(Marquee$c_id,imgList_$c_id"."speed); ";
				echo "imgListTab_$c_id.onmouseover=function() {clearInterval(imgListMar_$c_id)}; ";
				echo "imgListTab_$c_id.onmouseout=function() {imgListMar_$c_id=setInterval(Marquee$c_id,imgList_$c_id"."speed)}; ";
				echo "</script>";
				echo '</div>';
				break;
			}
		case 3 :
			{
				echo "<marquee scrollamount='2' scrolldelay='6' direction='right' $marquee_css>".$context."</marquee>";
				break;
			}
		case 4 :
			{
				echo "<marquee scrollamount='2' scrolldelay='6' direction='up' $marquee_css>".$context."</marquee>";
				break;
			}
		case 5 :
			{
				echo "<marquee scrollamount='2' scrolldelay='6' direction='down' $marquee_css>".$context."</marquee>";
				break;
			}		
	}	
}

/**
 * 以栏目ID显示文章栏目的第一条文章
 * @param $mysql 数据库对象
 * @param $c_id 栏目ID
 * @param $titleCount 标题字符数 多余的字符将以...代替
 */
function showWzlmOneRec($mysql,$c_id,$titleCount)
{
	$tmpstr = "select article_id,article_title,article_time,article_order,s_id from article where  article_state=1 and item_id=$c_id order by article_order desc,article_time desc limit 0,1";
		
	$article = $mysql->findOneRec($tmpstr);
	if ( ($article == -1) || (count($article) <= 0) ) {
		echo "";
		return;
	}
	$article_id = $articleList[$i]["s_id"];
	if ($article_id == 0) $article_id = $articleList[$i]["article_id"];
	echo "<a style='font-family: \"黑体\";font-size:18px;color: #D5280D;' target='_blank' href='article.php?id=" .$article_id."' title='".$article["article_title"]."'>";
	if ($titleCount != 0)
	{
		$tmpstr = $article["article_title"];
		echo cutstr($tmpstr,$titleCount,1);
	}
	else
	{
			echo $article["article_title"];
	}
	echo "</a>";
}

/**
 * 把数据库的结果以FieldName为下标生成一个数组
 * @param $list 从数据库取得的结果集
 * @param $indexFieldName 下标字段名
 * @param $valueFieldName 值字段名
 * @return array
 */
function CreateArrayFromDBList($list,$indexFieldName,$valueFieldName){
	
	$arrayCount=count($list);
	$aArray=array();

	for($i=0;$i<$arrayCount;$i++){
		$aArray[$list[$i][$indexFieldName]]=$list[$i][$valueFieldName];
	}
	return $aArray;	
}

/**
 * 从数据库取得所有栏目的名称
 * @param $mysql 数据库操作对象
 * @return 数据库结果集
 */
function getAllColumnsName($mysql){
	$tmpstr = 'select columns_id,columns_title,sub_id from columns';
	$columnsList = $mysql->findAllRec($tmpstr);
	return $columnsList;
}

/**
 * 以字节长度截取字符串
 * @param  $str 源字符串
 * @param  $cut_len 目标长度
 * @param  $flag 1=加上..号
 */
function cutstr($str,$cut_len,$flag)
{
	$length = utf8_len($str);
	if ($cut_len >= $length) { return $str;} 
	$end_index = 0; 
	$char_count = 0;
	$length = strlen($str);
	for($i=0; $i<$length;){
		$char_aci = ord($str[$i]);
		if ($char_aci>224){
			$end_index += 3;
			$i+=3;
		} else if ( ($char_aci>192) && (($char_aci<=224)) ){
			$end_index += 2;
			$i+=2;
		} else {
			$end_index ++;
			$i++;
		}
		$char_count++;
		if ($char_count >= $cut_len) break;
	}
	$result = substr($str,0,$end_index);
	if($flag==1){$result=$result."..";}
	return $result; 
}

/**
 * 求一个UTF-8字符串中字数
 * @param $str
 * @return unknown_type
 */
function utf8_len($str){
	$char_count = 0;
	$length = strlen($str);	
	for($i=0; $i<$length;){
		$char_aci = ord($str[$i]);
		if ($char_aci>224){
			$i+=3;
		} else if ( ($char_aci>192) && (($char_aci<=224)) ){
			$i+=2;
		} else {
			$i++;
		}
		$char_count++;
	}
	return $char_count;
}
?>