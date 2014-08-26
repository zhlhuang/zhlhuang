<?php
//这是一个发货的接口
include_once("../WxPayHelper.php");
include_once("../alipay.class.php");

class deliver{
	public $appid="wxdde057f11e065c6e";
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
		"out_trade_no"=>$this->out_trade_no,
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
	   
	   $this->openid=$res["buyer_email"];   //这是从数据库中提取出来的买家ID
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
		
		$url='https://api.weixin.qq.com/pay/delivernotify?access_token='.$access_token;
		
		file_put_contents("../testfile/send.txt","access_token=".$access_token."-----posdata=".$postData);
		
		return $this->https_request($url,$postData);
		
	}
	
	 public function https_request($url, $data = null){
     $curl = curl_init();
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
     if (!empty($data)){
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
     }
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     $output = curl_exec($curl);
     curl_close($curl);
     return $output;
 }
	
	public function getaccess_token(){
		//这个是获取access_token  值
	$res=file_get_contents("http://127.0.0.1/WxApi/GetMyAccessToken.aspx");
	 return $res;
	 
	 }
}


?>