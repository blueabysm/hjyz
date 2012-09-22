<?php include("database/mysqlDAO.php")?>
<?php include("functions.php")?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$article_title?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<style type="">
  .footer { width:970px; height:auto; margin-left:auto; margin-right:auto;overflow:hidden;}
  .copyright { width:970px; text-align:center; height:95px; margin-left:auto; margin-right:auto;background: url(../images/bottom_bg.gif) repeat-x; overflow:hidden; padding-top:15px;color: #000;}
</style>
</head>
<body>
<?php showZybjlmById($mysqldao,2); ?>
</body>
</html>