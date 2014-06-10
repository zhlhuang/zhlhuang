<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH . '/models/wx_text.php');
require_once (APPLICATION_PATH . '/models/wx_member.php');
require_once (APPLICATION_PATH . '/models/wx_news.php');
require_once (APPLICATION_PATH . '/models/wx_word.php');

class IndexController extends BaseController
{

    public function indexAction ()
    {
        $xml = file_get_contents("php://input");
        
        $json = Zend_Json::fromXml($xml);
        $arr = json_decode($json, true);
        
        $res=$arr["xml"];
        
    /*         $text_model = new wx_text();
        $text = $arr["xml"]; */
        
        /* $msg="我已经收到你的信息咯！";
        $str=$this->gettextmsg($msg, $text["FromUserName"]); */
        $str='';
        if($res["MsgType"]=="text"){
           $str=$this->istext($res);
        }else if($res["MsgType"]=="event"){
            $str=$this->isevent($res);
        }
        echo $str;
        exit();
    }

    public function showAction ()
    {
        $text_model = new wx_text();
        
        $pagenow=$this->getRequest()->getParam("pagenow");
        if($pagenow==null){
            $pagenow=0;        
        }
        $showpage= $text_model->page($pagenow);
        $this->view->res=$text_model->fetchAll(NUll,"CreateTime desc",20,$pagenow*20)->toArray();
        $this->view->page=$showpage;
    }
    public function showdayAction(){
        echo "<pre>";
        print_r($this->getRequest()->getParams());
        echo "</pre>";
        $day=$this->getRequest()->getParam("day");
         $text_model = new wx_text();
         
         
         $date=strtotime(gmdate("Y-m-d",time()))-$day*86400;
      
         $where="CreateTime between ".$date." AND ".($date+86400);

         
        $this->view->res=$text_model->fetchAll($where,"CreateTime desc ")->toArray();
        $this->render("show");
        
    }
    
    public function showmemberAction(){
        $membermodel=new wx_member();
        $member=$membermodel->fetchAll()->toArray();
        $this->view->res=$member;
       $a=new wx_news();
       
    }
    
    
    public function istext($res){
    	//这是一条text类信息
    	if($res["Content"]=="1"){
    		return $this->gettextmsg("<a href='http://zhl.besteee.com/member/add?UserName=".$res['FromUserName']."'>点击这里跟我做朋友</a>", $res["FromUserName"]);
    	}elseif($res["Content"]=="2"){
    	    $newsmodel=new wx_news();	
    	    $newsres=$newsmodel->fetchAll("1","id desc",1,0)->toArray();
    		return $this->getnewsmsg($res["FromUserName"],$newsres);
    	}elseif ($res["Content"]=="3"){
    		$str=$this->getword();
    		return $this->gettextmsg($str, $res["FromUserName"]);
    	}elseif ($res["Content"]=="4"){
    	    $newsmodel=new wx_news();
    	    $newsres=$newsmodel->fetchAll("1","id desc",10,0)->toArray();
    	    return $this->getnewsmsg($res["FromUserName"],$newsres);
    	}else{	
    	    $textmodel=new wx_text();
    		$textres=$textmodel->insert($res);
    		if($textres){
    		    return $this->gettextmsg("我已经收到你的信息咯!  回复\n1：跟我做朋友\n2：看图文信息\n3：看今天单词\n4：看历史图文", $res["FromUserName"]);
    		}else{
    		    return $this->gettextmsg("抱歉没有收到信息", $res["FromUserName"]);
    		}
    	}
    }
    

    public function isevent($res){
    	//这是一条text类信息
    	if($res["Event"]=="subscribe"){
    		return $this->gettextmsg("谢谢你关注我", $res["FromUserName"]);
    		 
    	}else{
    		return $this->gettextmsg("再见", $res["FromUserName"]);
    	}
    }
    
    public function getword(){
        $wordmodel=new wx_word();
        $res=$wordmodel->fetchAll()->toArray(null,"ctime desc",8,0);
        $str="今天的单词：\n ";
        foreach ($res as $value){
            $str.=$value["word"]."\n ";
            $str.=$value["explain"]."\n ";
            if($value["match"]!=NULL){
                $str.="搭配：".$value["match"]."\n ";
            }
            $str.="\n ";
        }
        $str.="<a herf='http://zhl.besteee.com/word/showexample'>查看例题</a> \n";
        return $str;
    }
}

