<?php 
class jwc {
    public $Cookie;
    public $Validate;
    public $UserCode;
    public $UserPwd;
    public $student;
    public function getbody(){
        //获取学生服务子系统登录首页
        set_time_limit(0);
        $conn=fsockopen("jwc.wyu.edu.cn",80,$errno,$errstr,30);
        if(!$conn){
        	die("error<br/>");
        };
        $httpstr="GET /student/ HTTP/1.1\r\n";
        $httpstr.="Host:jwc.wyu.edu.cn\r\n";
        $httpstr.="Connection:close\r\n\r\n";
        fwrite($conn,$httpstr,strlen($httpstr));
        $res='';
        while(!feof($conn)){
        	$res.=fread($conn,1024);
        };
        fclose($conn);
        
        $all=split("Set-Cookie:",$res);  //拿到登录命令存入cookie中
        $all=split("\r\n", $all[1]);
        $this->Cookie=trim($all[0]);
        //echo $this->Cookie;
        return $this->getstatus($res);
    }
    
    
    public function getValidate(){
        set_time_limit(0);
        $conn=fsockopen("jwc.wyu.edu.cn",80,$errno,$errstr,30);
        if(!$conn){
        	die("error<br/>");
        };
        $httpstr="GET /student/rndnum.asp HTTP/1.1\r\n";
        $httpstr.="Host:jwc.wyu.edu.cn\r\n";
        $httpstr.="Connection:close\r\n\r\n";
        $httpstr.="Cookie:".$this->Cookie;
        
        fwrite($conn,$httpstr,strlen($httpstr));
        //echo $httpstr;
        $res='';
        while(!feof($conn)){
        	$res.=fread($conn,1024);
        };
        fclose($conn);
        $all=split("Set-Cookie:",$res); ///从set-cookie中获取到下一个页面需要的cookie
        $all1=split("\r\n", $all[1]);
        $all2=split("\r\n", $all[2]);
        $this->Cookie=trim($all1[0].";".$all2[0]);
        
        $v=split("LogonNumber=", $all1[0]);   //将验证码从cookie中提取出来
        $v=split(";", $v[1]);
        $this->Validate=$v[0];  //这个属性就是我们拿到的页面 
        
        
        
        //echo $this->Cookie; 
        return $this->getstatus($res);
    }
    
    
    public function getlogin($UserCode,$UserPwd){
        $this->UserCode=$UserCode;  //将用户名以及密码存入属性中
        $this->UserPwd=$UserPwd;
        set_time_limit(0);
        $conn=fsockopen("jwc.wyu.edu.cn",80,$errno,$errstr,30);
        if(!$conn){
        	die("error<br/>");
        };
        $data="UserCode=".$UserCode."&UserPwd=".$UserPwd."&Validate=".$this->Validate."&Submit=%CC%E1+%BD%BB";
        $httpstr="POST /student/logon.asp HTTP/1.1\r\n";
        $httpstr.="Host:jwc.wyu.edu.cn\r\n";
        $httpstr.="Connection:close\r\n";
        $httpstr.="Referer:http://jwc.wyu.edu.cn/student/body.htm\r\n";
        $httpstr.="Cookie:".$this->Cookie."\r\n";
        $httpstr.="Content-Type:application/x-www-form-urlencoded\r\n";
        $httpstr.="Content-Length:".strlen($data)."\r\n\r\n";
        $httpstr.=$data;
        fwrite($conn,$httpstr,strlen($httpstr));
        //echo $httpstr;
        $res='';
        while(!feof($conn)){
        	$res.=fread($conn,1024);
        };
        fclose($conn);

        //echo $this->Cookie."<br/>";

        return $this->getstatus($res);
    }
    
    
    public function getf1(){
        set_time_limit(0);
        $conn=fsockopen("jwc.wyu.edu.cn",80,$errno,$errstr,30);
        if(!$conn){
        	die("error<br/>");
        };
        
        $httpstr="GET /student/f1.asp HTTP/1.1\r\n";
        $httpstr.="Host:jwc.wyu.edu.cn\r\n";
        $httpstr.="Cookie:".$this->Cookie."\r\n";
        $httpstr.="Connection:keep-alive\r\n\r\n";
        $httpstr.="Referer:http://jwc.wyu.edu.cn/student/menu.asp\r\n";
        
        fwrite($conn,$httpstr,strlen($httpstr));
        //echo $httpstr;
        $res='';
        while(!feof($conn)){
        	$res.=fread($conn,1024);
        };
         fclose($conn);
         //将获取的到信息存入到指定的文件中
        file_put_contents(APPLICATION_PATH ."/controllers/test1.txt", $res);  
        $html=preg_replace("/[\t\n\r]+/","",file_get_contents(APPLICATION_PATH ."/controllers/test1.txt"));
       
        preg_match_all('/<td ([^>]*)>([^<>]*)<\/td>/',$html,$result);
        $st=$result[2];
        $student=array("num"=>$st[0],"class"=>$st[9],"rename"=>$st[1],
                "college"=>$st[10],"major"=>$st[8],"status"=>$st[14],"ctime"=>time(),"password"=>$this->UserPwd);
        
        $this->student=$student;
     
                
        return $this->getstatus($res);
    }
    
    
    public function getstatus($str){
        $res=substr($str, 9,3);
        return $res;
    }
    
    public function geterr($err){
        
    }
}
?>