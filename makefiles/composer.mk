require:
	@docker-compose exec -w "/var/www" php-cli composer require $PACKAGE

require-dev:
	@docker-compose exec -w "/var/www" php-cli composer require --dev $PACKAGE