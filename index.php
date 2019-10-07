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
		
			//Get replyToken
			 $replyToken=$event['replyToken'];
			$originalContentUrl='https://www.beartai.com/wp-content/uploads/2017/11/22886328_10208432809332575_6674604265514277172_n.jpg';
			$previewImageUrl='https://www.beartai.com/wp-content/uploads/2017/11/22886328_10208432809332575_6674604265514277172_n.jpg';
	
			$httpClient=new CurlHTTPClient($channel_token);
			$bot=new LINEBot($httpClient,array('channelSecret'=>$channel_secret));	
			$textMessageBuilder=new ImageMessageBuilder($originalContentUrl,$previewImageUrl);
			$response=$bot->replyMessage($replyToken,$textMessageBuilder);
		
	}
}

echo 'Image';
