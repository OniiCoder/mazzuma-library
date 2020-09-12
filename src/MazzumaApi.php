<?php

namespace Peter\Mazzuma;
use Peter\Mazzuma\Exception\InvalidAmountException;
use Peter\Mazzuma\Exception\InvalidPaymentOptionException;
use Peter\Mazzuma\Exception\EmptyArgumentNotAccepted;

class MazzumaApi {

    /** @var string The API Endpoint */
    private $endpoint_url = 'https://client.teamcyst.com/api_call.php';

    /** @var string The API Key from Mazzuma */
    private $apikey;

    /** @var string An integer value of the amount being sent */
    private $amount;

    /** @var string Network of sender */
    private $network;

    /** @var string Who is receiving the money? */
    private $recipient;

    /** @var string Who is sending the money? */
    private $sender;

    /** @var string The transaction flow direction */
    private $option;

    /** @var object  The response of the API */
    private $api_response;

    /**
     * create new MazzumaApi instance
     */
    public function __construct($key) {
        $this->apikey = $key;
    }

    /**
     * Call API to process transaction
     */

    public function sendMoney() {

        // check if CURL is enabled
        if (!function_exists('curl_version')) {
            return "CURL isn't enabled on your Server !";
        }

        $transaction_data = $this->buildTransactionDetails(
            $this->option,
            $this->network,
            $this->apikey,
            $this->sender,
            $this->recipient,
            $this->amount
        );

        $headers = array(
            'Content-Type: application/json'
         );

         $ch = curl_init($this->endpoint_url);                                                                      
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transaction_data)); // the data passed into the request is in json format                                                                 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                     
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
         
         $server_response = curl_exec ($ch);
         $this->api_response = json_decode($server_response, true);

         return $this->api_response;
    }

    /**
     * set transaction amount
     * @param $amount_input string - the amount to send
     * @return MazzumaAPI
     */
    public function amount($amount_input = null) {

        if($amount_input == null) {
            throw new InvalidAmountException("Please enter an amount to send");
        }

        $this->validateAmount($amount_input);
        $this->amount = $amount_input;
        return $this;
    }

    /**
     * returns the transaction amount
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * set sender number
     * @param $sender string - the mobile money phone number of the sender
     * @return MazzumaAPI
     */
    public function sender($sender = null) {

        // check that sender number is provided
        if($sender == null) {
            throw new EmptyArgumentNotAccepted("Sender MOMO Number is missing!");
        }
        
        $this->sender = $sender;
        return $this;
    }

    /**
     * returns the sender
     * @return string
     */
    public function getSender() {
        return $this->sender;
    }

    /**
     * set recipient number
     * @param $reciever string - the mobile money phone number of the recipient
     * @return MazzumaAPI
     */
    public function recipient($receiver = null) {

        // check that recipient number is provided
        if($receiver == null) {
            throw new EmptyArgumentNotAccepted("Recipient MOMO Number is missing!");
        }

        $this->recipient = $receiver;
        return $this;
    }

    /**
     * returns the recipient
     * @return string
     */
    public function getRecipient() {
        return $this->recipient;
    }

    /**
     * set sender network
     * set payment option
     */
    public function transfer($payment_flow) {
        $this->network = $this->getSenderNetwork($payment_flow);
        $this->setPaymentOption($payment_flow);
        return $this;
    }

    /**
     * 
     * @return get sender network from payment flow
     */
    private function getSenderNetwork($paymentFlow)
    {
        $networks = explode("_", trim($paymentFlow));

        return strtolower($networks[0]);
    }

    /**
     * return the corresponding Mazzuma option for each payment flow input
     */
    private function setPaymentOption($payment_flow) {

        switch ($payment_flow) {
            case 'MTN_TO_MTN':
                $this->option = 'rmtm';
                break;
            case 'MTN_TO_AIRTEL':
                $this->option = 'rmta';
                break;
            case 'MTN_TO_VODAFONE':
                $this->option = 'rmtv';
                break;
            case 'VODAFONE_TO_MTN':
                $this->option = 'rvtm';
                break;
            case 'VODAFONE_TO_AIRTEL':
                $this->option = 'rvta';
                break;
            case 'VODAFONE_TO_VODAFONE':
                $this->option = 'rvtv';
                break;
            case 'AIRTEL_TO_MTN':
                $this->option = 'ratm';
                break;
            case 'AIRTEL_TO_AIRTEL':
                $this->option = 'rata';
                break;
            case 'AIRTEL_TO_VODAFONE':
                $this->option = 'ratv';
                break;
            
            default:
                throw new InvalidPaymentOptionException('Invalid payment option!');
        }
    }


    /**
     * Parses the Transaction Details into Json for API call
     */
    public function buildTransactionDetails($option, $network, $apikey, $sender_momo_number, $recipient_momo_number, $amount
    ) {

        $are_valid_inputs = $this->validateAllInput(
            $amount,
            $network,
            $recipient_momo_number,
            $sender_momo_number,
            $option,
            $apikey
        );

        if($are_valid_inputs) {
            $data = [
                "price"=> $amount,
                "network"=> $network,
                "recipient_number"=> $recipient_momo_number,
                "sender"=> $sender_momo_number,
                "option"=> $option,
                "apikey"=> $apikey
            ];
    
            return $data;
        }
    }

    /**
     * Check that all fields are not empty strings
     */
    public function validateAllInput(
        $amount,
        $network,
        $recipient_momo_number,
        $sender_momo_number,
        $option,
        $apikey
    ) {
        if (empty($option) || empty($network) || empty($apikey) || empty($sender_momo_number) || empty($recipient_momo_number) || empty($amount)) {
            throw new EmptyArgumentNotAccepted("Invalid Input! Make sure to provide all inputs!");
        }

        return true;
    }

    /**
     * validate the amount to ensure it's a number
     * @return boolean
     */
    private function validateAmount($amount_input) {

        if(!is_numeric($amount_input)) {
            throw new InvalidAmountException('Amount is an invalid number');
        }

        return true;

    }
}
