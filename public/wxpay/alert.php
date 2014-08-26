<?php
//这是一个警告通知页面
include_once("CommonUtil.php");
	$xml = file_get_contents("php://input");
	$com=new CommonUtil();
	$postData=$com->Xmltoarray($xml); //其实这不是转化成数组  而是一个
if($xml){
	file_put_contents("./testfile/alert.txt",$xml); //将警告信息存入文件中
	echo "success";  //返回success  表示接受警告成功
}else{
	//没有接受到警告  返回失败
	echo "success";
}

?>