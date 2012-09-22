var oldText = '';
var nowid=0;
var actionType = 0;
function add(){
   var tmpobj = document.getElementById('t_name');
   tmpobj.value = '';	   
   changeDiv();
   tmpobj.focus();
   nowid=0;
   tmpobj = document.getElementById('formDiv');
   tmpobj.style.top = 25;
   tmpobj.style.left = 110;
   actionType = 1;
}
function edit(text,id){
   oldText = text;
   nowid = id;
   var tmpobj = document.getElementById('t_name');
   tmpobj.value =oldText;
   changeDiv();
   tmpobj.focus();
   tmpobj = document.getElementById('formDiv');
   tmpobj.style.top = (document.body.clientHeight-50)/2;
   tmpobj.style.left = (document.body.clientWidth-400)/2;
   actionType = 2;
}
function save(){
   var tmpobj = document.getElementById('t_name');
   if (actionType < 3) {
	   if (tmpobj.value == ''){
		   alert('请填写类型名称');
		   return;
	   }
   }
   if (tmpobj.value == oldText){
	   changeDiv();
   }
   oldText = tmpobj.value;
   tmpobj = document.getElementById('formDiv');
   tmpobj.innerHTML = '正在保存，请稍候……';
   var xhr  = new xmlHttpReq("onProcEnd");
   xhr.setAsync(false);
   var url  = "ajax_method/typesFunction.php";
   var args = "actionType=" + actionType + "&id=" + nowid + "&t_name=" + oldText;
   xhr.post(url, args);
}
function onProcEnd(ret){
	if(ret.length > 0){
		alert(ret);
		return ;
	}
	document.location.reload();
}
function del(id) {
   if (confirm('确定要删除该记录吗？') == false) return;	   
   changeDiv();
   var tmpobj = document.getElementById('formDiv');
   tmpobj.style.top = (document.body.clientHeight-50)/2;
   tmpobj.style.left = (document.body.clientWidth-400)/2;
   tmpobj.innerHTML = '正在删除，请稍候……';
   var xhr  = new xmlHttpReq("onProcEnd");
   xhr.setAsync(false);
   var url  = "ajax_method/typesFunction.php";
   var args = "actionType=3&t_name=''&id=" + id;
   xhr.post(url, args);  
}
function changeDiv(){
   var tmpobj = document.getElementById('bottomDiv');
   if (tmpobj.style.display == "none"){
		  tmpobj.style.display = "";
	} else {
		tmpobj.style.display = "none";
	}
   tmpobj = document.getElementById('formDiv');
   if (tmpobj.style.display == "none")	{
		  tmpobj.style.display = "";
	} else	{
		tmpobj.style.display = "none";
	}
}