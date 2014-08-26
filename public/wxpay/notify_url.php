<?php
include_once("alipay.class.php");
include_once("CommonUtil.php");
/*
这是支付返回的异步通知页面


*/
$res=$_REQUEST;//获取所有异步信息
if($res){
	
	$alipay=new alipay();
	
	$xml = file_get_contents("php://input");
	$com=new CommonUtil();
	$postData=$com->Xmltoarray($xml); //其实这不是转化成数组  而是一个对象
	
	$openid=$postData->OpenId;  //获取用户的openid
	
	$res["buyer_alias"]=$openid;
	
	$r=$alipay->in($res);
	$json=json_encode($res,1); //获取返回的支付信息
	


	
	
	file_put_contents("./testfile/notify_url.txt",$json."---/r/n".json_encode($postData).$openid.$res["partner"]);
	echo $r; //返回处理信息
}else{
	echo "fail"; //处理失败
}
?>