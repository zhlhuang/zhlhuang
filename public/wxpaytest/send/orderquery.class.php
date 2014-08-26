<?php
include_once("../WxPay.config.php");
include_once("../WxPayHelper.php");
include_once("../alipay.class.php");
class orderquery{
    public $appid="wxdde057f11e065c6e";
	public $openid;//用户openid
	public $transid;//交易号
	public $package; 
	public $timestamp;//时间
	public $partner="1220140801";//身份标示
	public $out_trade_no; //订单号
	public $app_signature;  //支付签名
	public $sign_method='sha1'; //签名方法
	
	
	public function getsign(){
		//执行加密sign
		$package="out_trade_no=".$this->out_trade_no."&partner=".$this->partner."&key=".PARTNERKEY;
		$sign=strtoupper(md5($package));//通过md5加密后转换成大写
		//echo $package;
		return $sign ;
	}
	
	public function getpackage(){
		$package="out_trade_no=".$this->out_trade_no."&partner=".$this->partner."&sign=".$this->getsign();
		//echo $package;
		return $package; //返回打包后的数据
	}
	
	public function getsignature(){
		$WxPayHelper=new WxPayHelper();  //通过helper类生成sign
		$allsignature=array(
		"appid"=>$this->appid,
		"package"=>$this->package,
		"timestamp"=>$this->timestamp
		);
		

		$signature=$WxPayHelper->getsign($allsignature);
		return $signature;
	}
	
	public function getpostData($out_trade_no){
		//获取json postData数据
		$pay=new alipay();
		$res=$pay->getall($out_trade_no); //获取支付状态表
		
		$this->out_trade_no=$out_trade_no;
		$this->timestamp=time();
		$this->package=$this->getpackage();
		
		$this->app_signature=$this->getsignature();
		
		
		
		$all=array(
		"appid"=>$this->appid,
		"package"=>$this->package,
		"timestamp"=>$this->timestamp,
		"app_signature"=>$this->app_signature,
		"sign_method"=>$this->sign_method
		);
		
	/*	echo "<pre>";
		print_r($all);
		echo "</pre>";
		
		*/
		return $postData=json_encode($all);
	}
	
		public function oquery($out_trade_no){
		
		//这将发货信息传送给微信支付接口
		
		$access_token=$this->getaccess_token();  //获取公众账号的access_token
		  $postData=$this->getpostData($out_trade_no); //拿到上面生成是postdata
		
		  
		
		
		$url='https://api.weixin.qq.com/pay/orderquery?access_token='.$access_token;
		$data=$this->https_request($url,$postData);
		file_put_contents("../testfile/orderquery.txt",$data);
		
		return json_decode($data,1);
		
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
		
		//http://127.0.0.1/WxApi/GetMyAccessToken.aspx
	$res=file_get_contents("http://127.0.0.1/WxApi/GetMyAccessToken.aspx");
	 return $res;
	 
	 }
	 
}
?>