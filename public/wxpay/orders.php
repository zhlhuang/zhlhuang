<?php
 require_once("sqlTool.php");
require_once("alipay.class.php");
 
 class orders{
	 public $res=array();
	 public $json=array();
	 public $pid=array();
	 public $out_trade_no;
	 
	 public function __construct($id){
	 $this->out_trade_no=$id;
		 //根据订单上的id查找订单
	 $sq=new sqlTool();
	 $res=$sq->execute_dql("select * from orders where id=".$id);  //在数据库中获取订单信息
	 $res=$res[0]; //因为订单号唯一   一般去第一条信息
	 $pid=split(",",$res["products_id"]);   //多个产品的订单分开
	 $json=json_decode($res["products_json"],1); //就订单里面的json转换成数组
	 
	  $this->res=$res;
      $this->json=$json;
      $this->pid=$pid;
	 }
	 
	 
    function getname(){
		 return $this->res["consumer_name"];//得到订单上收货人的姓名
	 }
		 
	function getout_trade_no(){
		return $this->res["id"];//获取订单id
	}
	
	function getsubject(){
		$json1=$this->json[$this->pid[0]]; 
		return $this->getname()."---".$json1['title'];//订单名称
	}
	
	function getprice(){
		$price=$this->res["discount_price"]*100;
		return $price;//订单的价格
	}
	
	function getreceive_mobile(){
		return $this->res["telephone"]; //收货人的电话号码
	}
	
	function getreceive_address(){
		return $this->res["address"];
	}
	
	function getbody(){
		$res='';
		foreach($this->json as $value){
			$res.=$value["title"]."----";
		}
		$res=substr($res,0,100);
		return $res;
	}

	
	public function getorders(){
		$sq=new sqlTool();
		$sql="select * from  orders as o Left Join alipay as a  ON a.out_trade_no = o.id where a.out_trade_no = o.id ";
		$res=$sq->execute_dql($sql);
		/*echo "<pre>";
		print_r($res);
		echo "</pre>";*/
		return $res;
	}
	
 }
