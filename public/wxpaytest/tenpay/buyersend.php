<?php
require_once("../alipay.class.php");
//买家已经退货申明
if($_SESSION["certification"]!="yes"){
	echo "fail";
	exit();
}
	
$id=$_GET["id"];
if($id){
	//成功获取id
	
	$pay=new alipay();
	
	$payres=$pay->getall($id);//获取订单信息
	
	$trade_status=$payres["trade_status"]; //拿到交易状态
	$res='fail';
	if($trade_status=="WAIT_BUYER_RETURN_GOODS"){
		//等待买家退货
		$res=$pay->updatastatus2($id,"WAIT_SELLER_CONFIRM_GOODS"); //更新等待卖家收货
	}
	
	if($res==1){
		echo "success";
	}else{
		echo "fail";
	}
	
	
	
}else{
	//没有传入id值
	echo "no id value";
}
?>