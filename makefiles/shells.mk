cli-shell:
	@docker-compose exec -w "/var/www" php-cli bash

fpm-shell:
	@docker-compose exec -w "/var/www" php-fpm sh

nginx-shell:
	@docker-compose exec -w "/var/www" nginx bash

mysql-shell:
	@docker-compose exec mariadb bash