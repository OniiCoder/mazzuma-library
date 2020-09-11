<?php

namespace Peter\Mazzuma;

class Index {

    public function sendMoney($endpoint_url, $transaction_data) {

        // check if an apikey is provided
       if($transaction_data["apikey"] == null || $transaction_data["apikey"] == '') {
            // if no apikey was provided, return a "bad request" response
            $response->code = 400;
            $response->status = "Please enter your apikey";
            return json_encode($response);
       } else {

        $headers = array(
            'Content-Type: application/json'
         );

         $ch = curl_init($endpoint_url);                                                                      
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transaction_data)); // the data passed into the request is in json format                                                                 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
         
         return $server_response = curl_exec ($ch); // return server response
       }
    }
}
