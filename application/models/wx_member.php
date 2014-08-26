<?php 
class wx_member extends Zend_Db_Table{
    protected  $_name="wx_member";
    protected  $_primary="UserName";
    
    public function getmemberone($FromUserName){
        $res=$this->fetchAll("UserName='".$FromUserName."'")->toArray();
        if($res){
            $this->updatatime($FromUserName);
            return $res[0];
        }else{
            return NULL;
        }
    }
    
    public function updatatime($FromUserName){
        $ip=$_SERVER['REMOTE_ADDR'];//获取客户端的ip地址
       $time=time();
       $arr=array("ctime"=>$time,"IP"=>$ip);
       $res=$this->update($arr, "UserName='".$FromUserName."'");
       return $res;
    }
}
?>