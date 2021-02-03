CONTAINER = @docker exec -it bell_backend
MYSQL = @docker exec -it bell_db
REDIS = @docker exec -it bell_redis
PROJECT_NAME=bell

dev.docker.run:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose.yml up
dev.docker.build:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose.yml up --build
dev.bash:
	$(CONTAINER) bash
redis.bash:
	$(REDIS) sh
dev.dbconnect:
	$(MYSQL) bash

dev.fixture.load:
	$(CONTAINER) bin/console doctrine:fixture:load