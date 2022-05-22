# README #

Microservices SDK. Utilities, Traits, Responses, etc

### Traits ###

1. HasCurrency
2. OwnerTrait
3. ResponseItemData
4. ResponseItemsData
5. Sorting
6. UuidTrait



Sumra Logstash
==========

This package register stderr handler with own formatter which adds request_id in logs

Installation
============

```json
{
    "require": {
        "sumra/logstash": "*"
    }
}
```

- Open your `bootstrap/app.php` file and:

add this line in `Register Service Providers` section:
```php
    $app->register(\Sumra\SDK\LogstashServiceProvider::class);
```

- To identify the application you need to add APP_NAME to your .env file

