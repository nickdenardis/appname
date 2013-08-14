# Base Laravel App Proof of Concept

Basically proof that Laraval is possible to start re-writing our API and other things.

## Setup

    git clone git@github.com:nickdenardis/appname.git
    chmod -R 755 app/storage
    composer install
    chmod -R 755 vendor/way/generators/src/Way/
    php artisan migrate --seed
    vendor/phpunit/phpunit/phpunit.php
    sass public/scss/foundation.scss:public/css/foundation.css
    sass public/scss/normalize.scss:public/css/normalize.css
    sass public/scss/app.scss:public/css/app.css
    php artisan serve

## Adding a model/controller/view

1. 