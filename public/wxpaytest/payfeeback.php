<?php
//这是一个维权接口
include_once("./CommonUtil.php");
/*$postData=" <xml><ToUserName>toUser</ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName> 
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[this is a test]]></Content>
 <MsgId>1234567890123456</MsgId>
 </xml>";     这是一个测试 */
 
 
 
 
 $postData=$_REQUEST;//接受微信传过来的postData
if($postData){
	
	file_put_contents("./testfile/payfeeback.txt",$postData);
   
	$com=new CommonUtil();
	
	$array=$com->Xmltoarray($postData);
	
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	
}else{
	echo "postdata is null";//没有接收到数据
}

?>