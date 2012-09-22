<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");
include_once("site_function.php");

class addSubSiteClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $template_dir_name;
	public $site_name;
	public $site_href;
	public $templateList;
	
	public $corp_id;
	public $user_id;
	public $treeItemStr;
	
	function addSubSiteClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		$this->template_dir_name = "";
		$this->site_name = "";
		$this->site_href = "";
		$this->templateList;
		$this->corp_id = 0;
		$this->user_id = 0;	
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";
						
		//取模板列表
		$sqlstr = "select * from site_template where template_type=2";
		$this->templateList = $this->mysql->findAllRec($sqlstr);
		if ($this->templateList == -1){
			$this->errorMessage = "模板信息丢失!";
			$this->toURL = "../logout.php";
			return;
		}
		
		//取管理员和单位
		$sqlstr = "select c_id,short_name from corp";
		$this->treeItemStr = "[['所有单位','',".getTreeStr($this->mysql,$sqlstr).']]';
		
				
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();			
		}		
	}
	
	function btnAdd_Click()
	{
		
		
		//填充form
		$this->template_dir_name = trim($this->postVars["template_dir_name"]);
		$this->site_href = strtolower(trim($this->postVars["site_href"]));
		$this->site_name = trim($this->postVars["site_name"]);
		$this->corp_id = $this->postVars["corp_id"];
		$this->user_id = $this->postVars["user_id"];
		
		//检查参数
		if (strlen($this->site_name) <= 0) {
			$this->errorMessage = "请填写网站名称";
			return;
		}
		
		//添加网站信息		
		$sqlstr = "insert into sub_sites(admin_id,site_state,site_type,template_dir_name,site_name,site_href) values(" .
					"$this->user_id,2,2,'$this->template_dir_name','$this->site_name','$this->site_href')";			
		$this->mysql->insertRec($sqlstr);
		//取新子站ID		
		$sub_id = $this->mysql->getNewInsertID();
		
		//更新用户表
		$sqlstr = "update admins set user_sub_id=$sub_id where user_id=$this->user_id";		
		$this->mysql->updateRec($sqlstr);
		//添加子网站栏目
		$this->addSubSiteColumns($this->user_id,$sub_id);		
		
		$this->errorMessage = "添加已成功,现在网站处于关停状态，请在完成内容编辑后再开通该子站点!";		
		$this->toURL = "manageSubSite.php";
	}
	/**
 	* 添加子网站的栏目
 	* @param $admin_id 子网站管理员ID
 	* @param $subSite_id 子网站ID  	
 	*/
 	function addSubSiteColumns($admin_id,$subSite_id)
 	{
 		//显示栏目的ID LIST 
 		//顺序 0-13 -> 导航栏，网站地图，关于我们，公示公告，网上调查，图片新闻-幻灯片,图片新闻，教育要闻,最新政策,机关处室,友情链接,底部链接,版权
 		$id_list = array();
 		$type_handel = array(); //栏目类型句柄
 		$type_handel_id = array();//栏目类型ID
 		$sqlstr = "";		
		$sqlResult;

		// ==== 变量初始化
		$sqlstr = "select columns_type_id from columns_type where type_handle='";
 		//文章栏目
 		$type_handel[0]='wzlm'; 		
		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[0]'");
		$type_handel_id[0]= $sqlResult["columns_type_id"];		
 		//图片列表栏目
 		$type_handel[1]='tplblm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[1]'");
		$type_handel_id[1]= $sqlResult["columns_type_id"];
 		//图片幻灯片栏目
 		$type_handel[2]='tphdplm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[2]'");
		$type_handel_id[2]= $sqlResult["columns_type_id"]; 		
 		//调查栏目
 		$type_handel[4]='dclm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[4]'");
		$type_handel_id[4]= $sqlResult["columns_type_id"];
 		//自由编辑栏目
 		$type_handel[5]='zybjlm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[5]'");
		$type_handel_id[5]= $sqlResult["columns_type_id"];
 		//二级链接条栏目
 		$type_handel[6]='ejljtlm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[6]'");
		$type_handel_id[6]= $sqlResult["columns_type_id"];
 		//链接条栏目
 		$type_handel[7]='ljtlm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[7]'");
		$type_handel_id[7]= $sqlResult["columns_type_id"];
 		//图片表格栏目
 		$type_handel[8]='tpbglm';
 		$sqlResult = $this->mysql->findOneRec($sqlstr . "$type_handel[8]'");
		$type_handel_id[8]= $sqlResult["columns_type_id"];

 		
 		// ======== 关于我们(地理位置，联系我们)
 		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[0]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[0],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[0].$columns_sn,
									'关于我们');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[0].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[2] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,34,$id_list[2],',add,editAll,delAll,');";
		$this->mysql->insertRec($sqlstr);
		//添加内容-地理位置
		$sqlstr = "insert into article(item_id,article_order,article_time,article_state,comments_type,article_title,article_from,article_ath,article_key) values(" .
						"$id_list[2],100,now(),1,1,'地理位置','','','');";			
		$this->mysql->insertRec($sqlstr);
		//取ID
		$dlwz_id = $this->mysql->getNewInsertID();
		$sqlstr = "insert into article_content(article_id,article_content) values(" .
					"$dlwz_id,'地理位置');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-联系我们
		$sqlstr = "insert into article(item_id,article_order,article_time,article_state,comments_type,article_title,article_from,article_ath,article_key) values(" .
						"$id_list[2],100,now(),1,1,'联系我们','','','');";			
		$this->mysql->insertRec($sqlstr);
		//取ID
		$lxwm_id = $this->mysql->getNewInsertID();			
		$sqlstr = "insert into article_content(article_id,article_content) values(" .
					"$lxwm_id,'联系我们');";			
		$this->mysql->insertRec($sqlstr);
 		
 		// ======== 公示公告
 		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[0]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[0],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[0].$columns_sn,
									'公示公告');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[0].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[3] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,34,$id_list[3],',add,editAll,delAll,');";
		$this->mysql->insertRec($sqlstr);

		// ======== 图片新闻
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[0]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[0],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[0].$columns_sn,
									'图片新闻');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[0].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[6] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,34,$id_list[6],',add,editAll,delAll,');";
		$this->mysql->insertRec($sqlstr);
		// ======== 图片新闻-图片
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[1]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[1],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[1].$columns_sn,
									'图片新闻-图片');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[1].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$hdpImgID = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,38,$hdpImgID,',proc,');";
		$this->mysql->insertRec($sqlstr);
		// ======== 图片新闻-幻灯片
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[2]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[2],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[2].$columns_sn,
									'图片新闻-幻灯片');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[2].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[5] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,40,$id_list[5],',edit,');";
		$this->mysql->insertRec($sqlstr);
		//创建扩展信息
		$sqlstr = " insert into columns_slideimage(columns_id,text_height,img_width,img_heigth,columns_imagelist_id) values($id_list[5],20,227,161,$hdpImgID);";
		$this->mysql->insertRec($sqlstr);
		
		// ======== 教育要闻
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[0]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[0],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[0].$columns_sn,
									'教育要闻');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[0].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[7] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,34,$id_list[7],',add,editAll,delAll,');";
		$this->mysql->insertRec($sqlstr);
		
		// ======== 最新政策
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[0]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[0],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[0].$columns_sn,
									'最新政策');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[0].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[8] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,34,$id_list[8],',add,editAll,delAll,');";
		$this->mysql->insertRec($sqlstr);
		
		// ======== 机关处室		
		$id_list[9] = $this->corp_id;
		
		// ======== 网上调查
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[4]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[4],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[4].$columns_sn,
									'网上调查');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[4].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[4] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,37,$id_list[4],',proc,');";
		$this->mysql->insertRec($sqlstr);
		//创建扩展信息
		$createResult = createColumns_dclm($this->mysql,$type_handel[4].$columns_sn);
		
		
		// ======== 友情链接
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[5]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[5],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[5].$columns_sn,
									'友情链接');		
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[5].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[10] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,36,$id_list[10],',edit,');";
		$this->mysql->insertRec($sqlstr);
		//创建扩展信息
		//取系统栏目内容
		$sqlstr = "select columns_contents from columns_html where columns_id in (select columns_id from columns where columns_handle='zybjlm2')";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$tmpstr = $sqlResult["columns_contents"];
		$sqlstr = " insert into columns_html(columns_id,columns_contents) values($id_list[10],'$tmpstr');";
		$this->mysql->insertRec($sqlstr);
		
		// ======== 网站地图
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[6]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[6],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[6].$columns_sn,
									'网站地图');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[6].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[1] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,42,$id_list[1],',proc,');";
		$this->mysql->insertRec($sqlstr);
		
 		// ======== 底部链接 (地理位置 | 网站地图 | 关于我们)
 		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[7]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[7],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[7].$columns_sn,
									'底部链接');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[7].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[11] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,35,$id_list[11],',proc,');";
		$this->mysql->insertRec($sqlstr);
		//添加内容-地理位置
		$tmpstr = "article.php?s=$subSite_id&id=$dlwz_id";
		$sqlstr = "insert into columns_link(columns_id,item_title,item_link) values(" .
						"$id_list[11],'地理位置','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-网站地图
		$tmpstr = "map.php?s=$subSite_id&id=$id_list[1]";
		$sqlstr = "insert into columns_link(columns_id,item_title,item_link) values(" .
						"$id_list[11],'网站地图','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-关于我们		
		$tmpstr = "article_more.php?s=$subSite_id&id=$id_list[2]";
		$sqlstr = "insert into columns_link(columns_id,item_title,item_link) values(" .
						"$id_list[11],'关于我们','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		
		// ======== 导航栏-图片(首页187,机关处室188,教育要闻189,最新政策190,主站191,联系我们192)
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[1]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[1],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[1].$columns_sn,
									'导航栏-图片');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[1].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$dhl_ImgID = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,38,$dhl_ImgID,',proc,');";
		$this->mysql->insertRec($sqlstr);
		//添加内容-首页187
		$tmpstr = WEB_DIRECTORY_NAME."sindex.php?s=$subSite_id";
		$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$dhl_ImgID,187,90,'首页','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-机关处室188
		$tmpstr = "viewPart.php?s=$subSite_id";
		$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$dhl_ImgID,188,91,'机关处室','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-教育要闻189
		$tmpstr = "article_more.php?s=$subSite_id&id=$id_list[7]";
		$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$dhl_ImgID,189,92,'教育要闻','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-最新政策190
		$tmpstr = "article_more.php?s=$subSite_id&id=$id_list[8]";
		$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$dhl_ImgID,190,93,'最新政策','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-主站191
		$tmpstr = WEB_DIRECTORY_NAME."index.php";
		$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$dhl_ImgID,191,94,'主站','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		//添加内容-联系我们192
		$tmpstr = "article.php?s=$subSite_id&id=$lxwm_id";
		$sqlstr = "insert into columns_imagelist(columns_id,file_id,item_order,item_title,item_link) values(" .
						"$dhl_ImgID,192,95,'联系我们','$tmpstr');";			
		$this->mysql->insertRec($sqlstr);
		// ======== 导航栏
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[8]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[8],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[8].$columns_sn,
									'导航栏');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[8].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[0] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,39,$id_list[0],',edit,');";
		$this->mysql->insertRec($sqlstr);
		//创建扩展信息
		$sqlstr = " insert into columns_imagetable(columns_id,columns_imagelist_id,text_xy) values($id_list[0],$dhl_ImgID,3);";
		$this->mysql->insertRec($sqlstr);		
		
		// ======== 版权
		//生成栏目句柄
 		$columns_sn = getNewColumns_sn($this->mysql,$type_handel[5]);
 		//创建的基本信息
		$createResult = createColumns_base_info(
									$this->mysql,
									$type_handel_id[5],
									$admin_id,
									0,
									$subSite_id,
									$type_handel[5].$columns_sn,
									'版权');
		//取新栏目ID	
		$sqlstr = "select columns_id from columns where columns_handle='".$type_handel[5].$columns_sn."'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$id_list[12] = $sqlResult["columns_id"];
		//设置权限
		$sqlstr = "insert into my_object (user_id,menu_id,obj_id,pur_list) values($admin_id,36,$id_list[12],',edit,');";
		$this->mysql->insertRec($sqlstr);
		//创建扩展信息
		//取系统栏目内容
		$sqlstr = "select columns_contents from columns_html where columns_id in (select columns_id from columns where columns_handle='zybjlm1')";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$tmpstr = $sqlResult["columns_contents"];
		$sqlstr = " insert into columns_html(columns_id,columns_contents) values($id_list[12],'$tmpstr');";
		$this->mysql->insertRec($sqlstr);

		// ======== 更新站点表id_list
		$tmpstr = "";
		for($i=0;$i<count($id_list);++$i)
		{
			$tmpstr = $tmpstr . $id_list[$i].',';
		}
		$tmpstr = substr($tmpstr,0,strlen($tmpstr) - 1);
		$sqlstr = "update sub_sites set col_id_list='$tmpstr' where admin_id=$admin_id";			
		$this->mysql->updateRec($sqlstr); 		
 	}
}
?>