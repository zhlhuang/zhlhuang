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

