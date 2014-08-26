<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH . '/models/wx_text.php');
require_once (APPLICATION_PATH . '/models/wx_member.php');
require_once (APPLICATION_PATH . '/models/wx_news.php');
require_once (APPLICATION_PATH . '/models/wx_word.php');

class zhlController extends BaseController
{
    public function indexAction(){
        $newsmodel=new wx_news();
        $res=$newsmodel->fetchAll(null,"id desc",4,0)->toArray();
/*              echo "<pre>";
         print_r($res);
        echo "</pre>";  */
        $this->view->res=$res;
    }
    public function adminAction(){
        session_start();
        $Username=$_SESSION["Username"];
        $pwd=$_SESSION["pwd"];
      if($Username=="admin" && $pwd=="11admin"){
          $this->render("admin");
      }else{
           $this->render("login");
      }
       
    }
    
    public function chkloginAction(){
        session_start();
        $res=$this->getRequest()->getParams();
        
        $Username=$res["Username"];
        $pwd=$res["pwd"];
        echo "<pre>";
        print_r($res);
        echo "</pre>";
        if($Username=="admin" && $pwd=="11admin"){
        
            $_SESSION["Username"]=$Username;
            $_SESSION["pwd"]=$pwd;
          
            $this->toshow("登录成功","admin");
        }else{
            $this->toshow("登录失败","admin");
        }
    }
}

