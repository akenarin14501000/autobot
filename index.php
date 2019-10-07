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
		if($event['type']=='message'){
			//Get replyToken
			 $replyToken=$event['replyToken'];
			switch($event['message']['type']){
			case'video';
			 $messageID=$event['message']['id'];
           			//create video file on server
					$fileID=$event['message']['id'];
					$response=$bot->getMessageContent($fileID);
					$fileName='linebot.mp4';
					$file=fopen($fileName,'w');
					fwrite($file,$response->getRawBody());
			$respMessage='Hello,your Video ID is'.$messageID;
			break;
			
			case'sticker';
			 $messageID=$event['message']['packageId'];
           			//reply sticker
			$respMessage='Hello,your sticker package ID is'.$messageID;
			break;
			
			 case'image';
			 $messageID=$event['message']['id'];
           			//reply message
			$respMessage='Hello,your image ID is'.$messageID;
			break;
			
			default:
			$respMessage='Please send image only';
			
			
			break;
			}
			$httpClient=new CurlHTTPClient($channel_token);
			$bot=new LINEBot($httpClient,array('channelSecret'=>$channel_secret));	
			$textMessageBuilder=new TextMessageBuilder($respMessage);
			$response=$bot->replyMessage($replyToken,$textMessageBuilder);
		}
	}
}

echo 'OK';
