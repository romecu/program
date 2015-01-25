<?php
header("Content-Type:text/html;charset=utf-8");//设置字符集
include_once "WXBizMsgCrypt.php";
/**
  * wechat php test
  */


  
//define your token
define("TOKEN", "weixin");
//http://stltxxh.sinaapp.com/index.php

     
 
$g_orderid=0;//全局变量存放order_id
$g_sn=0;//全局变量存放号码
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        //验证
$encodingAesKey = "Vis6J5UjC86ZQUDE1cUou9sExDMKlnlnzhehb6Lgrw3";
$token = "weixin";
        $corpId = "wx386e0035fe4564b2";//"wxda126a77f1b6b337";
            /**/
$sVerifyMsgSig =$_GET["msg_signature"];//parse_url("msg_signature");// HttpUtils.ParseUrl("msg_signature");
$sVerifyTimeStamp =$_GET["timestamp"];// parse_url("timestamp");//HttpUtils.ParseUrl("timestamp");
$sVerifyNonce = $_GET["nonce"];//parse_url("nonce");//HttpUtils.ParseUrl("nonce");
$sVerifyEchoStr = $_GET["echostr"];// parse_url("echostr");//HttpUtils.ParseUrl("echostr");

// 需要返回的明文
$sEchoStr="";
$sMsg="";
$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
$errCode= $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        
//$errCode1 = $wxcpt->DecryptMsg($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);        
if ($errCode == 0) {
	// 验证URL成功，将sEchoStr返回
    echo $sEchoStr;//$sEchoStr;
    exit;
    // HttpUtils.SetResponce($sEchoStr);
} else {
	print("ERR: " . $errCode . "\n\n");
    print("msg:".$sVerifyMsgSig. "\n\n");
    print("msg:".$sVerifyTimeStamp. "\n\n");
    print("msg:".$sVerifyNonce. "\n\n");
    print("msg:".$sVerifyEchoStr. "\n\n");
}
        /**/
        
        // $echoStr = $_GET["echostr"];

        //valid signature , option
        // if($this->checkSignature()){
        //	echo $echoStr;
        //  exit;}
    //


        
     }
    
    public function linkCheck($wxcpt,$sMsgSig,$sTimeStamp,$sNonce,$sVerifyEchoStr)
    {
        $sEchoStr="";
    
        $errCode= $wxcpt->VerifyURL($sMsgSig, $sTimeStamp, $sNonce, $sVerifyEchoStr, $sEchoStr);
        
        if ($errCode == 0) {
	// 验证URL成功，将sEchoStr返回
    echo $sEchoStr;
    exit;
   
} else {
	print("ERR: " . $errCode . "\n\n");
    print("msg:".$sVerifyMsgSig. "\n\n");
    print("msg:".$sVerifyTimeStamp. "\n\n");
    print("msg:".$sVerifyNonce. "\n\n");
    print("msg:".$sVerifyEchoStr. "\n\n");
}
        
    }
    
    public function responseMsg()
    {
        
        $g_sn=0;
        global $g_orderid;
          $mysql = new SaeMysql();
        // $sql = "select ifnull(count(userid),0) cc from `tb_user_pic`";
        //$data = $mysql->getLine( $sql );
        // $cc= $data['cc']+1;
        // $sql = "insert into `tb_user_pic`(userid,picurl,sn,seq,total_score,total_count,avg)values('".$fromUsername."','".$keyword."',0,'".$cc."',0,0,0) ";//插入图片
        //  $mysql->runSql( $sql );
        
        //验证并反馈echostr 20141108
             //验证
$encodingAesKey = "Vis6J5UjC86ZQUDE1cUou9sExDMKlnlnzhehb6Lgrw3";
$token = "weixin";
$corpId = "wx386e0035fe4564b2";
$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);

$sVerifyMsgSig =$_GET["msg_signature"];
$sVerifyTimeStamp =$_GET["timestamp"];
$sVerifyNonce = $_GET["nonce"];
$sVerifyEchoStr = $_GET["echostr"];

// 需要返回的明文
$sEchoStr="";
$sMsg="";
$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
        //linkCheck($wxcpt,$sVerifyMsgSig,$sVerifyTimeStamp,$sVerifyNonce,$sVerifyEchoStr);
              
$errCode= $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);

