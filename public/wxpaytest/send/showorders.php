<?php
include_once("../alipay.class.php");
include_once("../orders.php");

/*
这个是查看订单信息，以及处理发货的
*/
echo $_GET["getv"];
echo $_POST["postData"];

		echo "<pre>";
		print_r($GLOBALS);
		echo "</pre>";
?>