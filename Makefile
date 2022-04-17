docker-up: docker-memory
	docker-compose up -d

docker-down:
	docker-compose down

docker-build: docker-memory
	docker-compose up --build -d

docker-memory:
	sysctl -w vm.max_map_count=262144

test:
	docker-compose exec php-fpm vendor/bin/phpunit --colors=always

assets-install:
	docker-compose exec node yarn install

assets-dev:
	docker-compose exec node yarn run dev

assets-watch:
	docker-compose exec node yarn watch

perm:
	sudo chown ivan102:ivan102 bootstrap/cache -R
	sudo chown ivan102:ivan102 storage -R
	if [ -d "node_modules" ]; then sudo chown ${USER}:${USER} node_modules -R; fi
	if [ -d "public/assets" ]; then sudo chown ${USER}:${USER} public/assets -R; fi
	sudo chmod 777 -R ./
