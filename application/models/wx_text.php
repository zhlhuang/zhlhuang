<?php 
class wx_text extends Zend_Db_Table{
    protected  $_name="wx_text";
    protected  $_primary="MsgId";
    
    public function page($pagenow){
        $text=$this->fetchAll()->toArray();
        $str='';
        $count=count($text);
        $pagecount=floor($count/20);
        if ($pagenow>0) {
        	$str.="<a href='show?pagenow=".($pagenow-1)."'>上一页</a>   ";
        }
        for($i=0;$i<10 && $i<$pagecount;$i++){
            $str.="<a href='show?pagenow=".$i."'>".($i+1)."</a>   ";
        }
        if($pagenow<$pagecount){
            $str.="<a href='show?pagenow=".($pagenow+1)."'>下一页</a>   ";
        }
        
        
        $str.="当前页面".$pagenow."/".$pagecount."   共".$count."记录";
        return $str; 
    }
}
?>