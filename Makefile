SYMFONY_BASE_CONTAINER = symfony-base
MYSQL_DATABASE_CONTAINER = symfony-mysql

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

install: ## Install the project
	docker compose up -d --build
	docker exec ${SYMFONY_BASE_CONTAINER} composer install --no-interaction
	docker exec -it ${SYMFONY_BASE_CONTAINER} php bin/console doctrine:database:create --if-not-exists
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console doctrine:migrations:migrate --no-interaction

migration: ## Create migration
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console make:migration --no-interaction

migrations-migrate: ## Run migrations
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console doctrine:migrations:migrate --no-interaction

jwt-config: ## Generate jwt keys
	docker exec ${SYMFONY_BASE_CONTAINER} mkdir -p config/jwt
	docker exec ${SYMFONY_BASE_CONTAINER} openssl genrsa -out config/jwt/private.pem 4096
	docker exec ${SYMFONY_BASE_CONTAINER} openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

jwt-pp-config: ## Generate jwt keys (passphrase)
	docker exec ${SYMFONY_BASE_CONTAINER} mkdir -p config/jwt
	docker exec -it ${SYMFONY_BASE_CONTAINER} openssl genrsa -out config/jwt/private.pem -aes256 4096
	docker exec -it ${SYMFONY_BASE_CONTAINER} openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

start: ## Start the containers
	docker compose up -d

stop: ## Stop the containers
	docker compose stop

down: ## Containers down
	docker compose down

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

sf-bash: ## sh into container
	docker exec -it ${SYMFONY_BASE_CONTAINER} bash

db-bash: ## sh into container
	docker exec -it ${MYSQL_DATABASE_CONTAINER} bash

cc: ## cache clear.
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console doctrine:cache:clear-metadata
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console doctrine:cache:clear-query
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console doctrine:cache:clear-result
	docker exec ${SYMFONY_BASE_CONTAINER} php bin/console cache:clear

dump-autoload: ## dump-autoload
	docker exec ${SYMFONY_BASE_CONTAINER} composer dump-autoload

phpunit: ## Run phpunit
	docker exec ${SYMFONY_BASE_CONTAINER} php ./vendor/bin/phpunit

psalm: ## Run psalm
	docker exec ${SYMFONY_BASE_CONTAINER} php ./vendor/bin/psalm

phpcsfixer: ## Run php-cs-fixer
	docker exec ${SYMFONY_BASE_CONTAINER} php ./vendor/bin/php-cs-fixer fix

composer-update: ## Run composer update
	docker exec ${SYMFONY_BASE_CONTAINER} composer update