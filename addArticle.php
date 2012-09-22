<?php
session_start();
header('Content-Type:text/html;charset=UTF-8');
include("database/mysqlDAO.php");
include("functions.php");
include("fckeditor/fckeditor.php") ;

$isReturnToEdit = false;
$article_title = '';
$article_author  = '';
$article_tel = '';
$email = '';
$article_content = '';
$msg='';


function doPost(){
	global $isReturnToEdit;
	global $_POST;
	global $article_title;
	global $article_author;
	global $article_tel;
	global $email;
	global $article_content;
	global $msg;
	global $mysqldao;
	
	$sessYzm = $_SESSION['sessRandomNumber'];
	
	$yzm = $_POST['yzm'];
	$article_title = strip_tags($_POST['article_title']);
	$article_author  = strip_tags($_POST['article_author']);
	$article_tel = strip_tags($_POST['article_tel']);
	$email = strip_tags($_POST['article_email']);
	$article_content = $_POST['article_content'];
	
	$len = strlen($yzm);
	if (($len<4) || ($len>4) || ($yzm != $sessYzm) ){
		$msg = '验证码错误';
		$isReturnToEdit = true;
		return;
	}
	$len = strlen($article_title);
	if (($len<1) || ($len>60)){
		$msg = '标题为空或太长(1-60)';
		$isReturnToEdit = true;
		return;
	}
	$len = strlen($article_author);
	if (($len<1) || ($len>50)){
		$msg = '姓名为空或太长(1-25)';
		$isReturnToEdit = true;
		return;
	}
	$len = strlen($article_tel);
	if (($len<1) || ($len>30)){
		$msg = '电话为空或太长(1-30)';
		$isReturnToEdit = true;
		return;
	}
	$len = strlen($email);
	if ($len>90){
		$msg = '电子邮箱为空或太长(1-90)';
		$isReturnToEdit = true;
		return;
	}
	
    //内容预处理
	$ip = 'http://'.$_SERVER['SERVER_ADDR'];
	if ($_SERVER['SERVER_PORT'] != 80){
		$ip = $ip.':'.$_SERVER['SERVER_PORT'];
	}
	$ip = $ip.'/';
	$article_content = str_replace($ip,'/',$article_content);
	$article_content = str_replace(WEB_DOMAIN_NAME,'',$article_content);
	if(get_magic_quotes_gpc()){
		$this->article_content=stripslashes($this->article_content);
	}
	$article_content = htmlspecialchars($article_content);

	$article_from = ONLINE_ADD_ARTICLE_FROM_NAME.' ('.$article_tel.' '.$email.')';
	
	$sqlstr = 'insert into article(item_id,article_time,article_state,comments_type,article_title,article_from,article_ath) values(' .
				ONLINE_ADD_ARTICLE_COLUMN_ID.",now(),3,1,'%%s','%%s','%%s');";			
	$mysqldao->insertRec($sqlstr,array($article_title,$article_from,$article_author));
	
	$tmpstr = $mysqldao->getNewInsertID();		
	$sqlstr = "insert into article_content(article_id,article_content) values(" .
				"$tmpstr,'%%s');";
	$args= array($article_content);			
	$mysqldao->insertRec($sqlstr,$args);
	echo '<script>alert("投稿已成功，请等待审核！");window.location="index.php";</script>';
	exit;	
}

