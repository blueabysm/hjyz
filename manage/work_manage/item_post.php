<?


session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(22);

include_once("../../database/mysqlDAO.php");
$op = $_REQUEST["op"];
$id = $_REQUEST["id"];
$columns_name = $_REQUEST["columns_name"];
$columns_handle = $_REQUEST["columns_handle"];
$columns_pid = $_REQUEST["pid"];

if($op=="add"){
		//检查handle是否重复
	$findAllRec="select count(columns_id) from work_columns where columns_handle='$columns_handle'";
	$isBeing=$mysqldao->findOneRec($findAllRec);
	$isBeing = $isBeing[0];

	if($bIsBeing){
		$sReturnInfo="栏目handle重复！添加失败！";
	}else{
		$findAllRec="INSERT INTO work_columns (columns_name,columns_handle,columns_pid) VALUES ('$columns_name','$columns_handle','$columns_pid') ";
		$mysqldao->insertRec($findAllRec);
	
		$returnInfo="添加完成！";
	}
}
if($op=="mod"){
		//检查handle是否重复
	$findAllRec="select count(columns_id) from work_columns where columns_handle='$columns_handle' and columns_id<>'$iOpId'";
	$isBeing=$mysqldao->findOneRec($findAllRec);
	$isBeing = $isBeing[0];

	if($bIsBeing){
		$sReturnInfo="栏目handle重复！修改失败！";
	}else{
		$findAllRec="UPDATE work_columns SET columns_name='$columns_name',columns_handle='$columns_handle' WHERE  columns_id='$id'";
		$mysqldao->updateRec($findAllRec);
	
		$sReturnInfo="修改完成！";
	}
}
if($op=="del"){
	$findAllRec="DELETE FROM work_columns  WHERE  columns_id='$id'";
	$mysqldao->deleteRec($findAllRec);

	$sReturnInfo="已删除！";
}
GoToPage("item_list_manage.php",$returnInfo);
?>