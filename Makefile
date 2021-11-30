message = @echo "\n----------------------------------------\n$(1)\n----------------------------------------\n"

ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

root = $(dir $(realpath $(lastword $(MAKEFILE_LIST))))
compose = docker-compose

app = $(compose) exec -T app
artisan = $(app) php artisan

up:
	$(compose) up -d --remove-orphans

stop:
	$(compose) stop

down:
	$(compose) down

restart: down up
	$(call message,"Restart completed")

update: down
	$(compose) pull
	$(MAKE) up
	$(call message,"Update completed")

app-install:
	$(app) composer install
	$(app) php artisan migrate

app-key-generate:
	$(app) php artisan key:generate

into app:
	$(compose) exec app bash

ps:
	$(compose) ps

tests:
	$(app) php artisan test

logs:
	$(compose) logs
