<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>微信支付</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
</head>
</html>
<?php
include_once("WxPayHelper.php");
include_once("orders.php");


$id=$_GET["id"];
$order=new orders($id);


$ip=$_SERVER['REMOTE_ADDR'];//获取客户端的ip地址
$commonUtil = new CommonUtil();
$wxPayHelper = new WxPayHelper();

$body=str_replace(" ","",$order->getbody());
 $body=preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $body);  //这是价格json  Unicode编码转换成中文



$wxPayHelper->setParameter("bank_type", "WX"); //
$wxPayHelper->setParameter("body", $body);//商品描述
$wxPayHelper->setParameter("partner", "1220140801");//注册时分配的财付通商号
$wxPayHelper->setParameter("out_trade_no", $order->getout_trade_no()); //商家内部的订单号
$wxPayHelper->setParameter("total_fee",1);//商品价格
$wxPayHelper->setParameter("fee_type", "1");//支付币种，默认1人民币
$wxPayHelper->setParameter("notify_url", "http://www.jmyzds.com/store/wxpaytest/notify_url.php"); //异步返回通知页面
$wxPayHelper->setParameter("spbill_create_ip",$ip);//获取用户IP地址
$wxPayHelper->setParameter("input_charset", "UTF-8"); //传入字符串编码


//测试数据的输出
echo  $jj=$wxPayHelper->create_biz_package();
/*
echo "<pre>";
print_r(json_decode($jj,1)); 
$pa=json_decode($jj,1);
echo $pa["package"];
$arr=$commonUtil->splitParaStr($pa["package"],"&");
print_r($arr);
print_r($order->res);
echo "</pre>";

echo APPKEY;
*/
?>
<html>
<script language="javascript">
function callpay()
{
	WeixinJSBridge.invoke('getBrandWCPayRequest',<?php echo $jj; ?>,function(res){
	WeixinJSBridge.log(res.err_msg);
	alert(res.err_code+res.err_desc+res.err_msg);
	});
}
</script>
<body>
<div>商品详情</div>
<div><?php echo $body;?></div>
<div>商品价格</div>
<div><?php echo $order->getprice();?></div>

<button type="button" onClick="callpay()">微信支付</button>
</body>
</html>
