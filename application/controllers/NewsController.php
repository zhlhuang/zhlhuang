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
       $upload=new Zend_File_Transfer();
       echo "<pre>";
       print_r($upload->getFileInfo());
       echo "</pre>";
       exit;
   }
}

