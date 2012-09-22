/**************************************************************
WLEditor 1.0
Copyright (c) 2006 

Author: 王雷(wl2010tw@gmail.com)
Created: 2006/08/08
Last Modified: 2011/04/28 11:11 王雷
**************************************************************/

var IMAGE_PATH;
var MENU_BORDER_COLOR;
var MENU_BG_COLOR;
var MENU_TEXT_COLOR;
var MENU_SELECTED_COLOR;
var TOOLBAR_BG_COLOR;
var FORM_BORDER_COLOR;
var FORM_BG_COLOR;
var OBJ_NAME;
var SELECTION;
var RANGE;
var RANGE_TEXT;
var EDITFORM_DOCUMENT;
var UPLOAD_IMAGE_FUNCTION;
var UPLOAD_flash_FUNCTION;
var UPLOAD_FILE_FUNCTION;
var BROWSER;
var TOOLBAR_ICON;

//针对IE失去焦点丢失光标位置的特殊处理
var ieSelectionBookmark; //光标位置变量 
//焦点记录函数
var bookmark = function() {	
    var range = EDITFORM_DOCUMENT.selection.createRange();
    ieSelectionBookmark = range.getBookmark();   
};
//焦点恢复函数
var restoreBookmark = function() {	
    if (ieSelectionBookmark) {
        var range = EDITFORM_DOCUMENT.body.createTextRange();
        range.moveToBookmark(ieSelectionBookmark);
        range.collapse();
        range.select();       
    }
};


var MSG_INPUT_URL = "请输入正确的URL地址。";
var MSG_INVALID_IMAGE = "只能选择GIF,JPG,PNG,BMP格式的图片，请重新选择。";
var MSG_INVALID_FLASH = "只能选择SWF格式的图片，请重新选择。";
var MSG_INVALID_MEDIA = "只能选择MP3,WMV,ASF,WMA,RM格式的图片，请重新选择。";
var STR_BUTTON_INSERT = "插入文档";
var STR_BUTTON_CLOSE = "关闭窗口";
var STR_BUTTON_PREVIEW = "预览";
var STR_URL = "地址:";
var URL_TITLE = "名称:";
var STR_IMAGE_UPLOAD = "本机上传";
var STR_LINK_BLANK = "新窗口";
var STR_LINK_NOBLANK = "当前窗口";
var STR_LINK_TARGET = "目标";
var STR_ABOUT = "联系我";

var EDITOR_FONT_FAMILY = "SimSun";

var FONT_NAME = Array(
					Array('SimSun', '宋体'), 
					Array('SimHei', '黑体'), 
					Array('FangSong_GB2312', '仿宋体'), 
					Array('KaiTi_GB2312', '楷体'), 
					Array('NSimSun', '新宋体'), 
					Array('Arial', 'Arial'), 
					Array('Arial Black', 'Arial Black'), 
					Array('Times New Roman', 'Times New Roman'), 
					Array('Courier New', 'Courier New'), 
					Array('Tahoma', 'Tahoma'), 
					Array('Verdana', 'Verdana'), 
					Array('GulimChe', 'GulimChe'), 
					Array('MS Gothic', 'MS Gothic') 
					);
					
var ZOOM_TABLE = Array('500%','250%', '200%', '150%', '120%', '100%', '80%', '50%','25%');

var TITLE_TABLE = Array(
					Array('H1', '标题 1'), 
					Array('H2', '标题 2'), 
					Array('H3', '标题 3'), 
					Array('H4', '标题 4'), 
					Array('H5', '标题 5'), 
					Array('H6', '标题 6')
					);
					
var FONT_SIZE = Array(
					Array(1,'8pt'),
					Array(2,'9pt'),
					Array(2,'10pt'), 
					Array(3,'12pt'), 
					Array(4,'14pt'), 
					Array(5,'18pt'), 
					Array(6,'24pt'), 
					Array(7,'36pt')
				);
				
var SPECIAL_CHARACTER = Array('§','№','☆','★','○','●','◎','◇','◆','□','℃','‰','■','△','▲','※',
							'→','←','↑','↓','〓','¤','°','＃','＆','＠','＼','︿','＿','￣','―','α',
							'β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο','π','ρ',
							'σ','τ','υ','φ','χ','ψ','ω','≈','≡','≠','＝','≤','≥','＜','＞','≮',
							'≯','∷','±','＋','－','×','÷','／','∫','∮','∝','∞','∧','∨','∑','∏',
							'∪','∩','∈','∵','∴','⊥','∥','∠','⌒','⊙','≌','∽','〖','〗','【','】',
							'（','）','［','］');
							
var TOP_TOOLBAR_ICON = Array(
						Array('WL_SOURCE', 'source.gif', '26', '20', '视图转换'),
						Array('WL_PREVIEW', 'preview.gif', '20', '20', '预览'),						
						Array('WL_PRINT', 'print.gif', '20', '20', '打印'),
						Array('WL_SELECTALL', 'selectall.gif', '29', '20', '全选'),
						Array('WL_REMOVE', 'removeformat.gif', '20', '20', '清除格式'),						
						Array('WL_NO_OP1', 'sp.gif', '2', '20', ''),
						Array('WL_UNDO', 'undo.gif', '20', '20', '回退'),
						Array('WL_REDO', 'redo.gif', '20', '20', '前进'),
						Array('WL_NO_OP2', 'sp.gif', '2', '20', ''),
						Array('WL_CUT', 'cut.gif', '20', '20', '剪切'),
						Array('WL_COPY', 'copy.gif', '20', '20', '复制'),
						Array('WL_PASTE', 'paste.gif', '20', '20', '粘贴'),
						Array('WL_NO_OP3', 'sp.gif', '2', '20', ''),						
						Array('WL_LINK', 'link.gif', '20', '20', '创建超级连接'),
						Array('WL_UNLINK', 'unlink.gif', '20', '20', '删除超级连接'),
						Array('WL_NO_OP4', 'sp.gif', '2', '20', ''),
						Array('WL_IMAGE', 'image.gif', '20', '20', '插入图片'),
						Array('WL_FLASH', 'flash.gif', '20', '20', '插入Flash'),
						Array('WL_MEDIA', 'media.gif', '20', '20', '插入视频'),
						Array('WL_ADDITION', 'addition.gif', '20', '20', '插入附件'),
						Array('WL_NO_OP5', 'sp.gif', '2', '20', ''),
						Array('WL_DATE', 'date.gif', '20', '20', '插入日期'),
						Array('WL_TIME', 'time.gif', '20', '20', '插入时间'),
						Array('WL_TABLE', 'table.gif', '20', '20', '插入表格'),
						Array('WL_LAYER', 'layer.gif', '20', '20', '插入层'),						
						Array('WL_NO_OP6', 'sp.gif', '2', '20', ''),
						Array('WL_SPECIALCHAR', 'specialchar.gif', '20', '20', '插入特殊字符'),
						Array('WL_HR', 'hr.gif', '20', '20', '插入横线'),						
						Array('WL_NO_OP7', 'sp.gif', '2', '20', ''),
						Array('WL_ABOUT', 'about.gif', '20', '20', '关于')
				  );
				  
