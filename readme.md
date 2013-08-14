# Base Laravel App Proof of Concept

Basically proof that Laraval is possible to start re-writing our API and other things.

## Setup

    git clone git@github.com:nickdenardis/appname.git
    chmod -R 755 app/storage
    chmod -R 755 vendor/way/generators/src/Way/
    composer install
    php artisan migrate --seed
    vendor/phpunit/phpunit/phpunit.php
    php artisan serve

## Adding a model/controller/view

1. 