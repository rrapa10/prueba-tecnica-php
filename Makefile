start:
	docker-compose up --build -d

stop:
	docker-compose down

restart:
	docker-compose down && docker-compose up --build -d

logs:
	docker-compose logs -f

migrate:
	docker exec -it php_app php vendor/bin/doctrine orm:schema-tool:update --force

test:
	docker exec -it php_app vendor/bin/phpunit tests
