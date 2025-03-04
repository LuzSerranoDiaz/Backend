up:
	@echo "iniciando backend"
	@docker compose up -d

stop:
	@echo "finalizando backend"
	@docker compose stop