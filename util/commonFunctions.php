<?php

//弹出一个对话框
function showMessage($message)
{
  echo "<script>";
  echo "window.alert('".$message."');";
  echo "</script>";  
}
function messageToURL($message,$url)
{
  echo "<script>";
  echo "window.alert('".$message."');";
  echo "window.top.location='$url'";
  echo "</script>";  
}

function CreateArrayFromRs($aRs,$sFieldKey){	
	$iRsCount=count($aRs);
	$aArray=array();

	for($i=0;$i<$iRsCount;$i++){
		$aArray[$aRs[$i][$sFieldKey]]=$aRs[$i];
	}
	return $aArray;	
} 

function file_srand(){
	srand((double)microtime()*1000000);
	$randval = rand();
	$file_sid=time().$randval;
	return $file_sid;
}
/**
 * 判断给定的字符串是否由纯数字组成
 * @param $o_str 源字符串
 * @return 是就返回1 不是返回0		
 */
function isNumber($o_str){
	$str = strval($o_str);	
	if ($str == "") return 0;	
	for($i=0;$i<strlen($str);$i++)
	 if( (ord($str[$i])<48) || (ord($str[$i])>57) ) return 0;
	return 1;
}

/**
 * 判断给定的字符串是否是一个正整数 首位不能为0
 * @param $o_str 源字符串
 * @return 是就返回1 不是返回0		
 */
function isInteger($o_str){
	$str = strval($o_str);	
	if ($str == "") return 0;
	if (ord($str[$i]) == 48) return 0;	
	for($i=0;$i<strlen($str);$i++)
	 if( (ord($str[$i])<48) || (ord($str[$i])>57) ) return 0;
	return 1;
}

/**
 * 判断给定的字符串是否是一个合法的用户名
 * @param $str 源字符串
 * @return 是就返回1 不是返回0		
 */
function isUserName($str){
	if ($str == "") return 0;
	for($i=0;$i<strlen($str);$i++) {
		$nowChar = ord($str[$i]);		
		if ($nowChar < 48) return 0;
		if ($nowChar > 122) return 0;
		if ( ($nowChar > 57) && ($nowChar < 97) ) return 0;
	}
	return 1;
}

/*
函数功能：
	生成下拉框的html语句

注意：
	如果$sValueKey和$sNameKey都为空，则表示$aArray是一个一维数组（比如，民族、性别等）
	
参数说明：
	$sSelectName	下拉框的名称
	$aArray			生成下拉框所使用的二维数组，通常是一个记录集
	$sValueKey		做为下拉框value值所采用的数组key
	$sNameKey		做为下拉框name值所采用的数组key
	$sDefaultValue	默认值，当select的value等于默认值时则默认选中该项，缺省为false
	$bIsHaveAll		是否在下拉框最前面添加一个value为空，name为空的选项，缺省为false
	$sMoreCode		加到下拉框后面的附加代码，例如 “onchange=xxxx(this.value) class=""”等
*/
function CreateSelectHtml($sSelectName,$aArray,$sValueKey,$sNameKey,$sDefaultValue=false,$bIsHaveAll=false,$sMoreCode=""){
	$sSelectHtml="<SELECT NAME=\"".$sSelectName."\" ".$sMoreCode." >";

	if($bIsHaveAll){
		$sSelectHtml.="<option value=\"\"></option>";
	}

	$iArrayCount=count($aArray);
	for($i=0;$i<$iArrayCount;$i++){
		
		if($sValueKey && $sNameKey ){
			$sTempValue=$aArray[$i][$sValueKey];
			$sTempName=$aArray[$i][$sNameKey];
		}
		else{
			$sTempValue=$i;
			$sTempName=$aArray[$i];
		}
		

		if($sDefaultValue!==false && $sDefaultValue!=="" && $sDefaultValue==$sTempValue){
			$sTempIsSelected=" selected ";
		}
		else{
			$sTempIsSelected="";
		}
		
		$sSelectHtml.="<option value=\"".$sTempValue."\"".$sTempIsSelected.">".$sTempName."</option>";
	}
	$sSelectHtml.="</SELECT>";

	return $sSelectHtml;
}

/**
 * 判断用户能否访问当前的页面
 * @param $menu_id 菜单id -1=所有人可访问 0=所有登录用户  其它值=特定登录用户
 */
function canAcesssThisPage($menu_id)
{
	//如果菜单id为-1表示任何人可以访问该页面	
	if ($menu_id == -1) return;
		
	if ( 
		(isset($_SESSION["sess_user_name"]) == false) ||
		(isset($_SESSION["sess_user_purview"]) == false) )
	{	
		messageToURL('请登录!',WEB_DOMAIN_NAME.'/manage/login.php');
		exit;
	}
	//如果菜单id为0表示只要是登录用户即可访问该页面	
	if ($menu_id == 0) return;
		
	$all = $_SESSION["sess_user_purview"];
	$find = strpos($all,','.$menu_id.',');
	if ($find === false){
		ALTback('没有权限');
		exit;
	}	
}

/**
 * 判断用户能否访问当前的页面-ajax专用
 * @param $menu_id 菜单id -1=所有人可访问 0=所有登录用户  其它值=特定登录用户
 */
function canAcesssThisPageAjax($menu_id)
{
	
	//如果菜单id为-1表示任何人可以访问该页面	
	if ($menu_id == -1) return false;		
	if ( 
		(isset($_SESSION["sess_user_name"]) == false) ||
		(isset($_SESSION["sess_user_purview"]) == false) )
	{	
		echo '请登录!';
		return true;
	}
	
	//如果菜单id为0表示只要是登录用户即可访问该页面	
	if ($menu_id == 0) return false;	
		
	$all = $_SESSION["sess_user_purview"];
	$find = strpos($all,','.$menu_id.',');
	
	if ($find === false){
		echo '没有权限';
		return true;
	}
	return false;	
}

