# SalesForce REST Api PHP client

Salesforce/Force.com REST API PHP client. While it acts as more of a wrapper of the API methods, it should provide you with all the flexibility you will need to interact with the Salesforce REST api.

This component is based on documentation available [here](https://resources.docs.salesforce.com/sfdc/pdf/api_rest.pdf)

## Installation

```bash
composer require "aracoool/salesforce-client:^1.0"
```

## Usage

Getting an information of specific account

```php
use GuzzleHttp\Client;
use SalesForce\Authentication\Authentication;
use SalesForce\Authentication\PasswordAuthentication;

require __DIR__ . '/vendor/autoload.php';

$client = new \SalesForce\Client(new Client(), new PasswordAuthentication(
    Authentication::LIVE_HOST,
    'client id',
    'cleint secret',
    'username',
    'password + access token'
));

try {
    $result = $client->get('/sobjects/Account/0013600001UltKTAAZ');
    print_r($result);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
```

*Result*

```
stdClass Object
(
    [attributes] => stdClass Object
        (
            [type] => Account
            [url] => /services/data/v42.0/sobjects/Account/0013600001UltKTAAZ
        )

    [Id] => 0013600001UltKTAAZ
    ...
)
```