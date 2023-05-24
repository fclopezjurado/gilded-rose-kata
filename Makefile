.ONESHELL:
SHELL := /bin/bash
docker_composer_run := docker exec -it gilded-rose-kata-fpm

help:
	@echo 'Usage: make [target] ...'
	@echo
	@echo 'targets:'
	@echo -e "$$(grep -hE '^\S+:.*##' $(MAKEFILE_LIST) | sed -e 's/:.*##\s*/:/' -e 's/^\(.\+\):\(.*\)/\\x1b[36m\1\\x1b[m:\2/' | column -c2 -t -s :)"

up: ## Starts the application containers
	@docker-compose up

down: ## Destroys the application containers by stopping and removing them
	@docker-compose down

restart: down up ## Performs a down and up

terminal: ## Opens an interactive terminal into the FPM Docker container
	@$(docker_composer_run) sh

dependencies: ## Installs application dependencies
	@$(docker_composer_run) sh -c "composer install"

unit-test: ## Runs unit tests
	@$(docker_composer_run) sh -c "vendor/bin/phpunit tests --test-suffix .php"

static-analysis: ## Checks static code analysis rules
	@$(docker_composer_run) sh -c "vendor/bin/phpstan analyse -l 8 src tests"

coding-standards: ## Checks coding standards rules
	@$(docker_composer_run) sh -c "vendor/bin/php-cs-fixer fix --dry-run --diff -vvv"

coding-standards-apply: ## Applies coding standards rules fixes
	@$(docker_composer_run) sh -c "vendor/bin/php-cs-fixer fix --diff -vvv"

code-quality: coding-standards static-analysis

security-check: ## Checks security vulnerabilities on the dependencies
	@$(docker_composer_run) sh -c "bin/security-checker"

.DEFAULT_GOAL := help
