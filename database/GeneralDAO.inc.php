<?php

/**
*　mysql数据库访问类
* @author	王雷(xpf66@163.com)
* @version	0.6
* @date		2010/04/09 09:45
*/
class MySQL_DAO{
	
	/**
	 * mysql服务器地址 如果不是默认端口号请以IP:端口号方式
	 * @var string
	 */
	public $mysql_server;
	
	/**
	 * mysql用户名
	 * @var string
	 */
	public $mysql_user;
	
	/**
	 * mysql用户密码
	 * @var string
	 */
	public $mysql_user_pwd;
	
	/**
	 * mysql数据库名
	 * @var string
	 */
	public $mysql_db_name;	
	
	/**
	 * mysql数据库连接ID 	 
	 */
	public $mysql_conn_id;
	
	/**
	 *SQL语句执行后影响的行数	 
	 */
	public $a_rows;
	
	/**
	 * 存放错误信息
	 * @var string
	 */
	public $error_message;
	
	/**
	 * SQL格式化出错的提示信息
	 * @var string
	 */
	const FORMAT_SQL_ERROR = "格式化sql语句失败";
	
	/**
	 * 总页数mysql_insert_id
	 * @var string
	 */
	public $page_amount;
	
	/**
	 * 新添加的自动编号id
	 * @var string
	 */
	public $mysql_insert_id;
	
	/**
	 * MySQL_DAO类的构造函数
	 * @param $server mysql服务器地址 如果不是默认端口号请以IP:端口号方式
	 * @param $user mysql用户名
	 * @param $pwd mysql用户密码	
	 */
	function MySQL_DAO($server,$user, $pwd)
	{
		$this->mysql_server = $server;
		$this->mysql_user = $user;
		$this->mysql_user_pwd = $pwd;
	}
	
	/**
	 * 打开mysql数据库连接
	 * @return 如果无法打开则返回-1	 	
	 */
	function openConn()
	{
		$this->mysql_conn_id = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_user_pwd);
		if ($this->mysql_conn_id == FALSE)
		{
			$this->error_message = mysql_error(); 
			return -1;
		}
		return 1;
	}
	
	/**
	 * 关闭数据库连接	 
	 */
	function closeConn()
	{
		mysql_close($this->mysql_conn_id);		
	}
	
	/**
	 * 选择数据库
	 * @return 如果无法选择指定数据库返回-1	 	
	 */
	function selectDB($dbName = NULL)
	{
		if ($dbName != NULL)
		{
			$this->mysql_db_name = trim($dbName);
		}
		if (strlen($this->mysql_db_name) <= 0) return -1;
		if (mysql_select_db($this->mysql_db_name,$this->mysql_conn_id) == false)
		{
			$this->error_message = mysql_error();
			return -1;
		}
		mysql_query("set names 'utf8'", $this->mysql_conn_id);
		return 1;
	}
	
	/**
	 * 查找一行数据
	 * @param $sqlstr sql语句
	 * @param $args sql语句中的参数数组 例:select age from table where name='%%s' %%s即为要格式化的参数
	 * @return 执行不成功返回-1
	 */
	function findOneRec($sqlstr,$args = NULL)
	{		
		$query = $this->formatSQL($sqlstr,$args);
		
		if ($query == -1)
		{	
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}
		$result = mysql_query($query, $this->mysql_conn_id);
		$this->a_rows = mysql_affected_rows();
		if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}		
		$rowCount = mysql_num_rows($result);		
		if ($rowCount > 0)
		{
			$data = mysql_fetch_array($result);
			return $data;
		}
		return -1;
	}	
	/**
	 * 查找一个字段
	 * @param $sqlstr sql语句
	 * @param $args sql语句中的参数数组 例:select age from table where name='%%s' %%s即为要格式化的参数
	 * @return 执行不成功返回-1
	 */
    function findOneField ($sqlstr,$args = NULL)
	{		
		$query = $this->formatSQL($sqlstr,$args);
		if ($query == -1)
		{	
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}		
		$result = mysql_query($query, $this->mysql_conn_id);
		if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}		
		$rowCount = mysql_num_rows($result);		
		if ($rowCount > 0)
		{
			$data = mysql_fetch_array($result);
			return $data[0];
		}
		return -1;
	}
		
	/**
	 * 查找多行数据
	 * @param $sqlstr语句
	 * @param $args sql语句中的参数
	 * @return 执行不成功返回-1
	 */
	function findAllRec($sqlstr,$args = NULL)
	{
		$query = $this->formatSQL($sqlstr,$args);		
		if ($query == -1)
		{
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}
		$result = mysql_query($query, $this->mysql_conn_id);
		if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}

		$data = array();
        while($row = mysql_fetch_array($result))
        {
        	$data[] = $row;
        }
        return $data;
          
    }
    
