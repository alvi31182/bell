CONTAINER = @docker exec -it bell_backend
MYSQL = @docker exec -it bell_db

PROJECT_NAME=bell

dev.docker.run:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose.yml up
dev.bash:
	$(CONTAINER) bash
dev.dbconnect:
	$(MYSQL) bash

dev.fixture.load:
	$(CONTAINER) bin/console doctrine:fixture:load