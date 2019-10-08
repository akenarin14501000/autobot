<?php
require_once('./vendor/autoload.php');

#Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token='TUChny/ZBXe1rsUoqQyXj6rHNTN+efSNtWn4W65LGh4f96G/xnRomNi0A4iKBhZ71sa40XxbqP2hzk/AvG2bLNpMW4ITGmfyrAgDl5GwTvRCp8vxSPX40Af/Pi8tIBjVZlLATwfGxs+QygxYaCTFMQdB04t89/1O/w1cDnyilFU=';
$channel_secret='41941150e071e4009e1b8f5c93e36a7a';

#Get message from line api
$content =file_get_contents('php://input');
$events=json_decode($content,true);

if(!is_null($events['events'])){
	//loop through each event
	foreach($events['events'] as $event){
		//line api send a lot of event type,we interested in message only.
		if($event['type']=='message' && $event['message']['type']=='text' ){
			//Get replyToken
			$replyToken=$event['replyToken'];
			//split message then keep it in database.
			$appointment=explode(',',$event['message']['text']);
			if(count($appointment)==2){
				$host='ec2-54-83-9-169.compute-1.amazonaws.com';
				$dbname='d5rut4lfvlp4ar';
				$user='isnivawtdytcrl';
				$pass='fab82d419311ad5a75b8c1719c6acc014ee88e6f7954c3bfe7f134401d838587';
				$connection=new PDO("pgsql:dbname=$dbname;host=$host", $user, $pass);
				
				$params=array(
				'time'=>$appointment[0],
				'content'=>$appointment[1]
				);
				
				$statement=$connection->prepare('INSERT INTO appointment (time,content) VALUES(:time,:content)');
				$rerult=$statement->execute($params);
			$respMessage="บันทึกข้อมูลเรียบร้อยแล้วครับ";
			
			
			}else{
			$respMessage="ไม่สามรถทำงานได้ Error";	
			}
			
			
			$httpClient=new CurlHTTPClient($channel_token);
			$bot=new LINEBot($httpClient,array('channelSecret'=>$channel_secret));	
			$textMessageBuilder=new TextMessageBuilder($respMessage);
			$response=$bot->replyMessage($replyToken,$textMessageBuilder);
		}
	}
}

echo 'System Appointment';