/**
 * 判断当前用户能否执行指定的操作
 * @param $obj_id 对象id
 * @param $db 数据库操作对象
 * @param $pList 操作名称列表
 * @return string 如果可以操作则返回用户对当前对象的权限列表
 */
function checkPurview($menu_id,$obj_id,$db,$pList)
{
	$sqlstr = "select pur_list from my_object where menu_id=$menu_id and obj_id=$obj_id and user_id=".$_SESSION["sess_user_id"];
	$sqlResult = $db->findOneRec($sqlstr);
	if ($sqlResult == -1){
		return -1;
	}
	$all = trim($sqlResult["pur_list"]);
	$len = count($pList);
	$pcount = 0;
	for ($i=0;$i<$len;$i++)
	{
		$find = strpos($all,','.$pList[$i].',');
		if (!($find === false)) {
			$pcount++;
		}
	}
	if ($pcount == 0){
		return -1;
	}
	return $all;
}

/**
 * 判断sql语句是否有查询结果
 * @param $mysqldao 数据库连接对象,需已打开连接 <br>  
 * @param $sqlstr sql语句 <br>   
 * @return 有结果返回1 无结果在返回0
 */
function recordExists($mysqldao,$sqlstr)
{	
	$sqlResult;
	
	$sqlResult = $mysqldao->findOneRec($sqlstr);
	if ($sqlResult == -1) return 0;
	return 1;
}
function GoToPage($go_url,$msg=""){
  header("Content-Type: text/html; charset=UTF-8");
  echo "<script language=javascript>";
  if($msg){
	echo "window.alert('".$msg."');";
  }
  echo "location.href='".$go_url."'";
  echo "</script>";
  exit;
}

/**
 * 显示弹出信息,返回前一页面
 * @param $info 弹出信息
 */
function ALTback($info) 
 { 
	echo "<SCRIPT language=javascript>";
	echo "{ alert('".$info."');";
	echo "history.back();}";
	echo "</script>";
 } 
 
 //截取中文字符串  qshd
 function cutstr_chat($title,$length,$flag){
	$length=2*$length;
	if (strlen($title)>$length) { 
		$temp = 0; 
		for($i=0; $i<$length; $i++) 
			if (ord($title[$i]) > 128) 
				$temp++; 
				if ($temp%2 == 0) 
					$title = substr($title,0,$length); 
				else 
					$title = substr($title,0,$length-1); 

				if($flag==1){$title=$title."..";}
	} 
	return $title; 
}

function ubb($msg) {  
  global $image_path;
  $msg=preg_replace("/\[p\](.+?)\[\/p\]/is","<p>\\1</p>",$msg); 
  //标题字
  $msg=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$msg);  
  $msg=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$msg);  
  $msg=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$msg);  
  $msg=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$msg);  
  $msg=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$msg);  
  $msg=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$msg);  
  //链接
  $msg=preg_replace("/\[url\](http:\/\/.+?)\[\/url\]/i","<a href=\\1>\\1</a>",$msg); $msg=preg_replace("/\[url\](.+?)\[\/url\]/i","<a href=\"http://\\1\">http://\\1</a>",$msg);  
  $msg=preg_replace("/\[url=(http:\/\/.+?)\](.*)\[\/url\]/i","<a href=\\1>\\2</a>",$msg);  
  $msg=preg_replace("/\[url=(.+?)\](.*)\[\/url\]/i","<a href=\\1>\\2</a>",$msg); 
  $msg=preg_replace("/\[url_new=(.+?)\](.*)\[\/url_new\]/i","<a href=\\1 target='_blank'>\\2</a>",$msg); 
  //文字颜色
  $msg=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\\1>\\2</font>",$msg);  
  //文字大小
  $msg=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font size=\\1>\\2</font>",$msg);  

  $msg=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$msg);  
  $msg=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$msg);  
  $msg=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$msg);  
  //E_MAIL
  $msg=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href=mailto:\\1>\\1</a>",$msg);  
  //斜体字
  $msg=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$msg);  
  //下划线
  $msg=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$msg); 
  //加粗
  $msg=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$msg);  

  $msg=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><hr noshade>\\1<hr></blockquote>", $msg);    $msg=preg_replace("/\[code\](.+?)\[\/code\]/is","<blockquote><hr><i>\\1</i><hr></blockquote>", $msg); 
  //显示图片
  $img="<img src='".$image_path."\\1' border=0>";
  $msg=preg_replace("/\[img\](.+?)\[\/img\]/i",$img,$msg); 
  //显示Flash
  $flash="<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"  codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\">";
  $flash.="<param name=movie value='$image_path\\1'>";
  $flash.="<param name=quality value=high>";
  $flash.="<embed src='$image_path\\1' quality=high  pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type='application/x-shockwave-flash'>";
  $flash.="</embed></object>";
  $msg=preg_replace("/\[flash\](.+?)\[\/flash\]/is",$flash, $msg);  

  //物件对齐方式
  $msg=preg_replace("/\[align=(.+?)\](.+?)\[\/align\]/is","<div align=\\1>\\2</div>",$msg); 
  //弹出式子父图片链接
  $msg=preg_replace("/\[url_img=(.+?)\](.+?)\[\/url_img\]/i","<a href=$image_path\\1 target='_blank'><img src=$image_path\\2 border></a>",$msg); 
  //图片按指定的位置显示在文字的左边和右边
  $msg=preg_replace("/\[img_align=(.+?)\](.+?)\[\/img_align\]/is","<img align=\\1  src=$image_path\\2>",$msg);
  return $msg;  
}  
?>