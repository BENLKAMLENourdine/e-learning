<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About E-learning

A restfull API for a simple e-learning platform with CRUD Endpoints for categories and courses and an endpoint for uploading images

## How to use

Install the project's dependencies by running `composer install` in your terminal
create and modify the .env file 
`
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:X64ST92vnBHp3Wb4tufvubViAbja355QyPw4uUOcerQ=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=devinweb
DB_USERNAME=root
DB_PASSWORD=
`
you should create a database using PHPMYAMIN with the same name montionned in the .env file
generate the key with `php artisan key:generate`
create the database tables by running `php artisan migrate`
seed the data with `php artisan db:seed`
and finally run the server `php artisan serve`



