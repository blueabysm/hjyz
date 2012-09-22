<?php
session_start();
include_once("../config/config.inc.php");
include_once("../util/commonFunctions.php");
canAcesssThisPage(0);

include_once("../database/mysqlDAO.php");
include("adminLeftClass.inc.php");

$myPageClass = new adminLeftClass($mysqldao);
$myPageClass->Page_Load();
/* if(strlen($myPageClass->errorMessage)>=1){
	echo "<script>";
  	echo "window.alert('".$myPageClass->errorMessage."');";  	
  	echo "</script>";
}
if(strlen($myPageClass->toURL)>=1){
	echo "<script>";
  	echo "window.location='$myPageClass->toURL';";
  	echo "</script>";
} */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=WEB_SITE_NAME?></title>
	<link rel="stylesheet" type="text/css" href="../lib/jquery-easyui-1.2.2/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../lib/jquery-easyui-1.2.2/themes/icon.css">
	<script type="text/javascript" src="../lib/jquery-easyui-1.2.2/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="../lib/jquery-easyui-1.2.2/jquery.easyui.min.js"></script>
	<link href="manage.css" rel="stylesheet" type="text/css">
	<style>
		.panel-body{
			background:#f0f0f0;
		}
		.panel-header{
			background:#fff url('images/panel_header_bg.gif') no-repeat top right;
		}
		.panel-tool-collapse{
			background:url('images/arrow_up.gif') no-repeat 0px -3px;
		}
		.panel-tool-expand{
			background:url('images/arrow_down.gif') no-repeat 0px -3px;
		}
	</style>
	<script>		
		function ShowSubMenu(SubMenuID)
		{
			SubMenu = eval("SubMenu" + SubMenuID);
			if (SubMenu.style.display == "none")
			{
			  eval("SubMenu" + SubMenuID + ".style.display=\"\";");
			}
			else
			{
			  eval("SubMenu" + SubMenuID + ".style.display=\"none\";");
			}
		}
		
		function addTab(name,_url){
			var tt = $('#tabs');
	    	if (tt.tabs('exists', name)){
		    	tt.tabs('select', name);
		    	refreshTab({tabTitle:name,url:_url});
	    	} else {			
				tt.tabs('add',{
					title:name,
					content:'<iframe src="'+_url+'" width="100%" height="100%" frameborder="0"></iframe>',
					iconCls:'icon-default',
					closable:true
				});
				//for ie6
				refreshTab({tabTitle:name,url:_url});
	    	}
		}
		function refreshTab(cfg){
			var refresh_tab = cfg.tabTitle?$('#tabs').tabs('getTab',cfg.tabTitle):$('#tabs').tabs('getSelected');
			if(refresh_tab && refresh_tab.find('iframe').length > 0){
			var _refresh_ifram = refresh_tab.find('iframe')[0];
			var refresh_url = cfg.url?cfg.url:_refresh_ifram.src;
			//_refresh_ifram.src = refresh_url;
			_refresh_ifram.contentWindow.location.href=refresh_url;
			}
		}
	</script>
</head>
<body class="easyui-layout">
	<div region="west" split="true" title="系统菜单" style="width:157px;height:auto;background:#7190e0;padding:5px;">
	 
<?php											 
			  for($i=0;$i<count($myPageClass->mainMenuList);$i++)
			  {
	    ?>
	    
		
	  <table width="140" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff">
			<tr>
				<td background="images/MenuBG.gif" class="MainMenuText"  style="color:#15428b;height: 25px" onclick="ShowSubMenu(<?php echo $myPageClass->mainMenuList[$i]["menu_id"]?>)">
					&nbsp;<?php echo $myPageClass->mainMenuList[$i]["menu_name"];?>
				</td>
			</tr>
			<tr>
				<td valign="middle" bgcolor="#f0f0f0" class="SubMenuText" id="SubMenu<?php echo $myPageClass->mainMenuList[$i]["menu_id"]?>">
				    <?php 
				    for($j=0;$j<count($myPageClass->subMenuList);$j++)
				    {
				    	if ($myPageClass->subMenuList[$j]["pid"] == $myPageClass->mainMenuList[$i]["menu_id"]){
				    		echo '&nbsp;&nbsp;<a href="javascript:void(0)" class="SubMenuText" onclick=\'addTab("'.$myPageClass->subMenuList[$j]["menu_name"].'","'.$myPageClass->subMenuList[$j]["menu_url"].'")\'>'.$myPageClass->subMenuList[$j]["menu_name"]."</a><br>\n";
				    		
				    	}
				     }	
				    ?>
				</td>
			</tr>
		</table>
		<br>
		<?php
			  } 
		?>
		
	</div>
	<div region="center" title="欢迎你： “<?php echo $_SESSION["sess_user_realname"]?>” [<a href='logout.php'>退出</a>]　<a href='../' target='_blank'>网站前台</a>" style="height:100%">
	
		<div id="tabs" class="easyui-tabs" border="false" fit="true" >
		  <div title="欢迎使用" style="padding:20px;" iconCls='icon-default'>
		    <iframe src="blank.php" width="100%" height="100%" frameborder="0"></iframe>
		  </div>
		</div>
	
	</div>
</body>
</html>