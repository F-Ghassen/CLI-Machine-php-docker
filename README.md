CLI MAchine
=========

### Setup
System requirements:
- PHP 5.6
- Composer

### locally
composer install 
php bin/console purchase-cigarettes 2 10.00
# to run tests: 
cd vendor/bin
phpunit ../../tests

### Docker
docker build -t limango . 
docker run -it limango php bin/console purchase-cigarettes 2 10.00
# to run tests: 
docker run -it limango ./vendor/bin/phpunit /app/tests

### Example:
```
╰─$ php bin/console purchase-cigarettes 2 10.00

You bought 2 packs of cigarettes for -9,98€, each for -4,99€.

Your change is:
+-------+-------+
| Coins | Count |
+-------+-------+
| 0.02  | 1     |
+-------+-------+
```

