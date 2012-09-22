<?php
require('../database/mysqlDAO.php');
class DBManager
{
    var $dbHost = '';
    var $dbUser = '';
    var $dbPassword = '';
    var $dbSchema = '';
    
    function __construct($host,$user,$password,$schema)
    {
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPassword = $password;
        $this->dbSchema = $schema;
    }
    
    function createFromFile($sqlPath,$delimiter = '(;\n)|((;\r\n))|(;\r)',$prefix = '',$commenter = array('#','--'))
    {
        //判断文件是否存在
        if(!file_exists($sqlPath))
            return false;
        
        $handle = fopen($sqlPath,'rb');    
        
        $sqlStr = fread($handle,filesize($sqlPath));
        $sqlStr=str_replace("\r","\n",$sqlStr);
        //通过sql语法的语句分割符进行分割
        $segment = explode(";\n",trim($sqlStr)); 
        
        //var_dump($segment);
        
        //去掉注释和多余的空行
        foreach($segment as & $statement)
        {
		
		    //echo $statement.' <hr>';
            $sentence = explode("\n",$statement);
            
            $newStatement = array();
            
            foreach($sentence as $subSentence)
            {
                if('' != trim($subSentence))
                {
                    //判断是会否是注释
                    $isComment = false;
                    foreach($commenter as $comer)
                    {
                        if(eregi("^(".$comer.")",trim($subSentence)))
                        {
                            $isComment = true;
                            break;
                        }
                    }
                    //如果不是注释，则认为是sql语句
                    if(!$isComment)
                        $newStatement[] = $subSentence;                    
                }
            }
            
            $statement = $newStatement;
        }
        //对表名加前缀
        if('' != $prefix)
        {
            
        
            //只有表名在第一行出现时才有效 例如 CREATE TABLE talbeName
    
            $regxTable = "^[\`\'\"]{0,1}[\_a-zA-Z]+[\_a-zA-Z0-9]*[\`\'\"]{0,1}$";//处理表名的正则表达式
            $regxLeftWall = "^[\`\'\"]{1}";
            
            $sqlFlagTree = array(
                    "CREATE" => array(
                            "TABLE" => array(
                                    "$regxTable" => 0
                                )
                        ),
                    "INSERT" => array(
                            "INTO" => array(
                                "$regxTable" => 0
                            )
                        )
                    
                    );
                            
            foreach($segment as & $statement)
            {
                $tokens = split(" ",$statement[0]);
                
                $tableName = array();
                $this->findTableName($sqlFlagTree,$tokens,0,$tableName);
                
                if(empty($tableName['leftWall']))
                {
                    $newTableName = $prefix.$tableName['name'];
                }
                else{
                    $newTableName = $tableName['leftWall'].$prefix.substr($tableName['name'],1);
                }
                
                $statement[0] = str_replace($tableName['name'],$newTableName,$statement[0]);
            }
            
        }        
        //组合sql语句
        foreach($segment as & $statement)
        {
            $newStmt = '';
            foreach($statement as $sentence)
            {
                $newStmt = $newStmt.trim($sentence)."\n";
            }
                
            $statement = $newStmt;
        }
        
        //用于测试------------------------        
        //var_dump($segment);
        //writeArrayToFile('data.txt',$segment);
        //-------------------------------
        
        self::saveByQuery($segment);
        
        return true;
    }
    
    private function saveByQuery($sqlArray)
    {
        $conn = mysql_connect($this->dbHost,$this->dbUser,$this->dbPassword);
        
        mysql_select_db($this->dbSchema);
        mysql_query("set names 'utf8'");
        foreach($sqlArray as $sql)
        {
            mysql_query($sql);
        }        
        mysql_close($conn);
    }
    
    private function findTableName($sqlFlagTree,$tokens,$tokensKey=0,& $tableName = array())
    {
        $regxLeftWall = "^[\`\'\"]{1}";
        
        if(count($tokens)<=$tokensKey)
            return false;        
        
        if('' == trim($tokens[$tokensKey]))
        {
            return self::findTableName($sqlFlagTree,$tokens,$tokensKey+1,$tableName);
        }
        else
        {
            foreach($sqlFlagTree as $flag => $v)
            {    
                if(eregi($flag,$tokens[$tokensKey]))
                {
                    if(0==$v)
                    {
                        $tableName['name'] = $tokens[$tokensKey];
            
                        if(eregi($regxLeftWall,$tableName['name']))
                        {
                            $tableName['leftWall'] = $tableName['name']{0};
                        }
                        
                        return true;
                    }
                    else{
                        return self::findTableName($v,$tokens,$tokensKey+1,& $tableName);
                    }
                }
            }
        }
        
        return false;
    }
}

function writeArrayToFile($fileName,$dataArray,$delimiter="\r\n")
{
    $handle=fopen($fileName, "wb");
    
    $text = '';
    
    foreach($dataArray as $data)
    {
        $text = $text.$data.$delimiter;
    }
    fwrite($handle,$text);
}

@set_time_limit(1000);

if(file_exists("install.off"))
{
	echo"《E21教育管理信息系统》安装程序已锁定。如果要重新安装，请删除<b>/installs/install.off</b>文件！";
	exit();
}
$ecn=$_GET['ecn'];
if(empty($ecn))
{
	$ecn=$_POST['ecn'];
}