if ($errCode == 0) {
	// 验证URL成功，将sEchoStr返回
    echo $sEchoStr;
    exit;
   
} else {
	print("ERR: " . $errCode . "\n\n");
    print("msg:".$sVerifyMsgSig. "\n\n");
    print("msg:".$sVerifyTimeStamp. "\n\n");
    print("msg:".$sVerifyNonce. "\n\n");
    print("msg:".$sVerifyEchoStr. "\n\n");
}
//验证并反馈echostr 20141108
        

//解密用户发送的内容
$sReqMsgSig =$_GET["msg_signature"];
$sReqTimeStamp =$_GET["timestamp"];
$sReqNonce = $_GET["nonce"];
$sReqData=file_get_contents("php://input");


$sMsg = "";  // 解析之后的明文
$errCode1 = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
        
        

if($errCode1==0)
{
$xml = new DOMDocument();
$xml->loadXML($sMsg);
$reqToUserName = $xml->getElementsByTagName('ToUserName')->item(0)->nodeValue;
$reqFromUserName = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
$reqCreateTime = $xml->getElementsByTagName('CreateTime')->item(0)->nodeValue;
$reqMsgType = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
$reqContent = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
$reqMsgId = $xml->getElementsByTagName('MsgId')->item(0)->nodeValue;
$reqAgentID = $xml->getElementsByTagName('AgentID')->item(0)->nodeValue;
$reqEvent = $xml->getElementsByTagName('Event')->item(0)->nodeValue;
$reqEventKey = $xml->getElementsByTagName('EventKey')->item(0)->nodeValue;

    //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
     libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($sMsg, 'SimpleXMLElement', LIBXML_NOCDATA);
    //$xml->getElementsByTagName('PicMd5Sum')->item(0)->nodeValue;  
    /*       
    $storage = new SaeStorage();
$domain = 'stlt';
$destFileName = 'write_test.txt';
$content = 'Hello,I am from the method of write';
$attr = array('encoding'=>'gzip');
$result = $storage->write($domain,$destFileName, $content, -1, $attr, true);
    */ $orderid=time();
      $link = mysql_connect (SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
    switch($reqMsgType)
    {
       //
        case "event"://触发的是事件
        {//$mycontent=$reqEvent;//break;//$mycontent=$m ;break;
            if($reqEvent=="click")//触发的事件是click
            {
                if($reqEventKey=="order_day")//判断是点击那个菜单
            {
            
          
            if ($link) 
            {
                mysql_select_db ( SAE_MYSQL_DB, $link );
                //mysql_set_charset("gbk");
			
                $sql = "select order_id,sn,case when status=0 then '未处理' when status=1 then '已开户' when status=2 then '不能开户' end is_deal,rsrv2,rsrv5 from tb_dev_order where wx_id='".$reqFromUserName."' and date(upload_time) = curdate() and sn>0";//
                $result = mysql_query ( $sql );
                 $count=1;
                $mycontent="您当日所有开户号码订单状态如下：\n";
                while ( $row = mysql_fetch_array ( $result, MYSQL_NUM ) ) 
                {
 					
                    $mycontent=$mycontent."（'".$count."'）\n订单号：【".$row[0]."】"."\n号码：【".$row[1]."】"."\n状态：【".$row[2]."】"."\n订单中心意见：【".$row[4]."】";//."\n订单中心预计完成时间：【".$row[3]."】"."\n订单中心是否开户完成：【".$row[4]."】；\n";
                   $count=$count+1;
                }
                mysql_free_result ( $result );
                $count=1;
            } else 
            {
                echo "数据库连接KO";
            }
                    
             
                    
            }
                //月报数据
                //月报数据
                
                
                
                 if($reqEventKey=="order_mon")
                 {/*$mycontent="Event Test2";break;*/
                 
                      if ($link) 
            {
                mysql_select_db ( SAE_MYSQL_DB, $link );
                          //mysql_set_charset("gbk");
			
                $sql = " select order_id,sn,case when status=0 then '未处理' when status=1 then '已处理' when status=2 then '不能开户'  end is_deal,rsrv2,rsrv5 from tb_dev_order where wx_id='".$reqFromUserName."' and year(upload_time)=year(now())   and   month(upload_time)=month(now()) and sn>0";//
                $result = mysql_query ( $sql );
                $count=1;
                $mycontent="您当月所有开户号码订单状态如下：\n";
                while ( $row = mysql_fetch_array ( $result, MYSQL_NUM ) ) 
                {
 					
                    $mycontent=$mycontent."（'".$count."'）\n订单号：【".$row[0]."】"."\n号码：【".$row[1]."】"."\n状态：【".$row[2]."】"."\n订单中心意见：【".$row[4]."】";//."\n订单中心预计完成时间：【".$row[3]."】"."\n订单中心是否开户完成：【".$row[4]."】；\n";
                    $count=$count+1;
                }
                mysql_free_result ( $result );
                          $count=1;
            } else 
            {
                echo "数据库连接KO";
            }
                 }
                if($reqEventKey=="help")
                {$mycontent="
                1、【s+*:查询所有未预定的号码，例如s*，即可查询所有未预订的号码。】
                2、【s+xx:查询尾数为xx的号码(xx位数不限)，例如s33,s123等等。】
                3、【o+号码:预定看中的号码，例如o15602777777。】
                4、【c+订单号+#+对应订单中的号码：完整订单号的号码资料，可以更快的录入开户，例如m8888#15602777777。】©汕头联通信息化中心";break;}
            }

        if($reqEvent=="pic_photo_or_album")
        {
            if($reqEventKey=="ppoa1")//判断是点击那个菜单
            {
                $mycontent="图片上传成功;您的订单已经上传，需绑定您的订单和选择的号码，后台录入人员才可处理.
          请复制下面生成的内容回复即可绑定号码和订单，订单处理完毕后会通知您，谢谢";
                //$picUrl = trim($postObj->PicUrl);
                
                //$mycontent="图片上传成功;订单号";//.time().";您的订单已经上传，订单处理完毕后会通知您，谢谢";
                // $orderid=time();
                
                //$sql = "insert into `tb_dev_order`(pic_url,wx_id,sn,staff_id,status,upload_time,order_id,rsrv2,rsrv3,rsrv4)values('".$picUrl."','".$reqFromUserName."',0,0,0,'".$orderid."','".$orderid."',0,0,0) ";//插入图片
                //$mysql->runSql( $sql );
                
                // break;
            }/*$mycontent = trim($postObj->PicUrl);break;这段是可以取得照片地址的*/
        	
        }
        }break;

    
    case "text":
    	{
        switch(strtolower(substr($reqContent,0,1))){
            
            case "c":
            {	
                
                
                $oid=substr($reqContent,1,strpos($reqContent,'#',0)-1);//输入的order_id
                $snid=substr($reqContent,strpos($reqContent,'#',0)+1);//要更新的号码
                
                //判断用户要完整的id资料是否是自己的
        		$sql = "select status,occ_staff cc from `tb_dev_sn` where sn='".$snid."'";
        		$data = $mysql->getLine( $sql );
        		$cc= $data['cc'];
                $status= $data['status'];
                //判断用户要完整的id资料是否是自己的
                if($cc==""){$mycontent="号码【'".$snid."'】不存在，请确认！";}
                else
                {
                if($cc==$reqFromUserName and $status==1)
                {
                    
                    
                $sql = "select rsrv2 cc from `tb_dev_order` where order_id='".$oid."'";
        		$data = $mysql->getLine( $sql );
        		$cc= $data['cc'];
                    if($cc=="" or $cc==1)
                    {$mycontent="您输入的订单'".$oid."'已经更新过或者订单号不对！";}
                    else 
                    {
           			 $sql = "update `tb_dev_order` set sn='".$snid."' where order_id='".$oid."' and status=0 and wx_id='".$reqFromUserName."'";
            		 $mysql->runSql( $sql );
           			 $mycontent="您的订单'".$oid."'已经完善资料，请等待录入人员处理";
                    }
                }
                else 
                {
                	if($cc!=$reqFromUserName)
                    {$mycontent="号码【'".$snid."'】不属于您预定！";}
                    if($status!==0)
                    {$mycontent="号码【'".$snid."'】未预定！";}
                }
                }
            	break;
            }

            case "o"://预定号码
            {
            $ssn=substr($reqContent,1);
                
                //判断要预定的号码是否已被占用
        $sql = "select status cc,occ_time from `tb_dev_sn` where sn='".$ssn."'";
        $data = $mysql->getLine( $sql );
        $cc= $data['cc'];
        $occ_time=$data['occ_time'];
        
         $sql = "select sn cc from `tb_dev_order` where sn='".$ssn."'";
        		$data = $mysql->getLine( $sql );
        		$occ_sn= $data['cc'];
                
                //判断要预定的号码是否已被占用
            if($cc==0)
            {
            
                //$g_sn=$ssn;
            $sql = "update `tb_dev_sn` set status=1,occ_staff='".$reqFromUserName."',occ_time='".$orderid."' where sn='".$ssn."' and status=0";
            $mysql->runSql( $sql );
            $mycontent="1您已经预定号码：【".$ssn."】请及时填写资料拍照上传，以便录入人员及时处理".$cc;
            }
                else 
                { if(time()-$occ_time<=7200 and $occ_sn=="")//如果预占的时间小于2小时并且没有预订，那么不进行解锁仍然是原来预占的代理的号码
                {
                    $remain=7200-(time()-$occ_time);
                $mycontent="您要预定号码：【".$ssn."】已经被占用，请重新查询选择；还有".$remain."秒解锁，请等候";
                }
                 else//如果预占的时间大于2小时，那么自动解锁将，更新预定员工
                 {
            $sql = "update `tb_dev_sn` set status=1,occ_staff='".$reqFromUserName."',occ_time='".$orderid."' where sn='".$ssn."' ";
            $mysql->runSql( $sql );
            $mycontent="2您已经预定号码：【".$ssn."】请及时填写资料拍照上传，以便录入人员及时处理".$cc;
          
                 }
                }
       		break;
            }
            case "s":
            
            {
                // $link = mysql_connect (SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
         $mycontent="可用号码如下：";                
         if(substr($reqContent,1,1)=="*")
         {
           
            if ($link) 
            {
                mysql_select_db ( SAE_MYSQL_DB, $link );
                mysql_set_charset("gbk");

                $sql = "select sn from tb_dev_sn where status=0";
                $result = mysql_query ( $sql );

                while ( $row = mysql_fetch_array ( $result, MYSQL_NUM ) ) 
                {
 					
                    $mycontent=$mycontent."【".$row[0]."】";
                   
                }
                mysql_free_result ( $result );
            } else 
            {
                echo "数据库连接KO";
            }
           }
        else 
        {
            $slen=11-strlen(substr($reqContent,1))+1;
            $ssn=(substr($reqContent,1));
            $mycontent="可用号码如下：";
         if ($link) 
            {
                mysql_select_db ( SAE_MYSQL_DB, $link );
                mysql_set_charset("gbk");

             $sql = "select sn from tb_dev_sn where status=0 and substr(sn,'".$slen."')='".$ssn."'";
                $result = mysql_query ( $sql );
                while ( $row = mysql_fetch_array ( $result, MYSQL_NUM ) ) 
                {
 					
                    $mycontent=$mycontent."【".$row[0]."】";
                   
                }
                mysql_free_result ( $result );
            } else 
            {
                echo "数据库连接KO";
            }
        
        
        }
            }break;

    default :
            $mycontent="/:dig";
    break;
}   break;
            
        }
        case "image":{  
            	

            	
                $picUrl = trim($postObj->PicUrl);
				$sql = "insert into `tb_dev_order`(pic_url,wx_id,sn,staff_id,status,upload_time,order_id,rsrv2,rsrv3,rsrv4,rsrv5)values('".$picUrl."','".$reqFromUserName."',0,0,0,curdate(),'".$orderid."',0,0,0,0) ";//插入图片
         		$mysql->runSql( $sql );
            	$g_orderid=$orderid;
            
                  $sql = "select max(occ_time) cc from `tb_dev_sn` where occ_staff='".$reqFromUserName."'";
        		$data = $mysql->getLine( $sql );
        		$occ_id= $data['cc'];
            
            	$sql = "select sn cc from `tb_dev_sn` where occ_time='".$occ_id."'";
        		$data = $mysql->getLine( $sql );
        		$occ_sn= $data['cc'];
            
            $mycontent="c".$g_orderid."#".$occ_sn;
            //$mycontent="图片上传成功;订单号".$orderid.";您的订单已经上传，［请尽快绑定号码和订单号］，订单处理完毕后会通知您，谢谢";
            //$mycontent="图片上传成功;订单号".$orderid.";您的订单已经上传，［请尽快绑定号码和订单号］，订单处理完毕后会通知您，谢谢";
            //$sql = "update `tb_dev_sn` set status=1,occ_staff='".$reqFromUserName."',occ_time='".$orderid."' where sn='".$ssn."' ";
            //$mysql->runSql( $sql );
            
        	}
    
    }

  
$sRespData =
"<xml>
<ToUserName><![CDATA[".$reqFromUserName."]]></ToUserName>
<FromUserName><![CDATA[".$corpId."]]></FromUserName>
<CreateTime>".sReqTimeStamp."</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[".$mycontent."]]></Content>
</xml>";

$sEncryptMsg = ""; //xml格式的密文
$errCode = $wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
if ($errCode == 0) {
//file_put_contents('smg_response.txt', $sEncryptMsg); //debug:查看smg
print($sEncryptMsg);
} else {
print($errCode . "\n\n");
}
} else {
print($errCode . "\n\n");
}    

//解密用户发送的内容
        
        /**/
        //$errCode= $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        //验证并反馈echostr 20141108
		//get post data, May be due to the different environments
        /*   $sReqData ="<xml>
        <ToUserName><![CDATA[wxda126a77f1b6b337]]></ToUserName>
        <Encrypt><![CDATA[RypEvHKD8QQKFhvQ6QleEB4J58tiPdvo+rtK1I9qca6aM/wvqnLSV5zEPeusUiX5L5X/0lWfrf0QADHHhGd3QczcdCUpj911L3vg3W/sYYvuJTs3TUUkSUXxaccAS0qhxchrRYt66wiSpGLYL42aM6A8dTT+

6k4aSknmPj48kzJs8qLjvd4Xgpue06DOdnLxAUHzM6+kDZ+HMZfJYuR+LtwGc2hgf5gsijff0ekUNXZiqATP7PF5mZxZ3Izoun1s4zG4LUMnvw2r+KqCKIw+3IQH03v+BCA9nMELNqbSf6tiWSrXJB3LAVGUc

allcrw8V2t9EL4EhzJWrQUax5wLVMNS0+rUPA3k22Ncx4XXZS9o0MBH27Bo6BpNelZpS+/uh9KsNlY6bHCmJU9p8g7m3fVKn28H3KDYA5Pl/T8Z1ptDAVe0lXdQ2YoyyH2uyPIGHBZZIs2pDBS8R07+qN+E7Q==]]></Encrypt>
<AgentID>0</AgentID>
</xml>" ;
*/
        //$_POST["content"];//file_get_contents("php://input");//$GLOBALS["HTTP_RAW_POST_DATA"];

        // $sReqMsgSig ="477715d11cdb4164915debcba66cb864d751f3e6";//$_POST["msg_signature"];//parse_url("msg_signature");// HttpUtils.ParseUrl("msg_signature");
        // $sReqTimeStamp ="1409659813";//$_POST["timestamp"];// parse_url("timestamp");//HttpUtils.ParseUrl("timestamp");
        // $sReqNonce ="1372623149";// $_POST["nonce"];//parse_url("nonce");//HttpUtils.ParseUrl("nonce");
        //$sVerifyEchoStr = $_GET["echostr"];// parse_url("echostr");//HttpUtils.ParseUrl("echostr");
        
      	//extract post data
        // if (!empty($sReqData))
        // {
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
            // libxml_disable_entity_loader(true);
            //  $postObj = simplexml_load_string(/*$postStr*/$sReqData, 'SimpleXMLElement', LIBXML_NOCDATA);
            //  $fromUsername = $postObj->FromUserName;
            //  $toUsername = $postObj->ToUserName;
            //  $keyword = trim($postObj->Content);
            //  $time = time();
            /* $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<AgentID>0</AgentID>
							</xml>";   */  
            // $errCode1 = $wxcpt->EncryptMsg($textTpl, $sVerifyTimeStamp, $sVerifyNonce, $sEncryptMsg);//加密回复用户的内容
            
                            
            //   $sMsg = "";  // 解析之后的明文
			
            
            //   $xmlparse = new XMLParse;
            //	$array = $xmlparse->extract($sReqData);
            // echo $array[0];
            //   echo $array[2];
            //   $errCode1 = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
            
            //   $encrypt = $array[1];
            
            // $sha1 = new SHA1;
            //   $array = $sha1->getSHA1(/*$this->m_sToken*/$token, $sReqTimeStamp, $sReqNonce, $encrypt);
            //$ret = $array[1];
            //echo $ret;    
            //if ($errCode1 == 0) //if(!empty( $keyword ))
            // {
                    
                //$xml = new DOMDocument();
                //$xml->loadXML($sMsg);
                //$content = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
                //print("content: " . $content . "\n\n");
                    
                //$msgType = "text";
                //$contentStr = "Welcome to wechat world!";

                    // $resultStr = sprintf($sMsg, $fromUsername, $toUsername, $time, $msgType, $sEncryptMsg);
                //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $sEncryptMsg);
                // echo $sMsg;//$resultStr;
                // echo  $postStr;
            //    }
            //else
            //{
            //       echo $errCode1;//"Input something...";
            //        }
        //
            // }
        //else {
        //echo "";
        //exit;
        // }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>
