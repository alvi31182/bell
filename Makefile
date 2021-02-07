CONTAINER = @docker exec

PHP_EXEC = $(CONTAINER) -it bell_backend

MYSQL = @docker exec -it bell_db mysql -u bell_user -pbell_password

REDIS = @docker exec -it bell_redis

PROJECT_NAME = bell

SYMFONY = $(PHP_EXEC) bin/console

dev.docker.run:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose.yml up
dev.docker.build:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose.yml up --build
dev.bash:
	$(PHP_EXEC) bash
redis.bash:
	$(REDIS) sh
dev.dbconnect:
	$(MYSQL)
load-fixtures:
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:database:drop --force
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:migrations:migrate
	$(SYMFONY) doctrine:fixtures:load