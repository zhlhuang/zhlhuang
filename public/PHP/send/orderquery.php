<?php
// 这是订单查询接口
include_once("./orderquery.class.php");

$id=$_GET["id"];
if($id){
	$orderquery=new orderquery();

    $res=$orderquery->orderquery(35);

  /* echo "<pre>";  
   print_r($res);
   echo "</pre>";
   */
   
   if($res["errcode"]=='0'){
	   $order_info=$res["order_info"];
	   $trade_state=$order_info["trade_state"];//这是订单状态  0 表示付款成功、
	   $is_refund=$order_info["is_refund"]; //  订单是否退款
	   
	   
	   if($trade_state=='0' && $is_refund=="false"){ //付款成功  没有退货
	       echo "success";  //获取订单成功，
	   }else if($trade_state=="true"){
		   echo "is refund";
	   }else{
		   echo "order is error";
	   }
	   
	   
   }else{
	   echo $res["errmsg"];//获取订单失败
   }
   
   
}else{
	echo "the id is  null";
}

?>