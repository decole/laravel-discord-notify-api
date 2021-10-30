#Discord notify microservice

### How to install
```shell script
# build docker php container
docker-compose build --no-cache

# start service 
make up | docker-compose up -d

# into app container
make app | docker-compose exec app bash

# in app container put commands from install and migrate laravel: 
composer install && php artisan migrate
php artisan key:generate
```

### Microservice web GUI 
<localhost:89> watch gui log message transit on this microservice  

### Shell MAKE commands (watch Makefile file)

> `make up`
> 
> `make down`
> 
> `make stop`
> 
> `make app-install` - composer instal vendor and artisan migrate
> 
> `app-key-generate` - generate secret key by laravel
> 
> `make into app` - into php container
> 
> `mysql` - into mysql container
> 
> `make tests` - start unit tests


### Rollback migrate (if this needed)
```shell script
php artisan migrate:rollback --step=1
```


### Testing

> First step: migrate change db on test db (create **discord_bot_test** database) so watch ./docker-compose/mysql/init_db.sql file - for example this database created for first start mysql docker container.
> 
> `php artisan migrate --env=testing`
> 
> Second step:
> 
> `php artisan test`
