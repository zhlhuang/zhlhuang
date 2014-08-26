<?php
include_once("WxPayHelper.php");
include_once("orders.php");


$id=$_GET["id"];
$order=new orders($id);


$ip=$_SERVER['REMOTE_ADDR'];//获取客户端的ip地址
$commonUtil = new CommonUtil();
$wxPayHelper = new WxPayHelper();

$wxPayHelper->setParameter("bank_type", "WX"); //
$wxPayHelper->setParameter("body", $order->getbody());//商品描述
$wxPayHelper->setParameter("partner", "1900000109");//注册时分配的财付通商号
$wxPayHelper->setParameter("out_trade_no", $order->getout_trade_no()); //商家内部的订单号
$wxPayHelper->setParameter("total_fee", $order->getprice());//商品价格
$wxPayHelper->setParameter("fee_type", "1");//支付币种，默认1人民币
$wxPayHelper->setParameter("notify_url", "http://zhl.besteee.com/notify_url.php"); //异步返回通知页面
$wxPayHelper->setParameter("spbill_create_ip",$ip);//获取用户IP地址
$wxPayHelper->setParameter("input_charset", "UTF-8"); //传入字符串编码
echo "<pre>";
print_r(json_decode($wxPayHelper->create_biz_package(),1)); 
$pa=json_decode($wxPayHelper->create_biz_package(),1);
$arr=$commonUtil->splitParaStr($pa[package],"&");
print_r($order->res);
echo "</pre>";

?>
<html>
<script language="javascript">
function callpay()
{
	WeixinJSBridge.invoke('getBrandWCPayRequest',<?php echo $wxPayHelper->create_biz_package(); ?>,function(res){
	WeixinJSBridge.log(res.err_msg);
	alert(res.err_code+res.err_desc+res.err_msg);
	});
}
</script>
<body>
<div>商品详情</div>
<div><?php echo $order->getbody();?></div>
<div>商品价格</div>
<div><?php echo $order->getprice();?></div>

<button type="button" onClick="callpay()">微信支付</button>
</body>
</html>
