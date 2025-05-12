.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

rebuild:
	symfony console doctrine:database:drop -f
	symfony console doctrine:database:create
	symfony console doctrine:schema:update -f
	symfony console doctrine:fixtures:load -n
	

install:
	symfony composer install
	symfony console lexik:jwt:generate-keypair --overwrite
	make rebuild

run:
	symfony server:start

stop:
	symfony server:stop