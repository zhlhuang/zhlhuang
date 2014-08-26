<?php 

class wx_base extends Zend_Db_Table{
    public $topage;
    public $pagenow;
    public $count;
    public $allcount=20;
    public function page($pagenow,$topage,$count){
        //pagenow是当前页面    topage是跳转的页面    count 分页内容的记录数目\
        $this->pagenow=$pagenow;
        $this->topage=$topage;
        $this->count=$count;
    	//$text=$this->fetchAll()->toArray();
    	$str='';
    	//$count=count($text);
    	$pagecount=ceil($count/$this->allcount);
    	if ($pagenow>0) {
    		$str.="<a href='".$this->topage."?pagenow=".($pagenow-1)."'>上一页</a>   ";
    	}
    	for($i=0;$i<10 && $i<$pagecount;$i++){
    		$str.="<a href='".$this->topage."?pagenow=".$i."'>".($i+1)."</a>   ";
    	}
    	if($pagenow<$pagecount){
    		$str.="<a href='".$this->topage."?pagenow=".($pagenow+1)."'>下一页</a>   ";
    	}
    
    
    	$str.="当前页面".($pagenow+1)."/".$pagecount."   共".$count."记录";
    	return $str;
    }
}
?>