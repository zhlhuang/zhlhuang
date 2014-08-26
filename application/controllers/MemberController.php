<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH.'/models/wx_member.php');
class MemberController extends BaseController
{
    public function indexAction(){
        echo 'hello';
        exit;
    }
    public function addAction(){
        $UserName=$this->getRequest()->getParam("UserName");
        $this->view->Username=$UserName;
 
    }
    
    public function chkaddAction(){
        $UserName=$this->getRequest()->getParam("UserName");
        $nickName=$this->getRequest()->getParam("nickName");
        $phone=$this->getRequest()->getParam("phone");
        $sex=$this->getRequest()->getParam("sex");
        $ctime=time();
        
        $member=array(
        	"UserName"=>$UserName,
                "nickName"=>$nickName,
                "phone"=>$phone,
                "sex"=>$sex,
                "ctime"=>$ctime
        );
        
    
       
        $membermodel=new wx_member();
        
          $res=$membermodel->fetchAll("UserName='".$UserName."'")->toArray();
     
        if($res){
            //表中已经存在
            $membermodel->update($member, "UserName='".$UserName."'");
            $this->view->res="你已经是我的朋友了1";
        }else {
            //表中还没有记录
            $membermodel->insert($member); 
            $this->view->res="你已经是我的朋友了";
        }
    }
    
    public function loginAction(){
            $UserName=$this->getRequest()->getParam("UserName");//获取UserName
            $membermodel=new wx_member();
            $res=$membermodel->find($UserName)->toArray();
            
            $member=$res[0];
            $ctime=$member["ctime"]; //获取用户上次更新时间
            $time=time();
            echo $member["IP"]."    ";
            echo $ip=$_SERVER['REMOTE_ADDR'];//获取客户端的ip地址
            
            if($ctime>($time-1800)){ //如果在半个小时之内发过登录信息   默认是登陆
                echo "登录成功";
                $this->view->member=$member;
            }else{
                echo "登录失败";
            }
           
    }
    
    public function getnameAction(){
        $UserName= $this->getRequest()->getParam("UserName");
        $membermodel=new wx_member();
        $db=$membermodel->getAdapter();
        $where=$db->quoteInto("UserName=?", $UserName);
   
        $member=$membermodel->fetchAll($where)->toArray();
        echo $member[0]["nickName"];
        exit();
    }
}

