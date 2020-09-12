# Mazzuma PHP package

## Installation

Make sure you have composer installed on your PC. If you don't already have it installed, visit the [Composer webiste](https://getcomposer.org/).
If you are good to go, run ```composer init``` and proceed to add the Mazzuma package to your project directory with command below:
```
composer require peterperez/mazzuma-library:dev-master
```

## Example Usage

```php

<?php

require_once __DIR__ . '/vendor/autoload.php';

// IMPORT MazzumaApi PACKAGE
use Peter\Mazzuma\MazzumaApi;

// GET API KEY FROM MAZZUMA DASHBOARD
$api_key = "XXXXXXX"; 

// INITIALIZE THE MazzumaApi
$mazzuma = new MazzumaApi($api_key);

// INITIATE TRANSACTION AND ASSIGN API RESPONSE TO $api_response
try {
$api_response = $mazzuma->transfer('MTN_TO_MTN') // TRANSCATION FLOW
                ->amount(1) // AMOUNT TO SEND
                ->sender('0541718326') // WHO IS SENDING THE MONEY
                ->recipient('0548797248') // WHO IS RECEIVING THE MONEY
                ->sendMoney(); // TRIGGER THE TRANSFER

echo json_encode($api_response);

} catch(Exception $e) {
    echo $e->getMessage();
}

```

To further understand the API endpoint, parameters and also; your API-KEY, visit [Mazzuma Developer Portal](https://mazzuma.com/developer/).