<?php

namespace Peter\Mazzuma;

class Index {
    public function greet($greet = "Hello World") {
        return $greet;
    }

    function sendMoney($endpoint_url, $transaction_data) {

        ($endpoint_url == '') ? $endpoint_url = 'https://client.teamcyst.com/api_call.php' : null;

       if($transaction_data["apikey"] == null || $transaction_data["apikey"] == '') {
            $response->code = 500;
            $response->status = "failed";
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
