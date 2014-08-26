<?php
//这是一个发货的接口
include_once("../WxPayHelper.php");
include_once("../alipay.class.php");

class deliver{
	public $appid='wxdde057f11e065c6e';
	public $openid;//用户openid
	public $transid;//交易号
	public $out_trade_no; //订单号
	public $deliver_timestamp; //发货时间
	public $deliver_status='1'; //发货状态
	public $deliver_msg='ok'; //发货信息
	public $app_signature;  //支付签名
	public $sign_method='sha1'; //签名方法
	
	
	
	public function getsign(){
		//生成一个sign签名
		$WxPayHelper=new WxPayHelper();
		$signall=array(
		"appid"=>$this->appid,
		"openid"=>$this->openid,
		"transid"=>$this->transid,
		"deliver_timestamp"=>$this->deliver_timestamp,
		"deliver_status"=>$this->deliver_status,
		"deliver_msg"=>$this->deliver_msg
		);
		/*echo "<pre>";
		print_r($signall);
		echo "</pre>";
		*/
		 $sign=$WxPayHelper->getsign($signall);
		
		return $sign;
	}
	
	public function getpostData($out_trade_no){
	   //产生一个postdata  json数据
	   $pay=new alipay();
	   
	   $res=$pay->getall($out_trade_no); //获取支付状态表
	   
	   $this->openid=$res["buyer_email"];
	   $this->transid=$res["trade_no"];
	   $this->out_trade_no=$out_trade_no;
	   $this->deliver_timestamp=time();
	   $this->app_signature=$this->getsign();
	   
	   $postData=array(   //下面是发货要用的postData信息
	   "appid"=>$this->appid,
	   "openid"=>$this->openid,
	   "transid"=>$this->transid,
	   "out_trade_no"=>$this->out_trade_no,
	   "deliver_timestamp"=>$this->deliver_timestamp,
	   "deliver_status"=>$this->deliver_status,
	   "deliver_msg"=>$this->deliver_msg,
	   "app_signature"=>$this->app_signature,
	   "sign_method"=>$this->sign_method
	   );
	   
	   /*	echo "<pre>";
		print_r($postData);
		echo "</pre>";
		*/
		
		$postDatajson=json_encode($postData);  //转换成json格式输出
		
		return $postDatajson;
		
	}
	
	
	public function send($out_trade_no){
		
		//这将发货信息传送给微信支付接口
		
		$access_token=$this->getaccess_token();
		$postData=$this->getpostData($out_trade_no);
		
		$data=array('postData'=>$postData);  //这个是通过post请求发送的数据
		 $data=http_build_query($data);
	  
		$opts=array(
		  'http'=>array(
		 'method'=>'POST',
		 'header'=>"Content-type: application/x-www-form-urlencoded\r\n".
		  "Content-Length: ".strlen($data)."\r\n",
		'content'=>$data
		),
		);
	  $context=stream_context_create($opts);
	  $html=file_get_contents('https://api.weixin.qq.com/pay/delivernotify?access_token='.$access_token,false,$context);
	  
	  
	  file_put_contents("../testfile/send.txt","access_token=".$access_token."-----posdata=".$postData);  //将建立的数据放在文件中  方便调试
	  
	 //echo $html;
	  
	  return $res=json_decode($html,1);  //将json格式的信息装换成数组返回
	}
	
	public function getaccess_token(){
		//这个是获取access_token  值
	$res=file_get_contents("http://www.jmyzds.com/Temp/9D00055A0883424C92BEBA2214C67288.aspx");
	 return $res;
	 
	 }
}


?>