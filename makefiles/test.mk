test:
	@docker-compose exec -w "/var/www" php-cli ./bin/phpunit