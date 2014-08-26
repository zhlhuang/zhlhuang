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
$wxPayHelper->setParameter("partner", "1220140801");//注册时分配的财付通商号
$wxPayHelper->setParameter("out_trade_no", $order->getout_trade_no()); //商家内部的订单号
$wxPayHelper->setParameter("total_fee", 0.1);//商品价格
$wxPayHelper->setParameter("fee_type", "1");//支付币种，默认1人民币
$wxPayHelper->setParameter("notify_url", "http://www.jmyzds.com/store/wxpaytest/notify_url.php"); //异步返回通知页面
$wxPayHelper->setParameter("spbill_create_ip",$ip);//获取用户IP地址
$wxPayHelper->setParameter("input_charset", "UTF-8"); //传入字符串编码
/*

$commonUtil = new CommonUtil();
$wxPayHelper = new WxPayHelper();


$wxPayHelper->setParameter("bank_type", "WX");
$wxPayHelper->setParameter("body", "test");
$wxPayHelper->setParameter("partner", "1900000109");
$wxPayHelper->setParameter("out_trade_no", $commonUtil->create_noncestr());
$wxPayHelper->setParameter("total_fee", "1");
$wxPayHelper->setParameter("fee_type", "1");
$wxPayHelper->setParameter("notify_url", "htttp://www.baidu.com");
$wxPayHelper->setParameter("spbill_create_ip", "127.0.0.1");
$wxPayHelper->setParameter("input_charset", "GBK");

*/
echo $wxPayHelper->create_app_package("test");
echo "<br>";
echo $wxPayHelper->create_biz_package();

echo "<br>";
echo $wxPayHelper->create_native_package();
?>