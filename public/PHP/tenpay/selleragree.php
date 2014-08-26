<?php
require_once("../alipay.class.php");
//卖家收到货，同意退款


$id=$_GET["id"];
if($id){
	//成功获取id
	
	$pay=new alipay();
	
	$payres=$pay->getall($id);//获取订单信息
	
	$trade_status=$payres["trade_status"]; //拿到交易状态
	$res='fail';
	if($trade_status=="WAIT_SELLER_CONFIRM_GOODS"||$trade_status=="WAIT_BUYER_RETURN_GOODS"){
		//卖家收到退货
		$r=file_get_contents("http://www.jmyzds.com/store/wxpay/tenpay/clientRefund.php?id=".$id);
		if($res=="success"){
			$r=$pay->updatastatus2($id,"REFUND_SUCCESS"); //卖家同意退货  退款成功
		}else{
			$res=$r;
		}
		
	}
	
	if($res==1){
		echo "success";
	}else{
		echo $res;
	}
	
	
	
}else{
	//没有传入id值
	echo "no id value";
}
?>