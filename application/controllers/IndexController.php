<?php
require_once(APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH . '/models/wx_text.php');
class IndexController extends BaseController
{
    
    public function indexAction(){
        $xml=file_get_contents("php://input");
        $json=Zend_Json::fromXml($xml);
        $arr=json_decode($json,true);
        $text_model=new wx_text();
        $text=$arr["xml"];
        echo "<pre>";
        print_r($text);
        echo "</pre>";
        exit;
    }
}