/**
	 * 按页数查找多行数据
	 * @param $sqlstr语句
	 * @param $to_page 要到达的页
	 * @param $page_rows 一页的条数
	 * @param $args sql语句中的参数
	 * @return 执行不成功返回-1
	 */
	function findAllRecByPage($sqlstr,$to_page,$page_rows,$args = NULL)
	{
		$query = $this->formatSQL($sqlstr,$args);
		
		if ($query == -1)
		{
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}
		
		$total=mysql_num_rows(mysql_query($query, $this->mysql_conn_id));//查询数据的总条数
        $this->page_amount = ceil($total/$page_rows); //获得总页数
        if ($to_page <1){
        	$to_page = 1;
        } else if ($to_page > $this->page_amount){
        	$to_page = $this->page_amount;
        }
        $offset=($to_page-1)*$page_rows;
		$result = mysql_query($query." limit $offset,$page_rows", $this->mysql_conn_id);
		if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}

		$data = array();
        while($row = mysql_fetch_array($result))
        {
        	$data[] = $row;
        }
        return $data;
          
    }
    
    /**
	 * 插入一条数据
	 * @param $sqlstr语句
	 * @param $args sql语句中的参数
	 * @return 执行不成功返回-1
	 */
    function insertRec($sqlstr,$args = NULL)
    {
    	$query = $this->formatSQL($sqlstr,$args);
		if ($query == -1)
		{
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}
    	$result = mysql_query($query, $this->mysql_conn_id);
		$this->mysql_insert_id =  mysql_insert_id(); 
		
    	$this->a_rows = mysql_affected_rows();
    	if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}
        return mysql_affected_rows();
    }

    /**
     * 获取刚刚插入记录的自增字段值
     * @return unknown_type
     */
    function getNewInsertID()
    {
    	return $this->mysql_insert_id;    	
    }
    
	/**
	 * 更新数据
	 * @param $sqlstr语句
	 * @param $args sql语句中的参数
	 * @return 执行不成功返回-1
	 */
    function updateRec($sqlstr,$args = NULL)
    {
    	$query = $this->formatSQL($sqlstr,$args);		
		if ($query == -1)
		{
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}		
    	$result = mysql_query($query, $this->mysql_conn_id);
    	$this->a_rows = mysql_affected_rows();
    	if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}
        return mysql_affected_rows();
    }
    
	/**
	 * 删除数据
	 * @param $sqlstr语句
	 * @param $args sql语句中的参数
	 * @return 执行不成功返回-1
	 */
    function deleteRec($sqlstr,$args = NULL)
    {
    	$query = $this->formatSQL($sqlstr,$args);
		if ($query == -1)
		{
			$this->error_message = $this->FORMAT_SQL_ERROR;
			return -1;
		}
    	$result = mysql_query($query, $this->mysql_conn_id);
    	$this->a_rows = mysql_affected_rows();	
    	if ($result == false){
			$this->error_message = mysql_error();
			return -1;
		}
        return mysql_affected_rows();
    }
	
	/**
	 * 格式化一个SQL语句
	 * @param $sqlstr 原始SQL语句 例:select age from table where name='%%s'
	 * @param $args 参数
	 * @return 格式化后的字符串，格式化失败返回-1
	 */
	function formatSQL($sqlstr,$args)
	{
		$tmpstr = $sqlstr;
		$len = strlen($tmpstr); 
		if ( $len<= 0) return -1;
		if ($args == NULL) return $tmpstr;
		if ( (is_array($args) == false) || (count($args) == 0) || ($len < 4)) return -1;
		foreach ($args as $nowArgs)
		{
			$ipos = strpos($tmpstr,'%%s');
			if ($ipos === false) return -1;
			$nowArgs = mysql_real_escape_string($nowArgs);
			if ($nowArgs == false) return -1;
			if ($ipos == 0)
			{
				$tmpstr = $nowArgs . substr($tmpstr,$ipos + 3);
			}
			else
			{
				$tmpstr = substr($tmpstr,0,$ipos) . $nowArgs . substr($tmpstr,$ipos + 3);
			}
			
		}
		
		return $tmpstr;
	}
	
	/**
	 * MySQL_DAO 类析构函数
	 */
	function __destruct()
	{
		mysql_close($this->mysql_conn_id);
	}
	
}  
?>