MAKEFLAGS += --no-print-directory

APP = @docker-compose $(if $(EXEC),exec,run --rm )\
	$(if $(ENTRYPOINT),--entrypoint "$(ENTRYPOINT)" )\
	$(if $(APP_ENV),-e APP_ENV=$(APP_ENV) )\
	$(if $(APP_DEBUG),-e APP_DEBUG=$(APP_DEBUG) )\
	--no-deps \
	php	

EXEC_MIGRATION = ${APP} bin/console doctrine:migration:execute Ahml\\Migrations\\$* --no-interaction

help:
	@grep -E '^[%a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
phpunit-check: ## Проверка юнит тестов
	$(APP) bin/phpunit --stop-on-failure --no-coverage
phpunit: ## Генерация coverage
	$(APP) bin/phpunit --stop-on-failure
cache-clear: ## Очистка кеша
	$(APP) bin/console cache:clear
migration: ## Применение новых миграций
	$(APP) bin/console doctrine:migration:migrate --allow-no-migration --no-interaction
migration-diff: ## Создание новой миграции на основе разницы между моделями доктрины и БД
	$(APP) bin/console doctrine:migration:diff --no-interaction
migration-generate: ## Создание пустой миграции
	$(APP) bin/console doctrine:migration:generate --no-interaction
migration-%-up: ## Применить миграцию по имени класса. Пример: make migration-Version20220711092923-up
	$(EXEC_MIGRATION) --up
migration-%-down: ## Откатить миграцию по имени класса. Пример: make migration-Version20220711092923-down
	$(EXEC_MIGRATION) --down
migration-%-repeat: ## Повторить миграцию по имени класса. Пример: make migration-Version20220711092923-repeat
	$(EXEC_MIGRATION) --down
	$(EXEC_MIGRATION) --up
