<?php
require_once(APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH . '/models/wx_text.php');
class IndexController extends BaseController
{
    
    public function indexAction(){
        $xml="
 <xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName> 
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[this is a test]]></Content>
 <MsgId>1232163465413216354654313461346546</MsgId>
 </xml>            ";
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

