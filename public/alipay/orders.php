<?php
 require_once("sqlTool.php");
 $sq=new sqlTool();
 $res=$sq->execute_dql("select * from orders where id=".$_GET["id"]);
 $res=$res[0];
 $id=split(",",$res["products_id"]);
 $json=json_decode($res["products_json"],1);

 class orders {
	 public $res=array();
	 public $json=array();
	 public $id=array();
	 public function __construct(){
	 }
	 function getname(){
		 return $this->res["consumer_name"];//得到订单上收货人的姓名
		 }
	function getout_trade_no(){
		return $this->res["id"];//获取订单id
	}
	function getsubject(){
		$json1=$this->json[$this->id[0]];
		return $this->getname()."---".$json1['title'];//订单名称
	}
	function getprice(){
		return $this->res["price"];//订单的价格
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
		return $res;
	}
 }
 
 $order=new orders();  //实例化订单状态
 $order->res=$res;
 $order->json=$json;
 $order->id=$id;
  echo "<pre>";
 print_r($order);
 echo "</pre>";
   echo "<pre>";
 print_r($id);
 echo "</pre>";
 
 echo $order->getbody();
 