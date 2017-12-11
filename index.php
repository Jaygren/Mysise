<?php
/**
1.	提供学生个人信息查询(完成)
2.	提供学生课表查询。（最好有上课前自动提醒功能）(完成)
3.	提供学生考勤信息查询。（完成）
4.	提供学生考试时间查询。（完成）
5.	提供学生成绩查询。（完成）
6.	提供学生奖惩情况查询(完成)
7.	提供学生开设课程信息查询。（直接post页面）(算完成了)
8.	提供晚归、违规电器查询。（完成）
 * 
 */
 
require_once 'util/simple_html_dom.php';
require_once 'util/MySiseUtil.php';
require_once 'util/DatabaseManager.php';
require_once 'util/isBind.php';
require_once 'sise/siseLogin.php';
require_once 'sise/getPerson.php';
require_once 'sise/getSchedule.php';
require_once 'sise/getExam.php';
require_once 'sise/getWorkattendance.php';
require_once 'sise/getScore.php';
require_once 'sise/getReward.php';
require_once 'sise/getWrongdoing.php'; 
 

define("TOKEN", "TuoTuo");


$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
 private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

 public function responseMsg()
 {
	 $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input"); 
	 if(!empty($postStr)){
		 $postObj=simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
		 $RX_TYPE=trim($postObj->MsgType);
		 switch($RX_TYPE)
		 {
			 case "text":
			 $resultStr=$this->receiveText($postObj,$cookie_file = tempnam("./","cookie"));
			 break;
			 case "event":
			 $resultStr=$this->receiveEvent($postObj,$cookie_file = tempnam("./","cookie"));
			 break;
			 default:
			 $resultStr="";
			 break;
		 }
		 echo $resultStr;
	 }else{
		 echo "";
		 exit;
	 }
	 }
private function receiveText($object,$cookie_file)
{
if (preg_match('#(^\d{10})\+#',$object->Content)){
        $arr = explode('+',$object->Content);
        $username =  $arr[0];
        $password =  $arr[1];
		$result=isBind($object->FromUserName,$cookie_file);
	if($result==3){
       $dbm = new DatabaseManager();
       $res = $dbm->add($object->FromUserName, $username, $password);
        if ($res){
            $contentStr='绑定成功!';}
            else{
            $contentStr='学号或密码不正确！';
	        }}else if($result==1){
            $contentStr='绑定失败，不能重复绑定!';
			unlink($cookie_file);}
		    else{
			$contentStr='数据库错误!';}
       }else{
       	$contentStr="你输入的文本无法匹配";
       }
	unlink($cookie_file);	
	$resultStr=$this->transmitText($object,$contentStr);
	return $resultStr;
}
//处理接收事件
private function receiveEvent($object,$cookie_file)
{
	$contentStr="";
	switch($object->Event)
	{
	case "subscribe":
	$contentStr="欢迎关注TuoTuo部落";
	break;
	case 'unsubscribe':
    $dbm = new DatabaseManager();
    $dbm->delete($object->FromUserName);
    break;
	case 'CLICK':
		  switch ($object->EventKey)
		  {
		  	//绑定账号
            case 'btn_bind':
            $contentStr="绑定账号请回复：学号+密码。\n例如：\nxxxxxxxxxx+xxxxxx";
            //解除绑定
            break;
            case 'btn_unbind':
            $dbm = new DatabaseManager();
                if ($dbm->delete($object->FromUserName))
                    {
                    $contentStr='解绑成功!';
                    }else{
                    $contentStr='解绑失败，数据库操作错误！';
                    }
			break;
			case 'btn_person':
                $result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[0],$cookie_file);
                $contentStr=getPerson($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';	
				unlink($cookie_file);
				}				
			break;
			case 'btn_reward':
				$result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[5],$cookie_file);
                $contentStr=getReward($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';
				unlink($cookie_file);
				}				
			break;
			case 'btn_wrongdoing':
				$result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[21],$cookie_file);
                $contentStr=getWrongdoing($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';
				unlink($cookie_file);	
				}				
			break;
			case 'btn_workattendance':
				$result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[3],$cookie_file);
                $contentStr=getWorkattendance($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';
				unlink($cookie_file);			
				}
			break;
			case 'btn_schedule':
				$result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[1],$cookie_file);
                $contentStr=getSchedule($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';
				unlink($cookie_file);			
				}
			break;
			case 'btn_exam';
			    $result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[2],$cookie_file);
                $contentStr=getExam($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';
				unlink($cookie_file);			
				}
			break;
			case 'btn_score';
			    $result=isBind($object->FromUserName,$cookie_file);
				if($result==1){
				$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
                $content=MysiseHeader($url,$cookie_file);
			    $urls=getUtils($content);	
				$contents=MysiseHeader($urls[0],$cookie_file);
                $contentStr=getScore($contents);
				unlink($cookie_file);
				}
				else{
				$contentStr='请先绑定账户！';
				unlink($cookie_file);	
				}
			break;
		  }
	break;
	default:
	 $contentStr="感谢使用!";
	 break;
	}
	$resultStr=$this->transmitText($object,$contentStr);
	return $resultStr;
}
//文本消息回复
  private function transmitText($object,$content,$funcFlag=0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
    $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content,
    $funcFlag);
    return $resultStr;
    }
}
?>
