<?php
	class sqlTool{
		public $username="root";
		public $password="123456";
		public $dbname="mooncake";
		public $conn;
		public $host="localhost";
		
		public function __construct(){
			$this->conn = mysql_connect($this->host,$this->username,$this->password);
			if(!$this->conn){
				die("不能连接数据库".mysql_error());
			}
			mysql_select_db($this->dbname,$this->conn) or die ("mysql_error");
			mysql_query("set names utf8",$this->conn) or die(mysql_error());
			
		}	
		public function execute_dql($sql){
			$arr=mysql_query($sql,$this->conn) or die ("不能查询数据库".mysql_error());
			$res=array();
			$i=0;
			while($row=mysql_fetch_assoc($arr)){
	              $res[$i++]=$row;
             };
			return $res;
		}
		public function execute_dml($sql){
			$b=mysql_query($sql,$this->conn);
			if (!$b) {
				return 0;
			}else {
				if (mysql_affected_rows($this->conn)>0) {
					return 1;
				}else {
					return 2;
				}
			}
		}
		public function close_connect(){
			if(!empty($this->conn)){
				mysql_close($this->conn);
			}
		}
	
	}
