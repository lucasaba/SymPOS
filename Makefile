COMPOSE_FILE_PATH := -f docker-compose.yml

build-images:
	$(info Make: Building images.)
	docker-compose build --no-cache
	@make -s clean
 
start-containers:
	$(info Make: Starting containers.)
	@docker-compose $(COMPOSE_FILE_PATH) up -d
 
stop-containers:
	$(info Make: Stopping containers.)
	@docker-compose stop
 
restart-containers:
	$(info Make: Restarting containers.)
	@make -s stop-containers
	@make -s start-containers

clean:
	@docker system prune --volumes --force

cli-shell:
	@docker-compose exec -w "/var/www" php-cli bash

init:
	@make -s build-images
	@make -s start-containers
	@docker-compose exec -w "/var/www" php-cli composer install