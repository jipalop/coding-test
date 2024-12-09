DOCKER := docker compose
DOCKER_EXEC := docker exec -it app-php

.PHONY: setup
setup: ## Setup local environment
	$(MAKE) build
	$(MAKE) start
	$(MAKE) install

.PHONY: start
start: ## Start local server
	$(DOCKER) up --pull always -d --wait

.PHONY: restart
restart: ## Restart local server
	$(DOCKER) restart

.PHONY: stop
stop: ## Stop local server
	$(DOCKER) down

.PHONY: build
build: ## Build php docker image
	$(DOCKER) build --no-cache

.PHONY: install
install:  ## Install dependencies
	$(DOCKER_EXEC) composer install --no-scripts

.PHONY: bash
bash:  ## Install dependencies
	$(DOCKER_EXEC) bash

.PHONY: tests
tests: ## Run only phpunit tests
	$(DOCKER_EXEC) php vendor/bin/phpunit -c phpunit.xml
