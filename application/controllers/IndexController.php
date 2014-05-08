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
        $text_model->insert($text);

 //$wechatObj->responseMsg();

$str="<xml>
    <ToUserName>
        <![CDATA[".$text['FromUserName']."]]>
    </ToUserName>
    <FromUserName>
        <![CDATA[".$text['ToUserName']."]]>
    </FromUserName>
    <CreateTime>".time()."</CreateTime>
    <MsgType>
        <![CDATA[text]]>
    </MsgType>
    <Content>
        <![CDATA[I love you]]>
    </Content>
    <FuncFlag>0</FuncFlag>
</xml>";
echo $str;
       
        exit;
    }
public function showAction(){

$text_model=new wx_text();
echo "<pre>";
        print_r($text_model->fetchAll()->toArray());
echo "</pre>";
exit;

}
}

