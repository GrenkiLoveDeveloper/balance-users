build:
	docker compose --env-file ./api/.env build --no-cache

up:
	docker compose --env-file ./api/.env up -d

down:
	docker compose down
