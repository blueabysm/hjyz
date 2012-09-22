/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50018
Source Host           : localhost:3306
Source Database       : e21jyzw2

Target Server Type    : MYSQL
Target Server Version : 50018
File Encoding         : 65001

Date: 2012-03-19 07:45:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `accessory`
-- ----------------------------
DROP TABLE IF EXISTS `accessory`;
CREATE TABLE `accessory` (
  `accessory_id` int(11) NOT NULL auto_increment,
  `article_id` varchar(11) collate utf8_unicode_ci default NULL,
  `accessory_name` varchar(255) collate utf8_unicode_ci default NULL,
  `accessory_info` varchar(255) collate utf8_unicode_ci default NULL,
  `accessory_handle` float(11,3) default NULL,
  `item_id` varchar(11) collate utf8_unicode_ci default NULL,
  `accessory_size` varchar(20) collate utf8_unicode_ci default NULL,
  `accessory_type` varchar(30) collate utf8_unicode_ci default NULL,
  `article_imgid` varchar(100) collate utf8_unicode_ci default NULL,
  `itemo_show` varbinary(100) default NULL,
  PRIMARY KEY  (`accessory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of accessory
-- ----------------------------

-- ----------------------------
-- Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `user_id` int(11) NOT NULL auto_increment COMMENT '记录id',
  `user_name` varchar(16) collate utf8_unicode_ci NOT NULL,
  `user_pwd` varchar(32) collate utf8_unicode_ci NOT NULL COMMENT '用户登录密码',
  `user_type` int(11) NOT NULL default '1',
  `user_realname` varchar(50) collate utf8_unicode_ci NOT NULL,
  `user_state` int(11) NOT NULL default '1',
  `user_sub_id` int(11) NOT NULL default '0',
  `user_company` int(11) NOT NULL default '0',
  `user_part` int(11) NOT NULL default '0',
  `user_phone` varchar(100) collate utf8_unicode_ci default NULL,
  `user_email` varchar(200) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'e21super', '21232f297a57a5a743894a0e4a801fc3', '9', '系统管理员', '1', '0', '0', '0', '027-87212221', 'webmaster@e21.edu.cn');
INSERT INTO `admins` VALUES ('2', 'admin', '21232f297a57a5a743894a0e4a801fc3', '5', '网站管理员', '1', '0', '292', '48', '027-87122221-8825', 'wl2010tw@gmail.com');

-- ----------------------------
-- Table structure for `admins_group`
-- ----------------------------
DROP TABLE IF EXISTS `admins_group`;
CREATE TABLE `admins_group` (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `group_users` varchar(1000) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admins_group
-- ----------------------------

-- ----------------------------
-- Table structure for `answer`
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `answer_id` int(10) NOT NULL auto_increment,
  `question_id` int(11) default NULL COMMENT '对应的问题id',
  `answer_time` date default NULL COMMENT '回答时间',
  `answer_content` text collate utf8_unicode_ci COMMENT '回答内容',
  PRIMARY KEY  (`answer_id`),
  KEY `NewIndex2` (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of answer
-- ----------------------------
INSERT INTO `answer` VALUES ('16', '4397', '2012-03-14', '测试');
INSERT INTO `answer` VALUES ('17', '4405', '2012-03-15', '是这么回事');

-- ----------------------------
-- Table structure for `apply`
-- ----------------------------
DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply` (
  `id` int(11) NOT NULL auto_increment,
  `user_name` varchar(8) collate utf8_unicode_ci default NULL,
  `user_address` varchar(255) collate utf8_unicode_ci default NULL,
  `user_selphone` varchar(30) collate utf8_unicode_ci default NULL,
  `user_phone` varchar(30) collate utf8_unicode_ci default NULL,
  `user_zip` int(13) default NULL,
  `time` datetime default NULL,
  `user_email` varchar(200) collate utf8_unicode_ci default NULL,
  `xm_name` varchar(255) collate utf8_unicode_ci default NULL,
  `xm_produce` varchar(255) collate utf8_unicode_ci default NULL COMMENT '???????',
  `xm_file` varchar(255) collate utf8_unicode_ci default NULL,
  `xm_pass` int(1) default '1' COMMENT '1????? 2?????? 3?????',
  `xm_pass1` int(1) default NULL,
  `finish_date` date default NULL,
  `APPMANDATE` date default NULL,
  `xm_id` int(8) default NULL,
  `remain_date` int(11) default '20',
  `deal_department` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of apply
-- ----------------------------
INSERT INTO `apply` VALUES ('3', '城在', '', '', 'sdfsdsdfsdf', '0', '2012-03-18 20:02:28', '', 'fsdfsdf', 'sdfsdf', '', '2', null, null, null, '3', '20', null);

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL auto_increment COMMENT '文章id',
  `item_id` int(11) default NULL COMMENT '所属栏目id',
  `article_order` int(11) NOT NULL default '100' COMMENT '文章列表显示顺序',
  `article_time` datetime NOT NULL COMMENT '文章发表时间',
  `article_state` int(11) NOT NULL default '5' COMMENT '文章状态 1=正常 2=归档',
  `comments_type` int(11) NOT NULL default '1' COMMENT '评论状态 1=不允许评论2=允许评论须审核才能显示3=允许评论不须审核直接显示',
  `click_count` int(11) NOT NULL default '0' COMMENT '点击次数',
  `article_title` varchar(255) collate utf8_unicode_ci NOT NULL default '' COMMENT '文章标题',
  `article_from` varchar(255) collate utf8_unicode_ci default NULL COMMENT '文章来源',
  `article_ath` varchar(255) collate utf8_unicode_ci default NULL COMMENT '文章作者',
  `article_key` varchar(255) collate utf8_unicode_ci default NULL COMMENT '?????????',
  `img_url` varchar(255) collate utf8_unicode_ci default NULL,
  `s_id` int(11) default '0',
  `user_id` int(11) default '0',
  `back_text` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('8157', '13', '100', '2012-03-14 11:37:27', '1', '1', '8', '测试', '', '', '', '/html/upload/2012/03/14/file1331696954.jpg', '0', '2', null);
INSERT INTO `article` VALUES ('8158', '197', '100', '2012-03-14 11:38:12', '1', '1', '7', '测试专题新闻', '', '', '', '', '0', '2', null);
INSERT INTO `article` VALUES ('8160', '13', '100', '2012-03-14 11:54:26', '1', '1', '14', '测试新闻二', '', '', '', '/html/upload/2012/03/14/file1331698233.jpg', '0', '2', null);
INSERT INTO `article` VALUES ('8162', '205', '100', '2012-03-16 22:17:27', '1', '1', '4', '测试信息公开', '办公室', '政策公开', '测试信息公开', '/html/upload/2012/03/16/file1331907741.jpg', '0', '2', null);

-- ----------------------------
-- Table structure for `article_comments`
-- ----------------------------
DROP TABLE IF EXISTS `article_comments`;
CREATE TABLE `article_comments` (
  `comments_id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL default '0',
  `article_id` int(11) NOT NULL COMMENT '所属文章id',
  `comments_time` datetime default NULL COMMENT '评论发表时间',
  `comments_state` int(11) NOT NULL default '2' COMMENT '评论状态:1=正常2=关闭，不显示',
  `comments_guest_name` varchar(100) collate utf8_unicode_ci default NULL COMMENT '评论人姓名',
  `comments_guest_ip` varchar(25) collate utf8_unicode_ci default NULL COMMENT '评论人ip',
  `comments_title` varchar(255) collate utf8_unicode_ci default NULL COMMENT '评论标题',
  `comments_content` text collate utf8_unicode_ci COMMENT '评论内容',
  PRIMARY KEY  (`comments_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `article_content`
-- ----------------------------
DROP TABLE IF EXISTS `article_content`;
CREATE TABLE `article_content` (
  `article_id` int(11) NOT NULL,
  `article_content` longtext collate utf8_unicode_ci,
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article_content
-- ----------------------------
INSERT INTO `article_content` VALUES ('8160', '&lt;img border=&quot;0&quot; src=&quot;/html/upload/2012/03/14/file1331698233.jpg&quot;&gt;');
INSERT INTO `article_content` VALUES ('8157', '测试 &lt;img border=&quot;0&quot; src=&quot;/html/upload/2012/03/14/file1331696954.jpg&quot;&gt;');
INSERT INTO `article_content` VALUES ('8158', '测试专题新闻');
INSERT INTO `article_content` VALUES ('8162', '&lt;img src=&quot;/html/upload/2012/03/16/file1331907741.jpg&quot; border=&quot;0&quot;&gt;');

-- ----------------------------
-- Table structure for `back_down`
-- ----------------------------
DROP TABLE IF EXISTS `back_down`;
CREATE TABLE `back_down` (
  `back_id` int(11) NOT NULL auto_increment,
  `down_id` int(11) default NULL COMMENT '对应下载记录id',
  `back_unit` varchar(250) collate utf8_unicode_ci default NULL COMMENT '回复单位',
  `back_type` int(11) default NULL COMMENT '审批状态',
  `explain` varchar(1000) collate utf8_unicode_ci default NULL COMMENT '被退回说明',
  PRIMARY KEY  (`back_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of back_down
-- ----------------------------

-- ----------------------------
-- Table structure for `columns`
-- ----------------------------
DROP TABLE IF EXISTS `columns`;
CREATE TABLE `columns` (
  `columns_id` int(11) NOT NULL auto_increment,
  `columns_type_id` int(11) NOT NULL COMMENT '栏目类型id,对应 columns_type 表',
  `admin_id` int(11) NOT NULL COMMENT '栏目管理员id',
  `create_type` int(11) NOT NULL default '0' COMMENT '栏目创建类型 0=系统栏目 1=用户创建栏目 2=程序创建栏目',
  `sites_id` int(11) NOT NULL default '0' COMMENT '站点ID 0=主站 其它=子站ID',
  `columns_handle` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '栏目管理员id',
  `columns_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `columns_title` varchar(100) collate utf8_unicode_ci default NULL,
  `level` int(11) default '0' COMMENT '上级栏目id',
  `sub_id` varchar(1000) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`columns_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns
-- ----------------------------
INSERT INTO `columns` VALUES ('1', '3', '2', '0', '0', 'zybjlm1', '页头', '页头', '1', '');
INSERT INTO `columns` VALUES ('2', '3', '2', '0', '0', 'zybjlm2', '页尾', '页尾', '1', '');
INSERT INTO `columns` VALUES ('190', '5', '2', '1', '0', 'tplblm7', '学校图库－列表', '学校图库－列表', '1', '');
INSERT INTO `columns` VALUES ('4', '1', '2', '0', '0', 'wzlm1', '图库', '图库', '0', '188,190');
INSERT INTO `columns` VALUES ('192', '13', '2', '1', '0', 'xxgk78', '干部人事', '干部人事', '1', '');
INSERT INTO `columns` VALUES ('193', '13', '2', '1', '0', 'xxgk79', '教育收费', '教育收费', '1', '');
INSERT INTO `columns` VALUES ('13', '1', '2', '1', '0', 'wzlm9', '外埠新闻', '外埠新闻', '1', '');
INSERT INTO `columns` VALUES ('14', '1', '2', '1', '0', 'wzlm10', '教育新闻', '教育新闻', '1', '');
INSERT INTO `columns` VALUES ('15', '1', '2', '1', '0', 'wzlm11', '学校新闻', '学校新闻', '1', '');
INSERT INTO `columns` VALUES ('16', '1', '2', '1', '0', 'wzlm12', '教育要闻', '教育要闻', '1', '');
INSERT INTO `columns` VALUES ('17', '1', '2', '0', '0', 'wzlm13', '工作动态', '工作动态', '0', '18,19,21,40,84,85,87,88,89,90,92');
INSERT INTO `columns` VALUES ('18', '1', '2', '1', '0', 'wzlm14', '最新政策', '最新政策', '1', '');
INSERT INTO `columns` VALUES ('19', '1', '2', '1', '0', 'wzlm15', '办事指南', '办事指南', '1', '');
INSERT INTO `columns` VALUES ('21', '1', '2', '1', '0', 'wzlm16', '公示公告', '公示公告', '1', '');
INSERT INTO `columns` VALUES ('22', '3', '2', '1', '0', 'zybjlm3', '大横条图片', '大横条图片', '1', '');
INSERT INTO `columns` VALUES ('23', '3', '2', '1', '0', 'zybjlm4', '信息公开目录分类', '信息公开目录分类', '1', '');
INSERT INTO `columns` VALUES ('24', '11', '2', '0', '0', 'zdlm1', '机构设置', '机构设置', '0', '42,43');
INSERT INTO `columns` VALUES ('25', '11', '2', '0', '0', 'zdlm2', '访问统计', '访问统计', '0', '26,27');
INSERT INTO `columns` VALUES ('26', '11', '2', '0', '0', 'zdlm3', '信息访问量排行', '信息访问量排行', '1', '');
INSERT INTO `columns` VALUES ('27', '11', '2', '0', '0', 'zdlm4', '栏目信息量排行', '栏目信息量排行', '1', '');
INSERT INTO `columns` VALUES ('28', '3', '2', '1', '0', 'zybjlm5', '一站式服务', '一站式服务', '1', '');
INSERT INTO `columns` VALUES ('29', '3', '2', '1', '0', 'zybjlm6', '公众参与', '公众参与', '1', '');
INSERT INTO `columns` VALUES ('30', '3', '2', '1', '0', 'zybjlm7', '便民服务', '便民服务', '1', '');
INSERT INTO `columns` VALUES ('31', '3', '2', '1', '0', 'zybjlm8', '申请公开在线查询', '申请公开在线查询', '1', '');
INSERT INTO `columns` VALUES ('32', '4', '2', '0', '0', 'dclm1', '网上投票', '网上投票', '1', '');
INSERT INTO `columns` VALUES ('35', '11', '2', '0', '0', 'zdlm5', '常见问题', '常见问题', '0', '');
INSERT INTO `columns` VALUES ('34', '10', '2', '0', '0', 'ejljtlm2', '动态导航', '动态导航', '1', '');
INSERT INTO `columns` VALUES ('40', '1', '2', '1', '0', 'wzlm18', '重要通知', '重要通知', '1', '');
INSERT INTO `columns` VALUES ('41', '11', '2', '0', '0', 'zdlm6', '学校领导', '学校领导', '0', '24');
INSERT INTO `columns` VALUES ('42', '11', '2', '0', '0', 'zdlm7', '学校机构', '学校机构', '0', '');
INSERT INTO `columns` VALUES ('43', '11', '2', '0', '0', 'zdlm8', '市直教育单位', '市直教育单位', '1', '');
INSERT INTO `columns` VALUES ('212', '2', '2', '2', '0', 'ljtlm19', '网上办事', '网上办事', '0', '');
INSERT INTO `columns` VALUES ('46', '11', '2', '0', '0', 'zdlm10', '市直学校', '市直学校', '1', '');
INSERT INTO `columns` VALUES ('75', '1', '2', '0', '0', 'wzlm26', '在线投稿', '在线投稿', '1', '');
INSERT INTO `columns` VALUES ('47', '11', '2', '0', '0', 'zdlm11', '民办学校', '民办学校', '1', '');
INSERT INTO `columns` VALUES ('196', '7', '2', '2', '0', 'tphdplm25', '图片幻灯片', '图片幻灯片', '0', '');
INSERT INTO `columns` VALUES ('197', '1', '2', '2', '0', 'wzlm70', '最新消息', '最新消息', '0', '');
INSERT INTO `columns` VALUES ('76', '4', '2', '0', '0', 'dclm2', '网上调查', '网上调查', '1', '');
INSERT INTO `columns` VALUES ('84', '1', '2', '1', '0', 'wzlm27', '学校安全', '学校安全', '1', '');
INSERT INTO `columns` VALUES ('85', '1', '2', '1', '0', 'wzlm28', '扶贫助学', '扶贫助学', '1', '93,94');
INSERT INTO `columns` VALUES ('188', '6', '2', '1', '0', 'tpbglm31', '学校图库', '学校图库', '1', '');
INSERT INTO `columns` VALUES ('89', '1', '2', '1', '0', 'wzlm32', '教育党建', '教育党建', '1', '');
INSERT INTO `columns` VALUES ('90', '1', '2', '1', '0', 'wzlm33', '教育工会', '教育工会', '1', '');
INSERT INTO `columns` VALUES ('91', '1', '2', '0', '0', 'wzlm34', '招生考试', '招生考试', '0', '95,96,97,98,99');
INSERT INTO `columns` VALUES ('92', '1', '2', '1', '0', 'wzlm35', '师生园地', '师生园地', '1', '');
INSERT INTO `columns` VALUES ('93', '1', '2', '1', '0', 'wzlm36', '资助政策', '资助政策', '1', '');
INSERT INTO `columns` VALUES ('94', '1', '2', '1', '0', 'wzlm37', '资助动态', '资助动态', '1', '');
INSERT INTO `columns` VALUES ('95', '1', '2', '1', '0', 'wzlm38', '招生信息', '招生信息', '1', '');
INSERT INTO `columns` VALUES ('96', '1', '2', '1', '0', 'wzlm39', '普通高考', '普通高考', '1', '');
INSERT INTO `columns` VALUES ('97', '1', '2', '1', '0', 'wzlm40', '普通中考', '普通中考', '1', '');
INSERT INTO `columns` VALUES ('98', '1', '2', '1', '0', 'wzlm41', '自学考试', '自学考试', '1', '');
INSERT INTO `columns` VALUES ('99', '1', '2', '1', '0', 'wzlm42', '成人考试', '成人考试', '1', '');
INSERT INTO `columns` VALUES ('6', '1', '2', '0', '0', 'wzlm69', '新闻动态', '新闻动态', '0', '13,14,15,16');
INSERT INTO `columns` VALUES ('195', '8', '2', '1', '0', 'ztlm8', '教育专题', '教育专题', '0', '');
INSERT INTO `columns` VALUES ('198', '3', '2', '2', '0', 'zybjlm34', '专题简介', '专题简介', '0', '');
INSERT INTO `columns` VALUES ('199', '6', '2', '2', '0', 'tpbglm32', '图片', '图片', '0', '');
INSERT INTO `columns` VALUES ('201', '7', '2', '1', '0', 'tphdplm26', '首页幻灯片', '首页幻灯片', '1', '');
INSERT INTO `columns` VALUES ('202', '13', '2', '1', '0', 'xxgk77', '发展规划', '发展规划', '1', '');
INSERT INTO `columns` VALUES ('187', '3', '2', '0', '0', 'zybjlm33', '互动栏目', '互动栏目', '0', '32,75,76');
INSERT INTO `columns` VALUES ('5', '13', '2', '0', '0', 'xxgk70', '信息公开', '信息公开', '0', '192,193,202,205');
INSERT INTO `columns` VALUES ('186', '3', '2', '0', '0', 'zybjlm32', '首页内容区块', '首页内容区块', '0', '1,2,22,23,28,29,30,31,201,34,215,216');
INSERT INTO `columns` VALUES ('205', '13', '2', '1', '0', 'xxgk82', '学生安全', '学生安全', '1', '');
INSERT INTO `columns` VALUES ('206', '2', '2', '2', '0', 'ljtlm13', '首页', '首页', '0', '');
INSERT INTO `columns` VALUES ('207', '2', '2', '2', '0', 'ljtlm14', '机构设置', '机构设置', '0', '');
INSERT INTO `columns` VALUES ('208', '2', '2', '2', '0', 'ljtlm15', '新闻动态', '新闻动态', '0', '');
INSERT INTO `columns` VALUES ('209', '2', '2', '2', '0', 'ljtlm16', '工作动态', '工作动态', '0', '');
INSERT INTO `columns` VALUES ('210', '2', '2', '2', '0', 'ljtlm17', '招生考试', '招生考试', '0', '');
INSERT INTO `columns` VALUES ('211', '2', '2', '2', '0', 'ljtlm18', '信息公开', '信息公开', '0', '');
INSERT INTO `columns` VALUES ('213', '2', '2', '2', '0', 'ljtlm20', '公众互动', '公众互动', '0', '');
INSERT INTO `columns` VALUES ('216', '3', '2', '0', '0', 'zybjlm35', '静态导航', '静态导航', '1', '');

-- ----------------------------
-- Table structure for `columns_html`
-- ----------------------------
DROP TABLE IF EXISTS `columns_html`;
CREATE TABLE `columns_html` (
  `columns_id` int(11) NOT NULL auto_increment,
  `columns_contents` text collate utf8_unicode_ci COMMENT '栏目类容',
  PRIMARY KEY  (`columns_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_html
-- ----------------------------
INSERT INTO `columns_html` VALUES ('1', '&lt;embed style=&quot;width: 1000px; height: 170px&quot; src=&quot;/images/topbanner1.swf&quot; type=application/x-shockwave-flash quality=&quot;high&quot;&gt;');
INSERT INTO `columns_html` VALUES ('2', '&lt;div class=&quot;footer&quot;&gt;\r\n&lt;div class=&quot;footerNav&quot;&gt;\r\n&lt;ul&gt;\r\n&lt;li&gt;| &lt;a href=&quot;#&quot;&gt;地理位置&lt;/a&gt; | \r\n&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;map.php&quot;&gt;网站地图&lt;/a&gt; | \r\n&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#&quot;&gt;网站运维&lt;/a&gt; | &lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;\r\n&lt;div class=&quot;copyright&quot;&gt;主办单位：湖北省钟祥市教育局 承办单位：湖北省钟祥市电化教育馆&lt;br /&gt;通信地址：湖北钟祥市石城大道中路26号　邮政编码：431900 建议使用 IE 7.0 及以上版本浏览器以获得最佳视觉效果 鄂ICP备：&lt;font face=&quot;宋体&quot;&gt;&lt;a href=&quot;http://www.miibeian.gov.cn&quot;&gt;鄂ICP06005900号&lt;/a&gt;&lt;/font&gt;&lt;font face=&quot;宋体&quot;&gt;&amp;nbsp;&lt;/font&gt; &lt;br /&gt;网站电话：0724-4223327　网站信箱：&lt;a href=&quot;mailto:zxjy0724@163.com&quot;&gt;zxjy0724@163.com&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;');
INSERT INTO `columns_html` VALUES ('22', '&lt;div&gt;&lt;img border=&quot;0&quot; src=&quot;/html/6.gif&quot;&gt;&lt;/div&gt;');
INSERT INTO `columns_html` VALUES ('23', '&lt;table border=&quot;0&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;100%&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; align=&quot;middle&quot;&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td align=&quot;middle&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;215&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=01&amp;amp;superior=info_category_query&quot;&gt;教育概况&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=02&amp;amp;superior=info_category_query&quot;&gt;发展规划&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=03&amp;amp;superior=info_category_query&quot;&gt;年度计划&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=04&amp;amp;superior=info_category_query&quot;&gt;干部人事&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=05&amp;amp;superior=info_category_query&quot;&gt;教育收费&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=06&amp;amp;superior=info_category_query&quot;&gt;基础教育&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=07&amp;amp;superior=info_category_query&quot;&gt;职业教育&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=08&amp;amp;superior=info_category_query&quot;&gt;教师管理&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=09&amp;amp;superior=info_category_query&quot;&gt;采购招标&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=10&amp;amp;superior=info_category_query&quot;&gt;财政资金&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=11&amp;amp;superior=info_category_query&quot;&gt;项目建设&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=12&amp;amp;superior=info_category_query&quot;&gt;机关荣誉&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=14&amp;amp;superior=info_category_query&quot;&gt;学校安全&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=15&amp;amp;superior=info_category_query&quot;&gt;教育督导&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=16&amp;amp;superior=info_category_query&quot;&gt;行政执法&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=17&amp;amp;superior=info_category_query&quot;&gt;计财审计&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;2&quot; colSpan=3&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;102&quot;&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=13&amp;amp;superior=info_category_query&quot;&gt;教育信息化&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td&gt;\r\n&lt;table border=&quot;0&quot; cellspacing=&quot;1&quot; cellpadding=&quot;0&quot; width=&quot;102&quot; bgcolor=&quot;#e4dac3&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td bgcolor=&quot;#ffffff&quot; height=&quot;24&quot; align=&quot;middle&quot;&gt;&lt;img src=&quot;/images/icon02.gif&quot; width=&quot;14&quot; height=&quot;7&quot;&gt;&lt;a href=&quot;/xxgk/web/webInfo.do?actionCase=info_more&amp;amp;moreType=infoType&amp;amp;infoSearchBean.infoType=99&amp;amp;superior=info_category_query&quot;&gt;其他&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/td&gt;&lt;/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;5&quot; align=&quot;middle&quot;&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;');
INSERT INTO `columns_html` VALUES ('28', '&lt;table border=&quot;0&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;683&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td width=&quot;162&quot;&gt;&lt;a href=&quot;/&quot;&gt;&lt;img src=&quot;/images/fu01.gif&quot; width=&quot;162&quot; height=&quot;82&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&lt;/td&gt;\r\n&lt;td width=&quot;162&quot;&gt;&lt;a href=&quot;http://www.hbe.gov.cn/yzsfw.php?ms=yd#shengbao&quot;&gt;&lt;img src=&quot;/images/fu02.gif&quot; width=&quot;162&quot; height=&quot;82&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;11&quot;&gt;&lt;/td&gt;\r\n&lt;td width=&quot;162&quot;&gt;&lt;a href=&quot;http://www.hbe.gov.cn/yzsfw.php?ms=gk#shengbao&quot;&gt;&lt;img src=&quot;/images/fu03.gif&quot; width=&quot;162&quot; height=&quot;82&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;12&quot;&gt;&lt;/td&gt;\r\n&lt;td width=&quot;162&quot;&gt;&lt;a href=&quot;http://www.hbe.gov.cn/yzsfw.php?ms=kt#shengbao&quot;&gt;&lt;img src=&quot;/images/fu04.gif&quot; width=&quot;162&quot; height=&quot;82&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;');
INSERT INTO `columns_html` VALUES ('29', '&lt;table border=&quot;0&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;990&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;&lt;img src=&quot;/images/gzcy.gif&quot; width=&quot;64&quot; height=&quot;72&quot;&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;mailbox_index.php&quot;&gt;&lt;img src=&quot;/images/gzcy01.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;question_all_index.php&quot;&gt;&lt;img src=&quot;/images/gzcy02.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a onclick=&quot;openChatWin(\'10002\');&quot; href=&quot;javascript:void(0)&quot;&gt;&lt;img src=&quot;/images/gzcy03.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;addArticle.php&quot;&gt;&lt;img src=&quot;/images/gzcy04.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;surveyMore.php?id=32&quot;&gt;&lt;img src=&quot;/images/gzcy05.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;surveyMore.php?id=76&quot;&gt;&lt;img src=&quot;/images/gzcy06.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;10&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;opinion_subject_index.php&quot;&gt;&lt;img src=&quot;/images/gzcy07.gif&quot; width=&quot;122&quot; height=&quot;72&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;');
INSERT INTO `columns_html` VALUES ('30', '&lt;div class=l_xinxiList&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.jszg.edu.cn/search.jsp&quot;&gt;教师资格证查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://dzda.e21.cn/&quot;&gt;学生学籍查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://cx.e21.cn/&quot;&gt;高考查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://putonghua.027web.cn/&quot;&gt;普通话水平测试&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.hbee.edu.cn/html/cx/index.html&quot;&gt;自修考试查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://zkcx2.jm.e21.cn/&quot;&gt;中考成绩查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.weather.com.cn/weather/101201402.shtml?from=cn&quot;&gt;钟祥天气查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.hao123.com/ss/lccx.htm&quot;&gt;列车时刻查询&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;');
INSERT INTO `columns_html` VALUES ('31', '&lt;table border=&quot;0&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;441&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td height=&quot;55&quot;&gt;&lt;a href=&quot;/&quot;&gt;&lt;img src=&quot;/images/tu03.gif&quot; width=&quot;218&quot; height=&quot;55&quot;&gt;&lt;/a&gt;&lt;/td&gt;\r\n&lt;td width=&quot;5&quot;&gt;&lt;/td&gt;\r\n&lt;td&gt;&lt;a href=&quot;/&quot;&gt;&lt;img src=&quot;/images/tu04.gif&quot; width=&quot;218&quot; height=&quot;55&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;');
INSERT INTO `columns_html` VALUES ('120', '&lt;div&gt;&lt;span style=&quot;font-family: 仿宋_gb2312; font-size: 16pt&quot;&gt;&lt;font size=&quot;4&quot;&gt;&lt;font face=SimSun&gt;&lt;img border=&quot;0&quot; src=&quot;/zx/html/upload/2012/03/13/file1331610792.gif&quot;&gt;“课内比教学，课外访万家”活动是省教育厅今年启动的一项教育教学重点工程&lt;span style=&quot;mso-bidi-font-weight: bold&quot;&gt;，目的是为了&lt;/span&gt;提高教师专业素质，推动课堂教学改革，密切家校、师生关系，全面提升教育教学质量，促进全省教育更好更快地发展。&lt;/font&gt;&lt;/font&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div&gt;&lt;span style=&quot;font-family: 仿宋_gb2312; font-size: 16pt&quot;&gt;&lt;font size=&quot;4&quot;&gt;&lt;font face=SimSun&gt;&lt;/font&gt;&lt;/font&gt;&lt;/span&gt;&amp;nbsp;&lt;/div&gt;\r\n&lt;div&gt;&lt;font size=&quot;4&quot;&gt;湖北省&lt;span style=&quot;font-family: 仿宋_gb2312; font-size: 16pt&quot;&gt;&lt;font size=&quot;4&quot;&gt;&lt;font face=SimSun&gt;“课内比教学”活动专题网站 &lt;/font&gt;&lt;/font&gt;&lt;/span&gt;&lt;a href=&quot;http://knbjx.e21.cn/&quot;&gt;http://knbjx.e21.cn/&lt;/a&gt;&lt;/font&gt;&amp;nbsp;&lt;/div&gt;\r\n&lt;div&gt;&amp;nbsp;&lt;/div&gt;');
INSERT INTO `columns_html` VALUES ('187', '互动栏目');
INSERT INTO `columns_html` VALUES ('198', '专题简介 &lt;img border=&quot;0&quot; src=&quot;/html/upload/2012/03/14/file1331696908.gif&quot;&gt;');
INSERT INTO `columns_html` VALUES ('186', '首页内容区块');
INSERT INTO `columns_html` VALUES ('216', '&lt;div id=menu&gt;\r\n&lt;ul&gt;\r\n&lt;li onmouseout=closeMenu()&gt;&lt;a class=current1 href=&quot;index.php&quot;&gt;首页&lt;/a&gt; \r\n&lt;li onmouseout=&quot;showMenu(\'sub_jgsz\',this)&quot;&gt;&lt;a href=&quot;viewPart.php?id=49&quot;&gt;机构设置&lt;/a&gt; \r\n&lt;li onmouseover=&quot;showMenu(\'sub_xwdt\',this)&quot;&gt;&lt;a href=&quot;article_group.php?id=6&quot;&gt;新闻动态&lt;/a&gt; \r\n&lt;li onmouseover=&quot;showMenu(\'sub_gzdt\',this)&quot;&gt;&lt;a href=&quot;article_group.php?id=17&quot;&gt;工作动态&lt;/a&gt; \r\n&lt;li onmouseout=&quot;showMenu(\'sub_zsks\',this)&quot;&gt;&lt;a href=&quot;article_group.php?id=91&quot;&gt;招生考试&lt;/a&gt; \r\n&lt;li onmouseover=&quot;showMenu(\'sub_xxgk\',this)&quot;&gt;&lt;a href=&quot;xxgk_group.php?id=5&quot;&gt;信息公开&lt;/a&gt; \r\n&lt;li onmouseout=closeMenu()&gt;&lt;a href=&quot;net_work.php&quot;&gt;网上办事&lt;/a&gt; \r\n&lt;li onmouseout=&quot;showMenu(\'sub_gzhd\',this)&quot;&gt;&lt;a href=&quot;question_all_index.php&quot;&gt;公众互动&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;\r\n&lt;ul class=subMenu id=sub_jgsz style=&quot;display: none&quot;&gt;\r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;listHead.php?id=299&quot;&gt;教育局领导&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;listPart.php?id=299&quot;&gt;机关科室&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=112&quot;&gt;办事处&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;\r\n&lt;ul class=subMenu id=sub_xwdt style=&quot;display: none&quot;&gt;\r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=13&quot;&gt;外埠新闻&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=14&quot;&gt;教育新闻&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=15&quot;&gt;学校新闻&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;toptic.php?id=195&quot;&gt;教育专题&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;\r\n&lt;ul class=subMenu id=sub_gzdt style=&quot;display: none&quot;&gt;\r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_group.php?id=85&quot;&gt;扶贫助学&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=89&quot;&gt;教育党建&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_group.php?id=91&quot;&gt;招生考试&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=84&quot;&gt;学校安全&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;\r\n&lt;ul class=subMenu id=sub_xxgk style=&quot;display: none&quot;&gt;\r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;xxgk_more.php?id=192&quot;&gt;干部人事&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;xxgk_more.php?id=193&quot;&gt;教育收费&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;\r\n&lt;ul class=subMenu id=sub_gzhd style=&quot;display: none&quot;&gt;\r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;mailbox_index.php&quot;&gt;局长信箱&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a onclick=&quot;openChatWin(\'10002\');&quot; href=&quot;javascript:void(0)&quot;&gt;在线沟通&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;surveyMore.php?id=32&quot;&gt;网站投票&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;surveyMore.php?id=76&quot;&gt;网上调查&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;opinion_subject_index.php&quot;&gt;民意征集&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;\r\n&lt;ul class=subMenu id=sub_zsks style=&quot;display: none&quot;&gt;\r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=95&quot;&gt;招生信息&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=96&quot;&gt;普通高考&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=97&quot;&gt;普通中考&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=98&quot;&gt;自学考试&lt;/a&gt; \r\n&lt;li onmouseover=delayMenu()&gt;&lt;a href=&quot;article_more.php?id=99&quot;&gt;成人考试&lt;/a&gt; &lt;/li&gt;&lt;/ul&gt;');

-- ----------------------------
-- Table structure for `columns_imagelist`
-- ----------------------------
DROP TABLE IF EXISTS `columns_imagelist`;
CREATE TABLE `columns_imagelist` (
  `columns_imagelist_id` int(11) NOT NULL auto_increment,
  `columns_id` int(11) NOT NULL COMMENT '所属栏目id',
  `item_order` int(11) NOT NULL default '100' COMMENT '条目序号',
  `file_id` int(11) NOT NULL COMMENT '文件id',
  `item_title` varchar(250) collate utf8_unicode_ci default NULL COMMENT '链接文字',
  `item_link` varchar(255) collate utf8_unicode_ci default NULL COMMENT '链接地址',
  PRIMARY KEY  (`columns_imagelist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_imagelist
-- ----------------------------
INSERT INTO `columns_imagelist` VALUES ('104', '190', '100', '4032', '学生', '');
INSERT INTO `columns_imagelist` VALUES ('105', '190', '100', '4040', '老师', '');
INSERT INTO `columns_imagelist` VALUES ('106', '190', '100', '4041', '初中', '');

-- ----------------------------
-- Table structure for `columns_imagetable`
-- ----------------------------
DROP TABLE IF EXISTS `columns_imagetable`;
CREATE TABLE `columns_imagetable` (
  `columns_id` int(11) NOT NULL COMMENT '所属栏目id',
  `columns_imagelist_id` int(11) default '0' COMMENT '图片列表id',
  `text_xy` int(11) default '1' COMMENT '文字方位 1=下方2=左方3=右方4=上方',
  `text_width` int(11) default '10' COMMENT '文字区域宽度',
  `text_height` int(11) default '10' COMMENT '文字区域高度',
  `text_img_gap` int(11) default '0',
  `img_width` int(11) NOT NULL default '0' COMMENT '图片宽度',
  `img_heigth` int(11) NOT NULL default '0' COMMENT '图片高度',
  `display_type` int(11) NOT NULL default '1' COMMENT '显示方式 1=不滚动2=向左滚动3=向右滚动4=向上滚动5=向下滚动',
  `col_number` int(11) default '10' COMMENT '列数',
  `col_width` int(11) default '0' COMMENT '列间距离',
  `row_height` int(11) default '0' COMMENT '行间距离'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_imagetable
-- ----------------------------
INSERT INTO `columns_imagetable` VALUES ('188', '190', '1', '10', '10', '0', '150', '120', '2', '8', '0', '0');
INSERT INTO `columns_imagetable` VALUES ('199', '190', '1', '10', '10', '0', '90', '60', '1', '3', '0', '0');

-- ----------------------------
-- Table structure for `columns_link`
-- ----------------------------
DROP TABLE IF EXISTS `columns_link`;
CREATE TABLE `columns_link` (
  `columns_link_id` int(11) NOT NULL auto_increment,
  `columns_id` int(11) default NULL COMMENT '所属栏目id',
  `item_order` int(11) default '100' COMMENT '条目序号',
  `item_title` varchar(255) collate utf8_unicode_ci default NULL COMMENT '链接标题',
  `item_link` varchar(255) collate utf8_unicode_ci default NULL COMMENT '链接地址',
  PRIMARY KEY  (`columns_link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_link
-- ----------------------------
INSERT INTO `columns_link` VALUES ('76', '213', '1', '局长信箱', 'mailbox_index.php');
INSERT INTO `columns_link` VALUES ('74', '207', '1', '学校领导', 'listHead.php?id=299');
INSERT INTO `columns_link` VALUES ('75', '207', '10', '学校机构', 'listPart.php?id=299');
INSERT INTO `columns_link` VALUES ('77', '213', '10', '网上投票', 'surveyMore.php?id=32');
INSERT INTO `columns_link` VALUES ('78', '213', '20', '网上调查', 'surveyMore.php?id=76');
INSERT INTO `columns_link` VALUES ('79', '213', '100', '民意征集', 'opinion_subject_index.php');
INSERT INTO `columns_link` VALUES ('80', '208', '10', '外埠新闻', 'article_more.php?id=13');
INSERT INTO `columns_link` VALUES ('81', '208', '20', '教育新闻', 'article_more.php?id=14');
INSERT INTO `columns_link` VALUES ('82', '208', '30', '学校新闻', 'article_more.php?id=15');
INSERT INTO `columns_link` VALUES ('83', '208', '40', '教育要闻', 'article_more.php?id=16');

-- ----------------------------
-- Table structure for `columns_link2`
-- ----------------------------
DROP TABLE IF EXISTS `columns_link2`;
CREATE TABLE `columns_link2` (
  `sub_columns_id` int(11) NOT NULL COMMENT '链接条栏目id',
  `columns_id` int(11) NOT NULL COMMENT '所属栏目id',
  `item_order` int(11) NOT NULL default '100' COMMENT '条目序号',
  `item_title` varchar(255) collate utf8_unicode_ci default NULL COMMENT '链接标题',
  `item_href` varchar(255) collate utf8_unicode_ci default NULL,
  `item_link` varchar(255) collate utf8_unicode_ci default NULL COMMENT '链接地址',
  PRIMARY KEY  (`sub_columns_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_link2
-- ----------------------------
INSERT INTO `columns_link2` VALUES ('212', '34', '60', '网上办事', null, 'net_work.php');
INSERT INTO `columns_link2` VALUES ('206', '34', '0', '首页', null, 'index.php');
INSERT INTO `columns_link2` VALUES ('207', '34', '10', '机构设置', null, 'viewPart.php?id=71');
INSERT INTO `columns_link2` VALUES ('208', '34', '20', '新闻动态', null, 'article_group.php?id=6');
INSERT INTO `columns_link2` VALUES ('209', '34', '30', '工作动态', null, 'article_group.php?id=17');
INSERT INTO `columns_link2` VALUES ('210', '34', '40', '招生考试', null, 'article_group.php?id=91');
INSERT INTO `columns_link2` VALUES ('211', '34', '50', '信息公开', null, 'xxgk_group.php?id=5');
INSERT INTO `columns_link2` VALUES ('213', '34', '70', '公众互动', null, 'question_all_index.php');

-- ----------------------------
-- Table structure for `columns_notice`
-- ----------------------------
DROP TABLE IF EXISTS `columns_notice`;
CREATE TABLE `columns_notice` (
  `notice_id` int(11) NOT NULL auto_increment,
  `columns_id` int(11) NOT NULL,
  `user_num` int(11) default '0',
  `create_user_id` int(11) NOT NULL,
  `state` int(11) NOT NULL default '0',
  `create_time` datetime NOT NULL,
  `send_time` datetime default NULL,
  `title` varchar(250) collate utf8_unicode_ci NOT NULL,
  `content` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `columns_notice_relpy`
-- ----------------------------
DROP TABLE IF EXISTS `columns_notice_relpy`;
CREATE TABLE `columns_notice_relpy` (
  `relpy_id` int(11) NOT NULL auto_increment,
  `notice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` int(11) NOT NULL default '0',
  `reply_type` int(11) NOT NULL default '0',
  `read_time` datetime default NULL,
  `relpy_time` datetime default NULL,
  `note` varchar(250) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`relpy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_notice_relpy
-- ----------------------------

-- ----------------------------
-- Table structure for `columns_slideimage`
-- ----------------------------
DROP TABLE IF EXISTS `columns_slideimage`;
CREATE TABLE `columns_slideimage` (
  `columns_id` int(11) NOT NULL COMMENT '所属栏目id',
  `columns_imagelist_id` int(11) default '0' COMMENT '图片列表id',
  `text_xy` int(11) default '1' COMMENT '文字方位 1=下方2=左方3=右方4=上方',
  `text_width` int(11) default '10' COMMENT '文字宽度',
  `text_height` int(11) default '35' COMMENT '文字区域高度',
  `text_img_gap` int(11) default '0' COMMENT '文字和图片距离',
  `img_width` int(11) NOT NULL default '100' COMMENT '图片宽度',
  `img_heigth` int(11) NOT NULL default '100' COMMENT '图片高度',
  `image_time` int(11) default '1000' COMMENT '单帧时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_slideimage
-- ----------------------------
INSERT INTO `columns_slideimage` VALUES ('196', '13', '1', '10', '20', '0', '298', '198', '1000');
INSERT INTO `columns_slideimage` VALUES ('201', '13', '1', '10', '35', '0', '298', '200', '1000');

-- ----------------------------
-- Table structure for `columns_toptic`
-- ----------------------------
DROP TABLE IF EXISTS `columns_toptic`;
CREATE TABLE `columns_toptic` (
  `columns_toptic_id` int(11) NOT NULL auto_increment COMMENT '记录id',
  `columns_id` int(11) NOT NULL COMMENT '所属栏目id',
  `small_img_id` int(11) NOT NULL COMMENT '首页图片id',
  `small_img_width` int(11) NOT NULL default '0',
  `small_img_height` int(11) NOT NULL default '0',
  `big_img_id` int(11) NOT NULL COMMENT '标题图片id',
  `big_img_width` int(11) NOT NULL default '0',
  `big_img_height` int(11) NOT NULL default '0',
  `toptic_order` int(11) NOT NULL default '100' COMMENT '专题显示顺序',
  `to_index` int(11) NOT NULL default '0' COMMENT '显示在首页',
  `slide_id` int(11) NOT NULL COMMENT '幻灯片栏目id',
  `article_column_id` int(11) NOT NULL COMMENT '文章栏目id',
  `html_column_id` int(11) NOT NULL COMMENT '自由编辑栏目id',
  `imagetable_id` int(11) NOT NULL COMMENT '图片表格栏目ID',
  `toptic_name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '专题名称',
  `toptic_href` varchar(255) collate utf8_unicode_ci default NULL COMMENT '专题链接 如果填写链接，点击该专题链接时直接导向该链接',
  `toptic_note` varchar(255) collate utf8_unicode_ci default NULL COMMENT '专题导航',
  PRIMARY KEY  (`columns_toptic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_toptic
-- ----------------------------
INSERT INTO `columns_toptic` VALUES ('40', '195', '4033', '298', '60', '4034', '979', '151', '100', '1', '196', '197', '198', '199', '课内比教学，课外访万家', '', '');

-- ----------------------------
-- Table structure for `columns_type`
-- ----------------------------
DROP TABLE IF EXISTS `columns_type`;
CREATE TABLE `columns_type` (
  `columns_type_id` int(11) NOT NULL auto_increment,
  `next_number` int(11) NOT NULL default '1' COMMENT '下一个栏目号',
  `type_name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '类型名称',
  `type_handle` varchar(20) collate utf8_unicode_ci NOT NULL,
  `manage_url` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '管理该类型的php入口url',
  `display_url` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '栏目显示入口',
  PRIMARY KEY  (`columns_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of columns_type
-- ----------------------------
INSERT INTO `columns_type` VALUES ('1', '73', '文章栏目', 'wzlm', '../article/manageArticle.php', 'viewArticleColumns');
INSERT INTO `columns_type` VALUES ('2', '22', '链接条栏目', 'ljtlm', '../columns_link/manageLinkColumns.php', 'link');
INSERT INTO `columns_type` VALUES ('3', '36', '自由编辑栏目', 'zybjlm', '../columns_html/editHtmlColumns.php', 'html');
INSERT INTO `columns_type` VALUES ('4', '3', '调查栏目', 'dclm', '../columns_survey/manageSurvey.php', 'survey');
INSERT INTO `columns_type` VALUES ('5', '8', '图片列表栏目', 'tplblm', '../columns_imagelist/manageImageListColumns.php', 'imagelist');
INSERT INTO `columns_type` VALUES ('6', '33', '图片表格栏目', 'tpbglm', '../columns_imagetable/editImageTableColumns.php', 'imagetable');
INSERT INTO `columns_type` VALUES ('7', '27', '图片幻灯片栏目', 'tphdplm', '../columns_slideimage/editSlideImageColumns.php', 'slideimage');
INSERT INTO `columns_type` VALUES ('8', '9', '专题栏目', 'ztlm', '../columns_toptic/manageTopticColumns.php', 'zt');
INSERT INTO `columns_type` VALUES ('10', '3', '二级链接条栏目', 'ejljtlm', '../columns_link2/manageLinkColumns2.php', 'link');
INSERT INTO `columns_type` VALUES ('11', '13', '自动栏目', 'zdlm', '../columns_auto/manageAutoColumns.php', 'zd');
INSERT INTO `columns_type` VALUES ('12', '2', '通知栏目', 'tzlm', '../columns_notice/manageNewNotice.php', 'tz');
INSERT INTO `columns_type` VALUES ('13', '83', '信息公开', 'xxgk', '../xxgk/manageArticle.php', 'viewxxgkColumns');

-- ----------------------------
-- Table structure for `corp`
-- ----------------------------
DROP TABLE IF EXISTS `corp`;
CREATE TABLE `corp` (
  `c_id` int(11) NOT NULL auto_increment,
  `c_type` int(11) NOT NULL,
  `corp_name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `short_name` varchar(100) collate utf8_unicode_ci default NULL,
  `phone` varchar(100) collate utf8_unicode_ci default NULL,
  `addr` varchar(200) collate utf8_unicode_ci default NULL,
  `to_index` int(11) default NULL,
  PRIMARY KEY  (`c_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of corp
-- ----------------------------
INSERT INTO `corp` VALUES ('325', '1', '钟祥市第一中学', '钟祥市第一中学', '', '', '1');

-- ----------------------------
-- Table structure for `corp_head`
-- ----------------------------
DROP TABLE IF EXISTS `corp_head`;
CREATE TABLE `corp_head` (
  `head_id` int(11) NOT NULL auto_increment,
  `corp_id` int(11) NOT NULL,
  `article_column_id` int(11) NOT NULL,
  `head_order` int(11) NOT NULL default '100',
  `head_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `head_photo` int(11) NOT NULL default '0',
  `head_post` varchar(500) collate utf8_unicode_ci NOT NULL,
  `head_post2` varchar(500) collate utf8_unicode_ci default NULL,
  `head_note` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `head_mail` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`head_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of corp_head
-- ----------------------------
INSERT INTO `corp_head` VALUES ('31', '325', '0', '100', '张某某', '0', '校长', '', '校长', '');

-- ----------------------------
-- Table structure for `corp_part`
-- ----------------------------
DROP TABLE IF EXISTS `corp_part`;
CREATE TABLE `corp_part` (
  `part_id` int(11) NOT NULL auto_increment COMMENT '记录id',
  `corp_id` int(11) NOT NULL COMMENT '所属栏目id',
  `article_column_id` int(11) NOT NULL default '0' COMMENT '文章栏目id',
  `part_order` int(11) NOT NULL default '100' COMMENT '机构显示顺序',
  `part_name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '机构名称',
  `part_master` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '机构负责人',
  `part_phone` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `part_monitor_phone` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '监督电话',
  `part_note` varchar(1000) collate utf8_unicode_ci NOT NULL COMMENT '机构职能',
  `master_photo` int(11) NOT NULL default '0',
  `part_addr` varchar(200) collate utf8_unicode_ci default NULL,
  `part_mail` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`part_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of corp_part
-- ----------------------------
INSERT INTO `corp_part` VALUES ('71', '325', '0', '100', '办公室', '刘三', '456456', '564-45645645', '办公室日常工作', '0', '', '');

-- ----------------------------
-- Table structure for `corp_part_sub`
-- ----------------------------
DROP TABLE IF EXISTS `corp_part_sub`;
CREATE TABLE `corp_part_sub` (
  `sub_id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `sub_order` int(11) NOT NULL default '100',
  `display_type` int(11) NOT NULL default '1',
  `c_type` int(11) NOT NULL default '1',
  PRIMARY KEY  (`sub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of corp_part_sub
-- ----------------------------

-- ----------------------------
-- Table structure for `corp_type`
-- ----------------------------
DROP TABLE IF EXISTS `corp_type`;
CREATE TABLE `corp_type` (
  `t_id` int(11) NOT NULL auto_increment,
  `t_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`t_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of corp_type
-- ----------------------------
INSERT INTO `corp_type` VALUES ('1', '教育局');
INSERT INTO `corp_type` VALUES ('2', '市直教育单位');
INSERT INTO `corp_type` VALUES ('3', '办事处');
INSERT INTO `corp_type` VALUES ('4', '市直学校');
INSERT INTO `corp_type` VALUES ('5', '民办学校');

-- ----------------------------
-- Table structure for `down`
-- ----------------------------
DROP TABLE IF EXISTS `down`;
CREATE TABLE `down` (
  `down_id` int(11) NOT NULL auto_increment,
  `down_type` int(11) default NULL COMMENT '1提供给公众用户的资源,2只提供给各单位的资源不需回收3只提供给各单位的资源需要回收',
  `down_title` varchar(255) collate utf8_unicode_ci default NULL,
  `down_count` int(11) default '0' COMMENT '下载次数',
  `down_order` float(11,3) default '500.000',
  `down_content` text collate utf8_unicode_ci COMMENT '下载的内容',
  PRIMARY KEY  (`down_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of down
-- ----------------------------
INSERT INTO `down` VALUES ('3', '1', '下载1', '0', null, 'ddddd');
INSERT INTO `down` VALUES ('4', '2', '下载2', '0', '500.000', '');

-- ----------------------------
-- Table structure for `down_files`
-- ----------------------------
DROP TABLE IF EXISTS `down_files`;
CREATE TABLE `down_files` (
  `file_id` int(11) NOT NULL auto_increment,
  `file_sid` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '所属信息的sid',
  `is_admin` int(11) default '1' COMMENT '1=管理员 2=其他用户回传',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '上传时间',
  `file_path` varchar(100) collate utf8_unicode_ci NOT NULL,
  `file_info` varchar(100) collate utf8_unicode_ci NOT NULL,
  `admin_ip` varchar(25) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of down_files
-- ----------------------------
INSERT INTO `down_files` VALUES ('1', '127321662518245', '1', '2010-05-07 15:06:32', '2010/05/07/20100507071705_25826.jpg', '', null);

-- ----------------------------
-- Table structure for `down_mes`
-- ----------------------------
DROP TABLE IF EXISTS `down_mes`;
CREATE TABLE `down_mes` (
  `mes_id` int(8) NOT NULL auto_increment,
  `mes_recive` varchar(1000) collate utf8_unicode_ci default '0' COMMENT '0 表示完全公开  ，隔开的用户id串',
  `mes_readover` varchar(1000) collate utf8_unicode_ci default NULL COMMENT '已读用户的id串',
  `mes_title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `mes_note` varchar(300) collate utf8_unicode_ci default NULL COMMENT '信息备注',
  `file_sid` varchar(20) collate utf8_unicode_ci default NULL COMMENT '附件sid',
  `mes_time` datetime default NULL,
  `mes_pass` int(1) default '0' COMMENT '是否通过',
  PRIMARY KEY  (`mes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of down_mes
-- ----------------------------
INSERT INTO `down_mes` VALUES ('1', '0', null, 'sff', 'sfsf', '127321662518245', '2010-05-07 15:06:32', '1');

-- ----------------------------
-- Table structure for `down_remes`
-- ----------------------------
DROP TABLE IF EXISTS `down_remes`;
CREATE TABLE `down_remes` (
  `remes_id` int(8) NOT NULL auto_increment,
  `user_id` int(8) NOT NULL COMMENT '回传者id',
  `mes_id` int(8) NOT NULL COMMENT '对应的管理员发送的信息的id',
  `mes_title` varchar(80) collate utf8_unicode_ci NOT NULL,
  `file_sid` varchar(20) collate utf8_unicode_ci default NULL COMMENT '附件sid',
  `mes_time` datetime default NULL,
  `admin_mes` varchar(300) collate utf8_unicode_ci default NULL COMMENT '管理员的反馈信息',
  `admin_read` int(2) default '0' COMMENT '1=管理员已读 0=未读',
  PRIMARY KEY  (`remes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of down_remes
-- ----------------------------
INSERT INTO `down_remes` VALUES ('7', '0', '0', '', '', '0000-00-00 00:00:00', '', '0');

-- ----------------------------
-- Table structure for `image`
-- ----------------------------
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `image_id` int(11) NOT NULL auto_increment,
  `article_id` varchar(11) collate utf8_unicode_ci default NULL,
  `image_name` varchar(255) collate utf8_unicode_ci default NULL,
  `image_info` varchar(255) collate utf8_unicode_ci default NULL,
  `image_mid` float(11,3) default NULL,
  `item_id` varchar(11) collate utf8_unicode_ci default NULL,
  `image_http` varchar(255) collate utf8_unicode_ci default NULL,
  `image_height` int(6) unsigned default NULL,
  `image_width` int(6) unsigned default NULL,
  `image_size` int(10) unsigned default NULL,
  `image_pid` int(11) default NULL,
  `article_imgid` varchar(255) collate utf8_unicode_ci default NULL,
  `first_show` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of image
-- ----------------------------
INSERT INTO `image` VALUES ('1', null, 'img20090215112529_17587.gif', '', '500.000', '33', null, '50', '188', '3150', null, '12346970355944', '1');
INSERT INTO `image` VALUES ('2', null, 'img20090401011646_32680.jpg', '', '500.000', '1', null, '230', '233', '11415', null, '123469788517291', '0');
INSERT INTO `image` VALUES ('3', null, 'img20090401011855_28308.jpg', '', '500.000', '1', null, '449', '359', '53909', null, '123469788517291', '0');
INSERT INTO `image` VALUES ('4', null, 'img20090401011939_1485.gif', '', '500.000', '8', null, '154', '588', '57727', null, '12385487396978', '0');
INSERT INTO `image` VALUES ('5', null, 'img20090401012011_16747.gif', '', '500.000', '1', null, '684', '1020', '59303', null, '123469788517291', '0');
INSERT INTO `image` VALUES ('6', null, 'img20090401012408_4131.gif', '', '500.000', '8', null, '154', '588', '57727', null, '123854903018916', '0');
INSERT INTO `image` VALUES ('7', null, 'img20090401012531_394.gif', '', '500.000', '8', null, '154', '588', '57727', null, '123854903018916', '0');
INSERT INTO `image` VALUES ('8', null, 'img20090401012615_23870.gif', '', '500.000', '8', null, '154', '588', '57727', null, '123854903018916', '0');
INSERT INTO `image` VALUES ('9', null, 'img20090401013555_22854.gif', '', '500.000', '7', null, '154', '588', '57727', null, '123854974329776', '0');
INSERT INTO `image` VALUES ('10', null, 'img20090401023254_12069.gif', '', '500.000', '49', null, '58', '156', '5490', null, '123855314427055', '1');

-- ----------------------------
-- Table structure for `mail`
-- ----------------------------
DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL auto_increment,
  `mail_open` int(11) default NULL COMMENT '是否公开1公开2不公开',
  `mail_age` int(11) default NULL,
  `mail_type` int(11) default NULL COMMENT '1建议2求助3投诉4批评5咨询6其他',
  `mail_vocation` varchar(100) collate utf8_unicode_ci default NULL COMMENT '职业',
  `mail_email` varchar(50) collate utf8_unicode_ci default NULL COMMENT '发信人email',
  `mail_phone` varchar(20) collate utf8_unicode_ci default NULL COMMENT '发信人电话',
  `mail_name` varchar(20) collate utf8_unicode_ci default NULL COMMENT '发信人姓名',
  `mail_address` varchar(100) collate utf8_unicode_ci default NULL COMMENT '地址',
  `mail_title` varchar(100) collate utf8_unicode_ci default NULL COMMENT '信件标题',
  `mail_field` varchar(20) collate utf8_unicode_ci default NULL COMMENT '类容有关领域',
  `mail_area` varchar(20) collate utf8_unicode_ci default NULL COMMENT '发生区域',
  `query_code` varchar(20) collate utf8_unicode_ci default NULL COMMENT '查询码',
  `mail_content` text collate utf8_unicode_ci COMMENT '信件类容',
  `write_time` datetime default NULL COMMENT '写信时间',
  `back_time` datetime default NULL COMMENT '回信时间',
  `back_content` text collate utf8_unicode_ci COMMENT '回复类容',
  `back_type` int(11) default NULL COMMENT '1未回复2已回复',
  `mail_sex` int(11) default NULL COMMENT '1男 2女',
  `mail_open1` int(11) default NULL,
  PRIMARY KEY  (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of mail
-- ----------------------------
INSERT INTO `mail` VALUES ('7', '1', '60', '2', '教师', '165581979', '13307192651', '陆伟民', '湖北武汉武昌', '找人', '人事', '', 'ef28a5bf3b07b642d', ' 寻找76年由沙洋师范分到您市的老师。分别36年老师，同学十分想念。', '2011-08-01 13:02:01', '2011-08-04 15:52:50', '     网友您好，现按照您的意思将寻人信息予以公布，希望您的同学看到此信息后能尽快与您联系。', '2', '2', '1');
INSERT INTO `mail` VALUES ('60', '1', '0', '1', '', '4564565', '1325487', '', '武汉', '测试提交', '水电气', '', '1df069ca8b9f71e50', ' 测试提交内容', '2012-03-15 15:13:12', '2012-03-15 15:14:09', '是的', '2', '1', '1');
INSERT INTO `mail` VALUES ('36', '1', '0', '5', '', 'jiujingjuanzi@126.com', '13597915803', '贺小姐', '钟祥市东街', '咨询教师资格证', '教育', '', '7cb6668c24121b7fa', '  我是08年师范院校毕业的，有教育学二学位，请问今年申请教师资格证时可不可以不用成绩单证明成绩？', '2011-12-22 13:02:08', '2012-03-15 14:29:37', '    贺小姐，您好！就您说问的问题，我专门咨询了教育局基础教育科，他们的回答是“不用”。具体情况请您直接到教育局基础教育科咨询!', '2', '2', '1');
INSERT INTO `mail` VALUES ('53', '1', '22', '5', '教师', '231906', '15671725328', '吴佳丽', '湖北省钟祥市丰乐镇山河', '教师考编制', '教育', '', '8d1a46707e7c94457', ' 您好!我是师范专科毕业生，请问我能参加教师考编吗？谢谢！', '2012-02-14 14:12:21', '2012-03-15 14:29:16', '    市教育局人事科答复：请您密切关注钟祥教育信息网！', '2', '2', '1');

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `menu_order` int(11) NOT NULL default '500',
  `menu_show` int(11) NOT NULL default '1',
  `menu_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `menu_note` varchar(250) collate utf8_unicode_ci default NULL,
  `menu_url` varchar(250) collate utf8_unicode_ci default NULL,
  `pur_edit_url` varchar(250) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', '0', '500', '1', '基本设置', null, null, null);
INSERT INTO `menus` VALUES ('2', '0', '494', '1', '用户管理', null, '', null);
INSERT INTO `menus` VALUES ('3', '0', '490', '1', '栏目管理', null, null, null);
INSERT INTO `menus` VALUES ('4', '0', '495', '1', '单位管理', null, null, null);
INSERT INTO `menus` VALUES ('5', '0', '491', '1', '网上办事', null, null, null);
INSERT INTO `menus` VALUES ('6', '1', '500', '0', '主站信息', null, 'setup/mainSiteInfo.php', null);
INSERT INTO `menus` VALUES ('8', '2', '490', '1', '添加用户', null, 'users/addUser.php', null);
INSERT INTO `menus` VALUES ('9', '2', '500', '1', '浏览用户列表', null, 'users/manageUser.php', null);
INSERT INTO `menus` VALUES ('10', '2', '500', '1', '权限管理', null, 'users/managePurview.php', null);
INSERT INTO `menus` VALUES ('11', '1', '500', '1', '用户组设置', null, 'users/manageUserGroup.php', null);
INSERT INTO `menus` VALUES ('12', '1', '500', '1', '个人信息', null, 'users/myInfo.php', null);
INSERT INTO `menus` VALUES ('13', '3', '500', '1', '添加栏目', null, 'columns/addColumns.php?retURL=manageColumnsAdmin.php', null);
INSERT INTO `menus` VALUES ('14', '1', '503', '1', '栏目设置', null, 'columns/manageColumnsAdmin.php', null);
INSERT INTO `menus` VALUES ('15', '3', '504', '1', '栏目内容', null, 'columns/manageColumnsTree.php', '');
INSERT INTO `menus` VALUES ('16', '3', '521', '1', '文章审批', null, 'article/myCheckArticleList.php', 'editObjColumnsPurview.php?t=1&id=');
INSERT INTO `menus` VALUES ('17', '3', '520', '1', '评论管理', null, 'comments_manage/comments_list.php', null);
INSERT INTO `menus` VALUES ('18', '4', '501', '1', '添加单位', null, 'corp/addCorp.php', null);
INSERT INTO `menus` VALUES ('19', '4', '504', '1', '浏览单位列表', null, 'corp/manageCorp.php', null);
INSERT INTO `menus` VALUES ('20', '4', '505', '1', '机构设置', null, 'corp/partSet.php', 'editObjPartSetPurview.php?id=');
INSERT INTO `menus` VALUES ('21', '5', '500', '0', '最新会议通知', null, 'columns_notice/myNewNotice.php', null);
INSERT INTO `menus` VALUES ('22', '1', '501', '1', '网上办事基本设置', null, 'work_manage/item_list_manage.php', null);
INSERT INTO `menus` VALUES ('23', '5', '500', '1', '网上办事日常处理', null, 'work_content_manage/article_list.php', null);
INSERT INTO `menus` VALUES ('24', '5', '500', '1', '网上诉求管理', null, 'mail_manage/mail_list.php', null);
INSERT INTO `menus` VALUES ('25', '5', '500', '1', '民意征集管理', null, 'opinion_manage/opinion_subject_list.php', null);
INSERT INTO `menus` VALUES ('26', '5', '500', '1', '民意征集结果管理', null, 'opinion_manage/opinion_result_list.php', null);
INSERT INTO `menus` VALUES ('27', '5', '500', '1', '网上申报管理', null, 'apply_manage/apply_list.php', null);
INSERT INTO `menus` VALUES ('28', '5', '500', '1', '网上答疑管理', null, 'question_manage/question_list.php', null);
INSERT INTO `menus` VALUES ('29', '53', '500', '1', '下载中心设置', null, 'download/downMesList.php', null);
INSERT INTO `menus` VALUES ('30', '3', '501', '0', '修改栏目', null, 'columns/editColumnsAdmin.php', null);
INSERT INTO `menus` VALUES ('31', '3', '502', '0', '删除栏目', null, 'columns/deleteColumns.php', null);
INSERT INTO `menus` VALUES ('32', '4', '502', '0', '修改单位信息', null, 'corp/editCorp.php', null);
INSERT INTO `menus` VALUES ('33', '4', '503', '0', '删除单位信息', null, 'corp/deleteCorp.php', null);
INSERT INTO `menus` VALUES ('34', '3', '505', '0', '栏目内容-文章栏目', null, 'article/manageArticle.php', 'editObjColumnsPurview.php?t=1&id=');
INSERT INTO `menus` VALUES ('35', '3', '506', '0', '栏目内容-链接条栏目', null, 'columns_link/manageLinkColumns.php', 'editObjColumnsPurview.php?t=2&id=');
INSERT INTO `menus` VALUES ('36', '3', '507', '0', '栏目内容-自由编辑栏目', null, 'columns_html/editHtmlColumns.php', 'editObjColumnsPurview.php?t=3&id=');
INSERT INTO `menus` VALUES ('37', '3', '508', '0', '栏目内容-调查栏目', null, null, 'editObjColumnsPurview.php?t=4&id=');
INSERT INTO `menus` VALUES ('38', '3', '509', '0', '栏目内容-图片列表栏目', null, null, 'editObjColumnsPurview.php?t=5&id=');
INSERT INTO `menus` VALUES ('39', '3', '510', '0', '栏目内容-图片表格栏目', null, null, 'editObjColumnsPurview.php?t=6&id=');
INSERT INTO `menus` VALUES ('40', '3', '511', '0', '栏目内容-图片幻灯片栏目', null, null, 'editObjColumnsPurview.php?t=7&id=');
INSERT INTO `menus` VALUES ('41', '3', '512', '0', '栏目内容-专题栏目', null, null, 'editObjColumnsPurview.php?t=8&id=');
INSERT INTO `menus` VALUES ('42', '3', '513', '0', '栏目内容-二级链接条栏目', '', null, 'editObjColumnsPurview.php?t=10&id=');
INSERT INTO `menus` VALUES ('43', '3', '514', '0', '栏目内容-通知栏目', '', '', 'editObjColumnsPurview.php?t=12&id=');
INSERT INTO `menus` VALUES ('44', '2', '521', '0', '修改用户', null, 'users/editUser.php', null);
INSERT INTO `menus` VALUES ('45', '2', '522', '0', '删除用户', null, 'users/deleteUser.php', null);
INSERT INTO `menus` VALUES ('47', '1', '500', '1', '单位类型设置', null, 'corp/corpTypes.php', null);
INSERT INTO `menus` VALUES ('49', '53', '499', '1', '资源列表', null, 'download/reciveMesList.php', null);
INSERT INTO `menus` VALUES ('50', '0', '496', '1', '查询统计', null, null, null);
INSERT INTO `menus` VALUES ('51', '50', '500', '1', '作者统计', null, 'count/autherList.php', null);
INSERT INTO `menus` VALUES ('52', '50', '500', '1', '来源统计', null, 'count/fromList.php', null);
INSERT INTO `menus` VALUES ('53', '0', '492', '1', '下载中心', null, null, null);
INSERT INTO `menus` VALUES ('54', '5', '500', '1', '在线沟通', 'newWindow', 'online_service/login.php', null);
INSERT INTO `menus` VALUES ('55', '3', '500', '0', '栏目内容-信息公开', null, 'xxgk/manageArticle.php', 'editObjColumnsPurview.php?t=13&id=');

-- ----------------------------
-- Table structure for `my_object`
-- ----------------------------
DROP TABLE IF EXISTS `my_object`;
CREATE TABLE `my_object` (
  `rec_id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL default '0',
  `obj_id` int(11) NOT NULL default '0',
  `pur_list` varchar(1000) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`rec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of my_object
-- ----------------------------
INSERT INTO `my_object` VALUES ('105', '0', '2', '0', '0', ',13,55,30,31,15,34,35,36,37,38,39,40,41,42,43,17,16,54,21,26,28,23,24,27,25,49,29,8,10,9,44,45,18,32,33,19,20,51,52,47,11,12,6,22,14,');
INSERT INTO `my_object` VALUES ('247', '0', '2', '34', '21', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('246', '0', '2', '34', '19', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('245', '0', '2', '34', '18', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('244', '0', '2', '34', '17', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('243', '0', '2', '34', '16', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('242', '0', '2', '34', '15', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('241', '0', '2', '34', '14', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('240', '0', '2', '34', '13', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('444', '0', '2', '34', '197', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('443', '0', '2', '40', '196', ',edit,');
INSERT INTO `my_object` VALUES ('441', '0', '2', '34', '6', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('463', '0', '2', '55', '192', ',add,edit,del,editAll,editAll,');
INSERT INTO `my_object` VALUES ('468', '0', '2', '55', '5', ',add,edit,del,editAll,editAll,');
INSERT INTO `my_object` VALUES ('464', '0', '2', '55', '193', ',add,edit,del,editAll,editAll,');
INSERT INTO `my_object` VALUES ('232', '0', '2', '34', '4', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('254', '0', '2', '36', '30', ',edit,');
INSERT INTO `my_object` VALUES ('253', '0', '2', '36', '29', ',edit,');
INSERT INTO `my_object` VALUES ('252', '0', '2', '36', '28', ',edit,');
INSERT INTO `my_object` VALUES ('251', '0', '2', '36', '23', ',edit,');
INSERT INTO `my_object` VALUES ('250', '0', '2', '36', '22', ',edit,');
INSERT INTO `my_object` VALUES ('249', '0', '2', '36', '2', ',edit,');
INSERT INTO `my_object` VALUES ('248', '0', '2', '36', '1', ',edit,');
INSERT INTO `my_object` VALUES ('256', '0', '2', '37', '32', ',proc,');
INSERT INTO `my_object` VALUES ('448', '0', '2', '40', '201', ',edit,');
INSERT INTO `my_object` VALUES ('442', '0', '2', '41', '195', ',proc,');
INSERT INTO `my_object` VALUES ('259', '0', '2', '42', '34', ',proc,');
INSERT INTO `my_object` VALUES ('277', '0', '2', '16', '21', ',proc,');
INSERT INTO `my_object` VALUES ('276', '0', '2', '16', '19', ',proc,');
INSERT INTO `my_object` VALUES ('275', '0', '2', '16', '18', ',proc,');
INSERT INTO `my_object` VALUES ('274', '0', '2', '16', '17', ',proc,');
INSERT INTO `my_object` VALUES ('273', '0', '2', '16', '16', ',proc,');
INSERT INTO `my_object` VALUES ('272', '0', '2', '16', '15', ',proc,');
INSERT INTO `my_object` VALUES ('271', '0', '2', '16', '14', ',proc,');
INSERT INTO `my_object` VALUES ('270', '0', '2', '16', '13', ',proc,');
INSERT INTO `my_object` VALUES ('269', '0', '2', '16', '12', ',proc,');
INSERT INTO `my_object` VALUES ('268', '0', '2', '16', '10', ',proc,');
INSERT INTO `my_object` VALUES ('267', '0', '2', '16', '9', ',proc,');
INSERT INTO `my_object` VALUES ('266', '0', '2', '16', '8', ',proc,');
INSERT INTO `my_object` VALUES ('265', '0', '2', '16', '7', ',proc,');
INSERT INTO `my_object` VALUES ('264', '0', '2', '16', '6', ',proc,');
INSERT INTO `my_object` VALUES ('263', '0', '2', '16', '5', ',proc,');
INSERT INTO `my_object` VALUES ('262', '0', '2', '16', '4', ',proc,');
INSERT INTO `my_object` VALUES ('255', '0', '2', '36', '31', ',edit,');
INSERT INTO `my_object` VALUES ('261', '0', '2', '43', '11', ',proc,');
INSERT INTO `my_object` VALUES ('282', '0', '2', '34', '40', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('434', '0', '2', '39', '188', ',edit,');
INSERT INTO `my_object` VALUES ('435', '0', '2', '38', '190', ',proc,');
INSERT INTO `my_object` VALUES ('285', '0', '3', '0', '0', ',13,30,31,15,34,35,36,37,38,39,40,41,42,43,17,16,23,28,21,27,26,25,24,49,29,8,10,9,44,45,18,32,33,19,20,51,52,47,12,11,6,22,14,');
INSERT INTO `my_object` VALUES ('311', '0', '2', '34', '75', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('312', '0', '2', '37', '76', ',proc,');
INSERT INTO `my_object` VALUES ('320', '0', '2', '34', '84', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('321', '0', '2', '34', '85', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('445', '0', '2', '36', '198', ',edit,');
INSERT INTO `my_object` VALUES ('446', '0', '2', '39', '199', ',edit,');
INSERT INTO `my_object` VALUES ('476', '0', '2', '35', '212', ',proc,');
INSERT INTO `my_object` VALUES ('325', '0', '2', '34', '89', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('326', '0', '2', '34', '90', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('327', '0', '2', '34', '91', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('328', '0', '2', '34', '92', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('329', '0', '2', '34', '93', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('330', '0', '2', '34', '94', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('331', '0', '2', '34', '95', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('332', '0', '2', '34', '96', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('333', '0', '2', '34', '97', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('334', '0', '2', '34', '98', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('335', '0', '2', '34', '99', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('469', '0', '2', '20', '325', ',set,');
INSERT INTO `my_object` VALUES ('433', '0', '2', '36', '187', ',edit,');
INSERT INTO `my_object` VALUES ('361', '0', '4', '0', '0', ',15,34,35,36,37,38,39,40,41,42,43,17,16,27,54,23,24,25,26,28,21,49,29,51,52,');
INSERT INTO `my_object` VALUES ('362', '0', '4', '34', '14', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('363', '0', '4', '34', '15', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('364', '0', '4', '34', '13', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('365', '0', '4', '34', '16', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('366', '0', '3', '34', '4', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('367', '0', '3', '34', '12', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('368', '0', '3', '34', '17', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('369', '0', '3', '34', '85', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('370', '0', '3', '34', '91', ',add,edit,del,editAll,delAll,');
INSERT INTO `my_object` VALUES ('371', '0', '4', '16', '12', ',proc,');
INSERT INTO `my_object` VALUES ('372', '0', '4', '16', '75', ',proc,');
INSERT INTO `my_object` VALUES ('373', '0', '4', '16', '21', ',proc,');
INSERT INTO `my_object` VALUES ('374', '0', '4', '16', '40', ',proc,');
INSERT INTO `my_object` VALUES ('432', '0', '2', '36', '186', ',edit,');
INSERT INTO `my_object` VALUES ('465', '0', '2', '55', '202', ',add,edit,del,editAll,editAll,');
INSERT INTO `my_object` VALUES ('467', '0', '2', '55', '205', ',add,edit,del,editAll,editAll,');
INSERT INTO `my_object` VALUES ('470', '0', '2', '35', '206', ',proc,');
INSERT INTO `my_object` VALUES ('471', '0', '2', '35', '207', ',proc,');
INSERT INTO `my_object` VALUES ('472', '0', '2', '35', '208', ',proc,');
INSERT INTO `my_object` VALUES ('473', '0', '2', '35', '209', ',proc,');
INSERT INTO `my_object` VALUES ('474', '0', '2', '35', '210', ',proc,');
INSERT INTO `my_object` VALUES ('475', '0', '2', '35', '211', ',proc,');
INSERT INTO `my_object` VALUES ('477', '0', '2', '35', '213', ',proc,');
INSERT INTO `my_object` VALUES ('479', '0', '2', '36', '216', ',edit,');

-- ----------------------------
-- Table structure for `opinion`
-- ----------------------------
DROP TABLE IF EXISTS `opinion`;
CREATE TABLE `opinion` (
  `opinion_id` int(11) NOT NULL auto_increment,
  `subject_id` int(11) default NULL,
  `opinion_name` varchar(20) collate utf8_unicode_ci default NULL COMMENT '姓名',
  `opinion_mphone` varchar(20) collate utf8_unicode_ci default NULL COMMENT '手机',
  `opinion_code` int(11) default NULL COMMENT '邮编',
  `opinion_title` varchar(255) collate utf8_unicode_ci default NULL COMMENT '标题',
  `opinion_address` varchar(255) collate utf8_unicode_ci default NULL,
  `opinion_phone` varchar(20) collate utf8_unicode_ci default NULL COMMENT '电话',
  `opinion_email` varchar(100) collate utf8_unicode_ci default NULL,
  `opinion_content` text collate utf8_unicode_ci,
  `opinion_time` date default NULL,
  `opinion_pass` int(11) NOT NULL default '1' COMMENT '1未采纳处理 2处理中 3已采纳',
  PRIMARY KEY  (`opinion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of opinion
-- ----------------------------
INSERT INTO `opinion` VALUES ('15', '11', 'sasou', '', '0', '很好', '', '132684548', '', '很好', '2012-03-15', '3');

-- ----------------------------
-- Table structure for `opinion_subject`
-- ----------------------------
DROP TABLE IF EXISTS `opinion_subject`;
CREATE TABLE `opinion_subject` (
  `subject_id` int(11) NOT NULL auto_increment,
  `subject_title` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '征集的题目',
  `subject_time` datetime default NULL COMMENT '征集时间',
  `subject_content` text collate utf8_unicode_ci COMMENT '具体类容',
  `subject_order` int(11) default NULL COMMENT '排序',
  `subject_from` varchar(100) collate utf8_unicode_ci default NULL COMMENT '信息来源',
  `click_count` int(11) default NULL COMMENT '点击量',
  PRIMARY KEY  (`subject_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of opinion_subject
-- ----------------------------
INSERT INTO `opinion_subject` VALUES ('11', '请说说对教育信息网改版的看法', '2011-06-10 10:41:27', '请说说对教育信息网改版的看法', '500', '', '230');

-- ----------------------------
-- Table structure for `purview`
-- ----------------------------
DROP TABLE IF EXISTS `purview`;
CREATE TABLE `purview` (
  `p_id` varchar(50) collate utf8_unicode_ci NOT NULL,
  `menu_id` int(11) NOT NULL,
  `p_order` int(11) NOT NULL default '500',
  `p_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `p_note` varchar(250) collate utf8_unicode_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of purview
-- ----------------------------
INSERT INTO `purview` VALUES ('add', '34', '500', '添加文章', '');
INSERT INTO `purview` VALUES ('edit', '34', '501', '修改文章(受限)', '');
INSERT INTO `purview` VALUES ('del', '34', '502', '删除文章(受限)', '');
INSERT INTO `purview` VALUES ('editAll', '34', '503', '修改文章(不受限)', '');
INSERT INTO `purview` VALUES ('delAll', '34', '504', '删除文章(不受限)', '');
INSERT INTO `purview` VALUES ('proc', '16', '500', '审批文章', null);
INSERT INTO `purview` VALUES ('proc', '35', '500', '管理内容', null);
INSERT INTO `purview` VALUES ('edit', '36', '500', '修改内容', null);
INSERT INTO `purview` VALUES ('proc', '37', '500', '管理内容', null);
INSERT INTO `purview` VALUES ('proc', '38', '500', '管理内容', null);
INSERT INTO `purview` VALUES ('edit', '39', '500', '修改内容', null);
INSERT INTO `purview` VALUES ('edit', '40', '500', '修改内容', null);
INSERT INTO `purview` VALUES ('proc', '41', '500', '管理内容', null);
INSERT INTO `purview` VALUES ('proc', '42', '500', '管理内容', null);
INSERT INTO `purview` VALUES ('proc', '43', '500', '管理通知', null);
INSERT INTO `purview` VALUES ('set', '20', '500', '机构设置', null);
INSERT INTO `purview` VALUES ('add', '55', '500', '添加文章', null);
INSERT INTO `purview` VALUES ('edit', '55', '500', '修改文章(受限)', null);
INSERT INTO `purview` VALUES ('del', '55', '500', '删除文章(受限)', null);
INSERT INTO `purview` VALUES ('editAll', '55', '500', '修改文章(不受限)', null);
INSERT INTO `purview` VALUES ('editAll', '55', '500', '修改文章(不受限)', null);

-- ----------------------------
-- Table structure for `question`
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `question_id` int(10) NOT NULL auto_increment,
  `consent_id` int(10) default NULL COMMENT '对应行政许可事项的id',
  `question_state` int(11) default '1' COMMENT '1未回答 2已回答',
  `question_time` date default NULL COMMENT '提问时间',
  `question_content` text collate utf8_unicode_ci COMMENT '提问内容',
  PRIMARY KEY  (`question_id`),
  KEY `NewIndex` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('4397', '0', '2', '2011-06-21', '未来10年内，湖北争取进入全国教育强省前列，这个目标是基于什么背景制定的？ ');
INSERT INTO `question` VALUES ('4405', '3', '2', '2012-03-15', '是怎么回事');

-- ----------------------------
-- Table structure for `site_template`
-- ----------------------------
DROP TABLE IF EXISTS `site_template`;
CREATE TABLE `site_template` (
  `template_dir_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `template_type` int(11) NOT NULL COMMENT '1=主网站模板2=子网站模板',
  `template_name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '模板名称'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of site_template
-- ----------------------------
INSERT INTO `site_template` VALUES ('1', '2', '默认模板');
INSERT INTO `site_template` VALUES ('1', '1', '默认模板');

-- ----------------------------
-- Table structure for `sub_sites`
-- ----------------------------
DROP TABLE IF EXISTS `sub_sites`;
CREATE TABLE `sub_sites` (
  `sub_sites_id` int(11) NOT NULL auto_increment,
  `admin_id` int(11) NOT NULL COMMENT '管理员用户表id',
  `site_state` int(11) NOT NULL default '1' COMMENT '网站状态:1=正常2=关停',
  `site_type` int(11) NOT NULL default '2',
  `template_dir_name` varchar(30) collate utf8_unicode_ci NOT NULL COMMENT '网站模板目录名',
  `site_name` varchar(30) collate utf8_unicode_ci default NULL COMMENT '网站名称',
  `site_href` varchar(255) collate utf8_unicode_ci default NULL COMMENT '网站链接',
  `col_id_list` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`sub_sites_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sub_sites
-- ----------------------------
INSERT INTO `sub_sites` VALUES ('1', '2', '1', '1', '1', '武昌区教育局', 'www.wuchang.e21.cn', '');

-- ----------------------------
-- Table structure for `survey`
-- ----------------------------
DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
  `columns_id` int(11) NOT NULL,
  `survey_contents` varchar(600) collate utf8_unicode_ci default NULL COMMENT '调查的内容',
  `survey_type` int(11) default '1' COMMENT '调查答案类型1=多选2=单选',
  `display_type` int(11) default '1' COMMENT '显示方式1=条型显示2=圆型显示3=混合显示',
  `text_display_mode` int(11) default '3' COMMENT '文字显示方式1=百分比2=票数3=百分比+票数',
  PRIMARY KEY  (`columns_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of survey
-- ----------------------------
INSERT INTO `survey` VALUES ('32', '学前教育你的孩子会选择哪种幼儿园?', '2', '1', '3');
INSERT INTO `survey` VALUES ('76', '义务教育如何均衡发展？', '2', '1', '3');

-- ----------------------------
-- Table structure for `survey_custom`
-- ----------------------------
DROP TABLE IF EXISTS `survey_custom`;
CREATE TABLE `survey_custom` (
  `survey_custom_id` int(11) NOT NULL auto_increment,
  `survey_item_id` int(11) NOT NULL,
  `custom_contents` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`survey_custom_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of survey_custom
-- ----------------------------

-- ----------------------------
-- Table structure for `survey_item`
-- ----------------------------
DROP TABLE IF EXISTS `survey_item`;
CREATE TABLE `survey_item` (
  `survey_item_id` int(11) NOT NULL auto_increment,
  `columns_id` int(11) NOT NULL,
  `item_type` int(1) NOT NULL,
  `item_count` int(11) NOT NULL default '0',
  `display_order` int(11) NOT NULL default '100',
  `item_contents` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`survey_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of survey_item
-- ----------------------------
INSERT INTO `survey_item` VALUES ('9', '32', '2', '6', '100', '国际幼儿园');
INSERT INTO `survey_item` VALUES ('10', '32', '2', '18', '100', '双语幼儿园');
INSERT INTO `survey_item` VALUES ('11', '32', '2', '2', '100', '普通民办幼儿园');
INSERT INTO `survey_item` VALUES ('12', '32', '2', '2', '100', '社区中心幼儿园一类的');
INSERT INTO `survey_item` VALUES ('13', '32', '2', '16', '100', '就近找一个就行了');
INSERT INTO `survey_item` VALUES ('15', '76', '2', '13', '100', '加大对农村学校尤其是薄弱学校的投入');
INSERT INTO `survey_item` VALUES ('16', '76', '2', '3', '100', '加大对城市薄弱学校的帮扶力度');
INSERT INTO `survey_item` VALUES ('17', '76', '2', '3', '100', '加强中小学标准化建设');
INSERT INTO `survey_item` VALUES ('18', '76', '2', '4', '100', '加大农村学校教师队伍建设');

-- ----------------------------
-- Table structure for `sys_config`
-- ----------------------------
DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config` (
  `item_name` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '配置项名称',
  `item_value` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`item_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_config
-- ----------------------------
INSERT INTO `sys_config` VALUES ('uploadFileType', ',jpg,gif,png,txt,doc,xls,zip,rar,');
INSERT INTO `sys_config` VALUES ('Version', '2.0.0.0');

-- ----------------------------
-- Table structure for `upload_files`
-- ----------------------------
DROP TABLE IF EXISTS `upload_files`;
CREATE TABLE `upload_files` (
  `file_id` int(11) NOT NULL auto_increment,
  `file_size` int(11) NOT NULL,
  `file_admin_id` int(11) NOT NULL COMMENT '文件上传者id',
  `file_state` int(11) NOT NULL default '1' COMMENT '1=正常 2=删除',
  `is_sys` int(11) default '0',
  `create_time` datetime NOT NULL COMMENT '上传时间',
  `file_type` varchar(10) collate utf8_unicode_ci default NULL,
  `file_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `file_admin` varchar(100) collate utf8_unicode_ci default NULL,
  `file_note` varchar(255) collate utf8_unicode_ci default NULL,
  `admin_ip` varchar(25) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of upload_files
-- ----------------------------
INSERT INTO `upload_files` VALUES ('4024', '9082', '2', '1', '0', '2012-03-13 12:01:27', 'gif', '/html/upload/2012/03/13/file1331611557.gif', '网站管理员', '专题1', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4025', '29333', '2', '1', '0', '2012-03-13 12:01:41', 'gif', '/html/upload/2012/03/13/file1331612260.gif', '网站管理员', '专题1', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4026', '12614', '2', '1', '0', '2012-03-13 12:03:00', 'jpg', '/html/upload/2012/03/13/file1331611962.jpg', '网站管理员', '测试', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4027', '12614', '2', '2', '0', '2012-03-13 12:05:25', 'jpg', '/html/upload/2012/03/13/file1331611742.jpg', '网站管理员', '滚动图片', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4028', '231176', '2', '1', '0', '2012-03-13 14:39:40', 'jpg', '/html/upload/2012/03/13/file1331621244.jpg', '网站管理员', '测试', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4029', '231176', '2', '1', '0', '2012-03-13 16:39:40', 'jpg', '/html/upload/2012/03/13/file1331628635.jpg', '网站管理员', '00', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4030', '6327', '2', '1', '0', '2012-03-14 08:55:54', 'gif', '/html/upload/2012/03/14/file1331686933.gif', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4031', '10975', '2', '1', '0', '2012-03-14 09:10:00', 'gif', '/html/upload/2012/03/14/file1331688279.gif', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4032', '12614', '2', '1', '0', '2012-03-14 10:39:35', 'jpg', '/html/upload/2012/03/14/file1331693126.jpg', '网站管理员', '1', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4033', '9082', '2', '1', '0', '2012-03-14 11:15:05', 'gif', '/html/upload/2012/03/14/file1331695069.gif', '网站管理员', '专题', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4034', '29333', '2', '1', '0', '2012-03-14 11:15:11', 'gif', '/html/upload/2012/03/14/file1331695396.gif', '网站管理员', '专题', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4035', '9082', '2', '1', '0', '2012-03-14 11:38:54', 'gif', '/html/upload/2012/03/14/file1331696908.gif', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4036', '176036', '2', '1', '0', '2012-03-14 11:40:16', 'jpg', '/html/upload/2012/03/14/file1331696954.jpg', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4037', '27848', '2', '1', '0', '2012-03-14 11:52:39', 'jpg', '/html/upload/2012/03/14/file1331697347.jpg', '网站管理员', '2', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4038', '27848', '2', '1', '0', '2012-03-14 11:54:23', 'jpg', '/html/upload/2012/03/14/file1331698233.jpg', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4039', '231176', '2', '1', '0', '2012-03-14 13:54:24', 'jpg', '/html/upload/2012/03/14/file1331704963.jpg', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4040', '27848', '2', '1', '0', '2012-03-15 11:49:29', 'jpg', '/html/upload/2012/03/15/file1331783737.jpg', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4041', '231176', '2', '1', '0', '2012-03-15 11:53:04', 'jpg', '/html/upload/2012/03/15/file1331783928.jpg', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4042', '1588', '2', '1', '0', '2012-03-16 22:17:24', 'jpg', '/html/upload/2012/03/16/file1331907741.jpg', '网站管理员', '0', '127.0.0.1');
INSERT INTO `upload_files` VALUES ('4043', '38113', '2', '1', '0', '2012-03-19 07:43:02', 'swf', '/html/upload/2012/03/19/file1332114885.swf', '网站管理员', '0', '127.0.0.1');

-- ----------------------------
-- Table structure for `work`
-- ----------------------------
DROP TABLE IF EXISTS `work`;
CREATE TABLE `work` (
  `article_id` int(11) NOT NULL auto_increment,
  `columns_id` int(11) default NULL COMMENT '栏目id，对应work_columns表，pid为-1的栏目',
  `article_title` varchar(255) collate utf8_unicode_ci default NULL,
  `article_from` varchar(255) collate utf8_unicode_ci default NULL,
  `article_ath` varchar(255) collate utf8_unicode_ci default NULL,
  `article_time` datetime default NULL,
  `click_count` int(11) default '0' COMMENT '点击量',
  `article_order` float(11,3) default NULL,
  `article_key` varbinary(255) default NULL,
  `base_id` int(11) default NULL COMMENT '基本设置对象id，对应work_columns表',
  `person` int(11) default NULL COMMENT '责任人id',
  `department` int(11) default NULL COMMENT '责任部门id',
  `person_tel` varchar(50) collate utf8_unicode_ci default NULL COMMENT '责任人联系电话',
  `guide` varchar(1000) collate utf8_unicode_ci default NULL,
  `unit` int(11) default NULL COMMENT '单位',
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of work
-- ----------------------------
INSERT INTO `work` VALUES ('1', '1', '表格下载1', '表格下载1', null, '2010-06-01 16:28:31', '290', '0.000', '', '8', '0', '0', '', '表格下载1表格下载1', '0');
INSERT INTO `work` VALUES ('2', '2', '行政许可1', '行政许可1', null, '2010-06-02 14:58:36', '39', '0.000', '', '9', '0', '0', '111', '行政许可1办事指南', '0');
INSERT INTO `work` VALUES ('3', '2', '民办教育机构设置、分立、合并、变更、终止审批', '汉阳区教育局', null, '2010-06-02 16:38:03', '4', '0.000', 0xE6B091E58A9EEFBC8CE69599E882B2E69CBAE69E84EFBC8CE8AEBEE7BDAEEFBC8CE58886E7AB8BEFBC8CE59088E5B9B6EFBC8CE58F98E69BB4EFBC8CE7BB88E6ADA2EFBC8CE5AEA1E689B9, '8', '0', '0', '', '1、受理：申请设置的举办者所提交的文件、证件、材料和审批表全部有效、齐全后，方可受理；\r\n2、审查：审查提交的文件、证件、材料和审批表的真实性、合法性、有效性，并核实教育培训机构的设置事项和条件；\r\n3、审批：经审查和核实后，作出准予设置或者不准予设置的决定，并书面通知申请人；\r\n4、发证：对审批准予设置民办非学历教育机构，颁发《中华人民共和国民办学校许可证》；\r\n5、公告：对准予设置民办非学历教育机构，由审批机关发布公告。', '0');

-- ----------------------------
-- Table structure for `work_columns`
-- ----------------------------
DROP TABLE IF EXISTS `work_columns`;
CREATE TABLE `work_columns` (
  `columns_id` int(11) NOT NULL auto_increment,
  `columns_handle` varchar(50) collate utf8_unicode_ci default NULL COMMENT '句柄',
  `columns_name` varchar(100) collate utf8_unicode_ci default NULL,
  `columns_pid` int(11) default '0' COMMENT '对应父栏目id',
  PRIMARY KEY  (`columns_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of work_columns
-- ----------------------------
INSERT INTO `work_columns` VALUES ('1', 'fxzxk', '非行政许可项', '-1');
INSERT INTO `work_columns` VALUES ('2', 'xzxk', '行政许可事项', '-1');
INSERT INTO `work_columns` VALUES ('3', 'qt', '其它', '-1');
INSERT INTO `work_columns` VALUES ('5', 'student', '学生办事', '0');
INSERT INTO `work_columns` VALUES ('6', 'school', '学校办事', '0');
INSERT INTO `work_columns` VALUES ('8', 'student_bgxz', '表格下载', '5');
INSERT INTO `work_columns` VALUES ('9', 'student_ksbm', '考试报名', '5');
INSERT INTO `work_columns` VALUES ('11', 'teatch', '教师办事', '0');
INSERT INTO `work_columns` VALUES ('12', 'student_zscx', '证书查询', '5');
INSERT INTO `work_columns` VALUES ('13', 'student_fscx', '分数查询', '5');
INSERT INTO `work_columns` VALUES ('14', 'school_zsrx', '招生热线', '6');
INSERT INTO `work_columns` VALUES ('15', 'school_bgcz', '表格下载', '6');
INSERT INTO `work_columns` VALUES ('16', 'school_wsbg', '网上办公', '6');
INSERT INTO `work_columns` VALUES ('17', 'school_qt', '其他', '6');

-- ----------------------------
-- Table structure for `work_content`
-- ----------------------------
DROP TABLE IF EXISTS `work_content`;
CREATE TABLE `work_content` (
  `work_id` int(11) NOT NULL,
  `work_content` longtext collate utf8_unicode_ci,
  `guide` text collate utf8_unicode_ci COMMENT '办事指南',
  PRIMARY KEY  (`work_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of work_content
-- ----------------------------
INSERT INTO `work_content` VALUES ('0', '表格下载1表格下载1表格下载1表格下载1表格下载1', null);
INSERT INTO `work_content` VALUES ('1', '表格下载1表格下载1表格下载1htmlspecialchars_decode&quot;gffh&quot;', null);
INSERT INTO `work_content` VALUES ('2', '行政许可1', null);
INSERT INTO `work_content` VALUES ('3', '表格下载2&lt;div class=l_xinxiList&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.jszg.edu.cn/search.jsp&quot;&gt;教师资格证查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://dzda.e21.cn/&quot;&gt;学生学籍查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://cx.e21.cn/&quot;&gt;高考查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://putonghua.027web.cn/&quot;&gt;普通话水平测试&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.hbee.edu.cn/html/cx/index.html&quot;&gt;自修考试查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://zkcx2.jm.e21.cn/&quot;&gt;中考成绩查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.weather.com.cn/weather/101201402.shtml?from=cn&quot;&gt;钟祥天气查询&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=box6&gt;&lt;a href=&quot;http://www.hao123.com/ss/lccx.htm&quot;&gt;列车时刻查询&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;', null);

-- ----------------------------
-- View structure for `view_art_ath_count`
-- ----------------------------
DROP VIEW IF EXISTS `view_art_ath_count`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_art_ath_count` AS select count(0) AS `art_num`,`article`.`article_ath` AS `article_ath` from `article` where ((`article`.`article_time` >= _utf8'2012-01-01') and (`article`.`article_time` <= _utf8'2012-12-31')) group by `article`.`article_ath` order by count(0) desc ;
