<?php
//这是一个警告通知页面

$postDaat=$_POST["postData"];  //获取微信发信过来的警告通知信息
if($postDaat){
	file_put_contents("./testfile/alert.text",$postDaat); //将警告信息存入文件中
	echo "success";  //返回success  表示接受警告成功
}else{
	//没有接受到警告  返回失败
	echo "fail";
}

?>