init: docker-down \
	docker-pull docker-build docker-up \
	app-composer-install yarn-install yarn-dev \
	echo-open-browser
up: docker-up
down: docker-down
restart: down up echo-open-browser
rebuild: down docker-build-no-pull docker-up echo-open-browser

docker-up:
	cd project && docker-compose up -d

docker-down:
	cd project && docker-compose down --remove-orphans

docker-pull:
	cd project && docker-compose pull

docker-build:
	cd project && docker-compose build --pull

docker-build-no-pull:
	docker-compose build

fix: rebuild app-composer-install app-migrations

app-php-cli-bash:
	cd project && docker-compose run --rm php-cli bash

app-composer-install:
	cd project && docker-compose run --rm php-cli composer install

app-migrations:
	cd project && docker-compose run --rm php-cli bin/console d:m:m --no-interaction

yarn-install:
	cd project && docker-compose run --rm node-cli yarn install

yarn-build:
	cd project && docker-compose run --rm node-cli yarn build

yarn-dev:
	cd project && docker-compose run --rm node-cli yarn dev

yarn-watch:
	cd project && docker-compose run --rm node-cli yarn watch

# make yarn-add PACK='svg-sprite-loader'
yarn-add:
	cd project && docker-compose run --rm node-cli yarn add ${PACK}

yarn-remove:
	cd project && docker-compose run --rm node-cli yarn remove ${PACK}

# TODO: указать путь до версии PHP на сервере
PROD_PHP = "/opt/php81/bin/php"
# запустить на сервере, чтобы всё обновилось
prod-build: prod-composer-install \
	prod-migrate \
 	prod-yarn-build

prod-composer-install:
	${PROD_PHP} composer.phar --working-dir=project install

prod-migrate:
	${PROD_PHP} project/bin/console d:m:m --no-interaction
	${PROD_PHP} project/bin/console cache:clear

prod-yarn-build:
	yarn --cwd project/ install
	yarn --cwd project/ build

echo-open-browser:
	xdg-open http://localhost:8069/