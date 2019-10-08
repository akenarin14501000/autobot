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
			//$appointment=explode(',',$event['message']['text']);
			try{
			$host='ec2-54-83-9-169.compute-1.amazonaws.com';
			$dbname='d5rut4lfvlp4ar';
			$user='isnivawtdytcrl';
			$pass='fab82d419311ad5a75b8c1719c6acc014ee88e6f7954c3bfe7f134401d838587';
			$connection=new PDO("pgsql:dbname=$dbname;host=$host", $user, $pass);
			$sql=sprintf('SELECT * FROM poll WHERE user_id='%s'',$event['source']['userId']);		
			$result=$connection->query($sql);
			error_log($sql);
			if ($result==false || $result->rowcount()<=0){
			switch ($event['message']['text']){
				case'1':
				#Insert
				$params=array(
				'userId'=>$event['source']['userId'],
				'answer'=>'1',);
				$statement=$connection->prepare('INSERT INTO poll (user_id,answer) values (:userId,:answer)' );
				$statement->execute($params);
			$sql=sprintf("SELECT * FROM poll WHERE answer='1' and user_id='%s'",$event['source']['userId']);	
			$result=$connection->query($sql);	
			$amount=1;
				if ($result){
					$amount=$result->rowcount();
				}
				$respMessage="จำนวนคนตอบว่าเพื่อน = ".$amount;
				break;
				
				case'2':
				#Insert
				$params=array(
				'userId'=>$event['source']['userId'],
				'answer'=>'2',);
				$statement=$connection->prepare('INSERT INTO poll (user_id,answer) values (:userId,:answer)' );
				$statement->execute($params);
			$sql=sprintf("SELECT * FROM poll WHERE answer='2' and user_id='%s'",$event['source']['userId']);	
			$result=$connection->query($sql);	
			$amount=1;
				if ($result){
					$amount=$result->rowcount();
				}
				$respMessage="จำนวนคนตอบว่าแฟน = ".$amount;
				break;
				
				case'3':
				#Insert
				$params=array(
				'userId'=>$event['source']['userId'],
				'answer'=>'3',);
				$statement=$connection->prepare('INSERT INTO poll (user_id,answer) values (:userId,:answer)' );
				$statement->execute($params);
			$sql=sprintf("SELECT * FROM poll WHERE answer='3' and user_id='%s'",$event['source']['userId']);	
			$result=$connection->query($sql);	
			$amount=1;
				if ($result){
					$amount=$result->rowcount();
				}
				$respMessage="จำนวนคนตอบว่าพ่อแม่ = ".$amount;
				break;
				
				case'4':
				#Insert
				$params=array(
				'userId'=>$event['source']['userId'],
				'answer'=>'4',);
				$statement=$connection->prepare('INSERT INTO poll (user_id,answer) values (:userId,:answer)' );
				$statement->execute($params);
			$sql=sprintf("SELECT * FROM poll WHERE answer='4' and user_id='%s'",$event['source']['userId']);	
			$result=$connection->query($sql);	
			$amount=1;
				if ($result){
					$amount=$result->rowcount();
				}
				$respMessage="จำนวนคนตอบว่าบุคคลอื่นๆ = ".$amount;
				break;
			default:
				$respMessage="บุคคลที่ท่านโทรหาบ่อยที่สุด คือ ?  \n\r
				กด 1 เพื่อน	\n\r
				กด 2 แฟน	\n\r
				กด 3 พ่อแม่	\n\r
				กด 4 บุคคลอื่นๆ	\n\r
				";
				break;
			}
			}else{
					$respMessage="ท่านได้ตอบโพลล์นี้แล้ว"
			}
		
			$httpClient=new CurlHTTPClient($channel_token);
			$bot=new LINEBot($httpClient,array('channelSecret'=>$channel_secret));	
			$textMessageBuilder=new TextMessageBuilder($respMessage);
			$response=$bot->replyMessage($replyToken,$textMessageBuilder);
		} catch (Exception $e){
			error_log($e->getMessage());
		}		
	  }
	}
}

echo 'System Poll';
