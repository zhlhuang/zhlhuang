<?php
require_once("../alipay.class.php");
require_once("./clientRefund.php");
//卖家是否同意退货  ps 未发货则默认退款


$id=$_GET["id"];
$flag=$_GET['flag']; //是否同意退货
if($id){
	//成功获取id
	
	$pay=new alipay();
	
	$payres=$pay->getall($id);//获取订单信息
	
	 $trade_status=$payres["trade_status"]; //拿到交易状态
	$res='fail';
	if($trade_status=="WAIT_SELLER_AGREE"){
		//卖家没有发货
		
	   //$r=file_get_contents("http://www.jmyzds.com/wxpay/tenpay/clientRefund.php?id=".$id);
	   //$res=https_request("http://www.jmyzds.com/store/wxpaytest/tenpay/clientRefund.php?id=".$id);
	    $res=refund($id);
		if($res=="success"){
			$r=$pay->updatastatus2($id,"REFUND_SUCCESS"); //卖家同意退货  退款成功
		}else{
			$res=$r;
		}
		
		
	}
	if( $trade_status=='WAIT_SELLER_AGREE_AFTER_SENT'){
		//卖家已经发货
		if($flag==1){
			//卖家同意发货你   等待买家退货
			$res=$pay->updatastatus2($id,"WAIT_BUYER_RETURN_GOODS");
		}else{
			//卖家不同意退款
			$res=$pay->updatastatus2($id,"SELLER_REFUSE_BUYER");
		}
		
	}
	//echo $res;
	
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