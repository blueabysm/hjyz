<?php
header("Content-type:text/html;charset=UTF-8");
error_reporting(E_ALL & ~E_NOTICE);
/**  
 * @name e21教育政务网站管理系统配置文件
 * 
 * 本文件包含以下配置选项: MySQL设置 ,网站设置
 *
 * @author 王雷
 * @version 2.0
 *  
 */

/** skin */
define('skin', 'skin/web-green/');

// ** MySQL设置  ** //

/** MySQL数据库名 */
define('DB_NAME', 'hjyz');

/** MySQL数据库用户名 */
define('DB_USER', 'hjyz');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'BzFpJ747VbZr');

/** MySQL主机名 */
define('DB_HOST', 'localhost');


// ** 网站设置  ** //

/** 网站名称 */
define('WEB_SITE_NAME', 'hjyz');

/** 网站域名 */
define('WEB_DOMAIN_NAME', 'http://hjyz.zhx.e21.cn');

/** 网站目录名称 */
define('WEB_DIRECTORY_NAME', '/');

/** 上传目录 */
define('WEB_SITE_UPLOAD_DIR', 'html'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR);

/** 上传目录URL */
define('WEB_SITE_UPLOAD_URL', 'html/upload/');

/** 最大栏目深度 */
define('MAX_COLUMNS_DEPTH', 9);

/** 文章评论开关  默认为true 需要关闭时改为 false */
define('ARTICLE_COMMENTS_FLAG', true);

/** 在线投稿中所含文件上传目录名 */
define('ONLINE_ADD_ARTICLE_UPLOAD_DIR_NAME', 'addArticle');

/** 在线投稿功能名称 */
define('ONLINE_ADD_ARTICLE_FROM_NAME', '在线投稿');

/** 在线投稿允许上传的图片类型 */
define('ONLINE_ADD_ARTICLE_COLUMN_ID', 75);

/** 后台允许上传的文件类型 */
define('UPLOAD_FILE_TYPE', 'jpg,gif,png,bmp,txt,doc,xls,zip,rar,ppt,docx,xlsx,pptx,swf');

/** 后台允许上传的图片类型 */
define('UPLOAD_IMAGE_TYPE', 'jpg,gif,png,bmp,swf');
?>