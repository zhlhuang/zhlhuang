<?php 
require_once 'wx_base.php';
class wx_text extends Zend_Db_Table{
    protected  $_name="wx_text";
    protected  $_primary="MsgId";
    
    public function page($pagenow){
        $text=$this->fetchAll()->toArray();
        $count=count($text);
        $pagebase=new wx_base();
        
        $str=$pagebase->page($pagenow, "show", $count);
        return $str; 
    }
}
?>