var BOTTOM_TOOLBAR_ICON = Array(
						Array('WL_TITLE', 'title.gif', '26', '20', '标题'),
						Array('WL_FONTNAME', 'font.gif', '26', '20', '字体'),
						Array('WL_FONTSIZE', 'fontsize.gif', '26', '20', '文字大小'),						
						Array('WL_NO_OP8', 'sp.gif', '2', '20', ''),
						Array('WL_BOLD', 'bold.gif', '20', '20', '粗体'),
						Array('WL_ITALIC', 'italic.gif', '20', '20', '斜体'),
						Array('WL_UNDERLINE', 'underline.gif', '20', '20', '下划线'),
						Array('WL_STRIKE', 'strikethrough.gif', '20', '20', '删除线'),
						Array('WL_NO_OP9', 'sp.gif', '2', '20', ''),
						Array('WL_JUSTIFYLEFT', 'justifyleft.gif', '20', '20', '左对齐'),
						Array('WL_JUSTIFYCENTER', 'justifycenter.gif', '20', '20', '居中'),
						Array('WL_JUSTIFYRIGHT', 'justifyright.gif', '20', '20', '右对齐'),
						Array('WL_JUSTIFYFULL', 'justifyfull.gif', '20', '20', '两端对齐'),
						Array('WL_NO_OP10', 'sp.gif', '2', '20', ''),
						Array('WL_NUMBEREDLIST', 'numberedlist.gif', '20', '20', '编号'),
						Array('WL_UNORDERLIST', 'unorderedlist.gif', '20', '20', '项目符号'),
						Array('WL_INDENT', 'indent.gif', '20', '20', '减少缩进'),
						Array('WL_OUTDENT', 'outdent.gif', '20', '20', '增加缩进'),						
						Array('WL_NO_OP11', 'sp.gif', '2', '20', ''),
						Array('WL_TEXTCOLOR', 'textcolor.gif', '20', '20', '文字颜色'),
						Array('WL_BGCOLOR', 'bgcolor.gif', '20', '20', '文字背景'),
						Array('WL_NO_OP12', 'sp.gif', '2', '20', ''),
						Array('WL_SUBSCRIPT', 'subscript.gif', '20', '20', '下标'),
						Array('WL_SUPERSCRIPT', 'superscript.gif', '20', '20', '上标'),
						Array('WL_NO_OP13', 'sp.gif', '2', '20', ''),
						Array('WL_ZOOM', 'zoom.gif', '60', '20', '显示比例')							
				  );
var COLOR_TABLE = Array(
						"#FF0000", "#FFFF00", "#00FF00", "#00FFFF", "#0000FF", "#FF00FF", "#FFFFFF", "#F5F5F5", "#DCDCDC", "#FFFAFA",
						"#D3D3D3", "#C0C0C0", "#A9A9A9", "#808080", "#696969", "#000000", "#2F4F4F", "#708090", "#778899", "#4682B4",
						"#4169E1", "#6495ED", "#B0C4DE", "#7B68EE", "#6A5ACD", "#483D8B", "#191970", "#000080", "#00008B", "#0000CD",
						"#1E90FF", "#00BFFF", "#87CEFA", "#87CEEB", "#ADD8E6", "#B0E0E6", "#F0FFFF", "#E0FFFF", "#AFEEEE", "#00CED1",
						"#5F9EA0", "#48D1CC", "#00FFFF", "#40E0D0", "#20B2AA", "#008B8B", "#008080", "#7FFFD4", "#66CDAA", "#8FBC8F",
						"#3CB371", "#2E8B57", "#006400", "#008000", "#228B22", "#32CD32", "#00FF00", "#7FFF00", "#7CFC00", "#ADFF2F",
						"#98FB98", "#90EE90", "#00FF7F", "#00FA9A", "#556B2F", "#6B8E23", "#808000", "#BDB76B", "#B8860B", "#DAA520",
						"#FFD700", "#F0E68C", "#EEE8AA", "#FFEBCD", "#FFE4B5", "#F5DEB3", "#FFDEAD", "#DEB887", "#D2B48C", "#BC8F8F",
						"#A0522D", "#8B4513", "#D2691E", "#CD853F", "#F4A460", "#8B0000", "#800000", "#A52A2A", "#B22222", "#CD5C5C",
						"#F08080", "#FA8072", "#E9967A", "#FFA07A", "#FF7F50", "#FF6347", "#FF8C00", "#FFA500", "#FF4500", "#DC143C",
						"#FF0000", "#FF1493", "#FF00FF", "#FF69B4", "#FFB6C1", "#FFC0CB", "#DB7093", "#C71585", "#800080", "#8B008B",
						"#9370DB", "#8A2BE2", "#4B0082", "#9400D3", "#9932CC", "#BA55D3", "#DA70D6", "#EE82EE", "#DDA0DD", "#D8BFD8",
						"#E6E6FA", "#F8F8FF", "#F0F8FF", "#F5FFFA", "#F0FFF0", "#FAFAD2", "#FFFACD", "#FFF8DC", "#FFFFE0", "#FFFFF0",
						"#FFFAF0", "#FAF0E6", "#FDF5E6", "#FAEBD7", "#FFE4C4", "#FFDAB9", "#FFEFD5", "#FFF5EE", "#FFF0F5", "#FFE4E1"
					);

