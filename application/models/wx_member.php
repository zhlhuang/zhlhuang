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
      
       $time=time();
       $arr=array("ctime"=>$time);
       $res=$this->update($arr, "UserName='".$FromUserName."'");
       return $res;
    }
    public function updataIP($FromUserName,$ip){
        $arr=array("IP"=>$ip);//更新用户的IP地址
        $res=$this->update($arr, "UserName='".$FromUserName."'");
        return $res;
    }
    
    public function islogin($FromUserName){
        //判定用户是否登录
        $where="UserName='".$FromUserName."'"; //登录用户的openid
        $ipnow=$_SERVER['REMOTE_ADDR'];//获取客户端的ip地址
       
         $nowtime=time()-1800;
        $res=$this->fetchAll($where)->toArray();
        if($res){
        
            $time=$res[0]["ctime"];
            $ip=$res[0]["IP"];
         
            
            if($time>$nowtime && $ipnow==$ip){
                $this->updatatime($FromUserName);//验证成功更新活动时间
                return 1; // 已经登录
            }else{
                return 2; //登录超时  重新登录
            }
        }else{
            return 0; //查无用户  不成功
        }
        
        
    }
}
?>