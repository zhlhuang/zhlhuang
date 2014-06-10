<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH.'/models/wx_shownews.php');
require_once (APPLICATION_PATH.'/models/wx_word.php');
require_once (APPLICATION_PATH.'/models/wx_example.php');
class WordController extends BaseController
{
    public function addwordAction(){
    }
    
    public function chkaddwordAction(){
     
        
        $typeid=$this->getRequest()->getParam("typeid");
        $word=$this->getRequest()->getParam("word");
        $explain=$this->getRequest()->getParam("explain");
        $remember=$this->getRequest()->getParam("remember");
        $match=$this->getRequest()->getParam("match");
        
        $addword=array(
        	"typeid"=>$typeid,
                "word"=>$word,
                "explain"=>$explain,
                "remember"=>$remember,
                "match"=>$match,
                "ctime"=>time()
        );
        
        $wordmodel=new  wx_word();
        $res=$wordmodel->insert($addword);
        if($res){
            $allword=$wordmodel->fetchAll()->toArray();
            $this->view->allword=$allword;
        }else{
           echo "error";
           exit;
        }
        
/*         
        echo "<pre>";
        print_r($addword);
        echo "</pre>"; */
    }
    
    public function showwordAction(){
        $wordmodel=new  wx_word();
        $allword=$wordmodel->fetchAll()->toArray();
        $this->view->allword=$allword;
        $this->render("chkaddword");
    }
    
    public function addexampleAction(){
        $wid=$this->getRequest()->getParam("wid");
        $typeid=$this->getRequest()->getParam("typeid");
        
        $examplemodel=new wx_example();
        $res=$examplemodel->fetchAll("wid=".$wid)->toArray();
        if($res){
            $this->view->res=$res[0];
        }
        $this->view->wid=$wid;
        $this->view->typeid=$typeid;
    }
    
     
    public function chkaddexampleAction(){
        $res=$this->getRequest()->getParams();
        unset($res["controller"],$res["action"],$res["module"]);
/*         echo "<pre>";    
        print_r($res)  
        echo "</pre>"; */
        
        $examplemodel=new wx_example();
        $r=$examplemodel->fetchAll("wid=".$res["wid"])->toArray();
        if($r){
           $flag=$examplemodel->update($res,"wid=".$res["wid"]);
           if($flag){
               echo "ok1";
           }else{
               echo "error1";
           }
        }else{
            $flag=$examplemodel->insert($res);
            if($flag){
            	echo "ok";
            }else{
            	echo "error";
            }
        }
        exit;
    }
    
    public function showexampleAction(){
        $examplemodel=new wx_example();
        $res=$examplemodel->fetchAll(null,"wid asc",5,0)->toArray();
        $this->view->res=$res;
        
    }
    
    public function getexampleAction(){
        $wid=$this->getRequest()->getParam("wid");
        
        $examplemodel=new wx_example();
        $res=$examplemodel->fetchAll("wid=".$wid)->toArray();
        $res=json_encode($res[0]);
        echo $res;
        exit;
    }
}

