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

To install the software please open a terminal and exec the following commands one by one

```
git clone git@github.com:SandroBasta/poker-hand-analyzer.git
cd poker-hand-analyzer/src
composer install
cp .env.example .env
php artisan key:generate
```

## Before migrations run you have to set up db, you can use MYSQL or SQLITE

SQLITE
- update your .env file 

```
 DB_CONNECTION=sqlite
```
- create the file where to store data

```
touch database/database.sqlite
```

MYSQL
- create Database in your local/stage instance 
- update .env file 
```
DB_CONNECTION=mysql
DB_HOST=your-host
DB_PORT=your-port
DB_DATABASE=your-database-name
DB_USERNAME=your-username
```
## Run 
```
php artisan migrate
php artisan serve
```
1. Open your browser and go to http://127.0.0.1:8000
2. Click on register link on top-right corner and proceed to register a new user
3. Upload the hands.txt file, click on Submite  button and wait.

In hand.txt file from Task there Player ONE wins in 376 hands

## Authentication
Is based on laravel/ui
Laravel makes implementing authentication very simple. 
More here: https://laravel.com/docs/7.x/authentication

## Run in Docker env
please read Docker-readme.md file

## Unit Test

We are testing all ranks and hands.
To proceed with test please open folder in terminal and run:
```
cd src
php artisan test
```