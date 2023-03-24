build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

install:
	docker-compose run --rm web composer install

console:
	docker-compose exec web php bin/console $(cmd)

cc:
	docker-compose exec web php bin/console cache:clear

test:
	docker-compose exec web php bin/phpunit