//如果是提交
if(isset($_POST["btnSubmit"])){
	doPost();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
<script>
	function isNull(str){
	    if ( str == "" ) return true;
	    var regu = "^[ ]+$";
	    var re = new RegExp(regu);
	    return re.test(str);
	}
	
	function check(){
	    var article_title=document.getElementById("article_title").value;
	    var article_author=document.getElementById("article_author").value;
	    var article_tel=document.getElementById("article_tel").value;
	    var yzm=document.getElementById("yzm").value;//验证码;
	
	    var oEditor = FCKeditorAPI.GetInstance("content");	    
	    var tmpstr = oEditor.GetXHTML(true);  
	
	    if(isNull(article_author)){alert("姓名不能为空"); return false;}
	    if(isNull(article_title)){alert("标题不能为空"); return false;}
	    if(isNull(tmpstr)){alert("内容不能为空"); return false;}
	    if(tmpstr.length<10){alert("内容太短"); return false;}
	    if(isNull(yzm)){alert("请填写验证码"); return false;}
	    
	    document.getElementById("article_content").value=oEditor.GetXHTML(true);
	
	    return true;
	}
	function toNext(){
		document.getElementById("toNext").style.display="";
		document.getElementById("agree").style.display="none";
	}	
</script>
</head>
<body<?php  if ($isReturnToEdit){echo ' onload="toNext()"';}?>>
<div align="center">

<!-- top -->
<?php showZybjlmById($mysqldao,1); ?>
<!-- end top -->

<div class="content" style="width: 1000px">
  <div class="txtline">
    <h2><?=ONLINE_ADD_ARTICLE_FROM_NAME?></h2>
  </div>
  <div class="messsage"></div>
  <div class="information">
   <div id="agree">
   <p>
	  您在使用在线投稿时，请遵循以下规则：
   </p>
   <ul>
     <li>
          <p>一、不得故意损害本网站或他人的合法权利与利益，不得利用在线投稿功能以任何方式直接或者间接的从事违反中华人民共和国法律、国际公约以及社会公德的行为，且不得含有下列内容：</p>
          <ul style="margin-left:20px;">
         	 <li>&nbsp;1、违反宪法确定的基本原则的；</li>
			 <li>&nbsp;2、危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</li>
			 <li>&nbsp;3、损害国家荣誉和利益的；</li>
			 <li>&nbsp;4、煽动民族仇恨、民族歧视，破坏民族团结的；</li>
			 <li>&nbsp;5、破坏国家宗教政策、宣扬邪教和封建迷信的；</li>
			 <li>&nbsp;6、散布谣言，扰乱社会秩序，破坏社会稳定的；</li>
			 <li>&nbsp;7、散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的；</li>
			 <li>&nbsp;8、侮辱或者诽谤他人，侵害他人合法权益的；</li>
			 <li>&nbsp;9、煽动非法集会、结社、游行、示威、聚众扰乱社会秩序的；</li>
			 <li>&nbsp;10、以非法民间组织名义活动的；</li>
			 <li>&nbsp;11、含有法律、行政法规禁止的其他内容的;</li>
          </ul>
     </li>
     <li>二、 在线投稿的文章和观点仅代表作者本人的立场和看法，不代表本网的观点与立场，如涉及损害第三方合法权益的事情,由作者本人承担相关法律责任。</li>
     <li>三、本网有权对网友稿件的内容进行审核，审核通过的才能显示在本网页面中。</li>
     <li>四、本网有权将网友稿件用于其他用途，包括新闻、通讯、电子杂志等应用，文章有版权声明者除外。</li>
   </ul>
    <div align="center">
      <button style="width: 260px" onclick="toNext()">我已阅读并同意以上内容&nbsp;&nbsp;</button>
    </div>   	  
   </div>
   <div id="toNext"  style="display:none">
   <form id="form1" name="form1" action="addArticle.php" onsubmit="return check();" method="post" >
	 <div align="left" style="margin-left: 30px"> 
	 <?php if (strlen($msg)>0){echo '<h3 style="color:red">'.$msg.'</h3>';}?>
	    姓名：<input type="text"  id="article_author" name="article_author" class="input" style="width:130px" maxlength="50" value="<?=$article_author?>"/><font color=red>*</font><br/>
	   文章标题：<input type="text"  id="article_title" name="article_title" class="input" style="width:500px" maxlength="120" value="<?=$article_title?>"/><font color=red>*</font><br/>
	   联系电话：<input type="text"  id="article_tel" name="article_tel" class="input" style="width:99px" maxlength="30"  value="<?=$article_tel?>"/><font color=red>*</font><br/>
	   电子邮件：<input type="text"  id="article_email" name="article_email" class="input" style="width:300px"  maxlength="90"  value="<?=$email?>"/>
	 </div>
	 <div align="left">
	   <?php
          $sBasePath ="fckeditor/" ;
          $oFCKeditor = new FCKeditor('content') ;
          $oFCKeditor->BasePath	= $sBasePath ;
          $oFCKeditor->ToolbarSet="addArticle";
          $oFCKeditor->Width = "800px";
          $oFCKeditor->Height = "450";
          $oFCKeditor->Value = $article_content;
          $oFCKeditor->Create() ;
	   ?>
	   <input type="hidden" name="article_content" id="article_content"/>
	</div>
	<div style="text-align:left">
	        验证码：<input type="text" name="yzm" maxlength="4" id="yzm" class="input" style="width:40px;height:20px"> 
	       <img title="验证码" src="util/gd_admin.php" width="35"  height="18" border="0" align="absbottom"/> 
	       &nbsp; &nbsp;<input type="submit" name="btnSubmit" id="btnSubmit" class="btn2" value="提交">
	</div>
   </form>
   </div>
  </div>
</div> 



<?php include('bottom.php') ?>

</div>
</body>
</html>
