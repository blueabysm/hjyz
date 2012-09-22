if (!window.XMLHttpRequest){
	window.XMLHttpRequest = function(){
		var xmlHttp = null;
		var ex;
		try		{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP.4.0");
		}catch (ex){
			try	{
				xmlHttp = new ActiveXObject("MSXML2.XMLHTTP");
			}catch (ex){
				try {
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (ex){
					
				}
			}
		}
		return xmlHttp;
	};
}

function xmlHttpReq(callback){
	switch(typeof(callback)){
		case "function":
		case "string":
			break; //允许参数是 函数或字符串

		default:
			return null;
	}

	var xml_method = 0;
	var async = true;
	var charset = 'utf-8';
	var http = new XMLHttpRequest();
	if (http == null){
		return null;
	}

	http.onreadystatechange = function(){
		/* 	0: Uninitialized
			1: Loading
			2: Loaded
			3: Interactive
			4: Finished */
		if(http.readyState == 4 && http.status == 200){
			try	{
				var ret = http.responseText; //结果
				if (typeof(callback)=="function"){
					callback(ret); //回访回调函数
				}else if(typeof(callback)=="string"){
					var lc = callback.indexOf("(");
					var rc = callback.indexOf(")");
					if ((lc<0)&&(rc<0)){
						s = callback+"(ret)";
					}else{
						var a = "";
						a = (rc-lc<2)?"":",";
						r = /\)/g;
						s = callback.replace(r ,a+"ret)");
					}
					eval(s);
				}
			}catch(e){
			}
		}
	};
	
	this.setAsync = function(async_type){
		async = async_type;
	};
	this.setCharset = function(ch){
		charset = ch;
	};

	this.get = function(url){
		try	{
			http.open('get', url, async);
			http.setRequestHeader("Method", "G " + url + " HTTP/1.1");
			http.send(null);
		}catch(e){
		}
	};

	this.post = function(url,args){
		try{
			http.open('post', url, async);
			http.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
			http.setRequestHeader("Charset",charset);
			http.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			
			var arg_g_arr = args.split("&");
			for(key in arg_g_arr){
				value_arr = arg_g_arr[key].split("=");
				value_arr[1] = encodeURI(value_arr[1]);
				arg_g_arr[key] = value_arr.join("=");
			}
			args = arg_g_arr.join("&");
			http.send(args);
		}catch(e){			
		}
	};
}