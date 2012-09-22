<? 
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(23);

include_once("../../database/mysqlDAO.php");

//取得参数
$op=$_REQUEST["op"]; 

if ($_REQUEST["id"]){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( IsNumber($id) == 0){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}


$postArticle_title=trim($_POST["article_title"]);
$postArticle_from=trim($_POST["article_from"]);
$postArticle_order=$_POST["article_order"];
$postArticle_key=trim($_POST["article_key"]);
$postColumns_id=$_POST["columns"];
$postBase_id=$_POST["base"];
$unit=$_POST["unit"];
$department=$_POST["department"];
$person=$_POST["person"];
$person_tel=trim($_POST["person_tel"]);
$guide=trim($_POST["guide"]);
//文章内容
$workContent=$_POST["work_content"];
$workContent=htmlspecialchars($workContent); 
//echo $workContent;exit;
//添加

if($op=="add"){
	//添加文章表
	$sfindAllRec="INSERT INTO work (article_title,article_from,article_time,click_count,article_order,article_key,columns_id,base_id,unit,department,person,person_tel,guide) VALUES ('$postArticle_title','$postArticle_from',now(),'0','$postArticle_order','$postArticle_key','$postColumns_id','$postBase_id','$unit','$department','$person','$person_tel','$guide') ";
	$mysqldao->insertRec($sfindAllRec);
	$iArticleId=mysql_insert_id();

	//添加文章内容表
 
	$sfindAllRec="INSERT INTO work_content (work_id,work_content) VALUES ('$iArticleId','$workContent') ";
	$mysqldao->insertRec($sfindAllRec);


	$sReturnInfo="添加完成！";
	
	
}else if($op=="mod"){
	//先赋初值为0
	$article_id = 0;
	//只有存在该参数情况时才从URL取值

	
	//修改文章表
	$upQuery="UPDATE work SET article_title='$postArticle_title',article_from='$postArticle_from',article_order='$article_order',article_key='$postArticle_key',columns_id='$postColumns_id',base_id='$postBase_id',unit='$unit',department='$department',person='$person',person_tel='$person_tel',guide='$guide' WHERE article_id=$id";
	$mysqldao->updateRec($upQuery);


	//修改文章内容表	
	$sfindAllRec="UPDATE work_content SET work_content='$workContent' WHERE work_id='$id'";
	$mysqldao->updateRec($sfindAllRec);

	

	$sReturnInfo="修改完成！";

	
}else if($op=="del"){

	//删除文章表
	$sfindAllRec="delete from work WHERE article_id='$id'";
	$mysqldao->deleteRec($sfindAllRec);
	
	//删除文章内容表
	$sfindAllRec="delete from work_content WHERE work_id='$id'";
	$mysqldao->deleteRec($sfindAllRec);
	

	$sReturnInfo="删除完成！";
	
}else{
	die("错误的操作参数！");
}




GoToPage("article_list.php?",$sReturnInfo);

?>