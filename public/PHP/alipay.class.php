<?php
require_once("sqlTool.php");

class alipay extends sqlTool{
	public function in($all){
		
		if($all["trade_state"]==0){  
			$all["trade_state"]='WAIT_SELLER_SEND_GOODS'; //支付成功 等待卖家发货
		}else{
			$all['trade_state']=='WAIT_BUYER_PAY'; //支付失败 等待支付
		}
		
		
		
		
		$out_trade_no=$all["out_trade_no"]; //商户订单号
		$sq=new sqlTool();
		$sql="select * from `alipay` where out_trade_no='".$out_trade_no."'" ; //查看数据库中是否有信息
		$res=$sq->execute_dql($sql);
		$sq->close_connect();
		if($res){//若数据库中存在信息
			$this->updatastatus($all); //执行更新代码
		}else{
			$this->insert($all); //若数据中不存在信息，执行插入代码
		}
		
	}
	  public function insert($all){
		  //这是一个支付返回的支付信息存入数据库
		  $sq=new sqlTool();
		  
	$out_trade_no=$all["out_trade_no"]; //商户订单号
	$trade_no=$all["transaction_id"]; //交易号
	$gmt_payment=$all["time_end"]; //支付时间
	$price=$all["total_fee"];  //交易总金额
	$notify_id=$all["notify_id"]; //异步处理id
	$trade_status=$all["trade_state"]; //交易状态
	$buyer_email=$all["buyer_alias"] ;//买家别名  可能是Openid
	$seller_eamil=$all["partner"]; //买家号
	
$sql="INSERT INTO `alipay`(`out_trade_no`, `trade_no`, `trade_status`, `buyer_email`, `gmt_payment`, `price`, `seller_email`,`notify_id`) VALUES ('".$out_trade_no."','".$trade_no."','".$trade_status."','".$buyer_email."','".$gmt_payment."','".$price."','".$seller_email."','".$notify_id."') ";
	  
	  $res=$sq->execute_dml($sql);
	  $sq->close_connect();
	  if($res){
		  return "success";
	  }else{
		  return "fail";
		  }  
	  }
	  
		function updatastatus($all){
			//当交易状态改变是   更新数据库的状态信息
			$sq=new sqlTool();
			$out_trade_no=$all["out_trade_no"];  //商家订单号
			$trade_status=$all["trade_state"]; //交易状态
			$gmt_payment=$all["time_end"]; //买家支付信息更新时间
			$sql="UPDATE `alipay`  SET  `trade_status`='".$trade_status."',`gmt_payment`='".$gmt_payment."' WHERE out_trade_no='".$out_trade_no."'";
			file_put_contents("testsql.txt",$sql);
			$res=$sq->execute_dml($sql);
		if($res){
			return "success";
		}else{
			return "fail";
			}  
		}
		
		
		public function getall($out_trade_no){
			//获取订到信息  以及支付状态
			$sql="select * from `alipay` where out_trade_no='".$out_trade_no."'";
			$res=$this->execute_dql($sql);
			/*echo "<pre>";
			print_r($res[0]);
			echo "</pre>";*/
			return $res[0];
			
		}
		
		public function updatastatus2($out_trade_no,$status){
			$sql="UPDATE `alipay` set `trade_status`='".$status."' where out_trade_no='".$out_trade_no."'";
			$res=$this->execute_dml($sql);
			return $res; // 1表示更新成功，2表示  没有更新
		}
	
	}
?>