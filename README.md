batteries
=========

A Symfony3 first test project for Levi9 training

Run project:

1. composer install

2. php bin/console doctrine:database:create

3. php bin/console doctrine:schema:create

4. php bin/console assets:install

5. php bin/console server:run

PhpUnit:

1. php bin/console doctrine:database:create --env=test

2. php bin/console doctrine:schema:create --env=test

3. ./vendor/bin/phpunit