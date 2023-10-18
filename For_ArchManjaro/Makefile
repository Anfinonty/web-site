.DEFAULT_GOAL := help

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

start:
	set -eux && mkcert -cert-file server.crt -key-file server.key gdaym8.example.com *.gdaym8.example.com && docker compose stop && docker compose up -d --build --remove-orphans && docker compose ps

.PHONY: stop
stop:
	docker compose stop

.PHONY: down
down:
	docker compose down

.PHONE: enter
enter:
	set -eux && docker compose exec ${CONTAINER} bash

.PHONY: logs
logs:
	set -eux && docker compose logs -f --tail 100 ${CONTAINERS}
