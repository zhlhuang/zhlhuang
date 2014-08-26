<?php
require_once (APPLICATION_PATH . '/controllers/BaseController.php');
require_once (APPLICATION_PATH . '/controllers/jwc.php');
class TestController extends BaseController
{
   public function indexAction(){
       $jwc=new jwc();
       echo $jwc->getbody();
/*        set_time_limit(0);
       $conn=fsockopen("jwc.wyu.edu.cn",80,$errno,$errstr,30);
       if(!$conn){
           die("error<br/>");
       };
       $data="UserCode=3112002855&UserPwd=a6253562&Validate=5312&Submit=%CC%E1+%BD%BB";
       $httpstr="POST /student/logon.asp HTTP/1.1\r\n";
       $httpstr.="Host:jwc.wyu.edu.cn\r\n";
       $httpstr.="Connection:close\r\n";
       $httpstr.="Referer:http://jwc.wyu.edu.cn/student/body.htm\r\n";
       $httpstr.="Cookie:ASPSESSIONIDSACATQCQ=MCCKOBAAKBIKAJCMIEMFHIKF; LogonNumber=3222\r\n";
       $httpstr.="Content-Type:application/x-www-form-urlencoded\r\n";
       $httpstr.="Content-Length:".strlen($data)."\r\n\r\n";
       $httpstr.="UserCode=3112002855&UserPwd=a6253562&Validate=3222&Submit=%CC%E1+%BD%BB";
       fwrite($conn,$httpstr,strlen($httpstr));
       //echo $httpstr;
       $res='';
       while(!feof($conn)){
       $res.=fread($conn,1024);
       };
       fclose($conn);
       echo $res; */
       exit;
   }
   
   public function loginAction(){
       
   }
   
   public function chkloginAction(){
       
       $UserCode=$this->getRequest()->getParam("UserCode");
       $UserPwd=$this->getRequest()->getParam("UserPwd");
       $jwc=new jwc();
       $err='200';
       if($jwc->getbody()=="200"){
           if($jwc->getValidate()=="200"){
               if($jwc->getlogin($UserCode, $UserPwd)=="200"){
                   if($jwc->getf1()=="200"){
                       echo "<pre>";
                       print_r($jwc->student);
                       echo "</pre>";
                   }else {
                       $err= 204;
                   }
               }else{
                   $err= 203;
               }
           }else {
           	$err= 202;
           }
       }else{
           $err= 201;
       }
       
       
       if($err=="200"){
           echo "ok";
       }else {
           echo $err;
       }
       exit;
   }
  
}

