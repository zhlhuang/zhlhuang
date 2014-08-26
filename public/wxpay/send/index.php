<?php
//调用发货接口的测试页面

include_once("deliver.php");
include_once("../alipay.class.php");
$deliver=new deliver();

$id=$_GET["id"]; //接受商品订单号


//echo $deliver->getsign();  

//echo $postData=$deliver->getpostData(58);

//echo "<br />".$access_token=$deliver->getaccess_token();
if($id==NULL){
	echo "id is NULL";
}else{
  $res=$deliver->send($id);
 $res=json_decode($res,1);
//var_dump($res1);
if($res["errcode"]==0){
	//将数据库中的支付状态修改
	//echo "ok";
	$pay=new alipay();
    $r=$pay->updatastatus2($id,"WAIT_BUYER_CONFIRM_GOODS");  //卖家已经发货
	if($r==1){
		echo "success";
	}else{
		echo "success";
	}
	
}else{
	echo $res["errmsg"];
}
}
?>