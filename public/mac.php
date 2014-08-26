<!DOCTYPE HTML>
<html>
<head>
<?php
//
$url="http://zhl.besteee.com/mac1.php";
echo $api="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdde057f11e065c6e&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_base#wechat_redirect";

$res= file_get_contents($api);
echo $res;
echo "<br/>".$url;
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>hello</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
</head>
<body>
<a href="<?php echo $api; ?>">hello </a>
</body>
</html>
