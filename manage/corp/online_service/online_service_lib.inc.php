<?php
/**********************************************
 * 3des加密解密字符串类;加密串失效时间默认为600000毫秒。10分钟
 *
 * soft456@gmail.com 2009年8月17日 23:28:32
 *
 **********************************************/
class Mcrypt_class {
	var $key = null;
	var $timeOut = null;

	//默认超时时间为：10分钟，即600000毫秒。
	function Mcrypt_class($key="aH1_~2@?",$timeOut=600000){
		$this -> key = $key;
		$this -> timeOut = $timeOut;
	}

	//加密字符串，入口参数为一唯数组；成功返回加密后的字符串
	function Encode($aPar){
		if(count($aPar) <= 0 ){die("传入参数错误！");}
		$oIV = pack('H16',"0102030405060708");

		//取得时间戳
		$sTimeStamp = $this -> getMicroTime();
		$iCnt = count($aPar);
		$sParameterValue = null;

		foreach ($aPar as $key=>$val) {			
			$aPar[$key] = $this -> getUTFString($val);
		}

		for($i=0; $i < $iCnt; $i++){
			$sParameterValue .= $i==0 ? $aPar[$i] : "$".$aPar[$i];
		}	
		
		$digest = base64_encode(sha1($sTimeStamp."$".$sParameterValue));

		$sParameterValue = $this -> paddingPKCS7($sTimeStamp."$".$sParameterValue."$".$digest);

		$sParameterValue = mcrypt_encrypt(MCRYPT_3DES,$this->key,$sParameterValue,MCRYPT_MODE_CBC,$oIV);
		$sParameterValue = rawurlencode(base64_encode($sParameterValue));
		return $sParameterValue;
	}

	//解码字符串，成功返回数组，不含时间。否则返回false
	function Decode($str){
		if($str == ""){die("参数错误！");}
		
		$str = base64_decode(rawurldecode($str));		
		$oIV = pack('H16',"0102030405060708");

		//解密字符串
		$str = mcrypt_decrypt(MCRYPT_3DES,$this->key,$str,MCRYPT_MODE_CBC,$oIV);	
		$aStrRs = explode("$", $str);		

		//验证HAS字串是否相等		
		$iCnt = count($aStrRs);
	
		$sParameterValue = null;
		for($i=0; $i < $iCnt-1; $i++){
			$tt = $aStrRs[$i];			
			$sParameterValue .= $i==0 ? $tt : "$".$tt;
		}

		$sDigest = strtoupper(sha1($sParameterValue));		
		$urlDig = iconv('utf-8','gb2312',$aStrRs[$iCnt - 1]);	
		$sUrlDigest = strtoupper(base64_decode($urlDig));

		$urlTime = $aStrRs[0];
		
		foreach ($aStrRs as $key=>$val) {			
			$aStrRs[$key] = $this -> getGb2312Str($val);
		}

		if($sDigest == $sUrlDigest){
			//检测加密串的有效期
			$sTimeStamp = $this -> getMicroTime();
			if(($sTimeStamp - $urlTime) > $this -> timeOut){
				//超时
				return false;
				exit;
			}else{
				array_pop($aStrRs);
				return $aStrRs;
			}
		}else{
			return false;
			exit;
		}
	}

	function isTimeOut($str){

		if($str == ""){die("参数错误！");}
		$str = base64_decode(rawurldecode($str));
		$oIV = pack('H16',"0102030405060708");

		//解密字符串获取加密串的时间
		$str = mcrypt_decrypt(MCRYPT_3DES,$this->key,$str,MCRYPT_MODE_CBC,$oIV);
		$aStrRs = explode("$", $str);
		$oldTime = $aStrRs[0];
		unset($aStrRs);

		$sTimeStamp = $this -> getMicroTime();
		echo $sTimeStamp - $oldTime;
		if(($sTimeStamp - $oldTime) > $this -> timeOut){
			//超时
			return true;
		}else{
			return false;
		}
	}

	//将当前时间更新到加密串中，避免失效.成功返回新的加密串
	function refreshTimeOut($str){
		if($str == ""){
			return false;
		}else{
			$aTempRs = $this -> Decode($str);
			array_shift($aTempRs);
			return $this -> Encode($aTempRs);
		}
	}

	//取得当前时间到指定时间之间的毫秒数（默认为2000年1月1日0点0分0秒）
	function getMicroTime(){
		list($usec, $sec) = explode(" ",microtime());
		//$time_start =($sec*1000+$usec*1000);
		//$to = mktime(0,0,0,1,1,2000);
		//$sUnixTime = ceil($time_start-$to*1000);
		//$sUnixTime = ceil($time_start-946684800000);
		return "$sec";
	}

	//将要加密的子串的填充模式转换，补齐位数
	function paddingPKCS7($data) {
		$block_size = mcrypt_get_block_size('tripledes', 'cbc');
		$padding_char = $block_size - (strlen($data) % $block_size);
		$data .= str_repeat(chr($padding_char),$padding_char);
		return $data;
	}

	function getUTFString($string){
		$encoding = mb_detect_encoding($string, array('ASCII','GB2312','GBK','BIG5'));
		return mb_convert_encoding($string, 'utf-8', $encoding);
	}

	function getGb2312Str($string){
		$encoding = mb_detect_encoding($string, array('ASCII','UTF-8','GB2312','GBK','BIG5'));
		return mb_convert_encoding($string, 'GB2312', $encoding);
	}
}
?>