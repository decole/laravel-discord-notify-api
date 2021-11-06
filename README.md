# Discord notify microservice

### How to install

Change in docker-compose.yml some params.

in docker-compose.yml find `user: decole` and fix **decole** - to your system login name.

```
args:
  user: decole
  uid: 1000
```

fix fo example. Your system login is **samm012** 
in docker-compose.yml fix `user: decole` to `user: samm012` for all this cases

watch:

```
args:
  user: samm012
  uid: 1000
```

And in console execute this:

```shell script
# build docker php container
docker-compose build --no-cache

# start service or docker-compose up -d
make up   

# into app container or docker-compose exec app bash
make app

# in app container put commands from install and migrate laravel: 
composer install && php artisan migrate

#into app container (make app) execute this command
php artisan key:generate

# exit at container
exit

# in your console restart docker-compose 
make restart

# app is start!
```

### Microservice web GUI

<localhost:89> - welcome page with microservice info

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

In .env file enter yore credentials.

> DISCORD_WEBHOOK="enter yore webhook string"
> 
> DISCORD_USER="enter yore discord user id"


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
> `make tests` - start unit tests

You can see the full list of commands in the file itself. ( ./Makefile )


### Testing
use make command `make test`

or into app container:
```shell script
make app

php artisan test
```
