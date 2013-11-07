<?php
/**
  * 用来验证开发者 URL 和 Token 填写是否正确
  */
  
//define your token
define("TOKEN", "wxcommand");       //定义自己的TOKEN

//新建一个 wechatCallbackapiTest 类实体 wechatObj
$wechatObj = new wechatCallbackapiTest();

//调用该类的 valid() 函数
$wechatObj->valid();

//定义一个 wechatCallbackapiTest 类
//该类有函数成员：
//		valid
//		checkSignature
class wechatCallbackapiTest
{
	//验证 signature 是否有效
	public function valid()
	{
		$echoStr = $_GET["echostr"];

		//valid signature , option
		//验证通过，返回 $echoStr
		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}
		
	private function checkSignature()
	{
		//分别为 GET 请求中三个参数的内容
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];	
        
		//定义的TOKEN的值
		$token = TOKEN;
		
		//将token、timestamp、nonce 三个参数进行字典序排序
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		
		//拼接成一个字符串并且进行 sha1 加密
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		//如果与 GET 请求中包含的 signature 相同，则验证通过；否则失败
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>