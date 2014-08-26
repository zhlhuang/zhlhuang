<?php
require_once("../alipay.class.php");
//用户申请退货


$id=$_GET["id"];
if($id){
	//成功获取id
	
	$pay=new alipay();
	
	$payres=$pay->getall($id);//获取订单信息
	
	$trade_status=$payres["trade_status"]; //拿到交易状态
	$res=0;
	if($trade_status=="WAIT_SELLER_SEND_GOODS"){
		//卖家没有发货
		$res=$pay->updatastatus2($id,"WAIT_SELLER_AGREE"); //等待卖家同意
	}
	if( $trade_status=='WAIT_BUYER_CONFIRM_GOODS'){
		//卖家已经发货
		$res=$pay->updatastatus2($id,"WAIT_SELLER_AGREE_AFTER_SENT"); //等待卖家同意
	}
	//echo $res;
	
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