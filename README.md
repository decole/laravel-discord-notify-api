#Discord notify microservice

### How to install
```shell script
# build docker php container
docker-compose build --no-cache

# start service or docker-compose up -d
make up   

# into app container or docker-compose exec app bash
make app

# in app container put commands from install and migrate laravel: 
composer install && php artisan migrate
php artisan key:generate
```

### Microservice web GUI 
<localhost:89> watch gui log message transit on this microservice  

### How to use

Send to service api POST query with json. And service send notification by discord webhook message to your special discord chat. 

For example:

> POST http://localhost:89/api/notifications

Request body:
```json
{
    "who": "test_service",
    "message": "Warning! Service N does not respond to the request."
}
```

### Shel MAKE commands (watch Makefile file)

> `make up` - it is `docker-compose up -d --remove-orphans`
> 
> `make down` - it is `docker-compose down`
> 
> `make stop` - it is `docker-compose down`
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

You can see the full list of commands in the file itself. ( ./Makefile )



### Rollback migration (if this needed)
```shell script
make app

php artisan migrate:rollback
```


### Testing

Test database "discord_bot_test" is used for testing. First testing - in container (`make app`) use command `php artisan migrate --env=testing`

> First step: migrate change db on test db (create **discord_bot_test** database) so watch ./docker-compose/mysql/init_db.sql file - for example this database created for first start mysql docker container.
> 
> `php artisan migrate --env=testing`
> 
> Second step:
> 
> `php artisan test`
