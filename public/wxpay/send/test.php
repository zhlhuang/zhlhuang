<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>test ajax</title>
</head>
<script type="text/javascript" src="http://zhl.besteee.com/js/jquery.js"></script>
<style>
.alldiv{
border: 1px solid red;
float: left;
width: 100px;
height: 100px;
margin-left: 50px;
}
.allspan{
border: 1px solid blue;
float: left;
width: 50px;
height: 50px;
margin-left: 50px;
}
</style>
<body>
              <input type="text" id="text" />
              <input type="button" value="test ajax" id="btn1" /><br />
              <div class="alldiv" id="one"></div>
</body>
<script>
/*
              $("#btn1").click(
                            function(){
                                          send_Data={'username':$('#text').val(),'psw':'123456'};
                                          $("#one").load("test.php",send_Data,function(data,status,ajasobj){
                                                        //杩欓噷鏄洖璋冨嚱鏁�
                                                        alert(data);
                                          });
                            }
              );*/
             $("#btn1").click(
                           function(){
                                         $("#one").load("http://www.jmyzds.com/store/wxpay/send/orderquery.php?id=108",'',function(data,status){
                                                       //alert(status);
                                                       alert(data);
                                         });
                           }
             );

</script>
</html>