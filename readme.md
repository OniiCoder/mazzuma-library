# Mazzuma PHP package

## Installation

Make sure you have composer installed on your PC. If you don't already have it installed, visit the [Composer webiste](https://getcomposer.org/).
If you are good to go, add the Mazzuma package to your project directory with command below:
```
composer require peterperez/mazzuma-library:dev-master
```

## Example Usage

```php

<?php

require_once __DIR__ . '/vendor/autoload.php';

// import our mazzuma class
use peter\Mazzuma\Index;

// initialize the library
$mazzuma = new Index();

//specify request endpoint
$endpoint_url = 'https://client.teamcyst.com/api_call.php';

//prepare transaction data
$transaction_data = array(
    "price"=> 1,
    "network"=> "mtn", // what network are you sending from?
    "recipient_number"=> "054XXXXXXX", // who is receiving?
    "sender"=> "054XXXXXXX", // who is sending?
    "option"=> "rmtm",
    "apikey"=> "YOUR-API-KEY" // provide API Key from Mazzuma Dashboard
);

//initiate transaction and assign response to $transaction
$transaction = $mazzuma->sendMoney($endpoint_url, $transaction_data);

var_dump($transaction);

```

To further understand the API endpoint, parameters and also; your API-KEY, visit [Mazzuma Developer Portal](https://mazzuma.com/developer/).