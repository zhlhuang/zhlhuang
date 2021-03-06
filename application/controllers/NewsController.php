<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH.'/models/wx_shownews.php');
require_once (APPLICATION_PATH.'/models/wx_news.php');
class NewsController extends BaseController
{
   public function indexAction(){
       $id=$this->getRequest()->getParam("id");
       $where="id=".$id;
       $shownewsmodel=new wx_shownews();
       $newsres=$shownewsmodel->fetchAll($where)->toArray();
       $this->view->res=$newsres[0];

   }
   public function addnewsAction() {
      $newsmodel=new wx_news();
     
      
      $pagenow=$this->getRequest()->getParam("pagenow");  //获取当前显示页面
      
      if($pagenow==null){
      	$pagenow=0;
      }
      
      $showpage=$newsmodel->page($pagenow);
/*       echo "<pre>";
      print_r($res);
      echo "</pre>";  */
      $res=$newsmodel->fetchAll(null,"id desc",5,$pagenow*5)->toArray();
      $this->view->res=$res;
      $this->view->page=$showpage;
   }
   public function chkaddnewsAction(){
       
       $upload=new Zend_File_Transfer_Adapter_Http();
       $finame=date("Y-m"); //按当前的月份给文件夹命名
      if(!file_exists('../public/upload/img/'.$finame)){  //如果文件夹不存在 
          mkdir('../public/upload/img/'.$finame);//创建文件夹
      }
       $upload->setDestination('../public/upload/img/'.$finame); //每个月份上传的图片都放在一个文件夹上
       
       $fileInfo=$upload->getFileInfo();
       $PicUrl='';
       
       foreach ($fileInfo as $file=>$info){
           $imgname=time().mb_convert_encoding($info['name'], 'gbk','utf-8');//用日期来命名文件
           $upload->addFilter("Rename",array("target"=>$imgname,"overwrite"=>true),$file);   
           $upload->receive($file);  
           $PicUrl="http://zhl.besteee.com/upload/img/".$finame."/".$imgname;    //这是图片调用的路径
       }
       
       
       $Title=$this->getRequest()->getParam("Title"); //文章的标题
       $Description=$this->getRequest()->getParam("Description");//文章的简介
       $Url="http://zhl.besteee.com/news/index";//文章跳转的地址
       $news=array("Title"=>$Title,"Description"=>$Description,"PicUrl"=>$PicUrl,"Url"=>$Url,"Createtime"=>time());
       
       $newsmodel=new wx_news();//添加到数据库中
      $res=$newsmodel->insert($news);

       if($res){
          $this->forward("addnews");
       }else {
           echo "error";
           exit;
       }
   }
   public function addnewshowAction(){
       $id=$this->getRequest()->getParam("id");
       $this->view->id=$id;
       $this->view->Title=$this->getRequest()->getParam("Title");
       $shownewsmodel=new wx_shownews();
       $res=$shownewsmodel->fetchAll("id=".$id)->toArray();
/*        echo "<pre>";
       print_r($res);
       echo "</pre>"; */
       $this->view->content=$res[0]["content"];
       
   }
   
   public function chkaddnewshowAction(){
       $id=$this->getRequest()->getParam("id");
       $Title=$this->getRequest()->getParam("Title");
       $content=stripslashes($this->getRequest()->getParam("content"));
       $Createtime=time();
       
       $shownewsmodel=new wx_shownews();

       $shownews=array("id"=>$id,"Title"=>$Title,"img"=>'{"m1":"http://zhl.besteee.com/upload/1.jpg"}',"content"=>$content
      ,"Createtime"=>$Createtime);
       $r=$shownewsmodel->find("id=".$id);
       $res='';
       if($r){
           $res=$shownewsmodel->update($shownews, "id=".$id);
           if($res){
           	echo "ok";
           }else{
           	echo "error";
           }
       }else{
           $res=$shownewsmodel->insert($shownews);
           if($res){
           	echo "ok";
           }else{
           	echo "error";
           }
       }
     
       exit;
   }
   
   public function deletenewsAction(){
       $id= $this->getRequest()->getParam("id");
       $newsmodel=new wx_news();
       $shownews=new wx_shownews();
       $r1=$newsmodel->delete("id=".$id);
       $r2=$shownews->delete("id=".$id);
       

       if ($r1==0 || $r2==0) {
       	echo "ok";
       }
       exit;
   }
}

