<?
/*
ҳ�湦�ܣ���ʾ��

����

�ļ���div_view.php

����Ա������

*/

//php����ҳ�棬����ʱ��������div_view_span��innerHTML
//$pageAndparameter Ҫ�����ҳ��Ͳ���
//$returnHtmlElementId ��ʾ���ݵ�htmlԪ�ص�id��һ���Ǹ�span��id
function loadViewPage($pageAndparameter,$returnHtmlElementId){

	//����ҳ�棬����
	$page_content="";
	ob_start();


	//��ҳ��Ͳ���ָ�Ϊҳ���ļ��Ͳ����ַ�
	$tempArray=explode("?",$pageAndparameter);
	$pageName=$tempArray[0];
	$parameterString=$tempArray[1];

	//�ָ�ÿ��������嵽GET����
	$parameterArray=explode("&",$parameterString);
	$_GET = array();
	for($i=0;$i<count($parameterArray);$i++){
		$oneParameterArray=explode("=",$parameterArray[$i]);
		//$$oneParameterArray[0]=$oneParameterArray[1];
		$_GET[$oneParameterArray[0]]=$oneParameterArray[1];
	}

	include($pageName);
	$page_content=ob_get_contents();

	ob_end_clean();

	//��ҳ�滺��ֵ����
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($returnHtmlElementId,"innerHTML",iconv('gbk','utf-8', $page_content));
	
	//���ò���к���
	//$objResponse->addScriptCall("CenterDiv","div_view");


	return $objResponse;
}



$xajax->registerFunction("loadViewPage");
$xajax->processRequests();


?>
<script>>
<!--


//����϶���************************************************************��ʼ
var dragVivObj=0;
var thisX=0;
var thisY=0;
var isIE = (navigator.appVersion.indexOf("MSIE")!=-1);//IE
var isFireFox = (navigator.userAgent.indexOf("Firefox")!=-1);//Firefox
 
function Find(evt,o){
	dragVivObj = o;
	if (isFireFox){
		thisX = document.documentElement.scrollLeft + evt.layerX;
		thisY = document.documentElement.scrollTop + evt.layerY;
    
		if (document.documentElement.scrollTop > 0){
			thisY = evt.layerY - document.documentElement.scrollTop;
		}
    
		if (document.documentElement.scrollLeft > 0){
			thisX = evt.layerX - document.documentElement.scrollLeft;
		}
	}

	if (isIE){
		thisX = document.body.scrollLeft + evt.offsetX;
		thisY = document.body.scrollTop + evt.offsetY;
		

		if (document.body.scrollTop > 0){
			thisY = evt.offsetY - document.body.scrollTop;
		}
    
		if (document.body.scrollLeft > 0){
			thisX = evt.offsetX - document.body.scrollLeft;
		}

	}
}

function DragDiv(evt){
	if(dragVivObj == 0){
		return false
	}
	else{
		dragVivObj.style.left = evt.clientX - thisX + "px";
		dragVivObj.style.top = evt.clientY - thisY + "px";
	}
}

function DragCancel(){
	dragVivObj=0;
}

document.onmousemove=function() {DragDiv(event);};
document.onmouseup=function() {DragCancel()};
//����϶���************************************************************����








//��ʾdiv_id����㣬ʹ��xajax��ʽ����page���ҳ�棨xajax_loadViewPage��������ҳ�����ݻ��棬���ظ�content_id���Ԫ�ص�innerHTML����ʾ
//op��������ʾ��������	
//page��Ҫ�����ҳ���Լ�����
//is_no_move�������������¶�λdiv
function DisplayXajaxDiv(op,page,div_id,content_id,is_no_move){
	
	div_obj=document.getElementById(div_id);
	content_obj=document.getElementById(content_id);

	if(op=="show"){
		//��ʾ��
		div_obj.style.display="";

		if(!is_no_move){
			div_obj.style.left=window.event.clientX+10;
			div_obj.style.top=document.body.scrollTop+window.event.clientY+10;
		}
		

		content_obj.innerHTML="��������...";

		//ajax����ҳ�棬���ظ�content_id��innerHTML
		xajax_loadViewPage(page,content_id);

	}

	if(op=="hidden"){
		//���ز�
		div_obj.style.display="none";
	}

}





function DisplayViewDiv(op,page,is_no_move){
	DisplayXajaxDiv(op,page,"div_view","div_view_span",is_no_move);
	dragVivObj=0;
}


function DisplayViewDiv2(op,page,is_no_move){
	DisplayXajaxDiv(op,page,"div_view_2","div_view_span_2",is_no_move);
	dragVivObj=0;
}








//-->
</script>


<div id="div_view" style="position:absolute;display:none;z-index:1;filter:alpha(opacity=90);background:#1979C9; padding:2px;">
	<table bgcolor="#1979C9" border="0" cellpadding="1" cellspacing="1">
		<tr style="cursor:move " onmousedown="Find(event,document.getElementById('div_view'))" onmouseup="DragCancel()"> 
			<td align="left" bgcolor="#1979C9"  colspan="10" >	
				<span class="w12" onclick="DisplayViewDiv('hidden','')" style="cursor:hand "><B>�ر�</B></span>
			</td>
		</tr>
		<tr> 
			<td align="center" bgcolor="#FFFFFF"  colspan="10" class="b12">	
				<span id="div_view_span"></span>
			</td>
		</tr>
	</table>
</div>




<div id="div_view_2" style="position:absolute;display:none;z-index:1;filter:alpha(opacity=90);background:#557FAA; padding:2px;">
	<table bgcolor="#557FAA" border="0" cellpadding="1" cellspacing="1">
		<tr style="cursor:move " onmousedown="Find(event,document.getElementById('div_view_2'))" onmouseup="DragCancel()"> 
			<td align="left" bgcolor="#557FAA"  colspan="10" >	
				<span class="w12" onclick="DisplayViewDiv2('hidden','')" style="cursor:hand "><B>�ر�</B></span>
			</td>
		</tr>
		<tr> 
			<td align="center" bgcolor="#FFFFFF"  colspan="10" class="b12">	
				<span id="div_view_span_2"></span>
			</td>
		</tr>
	</table>
</div>