$ok=$_GET['ok'];
if(empty($ok))
{
	$ok=$_POST['ok'];
}
$f=$_GET['f'];
if(empty($f))
{
	$f=$_POST['f'];
}
if(empty($f))
{
	$f=1;
}
$font="f".$f;
$$font="red";
//处理
if($ecn=="setdb"&&$ok)
{
	//安装
	$dbM = new DBManager(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$dbM->createFromFile('e21jyzw2.sql',';\r\n','');
}
$shorttag=ini_get('short_open_tag');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>E21教育管理信息系统</title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="C9F1FF" leftmargin="0" topmargin="0">
<?php
if(!$shorttag)
{
?>
<br>
<br><br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td height="25" class="header"><div align="center"><strong><font color="#FFFFFF">错误提示</font></strong></div></td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td height="25">您的PHP配置文件php.ini配置有问题，请按下面操作即可解决：</td>
        </tr>
        <tr>
          <td height="25">1、修改php.ini，将：short_open_tag 设为 On</td>
        </tr>
        <tr>
          <td height="25">2、修改后重启apache/iis方能生效。</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php
	echo"</body></html>";
	exit();
}
?>
<table width="776" height="100%" border="0" align="center" cellpadding="6" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td width="21%" rowspan="3" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center"><a href="http://www.e21.cn/" target="_blank"><img src="http://www.e21.cn/images/logo.gif" width="170" height="72" border="0"></a></div></td>
        </tr>
      </table>
      <br> 
	  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25"><strong>安装进程</strong></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr> 
                <td>1、<font color="<?php echo $f1;?>">阅读用户使用条款</font></td>
              </tr>
              <tr> 
                <td>2、<font color="<?php echo $f2;?>">创建数据库</font></td>
              </tr>
              <tr> 
                <td>3、<font color="<?php echo $f3;?>">安装完毕</font></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td><div align="center"><strong><font color="#0000FF" size="3">想到即可做到 - E21教育管理信息系统</font></strong></div></td>
  </tr>
  <tr> 
    <td valign="top"> 
      <?php
	//安装完毕
	if($ecn=="setdb")
	{

	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="index.php?ecn=success&ok=1&f=3">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">第二步：创建数据库</font></strong></div></td>
          </tr>
          <tr> 
            <td height="300"> <div align="center"> 
                <table width="92%" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td bgcolor="#FFFFFF"> <div align="center"> 
                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                          <tr> 
                            <td height="42"> <div align="center"><font color="#FF0000"> 
                                <?php echo '创建数据库成功！';?>
                                </font></div></td>
                          </tr>
                        </table>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <input type="button" name="Submit52223" value="上一步" onclick="javascript:history.go(-1);">
                &nbsp;&nbsp; 
                <input type="submit" name="Submit62222" value="下一步">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
	  }
	//安装完毕
	elseif($ecn=="success")
	{
        chmod(getcwd(), 0777);
		//锁定安装程序
		$fp=@fopen("install.off","w");
		@fclose($fp);
		$word='恭喜您！您已成功安装E21教育管理系统．';
		if($_GET['defaultdata'])
		{
			$word='恭喜您！您已成功安装E21教育管理系统．<br>请继续操作初始化内置数据(看安装说明第三大步)。';
		}
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">第三步：安装完毕</font></strong></div></td>
          </tr>
          <tr> 
            <td height="100"> <div align="center"> 
                <table width="92%" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td bgcolor="#FFFFFF"> <div align="center"> 
                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                          <tr> 
                            <td height="42"> <div align="center"><font color="#FF0000"> 
                                <?php echo $word;?>
								<br>
								后台用户名：admin;密码：admin;(请登陆后修改)
                                </font></div></td>
                          </tr>
                          <tr> 
                            <td height="30"> <div align="center">(友情提示：请马上删除/installs目录，以避免被再次安装.)</div></td>
                          </tr>
                          <tr> 
                            <td height="42"> <div align="center"> 
                                <input type="button" name="Submit82" value="进入后台控制面板" onclick="javascript:self.location.href='../manage'">
                              </div></td>
                          </tr>
                          <tr> 
                            <td height="25"> <div align="center" style="DISPLAY:none"><?=InstallSuccessShowInfo()?></div></td>
                          </tr>
                        </table>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> </div></td>
          </tr>
        </form>
      </table>
      <?php
	}
	//条款
	else
	{
	?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form name="form1" method="post" action="">
          <tr class="header"> 
            <td height="25"> <div align="center"><strong><font color="#FFFFFF">第一步：E21用户许可协议</font></strong></div></td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"> <div align="center"> 
                <table width="100%" height="350" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td><div align="center"> 
                        <IFRAME frameBorder=0 name=xy scrolling=auto src="xieyi.html" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:2"></IFRAME>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <input type="button" name="Submit5" value="我不同意" onclick="window.close();">
				                &nbsp;&nbsp; 
				<input type="button" name="Submit6" value="我同意" onclick="javascript:self.location.href='index.php?ecn=setdb&ok=1&f=2';">
              </div></td>
          </tr>
        </form>
      </table>
      <?php
		}
		?>
    </td>
  </tr>
  <tr> 
    <td valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td><hr align="center"></td>
        </tr>
        <tr> 
          <td height="36"> <div align="center">Ｅ21 版权所有<BR>
              <font face="Arial, Helvetica, sans-serif">Copyright &copy; 2011 
              - 2012<b> <a href="http://www.e21.cn"><font color="#000000">e21</font><font color="#FF6600">.cn</font></a></b></font></div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
