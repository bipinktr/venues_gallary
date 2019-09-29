# Venues Gallery

Venues Gallery is an image gallery application built on laravel php as rest api 
and react as the front end.

## Laravel 6.0, React 16.10 and PHP 7.2

## Prerequisite

1. Make sure you have [php](https://www.php.net/downloads.php/) installed.
2. Make sure you have [composer](https://getcomposer.org/download/) installed.
3. Make sure you have [laravel](https://laravel.com/docs/6.x/) installed.
4. Make sure you have latest stable version of [node](https://nodejs.org/en/download/) installed.

## Usage

```
git clone
cd venues_gallary/cli
php csvconvert.php venues.csv
cd venues_gallary/backend
composer install
php artisan serve
cd venues_gallary/frontend
npm install
npm start
```

REST API : http://127.0.0.1:8000/api/venues and filter with
http://127.0.0.1:8000/api/venues?name=palm&discount_percentage=20 .

The front end can access at http://localhost:3000 and can see the Venues Gallery.

Two different data sources can use here to get the data(json file and xml file).
By default json file is used as the data source. To change to xml file 
```
cd venues_gallary/backend
nano .env
DEFAULT_DATA_SOURCE=xml
```
The rest api URL can change in the front end by 
```
cd venues_gallary/frontend
nano .env
REACT_APP_BACKEND_API=http://127.0.0.1:8000
```