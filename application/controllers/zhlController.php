<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH . '/models/wx_text.php');
require_once (APPLICATION_PATH . '/models/wx_member.php');
require_once (APPLICATION_PATH . '/models/wx_news.php');
require_once (APPLICATION_PATH . '/models/wx_word.php');

class zhlController extends BaseController
{
    public function indexAction(){
        $newsmodel=new wx_news();
        $res=$newsmodel->fetchAll(null,"id desc",4,0)->toArray();
/*              echo "<pre>";
         print_r($res);
        echo "</pre>";  */
        $this->view->res=$res;
    }
}

