DOCKER := docker-compose -f docker-compose.yml
DOCKER_EXEC := docker exec -it slim_php

.PHONY: setup
setup: ## Setup local environment
	$(MAKE) build
	$(MAKE) install

.PHONY: start
start: ## Start local server
	$(DOCKER) up -d --no-recreate

.PHONY: restart
restart: ## Restart local server
	$(DOCKER) restart

.PHONY: stop
stop: ## Stop local server
	$(DOCKER) down

.PHONY: build
build: ## Build php docker image
	$(DOCKER) build --no-cache php

.PHONY: install
install:  ## Install dependencies
	$(DOCKER_EXEC) composer install --no-scripts