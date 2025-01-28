.PHONY: help ps build start stop restart logs app vendors migrations credit-program-generate import-data default redis db

default: help

help:
	@echo
	@echo 'Usage commands:'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "   make \033[36m%-15s\033[0m %s\n", $$1, $$2}'
	@echo

ps: ## Status containers.
	@echo
	@docker-compose ps
	@echo

logs: ## Showing all containers logs.
	@docker-compose logs -f

build: ## Building all containers.
	@docker-compose build

start: ## Running docker containers.
	@echo "\e[33;1mContainers up...\e[0m"
	@docker-compose up -d
	@echo "\e[36;1mDone...\e[0m \n"

stop: ## Stopping docker containers.
	@echo "\e[33;1mContainers stopping...\e[0m"
	@docker-compose down
	@echo "\e[36;1mDone...\e[0m \n"

restart: stop start ## Restart docker containers.

vendors: ## Install vendors. Usage `composer install -n` in app container.
	@echo "\e[34;1mInstalling vendors...\e[0m"
	@docker-compose exec php-fpm composer install -n
	@echo "\e[36;1mDone...\e[0m \n"

migrations: ## Up database tables. Usage `php bin/console doctrine:migrations:migrate` in app container.
	@echo "\e[34;1mInstalling vendors...\e[0m"
	@docker-compose exec php-fpm php bin/console doctrine:migrations:migrate -n
	@echo "\e[36;1mDone...\e[0m \n"

import-data: ## Import cars in database. Usage `php bin/console app:import-data /var/shared/cars.csv` in app container.
	@echo "\e[34;1mInstalling vendors...\e[0m"
	@docker-compose exec php-fpm php bin/console app:import-data /var/shared/cars.csv
	@echo "\e[36;1mDone...\e[0m \n"

credit-program-generate: ## Generate credit in database. Usage `php bin/console app:credit-program:generate` in app container.
	@echo "\e[34;1mInstalling vendors...\e[0m"
	@docker-compose exec php-fpm php bin/console app:credit-program:generate
	@echo "\e[36;1mDone...\e[0m \n"

app: ## Entering in application container.
	@docker-compose exec php-fpm bash

redis: ## Entering a database container.
	@docker-compose exec redis redis-cli

db: ## Entering a database container.
	@docker-compose exec mariadb bash
