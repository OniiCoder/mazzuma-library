<?php

namespace Peter\Mazzuma;

class MazzumaAPI {
     //TODO
    //Validate amount
    //Validate fields

    /** @var string The API Endpoint */
    private $api = 'https://client.teamcyst.com/api_call.php';

    /** @var string The API Key from Mazzuma */
    private $apikey;

    // /** @var string An integer value of the amount being sent */
    // private $amount;

    // /** @var string Network of sender */
    // private $network;

    // /** @var string Who is receiving the money? */
    // private $recipient_momo_number;

    // /** @var string Who is sending the money? */
    // private $sender_momo_number;

    // /** @var string The transaction flow direction */
    // private $option;

    /**
     * create new MazzumaAPI instance
     */
    public function __construct($key) {
        $this->apikey = $key;
    }

    /**
     * Call method to process transaction
     */

    public function sendMoney($data) {

        // check if CURL is enabled
        if (!function_exists('curl_version')) {
            return "CURL isn't enabled on your Server !";
        }

        $transaction_data = $this->buildTransactionDetails(
            $data['option'],
            $data['sender_network'],
            $data['api_key'],
            $data['sender_momo_number'],
            $data['recipient_momo_number'],
            $data['amount']
        );

        $headers = array(
            'Content-Type: application/json'
         );

         $ch = curl_init($endpoint_url);                                                                      
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transaction_data)); // the data passed into the request is in json format                                                                 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
         
         return $server_response = curl_exec ($ch);
    }

    /**
     * Parses the Transaction Details into Json for API call
     */
    private function buildTransactionDetails(
        $option,
        $network,
        $apikey,
        $sender_momo_number,
        $recipient_momo_number,
        $amount
    ) {
        if (empty($option) || empty($network) || empty($apikey) || empty($sender_momo_number) || empty($recipient_momo_number) || empty($amount)) {
            return "Invalid Input! Make sure to provide all inputs";
        }

        $data = [
            "price"=> $amount,
            "network"=> $network,
            "recipient_number"=> $paymentDirectionalFlow,
            "sender"=> $sender_momo_number,
            "option"=> $option,
            "apikey"=> $apikey
        ];

        $json_data = json_encode($data);

        return $json_data;
    }
}
