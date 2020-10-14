# DOMAIN CHECKER

Project will check domains from uploaded CSV file for availability and expire date. First it will try check it with whois server asociated with this tld, if no successed it will try to check it with WhoApi as fallback.

REQUIREMENTS
------------

The minimum requirement by this project that your Web server supports
- PHP 7.4.0
- MySQL
- PHP ext amqp (for RabbitMQ)


INSTALLATION
------------

~~~
git clone https://github.com/gevorgmansuryan/domain-checker.git
cd domain-checker
composer install
~~~


CONFIGURATION
-------------

#### Database

Edit the file `config/db.php` with real data, for example:

```php
return \yii\helpers\ArrayHelper::merge([
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=db_name',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ], YII_ENV_PROD ? [
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ] : []
);
```

#### Params

Edit the file `config/params.php` with real data, for example:

```php
return [
    'whoapi_api_key' => '3904a770ad337172b83615bf92a3fb71', //WhoApi api key
    'whois_timeout' => 1, //servers request timeout
];
```

TESTING
-------

- run `php yii migrate`
- run `php yii init` for initializing whois servers
- run `php yii queue/listen` to enable RabbitMQ worker
- run `php yii serve`
- open website upload CSV file containing domains
- go to `Stats` to see CSV file domains stats
- go to `Learning` to configure whois servers and help them to learn how to recognize and parse responses

- Also You can tun `php yii init/learn` and servers will try learn how to parse responses itself