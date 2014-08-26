<?php
class BaseController extends Zend_Controller_Action
{

    public function init ()
    {
        // 初始化我们的数据库适配器
        $url = constant("APPLICATION_PATH") . DIRECTORY_SEPARATOR .
                 'configs/application.ini';
        $dbconfig = new Zend_Config_Ini($url, "mysql");
        $db = Zend_Db::factory($dbconfig->db);
        $db->query("set names utf8");
        Zend_Db_Table::setDefaultAdapter($db);
    }
    public function toshow($news,$toback=null){
    
    	
    	$this->view->news=$news;
    	$this->view->toback=$toback;
    	$this->forward("show","globals");
    }
    public function into($str){
        //出去微信数据中多余的格式
        $par=array("/<!\[CDATA\[/","/\]\]>/");
        $rep=array("","");
        $str=preg_replace($par, $rep, $str);
        return $str;
    }
    
     public function gettextmsg($msg,$ToUserName,$FromUserName='gh_437ffb562bd0') {
    	return $str = "<xml>
    	        <ToUserName>
        <![CDATA[" .$ToUserName. "]]>
    </ToUserName>
    <FromUserName>
        <![CDATA[" .$FromUserName. "]]>
    </FromUserName>
    <CreateTime>" . time() . "</CreateTime>
    <MsgType>
        <![CDATA[text]]>
    </MsgType>
    <Content>
        <![CDATA[".$msg."]]>
    </Content>
    <FuncFlag>0</FuncFlag>
</xml>";
    }
    
    public function getnewsmsg($ToUserName,$newsres,$FromUserName='gh_437ffb562bd0'){
        $str="<xml>
                <ToUserName><![CDATA[" .$ToUserName. "]]></ToUserName>
<FromUserName><![CDATA[" .$FromUserName. "]]></FromUserName>
<CreateTime>".time()."</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>".count($newsres)."</ArticleCount>
<Articles>
";
        foreach ($newsres as $value){
            $str.="<item><Title><![CDATA[".$value["Title"]."]]></Title> 
<Description><![CDATA[".$value["Description"]."]]></Description>
<PicUrl><![CDATA[".$value["PicUrl"]."]]></PicUrl>
<Url><![CDATA[".$value["Url"]."?id=".$value["id"]."]]></Url></item>";
        }
$str.="
</Articles>
</xml> ";
return $str;
        //
    }
}

