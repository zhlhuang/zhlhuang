<?php
require_once("../alipay.class.php");
//�û������˻�


$id=$_GET["id"];
if($id){
	//�ɹ���ȡid
	
	$pay=new alipay();
	
	$payres=$pay->getall($id);//��ȡ������Ϣ
	
	$trade_status=$payres["trade_status"]; //�õ�����״̬
	$res=0;
	if($trade_status=="WAIT_SELLER_SEND_GOODS"){
		//����û�з���
		$res=$pay->updatastatus2($id,"WAIT_SELLER_AGREE"); //�ȴ�����ͬ��
	}
	if( $trade_status=='WAIT_BUYER_CONFIRM_GOODS'){
		//�����Ѿ�����
		$res=$pay->updatastatus2($id,"WAIT_SELLER_AGREE_AFTER_SENT"); //�ȴ�����ͬ��
	}
	//echo $res;
	
	if($res==1){
		echo "success";
	}else{
		echo "fail";
	}
	
	
	
}else{
	//û�д���idֵ
	echo "no id value";
}
?>