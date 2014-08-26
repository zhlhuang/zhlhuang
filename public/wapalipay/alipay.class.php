<?php
require_once("sqlTool.php");
class alipay extends sqlTool{
	  public function insert($all){
		  //这是一个支付返回的支付信息存入数据库
	  $sq=new sqlTool();
	  $out_trade_no=$all["out_trade_no"];  //商家订单号
	  $trade_no=$all["trade_no"];  //支付宝交易号
	  $trade_status=$all["trade_status"]; //交易状态
	  $buyer_email=$all["buyer_email"]; //买家id
	  $gmt_payment=$all["gmt_payment"]; //买家支付时间
	  $price=$all["price"];  //支付价格
	  $seller_email=$all["seller_email"];  //卖家id
	  $notify_id=$all["notify_id"];
	  
	  
	  
	  $sql="INSERT INTO `alipay`(`out_trade_no`, `trade_no`, `trade_status`, `buyer_email`, `gmt_payment`, `price`, `seller_email`,`notify_id`) VALUES ('".$out_trade_no."','".$trade_no."','".$trade_status."','".$buyer_email."','".$gmt_payment."','".$price."','".$seller_email."') ";
	  
	  $res=$sq->execute_dml($sql);
	  if($res){
		  return "录入成功";
	  }else{
		  return "录入失败";
		  }  
	  }
	  
		function updatastatus($all){
			//当交易状态改变是   更新数据库的状态信息
			$sq=new sqlTool();
			$out_trade_no=$all["out_trade_no"];  //商家订单号
			$trade_status=$all["trade_status"]; //交易状态
			$gmt_payment=$all["notify_time"]; //买家支付信息更新时间
			$sql="UPDATE `alipay`  SET  `trade_status`='".$trade_status."',`gmt_payment`='".$gmt_payment."' WHERE out_trade_no='".$out_trade_no."'";
			file_put_contents("testsql.txt",$sql);
			$res=$sq->execute_dml($sql);
		if($res){
			return "success";
		}else{
			return "fail";
			}  
		}
	
	}
?>