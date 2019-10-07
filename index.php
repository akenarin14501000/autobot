<?php
require_once('./vender/autoload.php');

#Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot
use \LINE\LINEBot\MessageBuilder\TextMeaasgeBuilder;

$channel_token='1v2OUa9tuMIiDhEg57ANbsRaBDbBGP9nlCC+Dpvt5HrsQ+LqcrImWPUBkH8re/pwqxv56d15kZeMoU/vQ0zuzPFlbhFM7AhRMZwLrSkLdcjbFurwXGOyHLt8MdgzLfAe7r0BsQV5cATlUanW3OgJewdB04t89/1O/w1cDnyilFU=';
$channel_secret='9b2c7349ea939ef723a3cd453d774c86';

#Get message from line api
$content =file_get+contents('php://input');
$events=json_decode($content,true);

if(!is_null($events['events'])){
	//loop through each event
	foreach($events['event'] as $event){
		//line api send a lot of event type,we interested in message only.
		if($event['type']=='message'){
			switch($event['message']['type']){
			 case'test';
			//Get replyToken
            $replyToken=$event['replyToken'];
			//reply message
			$respMessage='Hello,your message is'.$event['message']['type'];
			$httpClient=new CurlHTTPClient()$channel_token;
			$bot=new LINEBot($httpClient,array('channelSecret'=>$channel_secret));
			$textMessageBuilder=newTextMessageBuilder($respMessage);
			$response=$bot->replyMessage($replyToken,$textMessageBuilder);
			break;
			}
			
		}
	}
}

echo 'OK';