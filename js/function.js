
function mm(str){	//控制iframe的高度与当前body高度保持一致
	var e = eval("document.all."+ str);
	e.style.height = window.frames[str].document.body.scrollHeight;
}

function jumpUrl(url,isFrame,target){
	
	if(isFrame){
		if(target=='_self'){
			this.location.href=url;
		}
		else if(target=='parent'){			
			window.parent.location.href=url;
		}
	}else{
		
		if(target=='_self'){
			window.location.href=url;
		}
		else if(target=='parent'){			
			window.parent.location.href=url;
		}
	}
	
}


//验证文本内容是否为空
function IsEmpty(obj,msg){
    if(Trim(obj.value)==""){
        alert(msg);        
        if(obj.disabled==false && obj.readOnly==false){
            obj.focus();
        }
		return true;
    }
	return false;
}
//验证文本内容是否是数字
function IsNum(obj,msg){
	var zz_test=/^[-0-9.]+$/;
	if(!zz_test.test(obj.value) || isNaN(parseFloat(obj.value))){
		alert(msg);
		if(obj.disabled==false && obj.readOnly==false){
            obj.focus();
        }
		return false;
	}
	return true;
}
//验证文本内容是否是日期
function IsDate(obj,msg){
	var zz_test=/^[0-9][0-9][0-9][0-9]-[0-1][0-9]-[0-3][0-9]$/;
	if(!zz_test.test(obj.value)){
		alert(msg);
		if(obj.disabled==false && obj.readOnly==false){
            obj.focus();
        }
		return false;
	}
	return true;
}

//验证文本内容是否为用户名或者密码
function IsUserNameOrPwd(obj,msg){
	var zz_test=/^[0-9a-zA-Z_]+$/;
	if(!zz_test.test(obj.value)){
		alert(msg);
		if(obj.disabled==false && obj.readOnly==false){
            obj.focus();
        }
		return false;
	}
	return true;
}


//验证下拉框所选的值是否为给定的值v
function IsSelected(obj,v,msg){
	if(obj.options[obj.selectedIndex].value==v){
        alert(msg);
		obj.focus();
		return true;
    }
	return false;
}



//检查手机号码
function isMobile(obj, msg){
	if (obj.value != "")
	{ 
		var mobile=obj.value;
		var reg0 = /^13\d{5,9}$/;
		var reg1 = /^15\d{5,9}$/;
		//var reg2 = /^159\d{4,8}$/;
		var reg3 = /^0\d{10,11}$/;
		var my = false;
		if (reg0.test(mobile))my=true;
		if (reg1.test(mobile))my=true;
		//if (reg2.test(mobile))my=true;
		if (reg3.test(mobile))my=true;
		if (!my)
		{
			alert(msg);
			obj.focus();
			return false;
		}
	}
	return true;
	
}



//返回同一id的单选框或复选框选中了多少个（实际上单选框最多应该返回1）
function ReturnCheckedNum(form_name,id_name){
	
	obj=eval("document."+form_name+"."+id_name);
	var Num=0;

	if(typeof(obj.length)=="undefined"){
		if(obj.checked){
			Num=1;
		}
	}
	else{
		for(i=0;i<obj.length;i++){
			if(obj[i].checked){
				Num++;
			}
		}
	}

	return Num;
	
}


function IsChecked(form_name,id_name,msg){
	if(!ReturnCheckedNum(form_name,id_name)){
		alert(msg);
		return false;
	}
	else{
		return true;
	}
}



//确认框
function PopConfirm(url,msg){
	if (confirm(msg)) {
		document.location.href=url;
	}
}




//隐藏tbody
function HiddenTbody(tbody_id){
	if (tbody_id.style.display=="none"){
		tbody_id.style.display="";
	}
	else{
		tbody_id.style.display="none";
	}
}
//隐藏tbody
function HiddenTbody2(tbody_id,val){
	if (val=="51"){
		tbody_id.style.display="";
	}
	else{
		tbody_id.style.display="none";
	}
}
//隐藏tbody
function HiddenTbody3(item_id){
	//alert(item_id);
	//item_id.style.display="";
	document.all(item_id).style.display="";
}

//在数组中搜索给定的值，如果成功则返回第一次出现的索引，如果没有找到则返回false
//此函数同php的array_search函数
function ArraySearch(search_value,search_array){
	var i;

	for(i=0;i<search_array.length;i++){
		if(search_array[i]==search_value){
			return i;
		}
	}
	return false;
}




//向obj中添加html语句
function AddHtml(obj,html){
	obj.innerHTML+=html;
	
}


//features:	'width=600,height=400,scrollbars=auto,resizable=no'
function OpenWindow(theURL,winName,features) { 
  window.open(theURL,winName,features);
}



//层对象居中
function CenterDiv(div_id){
	
	divObj=document.getElementById(div_id);

	divObj.style.left=(document.body.offsetWidth-parseInt(divObj.offsetWidth))/2;
	divObj.style.top=(document.body.offsetHeight-parseInt(divObj.offsetHeight))/2;
}




//将id拆分为目录结构
function id2cate(id){

	id=id.toString();

	var returnStr="";
	for(var i=0;i<id.length;i++){
		returnStr+=id.substr(i,1)+"/";
	}
	return returnStr;
}



