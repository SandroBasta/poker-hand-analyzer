Analytico is a tool based on PHP and Laravel, whose purpose is only for test. Please do not use in production.

## General setup:

Before migrations run you have to set up db, you can use MYSQL or SQLITE

To install the software please open a terminal and exec the following commands one by one

```
git clone git@github.com:SandroBasta/poker-hand-analyzer.git
cd poker-hand-analyzer/src
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite //if you will use sqlite
php artisan migrate
```

## Run 
```
php artisan serve
```
1. Open your browser and go to http://127.0.0.1:8000
2. Click on register link on top-right corner and proceed to register a new user
3. Upload the hands.txt file, click on Submite  button and wait.

## Authentication
Is based on laravel/ui
Laravel makes implementing authentication very simple. 
More here: https://laravel.com/docs/7.x/authentication

## Run in Docker env
please read Docker-readme.md file

