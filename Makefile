.PHONY: help

CONSOLE=php bin/console
PHPUNIT=bin/phpunit
DEV_JWT_PASSPHRASE =    "DEVJWTPASSPHRASE"

## Colors
COLOR_RESET			= \033[0m
COLOR_ERROR			= \033[31m
COLOR_INFO			= \033[32m
COLOR_COMMENT		= \033[33m
COLOR_TITLE_BLOCK	= \033[0;44m\033[37m

## Help
help:
	@printf "${COLOR_TITLE_BLOCK}Makefile help${COLOR_RESET}\n"
	@printf "\n"
	@printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	@printf " make [target]\n\n"
	@printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	@awk '/^[a-zA-Z\-\_0-9\@]+:/ { \
		helpLine = match(lastLine, /^## (.*)/); \
		helpCommand = substr($$1, 0, index($$1, ":")); \
		helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
		printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Install project dev env
dev-install:
	composer install


prepare-dev:
	$(CONSOLE) cache:clear --env=dev
	$(CONSOLE) doctrine:database:drop --if-exists -f --env=dev
	$(CONSOLE) doctrine:database:create --env=dev
	$(CONSOLE) doctrine:schema:update -f --env=dev
	$(CONSOLE) doctrine:fixtures:load -n --env=dev

db-init: prepare-dev


create-dev-jwt:
	mkdir -p config/jwt
	openssl genrsa -aes256 -passout pass:$(DEV_JWT_PASSPHRASE) -out config/jwt/private.pem 4096
	openssl rsa -pubout -passin pass:$(DEV_JWT_PASSPHRASE) -in config/jwt/private.pem -out config/jwt/public.pem
	setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
	setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
	echo "JWT_PASSPHRASE=$(DEV_JWT_PASSPHRASE)" > .env.local
