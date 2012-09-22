/**
 * <script> var newSlider = {name:'newSlider',index:0,time:3000,time_h:0,activeCssClass:'on',cssClass:'noton',list:[{id:'s_whxw',cid:'s_whxw_c',url:'index.php'},{id:'s_jyxw',cid:'s_jyxw_c',url:'index.php'},{id:'s_xxxw',cid:'s_xxxw_c',url:'index.php'},{id:'s_jdzt',cid:'s_jdzt_c',url:'index.php'}]}; </script>
 *  滑动条参数说明:
 *  name 滑动条变量名
 *  index 当前激活的滑块索引
 *  time 超时时间(毫秒)，表示过了指定时间后自动还原到第一个
 *  time_h setTimeout的句柄
 *  activeCssClass 某个滑块激活时的css class name;
 *  cssClass 滑块非激活时的css class name;
 *  list 各滑块数组
 *  
 *  滑块参数说明
 *  id 滑块标签的id
 *  cid 滑块内容的id
 *  url 点击"更多"时指向的url
 */


function sliderOnMouseOver(slider,i){
	var title = document.getElementById(slider.list[slider.index].id);
	var content = document.getElementById(slider.list[slider.index].cid);
	title.className = slider.cssClass;
	content.style.display="none";
	slider.index = i;
	title = document.getElementById(slider.list[slider.index].id);
	content = document.getElementById(slider.list[slider.index].cid);
	title.className = slider.activeCssClass;
	content.style.display="";
	if (slider.time==0) return;
	window.clearTimeout(slider.time_h);
	if (i == 0) return;
	slider.time_h = window.setTimeout("sliderOnMouseOver("+slider.name+",0)",slider.time);
	
}
function sliderMoreClick(slider){
	window.open(slider.list[slider.index].url);
}

function imgSlide(slide,i){
	var title = document.getElementById(slide.txt_id);
	var li,li_a,li_img,num;
	li=document.getElementById(slide.li_id+'_'+slide.index);
	num=document.getElementById(slide.num+'_'+slide.index);
	li.style.display="none";
	num.className="slideNum";
	slide.index=i;
	li=document.getElementById(slide.li_id+'_'+i);
	num=document.getElementById(slide.num+'_'+i);
	li.style.display="";
	num.className="slideNumOn";
	li_a=document.getElementById(slide.li_id+'_'+i+'_a');
	li_img=document.getElementById(slide.li_id+'_'+i+'_i');
	title.href=li_a.href;
	title.innerHTML = li_img.alt;
	i++;
	if (i>=slide.count) i=0;
	slide.time_h = window.setTimeout("imgSlide("+slide.name+","+i+")",3000);
}
function imgSlideClick(slide,i){
	window.clearTimeout(slide.time_h);
	imgSlide(slide,i);
}

var up_menu = ''; 
var up_time_h;
function showMenu(id,obj) { 
	var subMenu = document.getElementById(id);
	if(subMenu!=null){
    if(up_menu!='')closeMenu();
	up_menu=id;
	subMenu.style.display = "";
	var x = obj.offsetLeft;
	var y = obj.offsetTop;
　　var p = obj.offsetParent;
　　while (p != null){
　　　　x += p.offsetLeft;
	   y += p.offsetTop;
　　　　p = p.offsetParent;
　　}
	subMenu.style.left=x+'px';
	subMenu.style.top=y+35+'px';
	window.clearTimeout(up_time_h);
	up_time_h = window.setTimeout("closeMenu()",1000);}
}
function closeMenu(){
	var subMenu = document.getElementById(up_menu);
	subMenu.style.display = "none";
}
function delayMenu(){
	window.clearTimeout(up_time_h);
	up_time_h = window.setTimeout("closeMenu()",1000);
}

function openChatWin(webCode){	
	var winMode = "width=725px,height=575px,status=no,resizable=no,location=no,menubar=no,toolbar=no,status=no";
	var sUrl = ' http://cs.e21.cn/chat.php?wid=' + webCode;
	window.open(sUrl,"_blank",winMode);
	props.focus();
}

