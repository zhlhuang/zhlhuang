<?php
include_once("alipay.class.php");
/*
这是支付返回的异步通知页面


*/
$res=$_REQUEST;//获取所有异步信息
if($res){
	
	$alipay=new alipay();
	
	$alipay->in($res);
	$json=json_encode($res,1); //获取返回的支付信息
	file_put_contents("./testfile/notify_url.txt",$json);
	echo $alipay->in($res); //返回处理信息
}else{
	echo "fail"; //处理失败
}
?>