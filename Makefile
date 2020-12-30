CONTAINER = @docker exec -it bell_backend

PROJECT_NAME=bell

dev.docker.run:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose.yml up
dev.bash:
	$(CONTAINER) bash

dev.fixture.load:
	$(CONTAINER) bin/console doctrine:fixture:load