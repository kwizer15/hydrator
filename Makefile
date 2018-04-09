PHONY: help server server-stop test cs

.DEFAULT_GOAL=help

-include .env

PHP = php
SERVER_HOST ?= localhost
SERVER_PORT ?= 8000
SERVER ?= php -S $(SERVER_HOST):$(PORT) -t public/
COMPOSER ?= composer

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-17s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

test: vendor ## Lance les tests
	$(PHP) vendor/bin/phpunit

cs: vendor ## Vérifie les règles de codage
	php vendor/bin/phpcs

composer.lock:
	$(COMPOSER) update

vendor: composer.lock
	$(COMPOSER) install

server: vendor ## Lance le serveur
	docker-compose up -d

server-stop:
	docker-compose stop
