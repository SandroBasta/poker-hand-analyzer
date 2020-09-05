## Setup global enviroment

### Create network

`docker network create local-private`

### Database

#### Creating global container for mysql

`docker run -dit --restart unless-stopped --name local-mysql --net local-private -v mysqldata:/var/lib/mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=docker -d mariadb:latest`

##### Creating project database

`docker exec -it local-mysql mysql -u root -p`

`CREATE DATABASE dogma DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;`

### Redis

`docker run -dit --restart unless-stopped --name local-redis --net local-private -p 6379:6379 redis:alpine`

### Setup enviroment

`docker-compose build --build-arg UID=1000 --build-arg GID=$GID`
`docker-compose up -d`
`docker exec -u www-data -it poker-hand-analyzer-app sh`