function getTimeStr()
{
	var date = new Date();
	var hour = date.getHours().toString(10);
	hour = hour.length < 2 ? '0' + hour : hour;
	var minute = date.getMinutes().toString(10);
	minute = minute.length < 2 ? '0' + minute : minute;
	var second = date.getSeconds().toString(10);
	second = second.length < 2 ? '0' + second : second;
	var value = hour + ':' + minute + ':' + second;
	return value;
}
function WLUploadImageClick()
{
  WLClearTemp();
  eval(UPLOAD_IMAGE_FUNCTION);
}
function WLUploadflashClick()
{
  WLClearTemp();
  eval(UPLOAD_flash_FUNCTION);
}
function WLUploadFileClick()
{
  WLClearTemp();
  eval(UPLOAD_FILE_FUNCTION );
}
function WLinsertFile(url,title)
{	
	if (BROWSER == 'IE') {
		restoreBookmark();
	}
	
	EditForm.focus();
	WLSelection();	
	
	var element = document.createElement("a");
	element.href = url;
	element.innerHTML = title;	

	WLSelect();
	WLInsertItem(element);
	WLClearTemp();
}
function WLDrawFile()
{
	var top = WLGetTop("WL_ADDITION") + 32;
	var left = WLGetLeft("WL_ADDITION") - 1;
	var str = '';	
	str += '<table cellpadding="0" cellspacing="0" style="width:250px;'+WLGetMenuCommonStyle(top, left)+'">' +
		'<tr><td style="width:35px;padding:10px;">'+STR_URL+'</td>' +
		'<td style="width:200px;padding-bottom:5px;"><input type="text" id="fileLink" value="http://" style="width:160px;border:1px solid #555555;">' +'</td></tr>' +
		'<tr><td style="width:35px;padding:10px;">'+URL_TITLE+'</td>' +
		'<td style="width:200px;padding-bottom:5px;"><input type="text" id="fileTitle" value="附件" style="width:160px;border:1px solid #555555;">' +'</td></tr>' +
		'<tr><td colspan="2" style="margin:5px;padding-bottom:5px;" align="center">' +
		'<input type="button" name="button" value="'+STR_IMAGE_UPLOAD+'" onclick="javascript:WLUploadFileClick();" style="border:1px solid #555555;"> ' +
		'<input type="button" name="button" value="'+STR_BUTTON_INSERT+'" onclick="javascript:WLDrawFileEnd();" style="border:1px solid #555555;"> ' +
		'<input type="button" name="button" value="'+STR_BUTTON_CLOSE+'" onclick="javascript:WLClearTemp();" style="border:1px solid #555555;"></td></tr>' + 
		'</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_IMAGE';
	
}
function WLDrawFileEnd()
{	
	var url = document.getElementById('fileLink').value;
	var title = document.getElementById('fileTitle').value;
	WLSelect();
	WLinsertFile(url,title);
	WLClearTemp();
	return true;
}
function WLGetBrowser()
{
	var browser = '';
	var agentInfo = navigator.userAgent.toLowerCase();
	if (agentInfo.indexOf("msie") > -1) {
		var re = new RegExp("msie\\s?([\\d\\.]+)","ig");
		var arr = re.exec(agentInfo);
		if (parseInt(RegExp.$1) >= 5.5) {
			browser = 'IE';
		}
	} else if (agentInfo.indexOf("firefox") > -1) {
		browser = 'FF';
	} else if (agentInfo.indexOf("netscape") > -1) {
		var temp1 = agentInfo.split(' ');
		var temp2 = temp1[temp1.length-1].split('/');
		if (parseInt(temp2[1]) >= 7) {
			browser = 'NS';
		}
	} else if (agentInfo.indexOf("gecko") > -1) {
		browser = 'ML';
	} else if (agentInfo.indexOf("opera") > -1) {
		var temp1 = agentInfo.split(' ');
		var temp2 = temp1[0].split('/');
		if (parseInt(temp2[1]) >= 9) {
			browser = 'OPERA';
		}
	}
	return browser;
}
function WLGetFileName(file, separator)
{
	var temp = file.split(separator);
	var len = temp.length;
	var fileName = temp[len-1];
	return fileName;
}
function WLGetFileExt(fileName)
{
	var temp = fileName.split(".");
	var len = temp.length;
	var fileExt = temp[len-1].toLowerCase();
	return fileExt;
}
function WLCheckImageFileType(file, separator)
{
	//判断URL地址的完整性
	//if (separator == "/" && file.match(/http:\/\/.{3,}/) == null) 
	// {
	//	alert(MSG_INPUT_URL);
	//	return false;
	// }
	var fileName = WLGetFileName(file, separator);
	var fileExt = WLGetFileExt(fileName);
	if (fileExt != 'gif' && fileExt != 'jpg' && fileExt != 'png' && fileExt != 'bmp') {
		alert(MSG_INVALID_IMAGE);
		return false;
	}
	return true;
}
function WLCheckFlashFileType(file, separator)
{
	//if (file.match(/http:\/\/.{3,}/) == null) {
	//	alert(MSG_INPUT_URL);
	//	return false;
	//}
	var fileName = WLGetFileName(file, "/");
	var fileExt = WLGetFileExt(fileName);
	if (fileExt != 'swf') {
		alert(MSG_INVALID_FLASH);
		return false;
	}
	return true;
}
function WLCheckMediaFileType(file, separator)
{
	if (file.match(/http:\/\/.{3,}/) == null) {
		alert(MSG_INPUT_URL);
		return false;
	}
	var fileName = WLGetFileName(file, "/");
	var fileExt = WLGetFileExt(fileName);
	if (fileExt != 'mp3' && fileExt != 'wmv' && fileExt != 'asf' && fileExt != 'wma' && fileExt != 'rm') {
		alert(MSG_INVALID_MEDIA);
		return false;
	}
	return true;
}
function WLHtmlentities(str)
{
	str = str.replace(/</g,'&lt;');
	str = str.replace(/>/g,'&gt;');
	str = str.replace(/&/g,'&amp;');
	str = str.replace(/"/g,'&quot;');
	return str;
}
function WLHtmlentitiesDecode(str)
{
	str = str.replace(/&lt;/g,'<');
	str = str.replace(/&gt;/g,'>');
	str = str.replace(/&amp;/g,'&');
	str = str.replace(/&quot;/g,'"');
	return str;
}
function WLHtmlToXhtml(str) 
{
	str = str.replace(/<p([^>]*>)/gi, "<div$1");
	str = str.replace(/<\/p>/gi, "</div>");
	str = str.replace(/<br>/gi, "<br />");
	str = str.replace(/(<hr[^>]*[^\\])(>)/gi, "$1 \\>");
	str = str.replace(/(<\w+)([^>]*>)/gi, function ($0,$1,$2) {
						return($1.toLowerCase() + WLConvertAttribute($2));
					}
				);
	str = str.replace(/(<\/\w+>)/gi, function ($0,$1) {
						return($1.toLowerCase());
					}
				);
	str = WLTrim(str);
	return str;
}
function WLConvertAttribute(str)
{
	str = WLConvertAttributeChild(str, 'style', '[^\"\'>]+');
	str = WLConvertAttributeChild(str, 'src', '[^\"\\s>]+');
	str = WLConvertAttributeChild(str, 'href', '[^\"\\s>]+');
	str = WLConvertAttributeChild(str, 'color', '[^\"\\s>]+');
	str = WLConvertAttributeChild(str, 'dir', '\\w+');
	str = WLConvertAttributeChild(str, 'target', '\\w+');
	str = WLConvertAttributeChild(str, 'align', '\\w+');
	str = WLConvertAttributeChild(str, 'width', '[\\w%]+');
	str = WLConvertAttributeChild(str, 'height', '[\\w%]+');
	str = WLConvertAttributeChild(str, 'border', '[\\w%]+');
	str = WLConvertAttributeChild(str, 'size', '[\\w%]+');
	str = WLConvertAttributeChild(str, 'cellspacing', '\\d+');
	str = WLConvertAttributeChild(str, 'cellpadding', '\\d+');
	return str;
}
function WLConvertAttributeChild(str, attName, regStr)
{
	var re = new RegExp("("+attName+"=)[\"']?("+regStr+")[\"']?","ig");
	str = str.replace(re, function ($0,$1,$2) {
						if (BROWSER == 'IE' && attName.match(/style/i) != null ) {
							return($1.toLowerCase() + "\"" + $2.toLowerCase() + "\"");
						} else {
							return($1.toLowerCase() + "\"" + $2 + "\"");
						}
					}
				);
	return str;
}
function WLTrim(str)
{
	str = str.replace(/^\s+|\s+$/g, "");
	str = str.replace(/[\r\n]+/g, "\r\n");
	return str;
}
function WLGetTop(id)
{
	var top = 0;
	var tmp = '';
	var obj = document.getElementById(id);
	while (eval("obj" + tmp).tagName != "BODY") {
		tmp += ".offsetParent";
		top += eval("obj" + tmp).offsetTop;
	}
	return top;
}
function WLGetLeft(id)
{
	var left = 0;
	var tmp = '';
	var obj = document.getElementById(id);
	while (eval("obj" + tmp).tagName != "BODY") {
		tmp += ".offsetParent";
		left += eval("obj" + tmp).offsetLeft;
	}
	return left;
}
function WLClearTemp()
{
	document.getElementById('popupData').innerHTML = '';
	document.getElementById('popupName').innerHTML = '';
}
function WLGetMenuCommonStyle(top, left)
{
	var str = 'position:absolute;top:'+top+'px;left:'+left+'px;font-size:12px;color:'+MENU_TEXT_COLOR+
			';background-color:'+MENU_BG_COLOR+';border:solid 1px '+MENU_BORDER_COLOR+';z-index:1';
	return str;
}
function WLDrawMenu(mode, content)
{
	var top = WLGetTop(mode) + 32;
	var left = WLGetLeft(mode) + 1;
	var str = '';
	str += '<div style="'+WLGetMenuCommonStyle(top, left)+'">';
	str += content;
	str += '</div>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = mode;
}
function WLDrawZoom()
{
	var str = '';
	for (i = 0; i < ZOOM_TABLE.length; i++) {
		str += '<div style="padding:2px;width:120px;cursor:pointer;" ' + 
		'onclick="javascript:WLExecute(\'WL_ZOOM_END\', \'' + ZOOM_TABLE[i] + '\');" ' + 
		'onmouseover="javascript:this.style.backgroundColor=\''+MENU_SELECTED_COLOR+'\';" ' +
		'onmouseout="javascript:this.style.backgroundColor=\''+MENU_BG_COLOR+'\';">' + 
		ZOOM_TABLE[i] + '</div>';
	}
	WLDrawMenu('WL_ZOOM', str);
}
function WLDrawTitle()
{
	var str = '';
	for (i = 0; i < TITLE_TABLE.length; i++) {
		str += '<div style="width:140px;cursor:pointer;" ' + 
		'onclick="javascript:WLExecute(\'WL_TITLE_END\', \'' + TITLE_TABLE[i][0] + '\');" ' + 
		'onmouseover="javascript:this.style.backgroundColor=\''+MENU_SELECTED_COLOR+'\';" ' +
		'onmouseout="javascript:this.style.backgroundColor=\''+MENU_BG_COLOR+'\';"><' + TITLE_TABLE[i][0] + ' style="margin:2px;">' + 
		TITLE_TABLE[i][1] + '</' + TITLE_TABLE[i][0] + '></div>';
	}
	WLDrawMenu('WL_TITLE', str);
}
function WLDrawFontname()
{
	var str = '';
	for (i = 0; i < FONT_NAME.length; i++) {
		str += '<div style="font-family:' + FONT_NAME[i][0] + 
		';padding:2px;width:160px;cursor:pointer;" ' + 
		'onclick="javascript:WLExecute(\'WL_FONTNAME_END\', \'' + FONT_NAME[i][0] + '\');" ' + 
		'onmouseover="javascript:this.style.backgroundColor=\''+MENU_SELECTED_COLOR+'\';" ' +
		'onmouseout="javascript:this.style.backgroundColor=\''+MENU_BG_COLOR+'\';">' + 
		FONT_NAME[i][1] + '</div>';
	}
	WLDrawMenu('WL_FONTNAME', str);
}
function WLDrawFontsize()
{
	var str = '';
	for (i = 0; i < FONT_SIZE.length; i++) {
		str += '<div style="font-size:' + FONT_SIZE[i][1] + 
		';padding:2px;width:120px;cursor:pointer;" ' + 
		'onclick="javascript:WLExecute(\'WL_FONTSIZE_END\', \'' + FONT_SIZE[i][0] + '\');" ' + 
		'onmouseover="javascript:this.style.backgroundColor=\''+MENU_SELECTED_COLOR+'\';" ' +
		'onmouseout="javascript:this.style.backgroundColor=\''+MENU_BG_COLOR+'\';">' + 
		FONT_SIZE[i][1] + '</div>';
	}
	WLDrawMenu('WL_FONTSIZE', str);
}
function WLCreateColorTable(cmdName, eventStr)
{
	var str = '';
	str += '<table cellpadding="0" cellspacing="2" border="0">';
	for (i = 0; i < COLOR_TABLE.length; i++) 
	  {
		if (i == 0 || (i >= 10 && i%10 == 0)) 
		 {
			str += '<tr>';
		 }
		str += '<td style="width:12px;height:12px;border:1px solid #AAAAAA;font-size:1px;cursor:pointer;background-color:' +
		COLOR_TABLE[i] + ';" onmouseover="javascript:this.style.borderColor=\'#000000\';' + ((eventStr) ? eventStr : '') + '" ' +
		'onmouseout="javascript:this.style.borderColor=\'#AAAAAA\';" ' + 
		'onclick="javascript:WLExecute(\''+cmdName+'_END\', \'' + COLOR_TABLE[i] + '\');">&nbsp;</td>';
		if (i >= 9 && i%(i-1) == 0) 
		 {
			str += '</tr>';
		 }
	  }
	str += '</table>';	
	return str;
}
function WLDrawColorTable(cmdName)
{
	var top = WLGetTop(cmdName) + 32;
	var left = WLGetLeft(cmdName) + 1;
	var str = '';
	str += '<div style="width:160px;padding:2px;'+WLGetMenuCommonStyle(top, left)+'">';
	str += WLCreateColorTable(cmdName);
	str += '</div>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = cmdName;
}
function WLDrawHr()
{
	var cmdName = 'WL_HR';
	var top = WLGetTop(cmdName) + 32;
	var left = WLGetLeft(cmdName) + 1;
	var str = '';
	str += '<div style="width:160px;padding:5px;'+WLGetMenuCommonStyle(top, left)+'">';
	str += '<div id="hrPreview" style="margin-bottom:5px;height:1px;border:0;font-size:0;background-color:#FFFFFF;"></div>';
	str += WLCreateColorTable(cmdName, 'document.getElementById(\'hrPreview\').style.backgroundColor = this.style.backgroundColor;');
	str += '</div>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = cmdName;
}
function WLDrawLayer()
{
	var cmdName = 'WL_LAYER';
	var top = WLGetTop(cmdName) + 32;
	var left = WLGetLeft(cmdName) + 1;
	var str = '';
	str += '<div style="width:160px;padding:5px;'+WLGetMenuCommonStyle(top, left)+'">';
	str += '<div id="divPreview" style="margin-bottom:5px;height:20px;border:1px solid #AAAAAA;font-size:1px;background-color:#FFFFFF;"></div>';
	str += WLCreateColorTable(cmdName, 'document.getElementById(\'divPreview\').style.backgroundColor = this.style.backgroundColor;');
	str += '</div>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = cmdName;
}
function WLDrawLink()
{
	var top = WLGetTop('WL_LINK') + 32;
	var left = WLGetLeft('WL_LINK') - 220;
	var str = '';
	str += '<table cellpadding="0" cellspacing="0" style="width:250px;'+WLGetMenuCommonStyle(top, left)+'">' + 
		'<tr><td style="width:50px;padding:5px;">URL</td>' +
		'<td style="width:200px;padding-top:5px;padding-bottom:5px;"><input type="text" id="hyperLink" value="http://" style="width:190px;border:1px solid #555555;background-color:#FFFFFF;"></td>' +
		'<tr><td style="padding:5px;">'+STR_LINK_TARGET+'</td>' +
		'<td style="padding-bottom:5px;"><select id="hyperLinkTarget"><option value="_blank" selected>'+STR_LINK_BLANK+'</option><option value="">'+STR_LINK_NOBLANK+'</option></select></td>' + 
		'<tr><td colspan="2" style="padding-bottom:5px;" align="center"><input type="button" name="button" value="'+STR_BUTTON_INSERT+'" ' +
		'onclick="javascript:WLDrawLinkEnd();"' +
		'style="border:1px solid #555555;"> <input type="button" name="button" value="'+STR_BUTTON_CLOSE+'" onclick="javascript:WLClearTemp();" style="border:1px solid #555555;"></td></tr>';
	str += '</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_LINK';
}
function WLDrawLinkEnd()
{
	var range;
	var url = document.getElementById('hyperLink').value;
	var target = document.getElementById('hyperLinkTarget').value;
	if (url.match(/http:\/\/.{3,}/) == null) {
		alert(MSG_INPUT_URL);
		return false;
	}
	WLSelect();
	var element;
    if (BROWSER == 'IE') {
		if (SELECTION.type.toLowerCase() == 'control') {
			var el = document.createElement("a");
			el.href = url;
			if (target) {
				el.target = target;
			}
			RANGE.item(0).applyElement(el);
		} else if (SELECTION.type.toLowerCase() == 'text') {
			WLExecuteValue('CreateLink', url);
			element = RANGE.parentElement();
			if (target) {
				element.target = target;
			}
		}
	} else {
		WLExecuteValue('CreateLink', url);
		element = RANGE.startContainer.previousSibling;
		element.target = target;
		if (target) {
			element.target = target;
		}
    }
	WLClearTemp();
	return true;
}
function WLDrawSpecialchar()
{
	var top = WLGetTop('WL_SPECIALCHAR') + 32;
	var left = WLGetLeft('WL_SPECIALCHAR') + 1;
	var str = '';
	str += '<table cellpadding="0" cellspacing="2" style="'+WLGetMenuCommonStyle(top, left)+'">';
	for (i = 0; i < SPECIAL_CHARACTER.length; i++) {
		if (i == 0 || (i >= 10 && i%10 == 0)) {
			str += '<tr>';
		}
		str += '<td style="padding:2px;border:1px solid #AAAAAA;cursor:pointer;" ' + 
		'onclick="javascript:WLExecute(\'WL_SPECIALCHAR_END\', \'' + SPECIAL_CHARACTER[i] + '\');" ' +
		'onmouseover="javascript:this.style.borderColor=\'#000000\';" ' +
		'onmouseout="javascript:this.style.borderColor=\'#AAAAAA\';">' + SPECIAL_CHARACTER[i] + '</td>';
		if (i >= 9 && i%(i-1) == 0) {
			str += '</tr>';
		}
	}
	str += '</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_SPECIALCHAR';
}
function WLDrawTableSelected(i, j)
{
	var text = i.toString(10) + ' by ' + j.toString(10) + ' Table';
	document.getElementById('tableLocation').innerHTML = text;
	var num = 10;
	for (m = 1; m <= num; m++) {
		for (n = 1; n <= num; n++) {
			var obj = document.getElementById('tableTd' + m.toString(10) + '_' + n.toString(10) + '');
			if (m <= i && n <= j) {
				obj.style.backgroundColor = '#AAAAAA';
			} else {
				obj.style.backgroundColor = '#FFFFFF';
			}
		}
	}
}
function WLDrawTable()
{
	var top = WLGetTop('WL_TABLE') + 32;
	var left = WLGetLeft('WL_TABLE') + 1;
	var str = '';
	var num = 10;
	str += '<table cellpadding="0" cellspacing="0" style="'+WLGetMenuCommonStyle(top, left)+'">';
	for (i = 1; i <= num; i++) {
		str += '<tr>';
		for (j = 1; j <= num; j++) {
			var value = i.toString(10) + ',' + j.toString(10);
			str += '<td id="tableTd' + i.toString(10) + '_' + j.toString(10) + 
			'" style="width:15px;height:15px;background-color:#FFFFFF;border:1px solid #DDDDDD;cursor:pointer;" ' + 
			'onclick="javascript:WLExecute(\'WL_TABLE_END\', \'' + value + '\');" ' +
			'onmouseover="javascript:WLDrawTableSelected(\''+i.toString(10)+'\', \''+j.toString(10)+'\');" ' + 
			'onmouseout="javascript:;">&nbsp;</td>';
		}
		str += '</tr>';
	}
	str += '<tr><td colspan="10" id="tableLocation" style="text-align:center;height:20px;"></td></tr>';
	str += '</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_TABLE';
}
function WLDrawImage()
{
	var top = WLGetTop("WL_IMAGE") + 32;
	var left = WLGetLeft("WL_IMAGE") - 1;
	var str = '';	
	str += '<table cellpadding="0" cellspacing="0" style="width:250px;'+WLGetMenuCommonStyle(top, left)+'">' + 
		'<tr><td colspan="2"><table border="0"><tr><td><img id="MyImg" style="width:240px;height:240px;border:1px solid #AAAAAA;background-color:#FFFFFF;" align="center" valign="middle" src="'+
		IMAGE_PATH+'image.gif" alt="无图片可显示，请确保图片地址正确"></td></tr></table></td></tr>' +  	
		'<tr><td style="width:35px;padding:5px;">'+STR_URL+'</td>' +
		'<td style="width:200px;padding-bottom:5px;"><input type="text" id="imageLink" value="http://" style="width:160px;border:1px solid #555555;" onchange="javascript:WLImagePreview();">'+
		'&nbsp;<input type="button" name="button" value="'+STR_BUTTON_PREVIEW+'" onclick="javascript:WLImagePreview();" style="border:1px solid #555555;"> ' +'</td>' +
		'<tr><td colspan="2" style="margin:5px;padding-bottom:5px;" align="center">' +
		'<input type="button" name="button" value="'+STR_IMAGE_UPLOAD+'" onclick="javascript:WLUploadImageClick();" style="border:1px solid #555555;"> ' +
		'<input type="button" name="button" value="'+STR_BUTTON_INSERT+'" onclick="javascript:WLDrawImageEnd();" style="border:1px solid #555555;"> ' +
		'<input type="button" name="button" value="'+STR_BUTTON_CLOSE+'" onclick="javascript:WLClearTemp();" style="border:1px solid #555555;"></td></tr>' + 
		'</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_IMAGE';
	
}
function WLImagePreview()
{
  var imageobj = document.getElementById('MyImg');
  var url = document.getElementById('imageLink').value;
  
  imageobj.src=url;

}
function WLDrawImageEnd()
{
	var url = document.getElementById('imageLink').value;
	if (WLCheckImageFileType(url, "/") == false) {
		return false;
	}
	WLSelect();
	WLInsertImage(url, 0, 0, 0)
	WLClearTemp();
	return true;
}
function WLInsertImage(url, width, height, border)
{
	if (BROWSER == 'IE') {
		restoreBookmark();
	}
	EditForm.focus();
    WLSelection(); 
    
	var element = document.createElement("img");
	element.src = url;
	//alert(url);
	if (width > 0) {
		element.style.width = width;
	}
	if (height > 0) {
		element.style.height = height;
	}
	element.border = border;
	WLSelect();
	WLInsertItem(element);
	WLClearTemp();
}
function WLDrawMedia()
{
	var top = WLGetTop('WL_MEDIA') + 32;
	var left = WLGetLeft('WL_MEDIA') + 1;
	var str = '';
	var str = '';
	str += '<table cellpadding="0" cellspacing="0" style="width:250px;'+WLGetMenuCommonStyle(top, left)+'">' + 
		'<tr><td colspan="2"><table border="0"><tr><td id="mediaPreview" style="width:240px;height:240px;border:1px solid #AAAAAA;background-color:#FFFFFF;" align="center" valign="middle">&nbsp;</td></tr></table></td></tr>' +  	
		'<tr><td style="width:28px;padding:5px;">'+STR_URL+'</td>' +
		'<td style="width:200px;padding-bottom:5px;"><input type="text" id="mediaLink" value="http://" style="width:160px;border:1px solid #555555;" onchange="javascript:WLMediaPreview();">'+
		'&nbsp;<input type="button" name="button" value="'+STR_BUTTON_PREVIEW+'" onclick="javascript:WLMediaPreview();" style="border:1px solid #555555;"> ' +'</td>' +
		'<tr><td colspan="2" style="margin:5px;padding-bottom:5px;" align="center">' +		
		'<input type="button" name="button" value="'+STR_BUTTON_INSERT+'" onclick="javascript:WLDrawMediaEnd();" style="border:1px solid #555555;"> ' +
		'<input type="button" name="button" value="'+STR_BUTTON_CLOSE+'" onclick="javascript:WLClearTemp();" style="border:1px solid #555555;"></td></tr>' + 
		'</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_MEDIA';
}
function WLGetMediaHtmlTag(url, width, height)
{
	var element = document.createElement("embed");
	element.src = url;
	if (width > 0) {
		element.width = width;
	}
	if (height > 0) {
		element.height = height;
	}
	return element;
}
function WLMediaPreview()
{
	var url = document.getElementById('mediaLink').value;
	if (WLCheckMediaFileType(url, "/") == false) {
		return false;
	}
	var el = document.getElementById('mediaPreview');
	if (el.hasChildNodes()) {
		el.removeChild(el.childNodes[0]);
	}
	el.appendChild(WLGetMediaHtmlTag(url, 230, 230));
	return true;
}
function WLDrawMediaEnd()
{
	var url = document.getElementById('mediaLink').value;
	if (WLCheckMediaFileType(url, "/") == false) {
		return false;
	}
	WLSelect();
	WLInsertItem(WLGetMediaHtmlTag(url, 0, 0));
	WLClearTemp();
	return true;
}
function WLDrawFlash()
{
	var top = WLGetTop('WL_FLASH') + 32;
	var left = WLGetLeft('WL_FLASH') + 1;
	var str = '';
	str += '<table cellpadding="0" cellspacing="0" style="width:250px;'+WLGetMenuCommonStyle(top, left)+'">' + 
		'<tr><td colspan="2"><table border="0"><tr><td id="flashPreview" style="width:240px;height:240px;border:1px solid #AAAAAA;background-color:#FFFFFF;" align="center" valign="middle">&nbsp;</td></tr></table></td></tr>' +  	
		'<tr><td style="width:28px;padding:5px;">'+STR_URL+'</td>' +
		'<td style="width:200px;padding-bottom:5px;"><input type="text" id="flashLink" value="" style="width:160px;border:1px solid #555555;" onchange="javascript:WLFlashPreview();">'+
		'&nbsp;<input type="button" name="button" value="'+STR_BUTTON_PREVIEW+'" onclick="javascript:WLFlashPreview();" style="border:1px solid #555555;"> ' +'</td>' +
		'<tr><td colspan="2" style="margin:5px;padding-bottom:5px;" align="center">' +	
		'<input type="button" name="button" value="'+STR_BUTTON_INSERT+'" onclick="javascript:WLDrawFlashEnd();" style="border:1px solid #555555;"> ' +
		'<input type="button" name="button" value="'+STR_BUTTON_CLOSE+'" onclick="javascript:WLClearTemp();" style="border:1px solid #555555;"></td></tr>' + 
		'</table>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_FLASH';
}
function WLGetFlashHtmlTag(url, width, height)
{
	var element = document.createElement("embed");
	element.src = url;
	element.quality = "high";
	element.type = "application/x-shockwave-flash";
	element.style.width = width;
	element.style.height = height;
	return element;
}
function WLFlashPreview()
{
	var url = document.getElementById('flashLink').value;
	if (WLCheckFlashFileType(url, "/") == false) {
		return false;
	}
	var el = document.getElementById('flashPreview');
	if (el.hasChildNodes()) {
		el.removeChild(el.childNodes[0]);
	}
	el.appendChild(WLGetFlashHtmlTag(url, '230', '230'));
	return true;
}
function WLDrawFlashEnd()
{
	var url = document.getElementById('flashLink').value;
	if (WLCheckFlashFileType(url, "/") == false) {
		return false;
	}
	WLSelect();
	WLInsertItem(WLGetFlashHtmlTag(url, '100', '100'));
	WLClearTemp();
	return true;
}
function WLDrawAbout()
{
	var top = WLGetTop("WL_ABOUT") + 32;
	var left = WLGetLeft("WL_ABOUT") - 168;
	var str = '';
	str += '<div style="width:200px;'+WLGetMenuCommonStyle(top, left)+';padding:5px;">';
	str += '<span style="margin-right:10px;">WLEditor1.1</span>' + 
		'<a href="mailto:wl2010tw@gmail.com" target="_blank" style="color:#4169e1;" onclick="javascript:WLClearTemp();">'+STR_ABOUT+'</a><br />';
	str += '</div>';
	document.getElementById('popupData').innerHTML = str;
	document.getElementById('popupName').innerHTML = 'WL_ABOUT';
}
function WLSelection()
{
	if (BROWSER == 'IE') {
		SELECTION = EDITFORM_DOCUMENT.selection;
		RANGE = SELECTION.createRange();
		RANGE_TEXT = RANGE.text;
	} else {
		SELECTION = document.getElementById("EditForm").contentWindow.getSelection();
        RANGE = SELECTION.getRangeAt(0);
		RANGE_TEXT = RANGE.toString();
	}
}
function WLSelect()
{
	if (BROWSER == 'IE') {
		RANGE.select();
	}
}
function WLInsertItem(insertNode)
{
	if (BROWSER == 'IE') {
		if (SELECTION.type.toLowerCase() == 'control') {
			RANGE.item(0).outerHTML = insertNode.outerHTML;
		} else {
			RANGE.pasteHTML(insertNode.outerHTML);
		}
	} else {
        SELECTION.removeAllRanges();
		RANGE.deleteContents();
        var startRangeNode = RANGE.startContainer;
        var startRangeOffset = RANGE.startOffset;
        var newRange = document.createRange();
		if (startRangeNode.nodeType == 3 && insertNode.nodeType == 3) {
            startRangeNode.insertData(startRangeOffset, insertNode.nodeValue);
            newRange.setEnd(startRangeNode, startRangeOffset + insertNode.length);
            newRange.setStart(startRangeNode, startRangeOffset + insertNode.length);
        } else {
            var afterNode;
            if (startRangeNode.nodeType == 3) {
                var textNode = startRangeNode;
                startRangeNode = textNode.parentNode;
                var text = textNode.nodeValue;
                var textBefore = text.substr(0, startRangeOffset);
                var textAfter = text.substr(startRangeOffset);
                var beforeNode = document.createTextNode(textBefore);
                var afterNode = document.createTextNode(textAfter);
                startRangeNode.insertBefore(afterNode, textNode);
                startRangeNode.insertBefore(insertNode, afterNode);
                startRangeNode.insertBefore(beforeNode, insertNode);
                startRangeNode.removeChild(textNode);
            } else {
				if (startRangeNode.tagName.toLowerCase() == 'html') {
					startRangeNode = startRangeNode.childNodes[0].nextSibling;
					afterNode = startRangeNode.childNodes[0];
				} else {
					afterNode = startRangeNode.childNodes[startRangeOffset];
				}
				startRangeNode.insertBefore(insertNode, afterNode);
            }
            newRange.setEnd(afterNode, 0);
            newRange.setStart(afterNode, 0);
        }
        SELECTION.addRange(newRange);
	}
}
function WLExecuteValue(cmd, value)
{
	if (BROWSER == 'IE') {
		RANGE.execCommand(cmd, false, value);
	} else {
		EDITFORM_DOCUMENT.execCommand(cmd, false, value);
	}
}
function WLSimpleExecute(cmd)
{
	EDITFORM_DOCUMENT.execCommand(cmd, false, null);
	WLClearTemp();
	EditForm.focus();
}
function WLExecute(mode, value)
{
	switch (mode)
	{
		case 'WL_SOURCE':
			var length = document.getElementById(TOP_TOOLBAR_ICON[0][0]).src.length - 10;
			var image = document.getElementById(TOP_TOOLBAR_ICON[0][0]).src.substr(length,10);
			if (image == 'source.gif') {
				document.getElementById("CodeForm").value = WLHtmlToXhtml(EDITFORM_DOCUMENT.body.innerHTML);
				document.getElementById("editIframe").style.display = 'none';
				document.getElementById("editTextarea").style.display = 'block';
				WLDisableToolbar(true);
			} else {
				EDITFORM_DOCUMENT.body.innerHTML = document.getElementById("CodeForm").value;
				document.getElementById("editTextarea").style.display = 'none';
				document.getElementById("editIframe").style.display = 'block';
				WLDisableToolbar(false);
			}
			WLClearTemp();
			break;
		case 'WL_PRINT':
			WLSimpleExecute('print');
			break;
		case 'WL_UNDO':
			WLSimpleExecute('undo');
			break;
		case 'WL_REDO':
			WLSimpleExecute('redo');
			break;
		case 'WL_CUT':
			WLSimpleExecute('cut');
			break;
		case 'WL_COPY':
			WLSimpleExecute('copy');
			break;
		case 'WL_PASTE':
			WLSimpleExecute('paste');
			break;
		case 'WL_SELECTALL':
			WLSimpleExecute('selectall');
			break;
		case 'WL_SUBSCRIPT':
			WLSimpleExecute('subscript');
			break;
		case 'WL_SUPERSCRIPT':
			WLSimpleExecute('superscript');
			break;
		case 'WL_BOLD':
			WLSimpleExecute('bold');
			break;
		case 'WL_ITALIC':
			WLSimpleExecute('italic');
			break;
		case 'WL_UNDERLINE':
			WLSimpleExecute('underline');
			break;
		case 'WL_STRIKE':
			WLSimpleExecute('strikethrough');
			break;
		case 'WL_JUSTIFYLEFT':
			WLSimpleExecute('justifyleft');
			break;
		case 'WL_JUSTIFYCENTER':
			WLSimpleExecute('justifycenter');
			break;
		case 'WL_JUSTIFYRIGHT':
			WLSimpleExecute('justifyright');
			break;
		case 'WL_JUSTIFYFULL':
			WLSimpleExecute('justifyfull');
			break;
		case 'WL_NUMBEREDLIST':
			WLSimpleExecute('insertorderedlist');
			break;
		case 'WL_UNORDERLIST':
			WLSimpleExecute('insertunorderedlist');
			break;
		case 'WL_INDENT':
			WLSimpleExecute('indent');
			break;
		case 'WL_OUTDENT':
			WLSimpleExecute('outdent');
			break;
		case 'WL_REMOVE':
			WLSimpleExecute('removeformat');
			break;
		case 'WL_ZOOM':
			EditForm.focus();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawZoom();
			}
			break;
		case 'WL_ZOOM_END':
			EditForm.focus();
			EDITFORM_DOCUMENT.body.style.zoom = value;
			WLClearTemp();
			break;
		case 'WL_TITLE':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawTitle();
			}
			break;
		case 'WL_TITLE_END':
			EditForm.focus();
			value = '<' + value + '>';
			WLSelect();
			WLExecuteValue('FormatBlock', value);
			WLClearTemp();
			break;
		case 'WL_FONTNAME':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawFontname();
			}
			break;
		case 'WL_FONTNAME_END':
			EditForm.focus();
			WLSelect();
			WLExecuteValue('fontname', value);
			WLClearTemp();
			break;
		case 'WL_FONTSIZE':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawFontsize();
			}
			break;
		case 'WL_FONTSIZE_END':
			EditForm.focus();
			value = value.substr(0, 1);
			WLSelect();
			WLExecuteValue('fontsize', value);
			WLClearTemp();
			break;
		case 'WL_TEXTCOLOR':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawColorTable('WL_TEXTCOLOR');
			}
			break;
		case 'WL_TEXTCOLOR_END':
			EditForm.focus();
			WLSelect();
			WLExecuteValue('ForeColor', value);
			WLClearTemp();
			break;
		case 'WL_BGCOLOR':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawColorTable('WL_BGCOLOR');
			}
			break;
		case 'WL_BGCOLOR_END':
			EditForm.focus();
			if (BROWSER == 'IE') {
				WLSelect();
				WLExecuteValue('BackColor', value);
			} else {
				var startRangeNode = RANGE.startContainer;
				if (RANGE.toString() != '' && startRangeNode.nodeType == 3) {
					var parent = startRangeNode.parentNode;
					var element = document.createElement("font");
					element.style.backgroundColor = value;
					element.appendChild(RANGE.extractContents());
					var startRangeOffset = RANGE.startOffset;
					var newRange = document.createRange();
					var afterNode;
					var textNode = startRangeNode;
					startRangeNode = textNode.parentNode;
					var text = textNode.nodeValue;
					var textBefore = text.substr(0, startRangeOffset);
					var textAfter = text.substr(startRangeOffset);
					var beforeNode = document.createTextNode(textBefore);
					var afterNode = document.createTextNode(textAfter);
					startRangeNode.insertBefore(afterNode, textNode);
					startRangeNode.insertBefore(element, afterNode);
					startRangeNode.insertBefore(beforeNode, element);
					startRangeNode.removeChild(textNode);
					newRange.setEnd(afterNode, 0);
					newRange.setStart(afterNode, 0);
					SELECTION.addRange(newRange);
				}
			}
			WLClearTemp();
			break;
		case 'WL_LINK':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawLink();
			}
			break;
		case 'WL_UNLINK':
			WLSimpleExecute('unlink');
			break;		
		case 'WL_IMAGE':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawImage();
			}
			break;
		case 'WL_MEDIA':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawMedia();
			}
			break;
		case 'WL_FLASH':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawFlash();
			}
			break;
		case 'WL_ADDITION':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawFile();
			}
			break;
		case 'WL_SPECIALCHAR':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawSpecialchar();
			}
			break;
		case 'WL_SPECIALCHAR_END':
			EditForm.focus();
			WLSelect();
			var element = document.createElement("span");
			element.appendChild(document.createTextNode(value));
			WLInsertItem(element);
			WLClearTemp();
			break;
		case 'WL_LAYER':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawLayer();
			}
			break;
		case 'WL_LAYER_END':
			EditForm.focus();
			var element = document.createElement("div");
			element.style.width = "100px";
			element.style.height = "100px";
			element.style.padding = "5px";
			element.style.border = "1px solid #AAAAAA";
			element.style.backgroundColor = value;
			element.innerHTML = "&nbsp;";
			WLSelect();
			WLInsertItem(element);
			WLClearTemp();
			break;
		case 'WL_TABLE':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawTable();
			}
			break;
		case 'WL_TABLE_END':
			var location = value.split(',');
			var element = document.createElement("table");
			element.cellPadding = 0;
			element.cellSpacing = 0;
			element.border = 1;
			element.style.width = "100px";
			element.style.height = "100px";
			for (var i = 0; i < location[0]; i++) {
				var rowElement = element.insertRow(i);
				for (var j = 0; j < location[1]; j++) {
					var cellElement = rowElement.insertCell(j);
					cellElement.innerHTML = "&nbsp;";
				}
			}
			EditForm.focus();
			WLSelect();
			WLInsertItem(element);
			WLClearTemp();
			break;
		case 'WL_HR':
			EditForm.focus();
			WLSelection();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawHr();
			}
			break;
		case 'WL_HR_END':
			EditForm.focus();
			var element = document.createElement("hr");
			element.width = "100%";
			element.color = value;
			element.size = 1;
			WLSelect();
			WLInsertItem(element);
			WLClearTemp();
			break;
		case 'WL_DATE':
			EditForm.focus();
			WLSelection();
			var date = new Date();
			var year = date.getFullYear().toString(10);
			var month = (date.getMonth() + 1).toString(10);
			month = month.length < 2 ? '0' + month : month;
			var day = date.getDate().toString(10);
			day = day.length < 2 ? '0' + day : day;
			var value = year + '-' + month + '-' + day;
			var element = document.createElement("span");
			element.appendChild(document.createTextNode(value));
			WLInsertItem(element);
			WLClearTemp();
			break;
		case 'WL_TIME':
			EditForm.focus();
			WLSelection();
			var date = new Date();
			var hour = date.getHours().toString(10);
			hour = hour.length < 2 ? '0' + hour : hour;
			var minute = date.getMinutes().toString(10);
			minute = minute.length < 2 ? '0' + minute : minute;
			var second = date.getSeconds().toString(10);
			second = second.length < 2 ? '0' + second : second;
			var value = hour + ':' + minute + ':' + second;
			var element = document.createElement("span");
			element.appendChild(document.createTextNode(value));
			WLInsertItem(element);
			WLClearTemp();
			break;
		case 'WL_PREVIEW':
			eval(OBJ_NAME).data();
			var newWin = window.open('', 'WLPreview','width=800,height=600,left=30,top=30,resizable=yes,scrollbars=yes');
			WLWriteFullHtml(newWin.document);
			break;
		case 'WL_ABOUT':
			EditForm.focus();
			if (document.getElementById('popupName').innerHTML == mode) {
				WLClearTemp();
			} else {
				WLDrawAbout();
			}
			break;
		default: 
			break;
	}
}
function WLOverIcon(obj)
{
	obj.style.border = '1px solid ' + MENU_BORDER_COLOR;
}
function WLOutIcon(obj)
{
	obj.style.border = '1px solid ' + TOOLBAR_BG_COLOR;
}
function WLDisableToolbar(flag)
{
	if (flag == true) {
		document.getElementById(TOP_TOOLBAR_ICON[0][0]).src = IMAGE_PATH + 'design.gif';
		for (i = 1; i < TOOLBAR_ICON.length; i++) {
			var el = document.getElementById(TOOLBAR_ICON[i][0]);
			el.style.visibility = 'hidden';
		}
	} else {
		document.getElementById(TOP_TOOLBAR_ICON[0][0]).src = IMAGE_PATH + 'source.gif';
		for (i = 0; i < TOOLBAR_ICON.length; i++) {
			var el = document.getElementById(TOOLBAR_ICON[i][0]);
			el.style.visibility = 'visible';
			EDITFORM_DOCUMENT.designMode = 'On';
		}
	}
}
function WLWriteFullHtml(documentObj)
{
	var editHtmlData = '<html>\r\n<head>\r\n<title>WLEditor</title>\r\n<style type="text/css">\r\np {margin:0;}\r\n</style>\r\n</head>\r\n';
	editHtmlData += '<body style="font-size:12px;font-family:'+EDITOR_FONT_FAMILY+';margin:2px;background-color:' + FORM_BG_COLOR + '">\r\n';
	editHtmlData += WLHtmlentitiesDecode(document.getElementsByName(eval(OBJ_NAME).hiddenName)[0].value);
	editHtmlData += '\r\n</body>\r\n</html>\r\n';
	documentObj.open();
	documentObj.write(editHtmlData);
	documentObj.close();
}
function WLEditor(objName) 
{
	this.objName = objName;
	this.hiddenName = objName;
	this.width = "100%";
	this.height = "200px";
	this.imagePath = '';
	this.uploadFileFunction = '';
	this.uploadImageFunction = '';
	this.uploadflashFunction='';
	this.menuBorderColor = '#4169e1';
	this.menuBgColor = '#e6e6fa';
	this.menuTextColor = '#8b0000';
	this.menuSelectedColor = '#6495ed';
	this.toolbarBgColor = '#DDDDDD';
	this.formBorderColor = '#AAAAAA';
	this.formBgColor = '#FFFFFF';
	this.init = function()
	{
		IMAGE_PATH = this.imagePath;
		ICON_PATH = this.iconPath;		
		IMAGE_ATTACH_PATH = this.imageAttachPath;
		IMAGE_UPLOAD_CGI = this.imageUploadCgi;
		MENU_BORDER_COLOR = this.menuBorderColor;
		MENU_BG_COLOR = this.menuBgColor;
		MENU_TEXT_COLOR = this.menuTextColor;
		MENU_SELECTED_COLOR = this.menuSelectedColor;
		TOOLBAR_BG_COLOR = this.toolbarBgColor;
		FORM_BORDER_COLOR = this.formBorderColor;
		FORM_BG_COLOR = this.formBgColor;
		OBJ_NAME = this.objName;		
		UPLOAD_IMAGE_FUNCTION = this.uploadImageFunction;
		UPLOAD_flash_FUNCTION= this.uploadflashFunction;
		UPLOAD_FILE_FUNCTION = this.uploadFileFunction;
		BROWSER = WLGetBrowser();
		TOOLBAR_ICON = Array();
		for (var i = 0; i < TOP_TOOLBAR_ICON.length; i++) {
			TOOLBAR_ICON.push(TOP_TOOLBAR_ICON[i]);
		}
		for (var i = 0; i < BOTTOM_TOOLBAR_ICON.length; i++) {
			TOOLBAR_ICON.push(BOTTOM_TOOLBAR_ICON[i]);
		}
	}
	this.show = function()
	{
		this.init();
		var iframeSize = '';
		iframeSize += 'width:' + this.width + ';';
		iframeSize += 'height:' + this.height + ';';
		
		if (BROWSER == '') 
		{
			var htmlData = '<div id="editTextarea" style="' + iframeSize + '">' +
			'<textarea name="CodeForm" id="CodeForm" style="' + iframeSize + 
			'padding:2px;margin:0;border:1px solid '+ FORM_BORDER_COLOR + 
			';font-size:12px;line-height:16px;font-family:'+EDITOR_FONT_FAMILY+';background-color:'+ 
			FORM_BG_COLOR +';">' + document.getElementsByName(this.hiddenName)[0].value + '</textarea></div>';
			document.open();
			document.write(htmlData);
			document.close();
			return;
		}
		
		var htmlData = '<div id="WLdiv" style="font-family:'+EDITOR_FONT_FAMILY+';">' +
			'<div style="padding:1px;background-color:'+ TOOLBAR_BG_COLOR +'">' +
			'<table cellpadding="0" cellspacing="0" border="0"><tr>';
		
		//加工具栏标头
		htmlData+='<td width="6" height="20"><img id="ToolBarHead" src="'+IMAGE_PATH+'ToolBarHead.gif'+
			'" width="6" height="20" align="absmiddle" style="border:1px solid '+TOOLBAR_BG_COLOR +';cursor:move;"></td>';
					
		for (i = 0; i < TOP_TOOLBAR_ICON.length; i++) 
		{
			htmlData += '<td width="' + TOP_TOOLBAR_ICON[i][2] + 
			'" height="' + TOP_TOOLBAR_ICON[i][3] + '"><img id="'+ TOP_TOOLBAR_ICON[i][0] +'" src="' + IMAGE_PATH + 
			TOP_TOOLBAR_ICON[i][1] + '" width="' + TOP_TOOLBAR_ICON[i][2] + 
			'" height="' + TOP_TOOLBAR_ICON[i][3];
			if (TOP_TOOLBAR_ICON[i][1]!='sp.gif')
			{
			 htmlData+= '" alt="' + TOP_TOOLBAR_ICON[i][4] + 
			 '" title="' + TOP_TOOLBAR_ICON[i][4] + 
			 '" align="absmiddle" style="border:1px solid '+ 
			 TOOLBAR_BG_COLOR +';cursor:pointer;" onclick="javascript:WLExecute(\''+ TOP_TOOLBAR_ICON[i][0] +'\');"'+
			 ' onmouseover="javascript:WLOverIcon(this);" onmouseout="javascript:WLOutIcon(this);"></td>';
			}
			else
			{
			  htmlData+= '" style="border:1px solid '+TOOLBAR_BG_COLOR +';cursor:default;" ></td>';
			}
		}
		
		
		htmlData += '</tr></table><table cellpadding="0" cellspacing="0" border="0"><tr>';
		
		//加工具栏标头
		htmlData+='<td width="6" height="20"><img id="ToolBarHead" src="'+IMAGE_PATH+'ToolBarHead.gif'+
			'" width="6" height="20" align="absmiddle" style="border:1px solid '+TOOLBAR_BG_COLOR +';cursor:move;"></td>';
		for (i = 0; i < BOTTOM_TOOLBAR_ICON.length; i++) 
		{
			htmlData += '<td width="' + BOTTOM_TOOLBAR_ICON[i][2] + 
			'" height="' + BOTTOM_TOOLBAR_ICON[i][3] + '"><img id="'+ BOTTOM_TOOLBAR_ICON[i][0] +'" src="' + IMAGE_PATH + 
			BOTTOM_TOOLBAR_ICON[i][1] + '" width="' + BOTTOM_TOOLBAR_ICON[i][2] + 
			'" height="' + BOTTOM_TOOLBAR_ICON[i][3];
			if (BOTTOM_TOOLBAR_ICON[i][1]!='sp.gif')
			{
			 htmlData+= '" alt="' + BOTTOM_TOOLBAR_ICON[i][4] + 
			 '" title="' + BOTTOM_TOOLBAR_ICON[i][4] + 
			 '" align="absmiddle" style="border:1px solid '+ 
			 TOOLBAR_BG_COLOR +';cursor:pointer;" onclick="javascript:WLExecute(\''+ BOTTOM_TOOLBAR_ICON[i][0] +'\');"'+
			 ' onmouseover="javascript:WLOverIcon(this);" onmouseout="javascript:WLOutIcon(this);"></td>';
			}
			else
			{
			  htmlData+= '" style="border:1px solid '+TOOLBAR_BG_COLOR +';cursor:default;" ></td>';
			}
		}
		htmlData += '</tr>' +
			'</table>' +
			'</div>' +
			'<div id="editIframe">' +
			'<iframe name="EditForm" id="EditForm" frameborder="0" style="' + iframeSize + 
			'padding:0;margin:0;border:1px solid '+ FORM_BORDER_COLOR +'">' +
			'</iframe>' +
			'</div>' +
			'<div id="editTextarea" style="display:none;">' +
			'<textarea name="CodeForm" id="CodeForm" style="' + iframeSize + 
			'padding:2px;margin:0;border:1px solid '+ FORM_BORDER_COLOR + 
			';font-size:12px;line-height:16px;font-family:'+EDITOR_FONT_FAMILY+';background-color:'+ 
			FORM_BG_COLOR +';"></textarea>' +
			'</div>' +
			'</div>' +
			'<span id="popupName" style="display:none;"></span>' +
			'<span id="popupData"></span>';
		document.open();
		document.write(htmlData);
		document.close();
		if (BROWSER == 'IE') {
			EDITFORM_DOCUMENT = document.frames("EditForm").document;			
		} else {
			EDITFORM_DOCUMENT = document.getElementById('EditForm').contentDocument;
		}
		EDITFORM_DOCUMENT.designMode = 'On';
		WLWriteFullHtml(EDITFORM_DOCUMENT);
		var el = EDITFORM_DOCUMENT.body;
		if (BROWSER == 'OPERA') {
			el.onclick = WLClearTemp;
		} else {
			if (el.addEventListener){
				el.addEventListener('click', WLClearTemp, false); 
			} else if (el.attachEvent){
				el.attachEvent('onclick', WLClearTemp);
			}
		}
		if (BROWSER == 'IE') {
			EDITFORM_DOCUMENT.attachEvent("onbeforedeactivate", bookmark);
			//EDITFORM_DOCUMENT.attachEvent("onactivate", restoreBookmark);
		}
	}
	this.data = function()
	{
		if (BROWSER == '') {
			htmlResult = document.getElementById("CodeForm").value;
			document.getElementsByName(this.hiddenName)[0].value = htmlResult;
			return htmlResult;
		}
		var length = document.getElementById(TOP_TOOLBAR_ICON[0][0]).src.length - 10;
		var image = document.getElementById(TOP_TOOLBAR_ICON[0][0]).src.substr(length,10);
		var htmlResult;
		if (image == 'source.gif') {
			htmlResult = WLHtmlToXhtml(EDITFORM_DOCUMENT.body.innerHTML);
		} else {
			htmlResult = document.getElementById("CodeForm").value;
		}
		document.getElementsByName(this.hiddenName)[0].value = htmlResult;
		return htmlResult;
	}
}

