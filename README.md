# SalesForce REST Api PHP client

Salesforce / Force.com REST API PHP client. While it acts as more of a wrapper of the API methods, it should provide you with all the flexibility you will need to interact with the Salesforce REST api.

This component is based on documentation available [here](https://resources.docs.salesforce.com/sfdc/pdf/api_rest.pdf)

## Installation

```bash
composer require "aracoool/salesforce-client:^1.0"
```

## Usage

### Getting an information of the specific account

```php
use SalesForce\Authentication\Authentication;
use SalesForce\Authentication\PasswordAuthentication;

require __DIR__ . '/vendor/autoload.php';

$client = new \SalesForce\ClientFactory::create(new PasswordAuthentication(
    Authentication::LIVE_HOST,
    'client id',
    'client secret',
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

**Result**

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

### Usage of the SOQL and SOQL query builder

```php
use SalesForce\Authentication\Authentication;
use SalesForce\Authentication\PasswordAuthentication;

require __DIR__ . '/vendor/autoload.php';

$client = new \SalesForce\ClientFactory::create(new PasswordAuthentication(
    Authentication::LIVE_HOST,
    'client id',
    'cleint secret',
    'username',
    'password + access token'
));

$soqlBuilder = new \SalesForce\Soql\Builder();
$soqlBuilder->select(['name'])
    ->from('Account');

try {
    $result = $client->get($soqlBuilder->build());
    print_r($result);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
```

**Result**

```
stdClass Object
(
    [totalSize] => 10845
    [done] => 
    [nextRecordsUrl] => /services/data/v42.0/query/01g0x000004qMUXAA2-2000
    [records] => Array
        (
            [0] => stdClass Object
                (
                    [attributes] => stdClass Object
                        (
                            [type] => Account
                            [url] => /services/data/v42.0/sobjects/Account/0010x000003mP6UAAU
                        )

                    [Name] => John Smith
                )
                
                ...
        )
)
```
