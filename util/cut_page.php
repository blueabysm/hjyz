<?
/*
页面功能：分页程序

注意：
	本文件应和fenye_css.php文件配合使用

参数：
	需要在include之前预先设定
		$sQuery			sql语句的前缀
		$sQueryCount	取得记录集条数的sql语句前缀
		$sQueryWhere	where语句
		$sRsVarName		生成列表的记录集变量名
		$iPerPage		每页显示的条数，缺省为30

执行结果：
	在接下来的程序中生成iCPage数组（供fenye_css.php文件使用）
	在接下来的程序中生成以$sRsVarName为变量名的记录集

文件名：cut_page.php

程序员：陈威

*/
function cut_page($all_rows,$perpage,$offset)
{
  $all_page=ceil($all_rows/$perpage);
  if ($all_page<=0) $all_page=1;    //填加该句，2005年2月19日 17:27:58 qq:6218724
  $now_page=ceil($offset/$perpage)+1;
  $last_offset=$offset-$perpage;
  if ($last_offset<0) $last_offset=$offset;
  $next_offset=$offset+$perpage;
  if ($next_offset>=$all_rows) $next_offset=$offset;
  $finish_offset=($all_page-1)*$perpage;
  return array($all_page,$now_page,$last_offset,$next_offset,$finish_offset);
}

if(!$iPerPage){
	$iPerPage=30;
}

if(!$_GET["iPage"] or $_GET["iPage"]<0){
	$iPage=0; 
}
else{
	$iPage=$_GET["iPage"];
}

if($_GET["gopage"]){
	$iPage=($iGoPage-1)*$iPerPage;
}

$iCPage=cut_page($mysqldao->findOneField($sQueryCount.$sQueryWhere),$iPerPage,$iPage);
$$sRsVarName=$mysqldao->findAllRec($sQuery.$sQueryWhere." limit $iPage,$iPerPage");

//echo $sQuery.$sQueryWhere." limit $iPage,$iPerPage";
?>