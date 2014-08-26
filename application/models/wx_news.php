<?php 
require_once 'wx_base.php';
class wx_news extends Zend_Db_Table{
    protected  $_name="wx_news";
    protected  $_primary="id";

    public function page($pagenow){
    	$text=$this->fetchAll()->toArray();
    	$str='';
    	$count=count($text);
    	$pagebase=new wx_base();
    	$pagebase->allcount=5;
    	$str=$pagebase->page($pagenow, "addnews", $count);
    	return $str;
    }
}
?>