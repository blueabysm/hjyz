<?php
 //取所有栏目名称
 $colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
<script src="js/function.js"></script>
</head>
<body>
<?php include("top.php") ?>