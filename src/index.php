<?php

namespace Peter\Mazzuma;

class Index {

    public function sendMoney($endpoint_url, $transaction_data) {

        // check if an api key is provided
       if($transaction_data["apikey"] == null || $transaction_data["apikey"] == '') {
            $response->code = 400;
            $response->status = "Please enter your apikey";
            return json_encode($response);
       } else {

        $additional_headers = array(
            'Content-Type: application/json'
         );

         $ch = curl_init($endpoint_url);                                                                      
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transaction_data));                                                                 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
         curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers); 
         
         return $server_output = curl_exec ($ch);
       }
    }
}
