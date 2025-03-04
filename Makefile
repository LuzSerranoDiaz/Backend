up:
	@echo "iniciando backend"
	@docker compose up -d

stop:
	@echo "finalizando backend"
	@docker compose stop

php:
	@docker exec -it php sh

mysql:
	@docker exec -it mysql sh

nginx:
	@docker exec -it nginx sh

chmod:
	@sudo chown ${USER}:${USER} src/*
	@sudo chmod -R 777 src/*