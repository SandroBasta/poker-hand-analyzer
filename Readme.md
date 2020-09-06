## Task
The file hands.txt, contains 1000 random hands dealt to two players. Each line of the file contains ten cards (space separated).
The first five are Player 1's cards and the last five are Player 2's cards. 
You can assume that all hands are valid, each player's hand is in no specific order and in each hand there is a clear winner.

1. Upload the file
2. Parse file into a DB
3. Have a way to show how many hands Player 1 wins
4. Authentication

## Solution
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

