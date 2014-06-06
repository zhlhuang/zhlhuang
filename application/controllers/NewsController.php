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
       $news=array("Title"=>$Title,"Description"=>$Description,"PicUrl"=>$PicUrl,"Url"=>$Url);
       
       $newsmodel=new wx_news();//添加到数据库中
       $res=$newsmodel->insert($news);
       if($res){
           echo "ok";
       }else {
           echo "error";
       }
       exit;
   }
}