function ActiveTableClass(tableObject){
	
	this.object=tableObject;
	this.topFixRowLength="";
	this.feetFixRowLength="";
	this.ActiveCellContent = "";

	this.addRow=function(){

		iNewTableRows=this.object.rows.length - this.feetFixRowLength;
		var oNewRow=this.object.insertRow(iNewTableRows);

		oNewRow.align="center";
		oNewRow.bgColor="#ffffff";

		for(i=0;i<this.ActiveCellContent.length;i++){
			oNewRow.insertCell(i).innerHTML=this.ActiveCellContent[i];
		}
	}

	this.deleteRow=function(row_i){

		if(confirm('您确定要删除吗？')){
			this.object.deleteRow(row_i);
		}
	}
}






function GetCookieVal(offset){
	//获得Cookie解码后的值
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1)
		endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie(name){
	//获得Cookie的原始值

	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;

	var i = 0;
	while (i < clen){
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return GetCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0) 
			break;
	}
	return null;
}
function SetCookie(name, value){
	//设定Cookie值

	var expdate = new Date();
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;

	if(expires!=null) 
		expdate.setTime(expdate.getTime() + ( expires * 1000 ));

	document.cookie = name + "=" + escape (value) +((expires == null) ? "" : ("; expires="+ expdate.toGMTString()))
	+((path == null) ? "" : ("; path=" + path)) +((domain == null) ? "" : ("; domain=" + domain))
	+((secure == true) ? "; secure" : "");
}
function DelCookie(name){
	//删除Cookie

	var exp = new Date();
	exp.setTime (exp.getTime() - 1);

	var cval = GetCookie (name);
	document.cookie = name + "=" + cval + "; expires="+ exp.toGMTString();

}














function Trim(str){
    return RTrim(LTrim(str));
}
function LTrim(str){
    var whitespace = new String(" \t\n\r");
    var s = new String(str);
	
	if (whitespace.indexOf(s.charAt(0)) != -1){

        var j=0, i = s.length;

        while (j < i && whitespace.indexOf(s.charAt(j)) != -1){
            j++;
        }
        s = s.substring(j, i);
    }

    return s;
}
function RTrim(str){

    var whitespace = new String(" \t\n\r");
    var s = new String(str);

    if (whitespace.indexOf(s.charAt(s.length-1)) != -1){

        var i = s.length - 1;

        while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1){
            i--;
        }
        s = s.substring(0, i+1);
    }
    return s;
}





function GetXMLHttpRequest(){
	var xmlHttp = false; 
	
	try { 
		xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); 
	} 
	catch (e) { 
		try { 
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch (e2) { 
			xmlHttp = false; 
		} 
	} 

	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') { 
		xmlHttp = new XMLHttpRequest(); 
	} 

	return xmlHttp;
}



function show_temple(idname,value){
 var obj1 = document.getElementById(idname);
 obj1.innerHTML = value;
}

/*
	使用方法：
	var args = new Object();
	args = GetUrlParms();
	如果要查找参数key:
	value = args[key] 
*/
function GetUrlParms()    
{
	
    var args=new Object();   
    var query=location.search.substring(1);//获取查询串   
    var pairs=query.split("&");//在逗号处断开   
    for(var   i=0;i<pairs.length;i++)   
    {   
        var pos=pairs[i].indexOf('=');//查找name=value   
            if(pos==-1)   continue;//如果没有找到就跳过   
            var argname=pairs[i].substring(0,pos);//提取name   
            var value=pairs[i].substring(pos+1);//提取value   
            args[argname]=unescape(value);//存为属性   
    }
    return args;
}


function jump(html_url,page,item_id,other_parm,php_url,page_to_php){ 
	/*
	*html_url,静态页面路径；php_url ,动态页面路径
	*page,跳到第几页
	*item_id,栏目ID
	*other_parm，其他参数如“xx=xxx1&yy=yyy1”
	*page_to_php,到第几页换为动态页面路径
	*/
	var urlstr="";
	//if(page==1) 
	//	urlstr =url; 
	//else 
	page = parseInt(page);
	page_to_php = parseInt(page_to_php);
	   urlstr=html_url+"?page_id="+page+"&page="+page+"&item_id="+item_id; 
	   if(page>page_to_php){
	     urlstr=php_url+"?page_id="+page+"&page="+page+"&item_id="+item_id; 
	   }
	   else{
	     urlstr=html_url+"?page_id="+page+"&page="+page+"&item_id="+item_id; 
	   }
       if(other_parm!=""){
	     urlstr = urlstr+"&"+other_parm;
	   }
      
	window.location.href=urlstr; 

}


function ShowPage(html_url,page,other_parm,php_url,page_to_php){ 
	/*
	*html_url,静态页面路径；php_url ,动态页面路径
	*page,跳到第几页
	*item_id,栏目ID
	*other_parm，其他参数如“xx=xxx1&yy=yyy1”
	*page_to_php,到第几页换为动态页面路径
	*/
	var urlstr="";
	//if(page==1) 
	//	urlstr =url; 
	//else 
	page = parseInt(page);
	page_to_php = parseInt(page_to_php);
	   urlstr=html_url+"?page="+page; 
	   if(page>=page_to_php){
	     urlstr=php_url+"?page="+page; 
	   }
	   else{
	     urlstr=html_url+"?page="+page; 
	   }
       if(other_parm!=""){
	     urlstr = urlstr+"&"+other_parm;
	   }
       //this.location.href=urlstr; 
       //window.location.href=urlstr; 
       if(page>=page_to_php){   
    	   this.location.href=urlstr; 
       }
       else{
    	   window.parent.location.href=urlstr;     	   
       }
}


