<?php

require_once('send_money.php');

//specify request endpoint
$endpoint_url = ''; // leave empty to use the default endpoint: 'https://client.teamcyst.com/api_call.php'

//prepare transaction data
$transaction_data = array(
    "price"=> 1,
    "network"=> "mtn",
    "recipient_number"=> "026xxxxxxx",
    "sender"=> "024xxxxxxx",
    "option"=> "rmta",
    "apikey"=> "a86f63ac31317afe14be406f9d3c6a9eafa863986414b856357a505c99b2aa9c" // provide API Key from Mazzuma Dashboard
);

//initiate transaction
$transaction = sendMoney($endpoint_url, $transaction_data);
var_dump($transaction);
