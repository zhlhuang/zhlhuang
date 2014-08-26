<?php
require_once 'wx_base.php'; 
class wx_word extends Zend_Db_Table{
    protected  $_name="wx_word";
    protected  $_primary="id";
    public function page($pagenow){
    	$text=$this->fetchAll()->toArray();
    	$str='';
    	$count=count($text);
    	$pagebase=new wx_base();
    	$pagebase->allcount=10;
    	$str=$pagebase->page($pagenow, "addword", $count);
    	return $str;
    }
}
?>