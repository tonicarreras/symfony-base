UID = $(shell id -u)
PHP_CONTAINER = symfony_php

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

install: ## Install the project
	U_ID=${UID} docker-compose up -d --build
	docker exec --user ${UID} ${PHP_CONTAINER} composer install --no-interaction
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console doctrine:migrations:migrate --no-interaction

make-migration: ## Create migration
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console make:migration --no-interaction

migrations-migrate: ## Run migrations
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console doctrine:migrations:migrate --no-interaction

start: ## Start the containers
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

down: ## Containers down
	U_ID=${UID} docker-compose down

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

sh: ## sh into container
	docker exec -it --user ${UID} ${PHP_CONTAINER} sh

cc: ## cache clear.
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console doctrine:cache:clear-metadata
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console doctrine:cache:clear-query
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console doctrine:cache:clear-result
	docker exec --user ${UID} ${PHP_CONTAINER} php bin/console cache:clear

dump-autoload: ## dump-autoload
	docker exec --user ${UID} ${PHP_CONTAINER} composer dump-autoload

phpunit: ## Run phpunit
	docker exec --user ${UID} ${PHP_CONTAINER} php ./vendor/bin/phpunit

psalm: ## Run psalm
	docker exec --user ${UID} ${PHP_CONTAINER} php ./vendor/bin/psalm